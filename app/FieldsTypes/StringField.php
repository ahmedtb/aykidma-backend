<?php

namespace App\FieldsTypes;

use Faker\Generator;
use App\FieldsTypes\FieldType;
use Illuminate\Container\Container;
use App\FieldsTypes\FieldTypeException;

class StringField extends FieldType
{
    public string $label;
    public ?string $value = null;
    public bool $required = true;

    public static function fromArray(array $array)
    {
        $instance = new self($array['label'], $array['value'], $array['required']);
        return $instance;
    }

    public function __construct(string $label, ?string $value = null, ?bool $required = true)
    {
        $this->label = $label;
        $this->required = $required;

        if ($value)
            $this->setValue($value);
    }

    public function setValue($value)
    {
        if (!(gettype($value) == 'string') && $value != null)
            throw new FieldTypeException('not valid value type..expected string');
        $this->value = $value;
        return $this;
    }
    public function getValue()
    {
        return $this->value;
    }

    public function jsonSerialize()
    {
        return array(
            'class' => static::class,
            'label' => $this->label,
            'value' => $this->value,
            'required' => $this->required

        );
    }


    public function generateMockedValue()
    {
        $faker = Container::getInstance()->make(Generator::class);
        $this->setValue($faker->sentence());
    }


    public function isCompatibleField($field)
    {
        // dd(get_class($field));
        if (get_class($field) != StringField::class)
            throw new FieldTypeException('field is not an string Field');
        else if ($field->label != $this->label)
            throw new FieldTypeException('string field label is not equal');
        else if ($this->required && $field->value == null)
            throw new FieldTypeException('string field value is required');
    }
}
