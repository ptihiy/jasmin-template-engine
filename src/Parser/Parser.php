<?php

namespace Jasmin\TemplateEngine\Parser;

use InvalidArgumentException;
use Jasmin\TemplateEngine\Expressions\ExpressionProcessor;
use Jasmin\TemplateEngine\TemplateLoader\FileTemplateLoader;
use Jasmin\TemplateEngine\TemplateLoader\TemplateLoaderInterface;

class Parser implements ParserInterface
{
    public function __construct(private TemplateLoaderInterface $templateLoader)
    {
    }

    public function parse(string $template, array $data = []): string
    {
        return preg_replace_callback_array([
            '/{{(.+?)}}/' => [$this, 'replaceExpression'],
            '/@include\(\'(.*?)\'\)/' => [$this, 'replaceInclude'],
            '/@if\((.*?)\)/' => [$this, 'replaceStatement']
        ], $template);
    }

    private function replaceExpression(array $matches): string
    {
        $stringToReplace = trim($matches[1]);
        $expr = ExpressionParser::parseExpression($stringToReplace);
        return ExpressionProcessor::process($expr);
    }

    public function replaceInclude(array $matches): string
    {
        $templatePath = $this->templateLoader->toRealPath($matches[1]);
        if (!file_exists($templatePath)) {
            throw new InvalidArgumentException("Template file doesn't exist");
        }
        return file_get_contents($templatePath);
    }

    private function replaceStatement(array $matches): string
    {
        var_dump($matches);
        return 'yes';
    }
}
