<?php

declare(strict_types=1);

namespace Chomsky;

use Chomsky\Config;
use Chomsky\Expression;


final class StringValue extends Value {

    private $_value = [];

    public function __construct($value)
    {
        $this->_value = $value;
    }

    public function __toString() : string
    {
        return $this->_value;
    }

}
