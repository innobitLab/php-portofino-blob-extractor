<?php

namespace PortofinoBlobExtractor\Parsers;

class MetadataParser
{
    const FIELD_SEPARATOR = '=';
    const LINE_SEPARATOR = "\n";

    public function parse($content)
    {
        if (empty($content))
            return array();

        $res = array();

        $lines = $this->extractLines($content);

        foreach ($lines as $line) {
            $this->guardFromInvalidLine($line);

            $field = $this->extractField($line);
            $res[$field->getName()] = $field->getValue();
        }

        return $res;
    }

    private function extractLines($content)
    {
        return explode(self::LINE_SEPARATOR, $content);
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

}