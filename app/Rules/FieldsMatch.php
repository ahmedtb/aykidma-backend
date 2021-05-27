<?php

namespace App\Rules;

use App\Models\Service;
use Illuminate\Contracts\Validation\Rule;

use function PHPUnit\Framework\matches;

class FieldsMatch implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }


    function key_value_pair_exists(array $haystack, $key, $value)
    {
        return array_key_exists($key, $haystack) &&
            $haystack[$key] == $value;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $fields)
    {

        // $offer = $this->service->offer;
        // if (!$offer)
        //     return false;

        $offer_fields = $this->service->fields;

        if (sizeof($fields) != sizeof($offer_fields))
            return false;
            
        $matches = 0;
        foreach ($offer_fields as $offer_field) {
            foreach ($fields as $field) {
                if (
                    $this->key_value_pair_exists($field, 'label', $offer_field['label'])
                    &&
                    $this->key_value_pair_exists($field, 'type', $offer_field['type'])
                )
                    $matches++;
            }
        }
        return $matches == sizeof($offer_fields);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
