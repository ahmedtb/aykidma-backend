<?php

namespace App\Filters;

class OrderFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'status',
    ];

    protected function status($status)
    {
        return $this->builder->where('status', $status);
    }
    
}
