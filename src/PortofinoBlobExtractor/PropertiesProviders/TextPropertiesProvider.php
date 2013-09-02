<?php

namespace PortofinoBlobExtractor\PropertiesProviders;


abstract class TextPropertiesProvider implements PropertiesProvider {

    // region -- CONSTANTS --
    // endregion

    // region -- MEMBERS --

    protected $itsParsedContent;

    // endregion

    // region -- GETTERS/SETTERS --
    // endregion

    // region -- METHODS --

    public function get($propertyName) {
        if ($this->itsParsedContent == null)
            $this->itsParsedContent = $this->parseContent($this->getContent());
        return $this->itsParsedContent[$propertyName];
    }

    protected function parseContent($content) {
        $content = $this->removeCommentedOrEmptyLines($content);
        return parse_ini_string($content);
    }

    protected abstract function getContent();

    protected function removeCommentedOrEmptyLines($content) {
        $splittedContent = $this->splitContentByLines($content);

        $newContent = '';
        $lineSeparator = '';

        foreach ($splittedContent as $line) {
            if (empty($line) || $this->isLineCommented($line))
                continue;

            $newContent .= $lineSeparator . $line;
            $lineSeparator = PHP_EOL;
        }

        return $newContent;
    }

    private function splitContentByLines($content) {
        $content = str_replace("\r\n", "\n", $content);
        return explode("\n", $content);
    }

    private function isLineCommented($line) {
        return $line[0] == '#';
    }

    // endregion

}