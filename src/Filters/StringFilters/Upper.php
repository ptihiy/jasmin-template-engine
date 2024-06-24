<?php

namespace Jasmin\TemplateEngine\Filters\StringFilters;

class Upper
{
    public static function filter(string $str)
    {
        return mb_strtoupper($str);
    }
}
