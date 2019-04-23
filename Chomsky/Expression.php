<?php

declare(strict_types=1);

namespace Chomsky;


use Chomsky\Chomsky;


final class Expression {

    private $value = null;

    public function __construct($expression)
    {
        $this->parse($expression);
    }

    public function evaluate() : string
    {
        return $this->value->__toString();
    }

    private function parse($expression) : void
    {
        $captures = [];
        if (preg_match("/^(?<identifier>[a-zA-Z_]+)(?<filter>\[(?<filter_key>[^=]+)=(?<filter_value>[^\]]+)\])?$/i", $expression, $captures) == false) {
            return;
        }

        $this->value = Value::create(Chomsky::remind($captures['identifier']));

        if (isset($captures['filter']) && $this->value->canFilter()) {
            $this->value->filter($captures['filter_key'], $captures['filter_value']);
        }
    }


}
