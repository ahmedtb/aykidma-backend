<?php

namespace App\FieldsTypes;

use JsonSerializable;


abstract class FieldType implements JsonSerializable
{

    public function getName()
    {
        return array_pop(explode('\\', get_class($this)));
    }

    abstract public static function fromArray(array $array);
    abstract public function setValue($value);
    abstract public function getValue();
    abstract public function generateMockedValue();
    abstract public function isCompatibleField($field);
}
