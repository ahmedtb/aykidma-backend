<?php

namespace App\FieldsTypes;

use Exception;
use Faker\Generator;
use Illuminate\Container\Container;


class TextAreaField extends FieldType
{
    public string $label;

    private ?string $value = null;
    public bool $required = true;

    public static function fromArray(array $arrayForm)
    {
        $instance = new self($arrayForm['label'], $arrayForm['value'], $arrayForm['required']);
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
        if (!(gettype($value) == 'string'))
            throw new Exception('not valid value type..expected string');
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
        if (get_class($field) != TextAreaField::class)
            throw new FieldTypeException('field is not an TextAreaField');
        else if ($field->label != $this->label)
            throw new FieldTypeException('TextAreaField label is not equal');
        else if ($this->required && $field->value == null)
            throw new FieldTypeException('TextAreaField value is required');
    }
}
