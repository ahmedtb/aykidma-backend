<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64Rule implements Rule
{

    protected int $maxSize;
    protected ?string $message = null;
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
        if (strlen($value) >= $this->maxSize) {
            $this->message = 'the base64 string exceedes the max size';
            return true;
        } else if (base64_encode(base64_decode($value)) === $value) {
            $this->message = 'the string is not valid base64 string';
            return true;
        } else {            // dd('failure!');
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
        return $this->message;
    }
}
