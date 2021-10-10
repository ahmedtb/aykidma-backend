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

    public static function fromArray(array $arrayForm)
    {
        $instance = new self($arrayForm['label'], $arrayForm['value']);
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
            'value' => $this->value
        );
    }
    public function render()
    {
        return View('fields.stringField',['field'=>$this, 'input' => false, 'index' => null]);
    }

    public function formInput(int $index)
    {
        return View('fields.stringField',['field'=>$this, 'input' => true, 'index' => $index]);
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
            throw new FieldTypeException('string fields label is not equal');
    }
}
