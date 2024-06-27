<?php

namespace Jasmin\TemplateEngine\Parser;

use InvalidArgumentException;
use Jasmin\TemplateEngine\Expressions\ExpressionProcessor as ExPr;
use Jasmin\TemplateEngine\TemplateLoader\FileTemplateLoader;
use Jasmin\TemplateEngine\TemplateLoader\TemplateLoaderInterface;

class Parser implements ParserInterface
{
    public function __construct(private TemplateLoaderInterface $templateLoader)
    {
    }

    public function parse(string $template, array $data = []): string
    {
        $templateWithIncludes = preg_replace_callback('/@include\(\'(.*?)\'\)/', [$this, 'replaceInclude'], $template);

        return preg_replace_callback_array([
            '/{{(.+?)}}/' => [$this, 'replaceExpression'],
            '/@(if|foreach)\((.*?)\)(.*?)@end\1/s' => [$this, 'replaceStatement'],
            '/@vite\(\'(.*?)\'\)/' => [$this, 'replaceVite'],
        ], $templateWithIncludes);
    }

    private function replaceExpression(array $matches): string
    {
        $stringToReplace = trim($matches[1]);
        $expr = ExpressionParser::parseExpression($stringToReplace);
        return ExPr::process($expr);
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
        switch ($matches[1]) {
            case 'foreach':
                return $this->replaceForeachStatement($matches);
            default:
                throw new InvalidArgumentException("Cannot process statement $matches[1]");
        }
    }

    private function replaceForeachStatement(array $matches): string
    {
        list($items, $item) = explode(' as ', $matches[2]);
        $foreach = ExPr::shortCode("foreach (" . ExPr::resolveVariable($items) . " as " . ExPr::resolveVariable($item) . ") {");
        $foreach .= $matches[3];
        $foreach .= ExPr::shortCode("}");

        return $foreach;
    }

    private function replaceVite(array $matches): string
    {
        var_dump($matches);
        return 'yes';
    }
}
