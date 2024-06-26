<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Jasmin\TemplateEngine\Renderer\Renderer;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Renderer::class)]
final class RendererTest extends TestCase
{
    public function testRendererCanLoadTemplates(): void
    {
        $renderer = new Renderer(realpath('./templates'), realpath('./cache'));
    }
}
