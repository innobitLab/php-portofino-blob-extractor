<?php

namespace PortofinoBlobExtractor\PropertiesProviders;


use PortofinoBlobExtractor\Parsers\MetadataParser;

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
        $parser = new MetadataParser();
        return $parser->parse($content);
    }

    protected abstract function getContent();

    // endregion

}