<?php

namespace Jasmin\TemplateEngine\TemplateEngine;

interface TemplateEngineInterface
{
    public function render(string $file): string;
}
