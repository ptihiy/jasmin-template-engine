<?php

namespace Jasmin\TemplateEngine\Expressions;

use Jasmin\TemplateEngine\Filters\NumberFilters\Round;
use Jasmin\TemplateEngine\Filters\StringFilters\Lower;
use Jasmin\TemplateEngine\Filters\StringFilters\Upper;

class ExpressionProcessor
{
    public static function process(Expression $expr)
    {
        $operand = $expr->getOperand();
        if (self::isString($operand)) {
            $operand = preg_replace('~^[\'"]?(.*?)[\'"]?$~', '$1', $operand);
        }
        if (self::isNumber($operand)) {
            // TODO: is it needed? PHP silently converts anyway
            $operand = (float) $operand;
        }
        foreach ($expr->getFilters() as $filter) {
            $operand = (self::resolveFilter($filter))::filter($operand);
        }

        return $operand;
    }

    private static function isString(string $operand): bool
    {
        return preg_match('/^"[^"]*"$/', $operand);
    }

    private static function isNumber(string $operand): bool
    {
        return preg_match('/^\d/', $operand);
    }

    private static function resolveFilter(string $filter): string
    {
        switch ($filter) {
            case 'upper':
                return Upper::class;
            case 'lower':
                return Lower::class;
            case 'round':
                return Round::class;
        }
    }
}
