<?php

declare(strict_types=1);

namespace Chomsky;

use Chomsky\Config;


final class ObjectValue extends Value {

    private $_value = null;

    public function __construct($obj)
    {
        $this->_value = $obj;
    }

    public function __toString() : string
    {
        $vars = [];
        foreach (get_object_vars($this->_value) as $key => $value) {
            $vars []= "$key:$value";
        }
        return '{' . implode(",", $vars) .'}';
    }

}
