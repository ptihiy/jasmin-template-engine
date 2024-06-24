<?php

namespace Jasmin\TemplateEngine\Parser;

use Jasmin\TemplateEngine\Expressions\Expression;

class ExpressionParser
{
    public static function parseExpression(string $str): Expression
    {
        $parts = array_map('trim', explode('|', $str));
        return new Expression($parts[0], array_slice($parts, 1));
    }
}
