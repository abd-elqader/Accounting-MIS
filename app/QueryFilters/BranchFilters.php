<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;
use Illuminate\Support\Arr;

class BranchFilters extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function id($term)
    {
        return $this->builder->where('id',$term);
    }
}
