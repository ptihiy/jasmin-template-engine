<?php

namespace Jasmin\TemplateEngine\Renderer;

use Jasmin\TemplateEngine\Parser\Parser;

class Renderer implements RendererInterface
{
    public function __construct(private string $templateDir, private string $cacheDir)
    {
    }

    public function render(string $file): string
    {
        $path = realpath($this->templateDir . '/' . $file . '.jasmin.php');
        $hash = hash_file(hash_algos()[2], $path);

        $cachedFilePath = realpath($this->cacheDir . '/' . $hash . '.php');

        if (file_exists($cachedFilePath)) {
            return 'cache file found';
        } else {
            $parser = new Parser();
            var_dump($this->cacheDir . '/' . $hash . '.php', $parser->parse(file_get_contents($path)));
            file_put_contents($this->cacheDir . '/' . $hash . '.php', $parser->parse(file_get_contents($path)));
            return 'cache file not found';
        }
        return $hash;
    }

    public function renderToString(string $template): string
    {
        $parser = new Parser();
        return $parser->parse($template);
    }
}
