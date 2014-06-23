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

        if (!strpos($content, self::FIELD_SEPARATOR))
            throw new ParseException();

        $res = array();

        $lines = $this->extractLines($content);

        foreach ($lines as $line) {
            $field = $this->extractField($line);
            $res[$field->getName()] = $field->getValue();
        }

        return $res;
    }

    private function extractLines($content)
    {
        return explode(self::LINE_SEPARATOR, $content);
    }

    private function extractField($line)
    {
        $exploded = explode(self::FIELD_SEPARATOR, $line);
        return new Field($exploded[0], $exploded[1]);
    }
}