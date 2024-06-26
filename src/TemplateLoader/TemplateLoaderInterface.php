<?php

namespace Jasmin\TemplateEngine\TemplateLoader;

interface TemplateLoaderInterface
{
    public function load(string $path): string;

    public function toRealPath(string $path): string;
}
