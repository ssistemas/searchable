<?php

namespace Ssistemas\Searchable\Traits;

use \Illuminate\Database\Eloquent\Builder;

trait Searchable {

    /**
    * Apply filters in your QueryBuilder based in $fields
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @param array $fields
    *
    */
    public function scopeSearch(Builder $query,$value)
    {
        if (isset($this->searchable))
        {
            foreach ($this->searchable as $key)
            {
                $query = $query->orWhere($key, 'LIKE', '%'.$value.'%');
            }
            return $query;
        }
    }

}
