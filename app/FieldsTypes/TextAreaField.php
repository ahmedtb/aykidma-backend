<?php

namespace App\FieldsTypes;

use Exception;
use Faker\Generator;
use Illuminate\Container\Container;


class TextAreaField extends FieldType
{
    public string $label;

    private ?string $value = null;

    public static function fromArray(array $arrayForm)
    {
        $instance = new self($arrayForm['label'],$arrayForm['value']);
        return $instance;
    }
    
    public function __construct(string $label, ?string $value = null)
    {
        $this->label = $label;
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
            'value' => $this->value
        );
    }

    public function render()
    {
        return View('fields.textAreaField',['field'=>$this, 'input' => false, 'index' => null]);
    }

    public function formInput(int $index)
    {
        return View('fields.textAreaField',['field'=>$this, 'input' => true, 'index' => $index]);
    }
    
    public function generateMockedValue() {
        $faker = Container::getInstance()->make(Generator::class);
        $this->setValue($faker->sentence());
    }

    public function isCompatibleField($field)
    {
        if (!get_class($field) != TextAreaField::class)
            throw new FieldTypeException('field is not an TextAreaField');
        else if ($field->label != $this->label)
            throw new FieldTypeException('TextAreaField label is not equal');
    }
}
