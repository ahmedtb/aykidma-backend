<?php

namespace App\Rules;

use App\Rules\base64;
use App\Models\Service;

use function PHPUnit\Framework\matches;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

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
        $service_fields = $this->service->fields;

        if (sizeof($fields) != sizeof($service_fields))
            return false;

        $matches = 0;
        foreach ($service_fields as $service_field) {
            foreach ($fields as $field) {
                if (
                    $this->key_value_pair_exists($field, 'label', $service_field['label'])
                    &&
                    $this->key_value_pair_exists($field, 'type', $service_field['type'])
                )
                    $matches++;
                // if($field['type'] == 'image'){
                //     $validator = Validator::make(['value' => $field['value']], [
                //         'value' => [new base64()],
                //     ]);
                // }
            }
        }
        return $matches == sizeof($service_fields);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The fields formate (types and labels) is not valid.';
    }
}
