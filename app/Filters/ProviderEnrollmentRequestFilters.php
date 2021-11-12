<?php

namespace App\Filters;

class ProviderEnrollmentRequestFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'with'
    ];

    protected function with($with)
    {
        return $this->builder->with($with);
    }
}
