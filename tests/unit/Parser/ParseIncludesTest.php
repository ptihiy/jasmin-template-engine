<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Jasmin\TemplateEngine\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use Jasmin\TemplateEngine\TemplateLoader\FileTemplateLoader;

#[CoversClass(Parser::class)]
final class ParseIncludesTest extends TestCase
{
    public function testParserThrowsExceptionWithNonexistentTemplate(): void
    {
        $parser = new Parser(new FileTemplateLoader(dirname(__DIR__, 2) . '/templates'));
        $template = $parser->parse('Hello, {{ "integer" }}, good bye, {{ "float" }}');

        $this->assertSame('Hello, integer, good bye, float', $template);
    }
}
