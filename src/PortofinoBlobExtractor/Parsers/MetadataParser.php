<?php

namespace PortofinoBlobExtractor\Parsers;

class MetadataParser
{
    const FIELD_SEPARATOR = '=';
    const LINE_SEPARATOR = "\n";
    const COMMENT_IDENTIFIER = '#';

    public function parse($content)
    {
        if (empty($content))
            return array();

        $res = array();

        $lines = $this->extractLines($content);

        foreach ($lines as $line) {
            if ($this->isComment($line))
                continue;

            $this->guardFromInvalidLine($line);

            $field = $this->extractField($line);

            $this->guardFromDuplicatedKey($field->getName(), $res);

            $res[$field->getName()] = $field->getValue();
        }

        return $res;
    }

    private function extractLines($content)
    {
        return explode(self::LINE_SEPARATOR, $content);
    }

    private function isComment($line)
    {
        return strpos($line, self::COMMENT_IDENTIFIER) === 0;
    }

    private function guardFromInvalidLine($line)
    {
        if (!$this->validateLine($line))
            throw new ParseException();
    }

    private function validateLine($line)
    {
        return strpos($line, self::FIELD_SEPARATOR);
    }

    private function extractField($line)
    {
        $exploded = explode(self::FIELD_SEPARATOR, $line, 2);
        return new Field($exploded[0], $exploded[1]);
    }

    private function guardFromDuplicatedKey($key, array $res)
    {
        if (array_key_exists($key, $res))
            throw new KeyAlreadyExistsException(sprintf('Key %s already exists', $key));
    }
}