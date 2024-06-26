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
        $template = <<<'EXPECTED'
@foreach(items as item)
{{ item }}
@endforeach
EXPECTED;
        $template = $parser->parse($template, ['items' => $items]);

        $expected = <<<'EXPECTED'
<?php foreach ($items as $item) { ?>
<?php echo $item ?>
<?php } ?>
EXPECTED;

        $this->assertSame($expected, $template);
    }
}
