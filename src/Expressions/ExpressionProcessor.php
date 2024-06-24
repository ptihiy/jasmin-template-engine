<?php

namespace Jasmin\TemplateEngine\Expressions;

use Jasmin\TemplateEngine\Filters\FilterInterface;
use Jasmin\TemplateEngine\Filters\StringFilters\Lower;
use Jasmin\TemplateEngine\Filters\StringFilters\Upper;

class ExpressionProcessor
{
    public static function process(Expression $expr)
    {
        $operand = $expr->getOperand();
        if (self::isString($operand)) {
            foreach ($expr->getFilters() as $filter) {
                $operand = (self::resolveFilter($filter))::filter($operand);
            }
        }

        return $operand;
    }

    private static function isString(string $operand): bool
    {
        return preg_match('/^"[^"]*"$/', $operand);
    }

    private static function resolveFilter(string $filter): string
    {
        switch ($filter) {
            case 'upper':
                return Upper::class;
            case 'lower':
                return Lower::class;
        }
    }
}
