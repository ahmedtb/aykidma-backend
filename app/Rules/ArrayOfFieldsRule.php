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
