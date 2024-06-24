<?php

namespace Jasmin\TemplateEngine\Expressions;

interface ExpressionInterface
{
    public function getOperand();

    public function getFilters();
}
