<?php

namespace tests;

use Jasmin\TemplateEngine\Parser\Parser;
use PHPUnit\Framework\TestCase;

final class ParserTest extends TestCase
{
    public function testParserParsesSimpleExpression(): void
    {
        $parser = new Parser();
        $results = $parser->parse('Hello, {{ integer }}, good bye, {{ float }}');

        $this->assertSame(['integer', 'float'], $results);
    }


    public function testParserParsesSimpleExpressionWithFilters(): void
    {
        $parser = new Parser();
        $results = $parser->parse('Hello, {{ integer|round }}, good bye, {{ float|round }}');

        $this->assertSame(['integer|round', 'float|round'], $results);
    }


    public function testParserParsesSimpleExpressionWithFiltersWithSpaces(): void
    {
        $parser = new Parser();
        $results = $parser->parse('Hello, {{ integer | round }}, good bye, {{ float | round }}');

        $this->assertSame(['integer | round', 'float | round'], $results);
    }



    public function testParseTemplateWithNoMoustache(): void
    {

        $parser = new Parser();
        $results = $parser->parse('Hello, good bye');

        $this->assertSame([], $results);
    }
}
