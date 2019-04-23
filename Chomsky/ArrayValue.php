<?php

declare(strict_types=1);

namespace Chomsky;

use Chomsky\Config;


final class ArrayValue extends Value {

    private $_value = [];

    public function __construct($array)
    {
        $this->_value = [];
        foreach($array as $value) {
            $this->_value []= Value::create($value);
        }
    }

    public function __toString() : string
    {
        $values = array_map(
            function($value) {
                return $value->__toString();
            },
            $this->_value
        );

        $lastOne = array_pop($values);
        $allButLast = implode(', ', $values);

        return $allButLast == ''
           ? $lastOne
           : implode(' ' . Config::AND_SEPARATOR . ' ', [implode(', ', $values), $lastOne ]);
    }

}
