<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Jasmin\TemplateEngine\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use Jasmin\TemplateEngine\TemplateLoader\FileTemplateLoader;

#[CoversClass(Parser::class)]
final class ParseForeachStatementTest extends TestCase
{
    public function testParseBasicForeachStatement(): void
    {
        $parser = new Parser(new FileTemplateLoader(dirname(__DIR__, 2) . '/templates'));

        $items = ['one', 'two', 'three'];
        $rawTemplate = <<<'TEMPLATE'
@foreach(items as item)
{{ item }}
@endforeach
TEMPLATE;
        $template = $parser->parse($rawTemplate, ['items' => $items]);

        var_dump($template);

        $this->assertSame("one\ntwo\nthree", $template);
    }
}
