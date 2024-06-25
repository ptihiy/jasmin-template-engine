<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Jasmin\TemplateEngine\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Parser::class)]
final class ParserWithNumberOperandsTest extends TestCase
{
    public function testParserCanHandleNumbers(): void
    {
        $parser = new Parser();
        $template = $parser->parse('Hello, {{ 2.15 }}, good bye, {{ 3 }}, hi, {{ 2e5 }}');

        $this->assertSame('Hello, 2.15, good bye, 3, hi, 200000', $template);
    }

    public function testParserCanHandleENotation(): void
    {
        $parser = new Parser();
        $template = $parser->parse('Hello, {{ 2e5 }}');

        $this->assertSame('Hello, 200000', $template);
    }

    public function testParserCanApplyFilters(): void
    {
        $parser = new Parser();
        $template = $parser->parse('Hello, {{ 2.15|round }}');

        $this->assertSame('Hello, 2', $template);
    }
}
