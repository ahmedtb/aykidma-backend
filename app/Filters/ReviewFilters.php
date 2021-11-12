<?php

namespace App\Filters;

class ReviewFilters extends Filters
{
    
    protected $filters = [
        'with'
    ];

    protected function with($with){
        return $this->builder->with($with);
    }
}
