<?php

namespace Jasmin\TemplateEngine\TemplateEngine;

use Jasmin\TemplateEngine\Parser\Parser;
use Jasmin\TemplateEngine\Parser\ParserInterface;
use Jasmin\TemplateEngine\TemplateLoader\FileTemplateLoader;
use Jasmin\TemplateEngine\TemplateLoader\TemplateLoaderInterface;

class TemplateEngine implements TemplateEngineInterface
{
    private TemplateLoaderInterface $templateLoader;
    private ParserInterface $parser;

    public function __construct(private string $templateDir, private string $cacheDir)
    {
        $this->templateLoader = new FileTemplateLoader($templateDir);
        $this->parser = new Parser($this->templateLoader);
    }

    public function render(string $file): string
    {
        $path = $this->templateLoader->toRealPath($file);
        $hash = hash_file(hash_algos()[2], $path);

        $cachedFilePath = realpath($this->cacheDir . '/' . $hash . '.php');

        $renderedTemplate = $this->parser->parse(file_get_contents($path));

        // cache if not already cached
        if (!file_exists($cachedFilePath)) {
            file_put_contents($cachedFilePath, $renderedTemplate);
        }
        return $renderedTemplate;
    }
}
