<?php

namespace App\FieldsTypes;

use JsonSerializable;
use Illuminate\Support\Facades\Date;
use App\FieldsTypes\FieldTypeException;
use Illuminate\Support\Facades\Validator;

class OptionsField extends FieldType
{
    public string $label;
    public array $options;
    private ?string $value = null;
    public bool $required = true;

    public static function fromArray(array $arrayForm)
    {
        $instance = new self($arrayForm['label'], $arrayForm['options'], $arrayForm['value'], $arrayForm['required']);
        return $instance;
    }

    public function __construct(string $label, array $options, ?string $value = null, ?bool $required = true)
    {
        $this->label = $label;
        $this->options = $options;
        $this->required = $required;

        if ($value)
            $this->setValue($value);
    }

    public function setValue($value)
    {
        if (!in_array($value, $this->options))
            throw new FieldTypeException('please choose from the options');

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
            'options' => $this->options,
            'value' => $this->value,
            'required' => $this->required

        );
    }

    public function generateMockedValue()
    {
        // $faker = new \Faker\Generator();
        $this->setValue($this->options[array_rand($this->options)]);
    }

    public function isCompatibleField($field)
    {
        if (get_class($field) != OptionsField::class)
            throw new FieldTypeException('field is not an OptionsField');
        else if ($field->label != $this->label)
            throw new FieldTypeException('optionsfields label is not equal');
        else if ($field->options != $this->options)
            throw new FieldTypeException('optionsfields options is not equal');
        else if ($this->required && $field->value == null)
            throw new FieldTypeException('options field value is required');
    }
}
