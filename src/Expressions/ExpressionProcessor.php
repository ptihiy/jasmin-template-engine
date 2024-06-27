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
        } elseif (self::isNumber($operand)) {
            // TODO: is it needed? PHP silently converts anyway
            $operand = (float) $operand;
        } elseif (self::isVariable($operand)) {
            $operand = self::shortCode('echo ' . self::resolveVariable($operand));
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

    private static function isVariable(string $operand): bool
    {
        return preg_match('/^[a-z]/', $operand);
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

    public static function resolveVariable(string $operand): string
    {
        return preg_replace_callback('/^(\w+)(?:\.(\w+))?$/', function ($matches) {
            if (count($matches) > 2) {
                return "$$matches[1]['$matches[2]']";
            } else {
                return "$$matches[1]";
            }
        }, $operand);
    }

    public static function shortCode(string $code): string
    {
        return "<?php " . $code . " ?>";
    }
}
