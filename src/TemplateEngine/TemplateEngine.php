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
    private array $globalVariables = [];

    public function __construct(private string $templateDir, private string $cacheDir)
    {
        $this->templateLoader = new FileTemplateLoader($templateDir);
        $this->parser = new Parser($this->templateLoader);
    }

    public function render(string $file, array $data = []): void
    {
        $data = array_merge($this->globalVariables, $data);

        $path = $this->templateLoader->toRealPath($file);

        $hash = hash_file(hash_algos()[2], $path);

        $cachedFilePath = $this->cacheDir . '/' . $hash . '.php';

        $renderedTemplate = $this->parser->parse(file_get_contents($path));

        if (!file_exists($cachedFilePath)) {
            fclose(fopen($cachedFilePath, 'a+b')) ;
            $fp = fopen($cachedFilePath, 'r+b');
            if (flock($fp, LOCK_EX)) {
                fwrite($fp, $renderedTemplate);
                fflush($fp);
                flock($fp, LOCK_UN);
            } else {
                echo "Couldn't get the lock!";
            }
        }

        extract($data);
        require $cachedFilePath;
    }

    public function addGlobalVar(string $name, mixed $value)
    {
        $this->globalVariables[$name] = $value;
    }
}
