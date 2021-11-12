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
        'with'
    ];

    protected function status($status)
    {
        return $this->builder->where('status', $status);
    }

    protected function with($with){
        return $this->builder->with($with);
    }
    
}
