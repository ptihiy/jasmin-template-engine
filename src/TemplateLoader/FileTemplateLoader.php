<?php

namespace Jasmin\TemplateEngine\TemplateLoader;

use InvalidArgumentException;

class FileTemplateLoader implements TemplateLoaderInterface
{
    public function __construct(private string $templatePath)
    {
        if (strlen($templatePath) === 0) {
            throw new InvalidArgumentException('Template path is not specified');
        }
    }

    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    public function load(string $path): string
    {
        return 'test';
    }

    public function toRealPath(string $path): string
    {
        if (str_ends_with($path, '.jasmin.php')) {
            $path = substr($path, 0, -strlen('.jasmin.php'));
        }

        return $this->getTemplatePath() . '/' . preg_replace('/\./', '/', $path) . '.jasmin.php';
    }
}
