<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Jasmin\TemplateEngine\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Parser::class)]
final class ParserTest extends TestCase
{
    public function testParserParsesSimpleExpression(): void
    {
        $parser = new Parser();
        $template = $parser->parse('Hello, {{ "integer" }}, good bye, {{ "float" }}');

        $this->assertSame('Hello, integer, good bye, float', $template);
    }

    public function testParseTemplateWithNoMoustache(): void
    {

        $parser = new Parser();
        $template = $parser->parse('Hello, good bye');

        $this->assertSame('Hello, good bye', $template);
    }
}
