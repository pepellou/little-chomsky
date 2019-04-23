<?php

declare(strict_types=1);

namespace Chomsky;

use Chomsky\Config;


final class ArrayValue extends Value {

    private $_values = [];

    public function __construct($array)
    {
        $this->_values = [];
        foreach($array as $value) {
            $this->_values []= Value::create($value);
        }
    }

    public function __toString() : string
    {
        $values = array_map(
            function($value) {
                return $value->__toString();
            },
            $this->_values
        );

        $lastOne = array_pop($values);
        $allButLast = implode(', ', $values);

        return $allButLast == ''
           ? $lastOne
           : implode(' ' . Config::AND_SEPARATOR . ' ', [implode(', ', $values), $lastOne ]);
    }

    public function canFilter() : bool
    {
        return true;
    }

    public function filter($key, $value) : void
    {
        $new_values = [];

        foreach ($this->_values as $_value) {
            if ($_value->isObject() && $_value->getField($key) == $value) {
                $new_values []= $_value;
            }
        }

        $this->_values = $new_values;
    }

    public function isObject() : bool
    {
        return false;
    }

}
