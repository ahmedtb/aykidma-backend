<?php

namespace App\Filters;

class ServiceProviderFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'activated',
    ];

    protected function activated($bool)
    {
        return $this->builder->where('activated', $bool == 'true');
    }
    
}
