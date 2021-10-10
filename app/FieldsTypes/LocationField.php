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

    private ?float $latitude = null;
    private ?float $longitude = null;

    public static function fromArray(array $array)
    {
        return new self($array['label'], $array['latitude'], $array['longitude']);
    }

    public function __construct(string $label, ?float $latitude = null, ?float $longitude = null)
    {
        $this->label = $label;

        if ($latitude && $longitude)
            $this->setValue([$latitude, $longitude]);
    }

    public function setValue($value)
    {
        if (gettype($value) != 'array' && sizeof($value) != 2)
            throw new Exception('location value should be array of [$latitude, $longitude]');

        $this->latitude = $value[0];
        $this->latitude = $value[1];

        return $this;
    }
    public function getValue()
    {
        return [$this->latitude, $this->longitude];
    }

    public function jsonSerialize()
    {
        return array(
            'class' => static::class,
            'label' => $this->label,
            'value' => [$this->latitude, $this->longitude]
        );
    }

    public function generateMockedValue()
    {
        $this->setValue([random_int(0, 5), random_int(0, 5)]);
    }

    
    public function isCompatibleField($field)
    {
        if (!get_class($field) != LocationField::class)
            throw new FieldTypeException('field is not an LocationField');
        else if ($field->label != $this->label)
            throw new FieldTypeException('LocationField label is not equal');
    }
}
