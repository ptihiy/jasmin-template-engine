<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Jasmin\TemplateEngine\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use Jasmin\TemplateEngine\TemplateLoader\FileTemplateLoader;

#[CoversClass(Parser::class)]
final class ParseIfTest extends TestCase
{
    public function testParserParsesSimpleIfExpression(): void
    {
        $parser = new Parser(new FileTemplateLoader(dirname(__DIR__, 2) . '/templates'));
        $template = $parser->parse('@if(true) good @endif');

        $this->assertSame('<?php if (true) { ?> good <?php } ?>', $template);
    }

    public function testParserParsesSimpleIfWithDoubleParenthesis(): void
    {
        $parser = new Parser(new FileTemplateLoader(dirname(__DIR__, 2) . '/templates'));
        $template = $parser->parse('@if((true)) good @endif');

        $this->assertSame('<?php if ((true)) { ?> good <?php } ?>', $template);
    }

    public function testParserParsesSimpleIfWithElseClause(): void
    {
        $parser = new Parser(new FileTemplateLoader(dirname(__DIR__, 2) . '/templates'));
        $template = $parser->parse('@if((false)) good @else bad @endif');

        $this->assertSame('<?php if ((false)) { ?> good <?php } else { ?> bad <?php } ?>', $template);
    }
}
