<?php

use PortofinoBlobExtractor\Parsers\MetadataParser;

class MetadataParserTest extends PHPUnit_Framework_TestCase
{
    private $parser;

    public function setUp()
    {
        $this->parser = new MetadataParser();
    }

    public function test_parse_empty_string()
    {
        $this->assertParse(array(), '');
    }

    public function test_parse_null()
    {
        $this->assertParse(array(), null);
    }

    public function test_parse_single_line()
    {
        $this->assertParse(array('label' => 'value'), 'label=value');
    }

    /**
     * @expectedException \PortofinoBlobExtractor\Parsers\ParseException
     */
    public function test_parse_line_without_delimiter()
    {
        $this->parser->parse('you cannot parse this!');
    }

    public function test_parse_multiple_lines()
    {
        $content = <<<EOT
label=value
otherLabel=otherValue
EOT;

        $expected = array(
            'label' => 'value',
            'otherLabel' => 'otherValue'
        );

        $this->assertParse($expected, $content);
    }

    private function assertParse($expected, $content)
    {
        $this->assertEquals($expected, $this->parser->parse($content));
    }
}
 