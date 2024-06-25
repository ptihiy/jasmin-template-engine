<?php

namespace Jasmin\TemplateEngine\Parser;

use Jasmin\TemplateEngine\Expressions\ExpressionProcessor;

class Parser implements ParserInterface
{
    public function parse(string $template, array $data = []): string
    {
        return preg_replace_callback('/{{(.+?)}}/', [$this, 'replace'], $template);
    }

    private function replace(array $matches): string
    {
        $stringToReplace = trim($matches[1]);
        $expr = ExpressionParser::parseExpression($stringToReplace);
        return ExpressionProcessor::process($expr);
    }
}
