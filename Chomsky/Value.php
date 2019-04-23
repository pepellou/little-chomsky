<?php

declare(strict_types=1);

namespace Chomsky;

class Value {

    public static function create($value) : Value
    {
        if (is_array($value)) {
            return new ArrayValue($value);
        }
        if (is_string($value)) {
            return new StringValue($value);
        }
        if (is_object($value)) {
            return new ObjectValue($value);
        }
    }

}
