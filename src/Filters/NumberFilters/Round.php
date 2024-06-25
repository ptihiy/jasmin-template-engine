<?php

namespace Jasmin\TemplateEngine\Filters\NumberFilters;

class Round
{
    public static function filter(float|int $number, int $precision = 0)
    {
        return round($number, $precision);
    }
}
