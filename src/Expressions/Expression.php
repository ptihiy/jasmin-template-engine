<?php

namespace Jasmin\TemplateEngine\Expressions;

class Expression implements ExpressionInterface
{
    public function __construct(private $operand, private $filters = [])
    {
    }

    public function getOperand()
    {
        return $this->operand;
    }

    public function getFilters()
    {
        return $this->filters;
    }
}
