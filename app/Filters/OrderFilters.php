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
        'service',
        'provider',
        'user'
    ];

    protected function status($status)
    {
        return $this->builder->where('status', $status);
    }
    
    protected function service()
    {
        return $this->builder->with('service');
    }
    
    protected function provider()
    {
        return $this->builder->with('service.ServiceProvider');
    }
    
    protected function user()
    {
        return $this->builder->with('user');
    }
}
