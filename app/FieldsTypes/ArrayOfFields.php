<?php

namespace App\FieldsTypes;

use Countable;
use Exception;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use JsonSerializable;

class ArrayOfFields implements JsonSerializable, Countable
{
    private ?array $fields = [];
    public static function fromArray(array $arrayForm)
    {
        $instance = new self($arrayForm['fields']);
        return $instance;
    }

    public function __construct(?array $fields = null)
    {
        if ($fields)
            $this->setFields($fields);
    }

    public function setFields($fields)
    {
        foreach ($fields as $field) {
            $this->setField($field);
        }
        // $this->fields = $fields;
        return $this;
    }

    public function removeField($index)
    {
        unset($this->fields[$index]);
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function setField($field, $index = null)
    {
        if ($index == null || count($this->fields)  == 0) {
            if (gettype($field) == 'array') {
                $instance = $field['class']::fromArray($field);
                array_push($this->fields, $instance);
            } elseif ($field instanceof FieldType)
                array_push($this->fields, $field);
            return $this;
        }

        if ($index >= count($this->fields)) {
            throw new Exception('index is larger than the max index...fields size is = ' . count($this->fields));
        } else {
            $this->fields[$index] = $field;
            return $this;
        }
    }

    public function getField($index)
    {
        return $this->fields[$index];
    }

    public function jsonSerialize()
    {
        return array(
            'class' => static::class,
            'fields' => array_map(function ($field) {
                return $field->jsonSerialize();
            }, $this->getFields()),
        );
    }

    public function count()
    {
        return count($this->fields);
    }

    public function generateMockedValues()
    {
        foreach ($this->fields as $field) {
            $field->generateMockedValue();
        }
    }

    public function isCompatible(ArrayOfFields $array_of_fields)
    {
        // dd($this);
        foreach ($this->getFields() as $index => $field) {
            $field->isCompatibleField($array_of_fields->getFields()[$index]);
        }
    }
}
