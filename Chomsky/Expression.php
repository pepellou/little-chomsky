<?php

declare(strict_types=1);

namespace Chomsky;


use Chomsky\Chomsky;


final class Expression {

    private $value = "";

    public function __construct($expression)
    {
        $this->parse($expression);
    }

    public function evaluate() : string
    {
        return Value::create($this->value)->__toString();
    }

    private function parse($expression) : void
    {
        $this->value = Chomsky::remind($expression);
    }


}
