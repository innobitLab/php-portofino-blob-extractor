<?php

use PortofinoBlobExtractor\Parsers\MetadataParser;

class MetadataParserTest extends PHPUnit_Framework_TestCase
{
    private $parser;

    public function setUp()
    {
        $this->parser = new MetadataParser();
    }

    private function assertParse($expected, $content)
    {
        $this->assertEquals($expected, $this->parser->parse($content));
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

    public function test_parse_field_with_separator_contained_in_value()
    {
        $this->assertParse(array('math' => '1 + 2 = 3'), 'math=1 + 2 = 3');
    }

    /**
     * @expectedException \PortofinoBlobExtractor\Parsers\ParseException
     */
    public function test_parse_multiple_line_with_invalid_one()
    {
        $content = <<<EOT
name=value
YouCantParseMe
EOT;

        $this->parser->parse($content);
    }

    public function test_parse_content_with_comments()
    {
        $content = <<<EOT
#this line is a comment
field=value
#another comment!
otherField=otherValue
EOT;

        $expected = array(
            'field' => 'value',
            'otherField' => 'otherValue'
        );

        $this->assertParse($expected, $content);
    }

    /**
     * @expectedException \PortofinoBlobExtractor\Parsers\KeyAlreadyExistsException
     */
    public function test_parse_same_key_twice()
    {
        $content = <<<EOT
field=value
field=otherValue
EOT;

        $this->parser->parse($content);
    }
}
 