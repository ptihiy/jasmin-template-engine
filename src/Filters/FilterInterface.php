<?php

namespace Jasmin\TemplateEngine\Filters;

interface FilterInterface
{
    public static function filter(string $operand): string;
}
