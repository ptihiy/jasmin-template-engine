<?php

namespace Jasmin\TemplateEngine\Renderer;

interface RendererInterface
{
    public function render(string $file): string;
}
