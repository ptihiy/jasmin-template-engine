<?php

namespace Jasmin\TemplateEngine\Filters\StringFilters;

class Lower
{
    public static function filter(string $str)
    {
        return mb_strtolower($str);
    }
}
