<?php

namespace Jasmin\TemplateEngine\Parser;

interface ParserInterface
{
    public function parse(string $string, array $data = []): string;
}
