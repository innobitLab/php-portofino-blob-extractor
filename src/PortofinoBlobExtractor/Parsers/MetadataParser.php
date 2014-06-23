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

        $lines = $this->extractLines($content);
        return $this->parseLines($lines);
    }

    private function extractLines($content)
    {
        return explode(self::LINE_SEPARATOR, $content);
    }

    private function parseLines(array $lines)
    {
        $res = array();

        foreach ($lines as $line) {
            if ($this->isComment($line))
                continue;

            $res = array_merge($res, $this->parseSingleLine($line, $res));
        }

        return $res;
    }

    private function parseSingleLine($line, array $res) {
        $this->guardFromInvalidLine($line);

        $field = $this->extractField($line);
        $this->guardFromDuplicatedKey($field->getName(), $res);

        return array($field->getName() => $field->getValue());
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