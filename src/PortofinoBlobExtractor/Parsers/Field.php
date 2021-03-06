<?php

namespace PortofinoBlobExtractor\Parsers;

class Field
{
    private $name;
    private $value;

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
} 