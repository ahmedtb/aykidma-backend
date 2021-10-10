<?php

namespace App\Rules;

use Exception;
use App\FieldsTypes\ArrayOfFields;
use Illuminate\Contracts\Validation\Rule;

class ArrayOfFieldsRule implements Rule
{

    protected ?ArrayOfFields $structure;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(?ArrayOfFields $structure = null)
    {
        $this->structure = $structure;
    }

    protected $errorMessage;


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            if ($value['class'] != ArrayOfFields::class)
                return false;
            $instance = ArrayOfFields::fromArray($value);
            if ($this->structure)
                $this->structure->isCompatible($instance);
            // foreach ($instance->getFields() as $index => $field) {
            //     if (
            //         !$this->structure->getFields()[$index]->label == $field->label || !get_class($this->structure->getFields()[$index]) == get_class($field)
            //     ) {
            //         $this->errorMessage = 'array_of_field structure is not compatibale';
            //         return false;
            //     }
            // }
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'InValid ArrayOfFields Array: ' . $this->errorMessage;
    }
}
