<?php

namespace App\FieldsTypes;

use Exception;
use JsonSerializable;
use Illuminate\Support\Facades\Date;
use App\FieldsTypes\FieldTypeException;
use Illuminate\Support\Facades\Validator;

class LocationField extends FieldType
{
    public string $label;

    public array $value = [
        'latitude' => null,
        'longitude' =>  null
    ];

    public static function fromArray(array $array)
    {
        return new self($array['label'], $array['value']);
    }

    public function __construct(string $label, array $value = ['latitude' => null, 'longitude' =>  null])
    {
        $this->label = $label;

        if ($value['latitude'] && $value['longitude'])
            $this->setValue($value);
    }

    public function setValue($value)
    {
        if (gettype($value) != 'array' && sizeof($value) != 2)
            throw new FieldTypeException('location value should be array with size 2');

        // dd($value);
        if (!is_numeric($value['latitude'])  && !is_numeric($value['longitude']))
            throw new FieldTypeException('location value should be array of [latitude=>float, longitude=>float]');

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

    public function generateMockedValue()
    {
        $this->setValue(
            ['latitude' => random_int(0, 5), 'longitude' => random_int(0, 5)]
        );
    }


    public function isCompatibleField($field)
    {
        if (get_class($field) != LocationField::class)
            throw new FieldTypeException('field is not an LocationField');
        else if ($field->label != $this->label)
            throw new FieldTypeException('LocationField label is not equal');
    }
}
