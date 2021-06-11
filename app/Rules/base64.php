<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class base64 implements Rule
{

    protected int $maxSize;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $maxSize)
    {
        $this->maxSize = $maxSize;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (sizeof($value) >= $this->maxSize || base64_encode(base64_decode($value)) === $value) {
            // dd('Success! The String entered match base64_decode and is Image');
            return true;
        } else {
            // dd('failure!');
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'image string value is not a valid base64 string';
    }
}
