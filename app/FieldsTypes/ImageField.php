<?php

namespace App\FieldsTypes;

use Exception;
use Faker\Generator;
use Illuminate\Container\Container;
use App\FieldsTypes\FieldTypeException;

class ImageField extends FieldType
{
    public string $label;
    public ?string $value = null;
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
        if (gettype($value) != 'string' || !isValidBase64($value))
            throw new FieldTypeException('not valid value base64 string..');

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
        $this->setValue(getBase64DefaultImage());
    }

    public function isCompatibleField($field)
    {
        if (get_class($field) != ImageField::class)
            throw new FieldTypeException('field is not an ImageField');
        else if ($field->label != $this->label)
            throw new FieldTypeException('ImageField label is not equal');
        else if ($this->required && $field->value == null)
            throw new FieldTypeException('Image Field value is required');
    }
}
