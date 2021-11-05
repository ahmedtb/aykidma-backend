<?php

namespace App\Filters;

class ServiceFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'approved',
    ];

    protected function approved($bool)
    {
        return $this->builder->where('approved', $bool == 'true');
    }
    
}
