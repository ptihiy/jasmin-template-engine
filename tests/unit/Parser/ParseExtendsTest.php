<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Jasmin\TemplateEngine\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use Jasmin\TemplateEngine\TemplateLoader\FileTemplateLoader;

#[CoversClass(Parser::class)]
final class ParseExtendsTest extends TestCase
{
    public function testParserCanExtendTemplates(): void
    {
        $parser = new Parser(new FileTemplateLoader(dirname(__DIR__, 2) . '/templates'));
        $actual = $parser->parse(file_get_contents(dirname(__FILE__, 3) . '/templates/extends/index.jasmin.php'));

        $expected = <<<'EXTENDS'
This is a layout file that should be extended

This block was substituted
EXTENDS;

        $this->assertSame($expected, $actual);
    }
}
