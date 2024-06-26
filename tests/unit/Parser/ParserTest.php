<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Jasmin\TemplateEngine\Parser\Parser;
use Jasmin\TemplateEngine\TemplateLoader\FileTemplateLoader;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Parser::class)]
final class ParserTest extends TestCase
{
    public function testParserParsesSimpleExpression(): void
    {
        $parser = new Parser(new FileTemplateLoader(dirname(__DIR__, 2) . '/templates'));
        $template = $parser->parse('Hello, {{ "integer" }}, good bye, {{ "float" }}');

        $this->assertSame('Hello, integer, good bye, float', $template);
    }

    public function testParseTemplateWithNoMoustache(): void
    {

        $parser = new Parser(new FileTemplateLoader(dirname(__DIR__, 2) . '/templates'));
        $template = $parser->parse('Hello, good bye');

        $this->assertSame('Hello, good bye', $template);
    }

    public function testParserParsesIncludeStatement(): void
    {
        $parser = new Parser(new FileTemplateLoader(dirname(__DIR__, 2) . '/templates'));
        $template = $parser->parse("@include('partials.simple-include')");

        $this->assertSame('file for tests 2', $template);
    }
}
