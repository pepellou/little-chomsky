<?php

declare(strict_types=1);

namespace Chomsky;

use Chomsky\Config;


final class ObjectValue extends Value {

    private $_value = null;
    private $_value_as_array = [];

    public function __construct($obj)
    {
        $this->_value = $obj;
        $this->_value_as_array = get_object_vars($this->_value);
    }

    public function __toString() : string
    {
        $vars = [];
        foreach ($this->_value_as_array as $key => $value) {
            $vars []= "$key:$value";
        }
        return '{' . implode(",", $vars) .'}';
    }

    public function canFilter() : bool
    {
        return false;
    }

    public function filter($key, $value) : void
    {
    }

    public function isObject() : bool
    {
        return true;
    }

    public function getField($key)
    {
        return $this->_value_as_array[$key];
    }

}
