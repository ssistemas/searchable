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
    public function scopeSearch(Builder $q, $search)
    {

        $query = clone $q;
        $query->select($this->getTable() . '.*');
        $this->makeJoins($query);
        if (!$search)
        {
            return $q;
        }

        $search = mb_strtolower(trim($search));
        $words = explode(' ', $search);

        if (isset($this->searchable))
        {
            foreach ($this->getColumns() as $key)
            {
                $query = $query->orWhere($key, 'LIKE', '%'.$search.'%');
            }
            foreach ($this->getOrders() as $key)
            {
                $arr = explode(',',$key);
                $query->orderBy($arr[0],$arr[1]);
            }
            return $query;
        }
    }
    /**
     * Returns the search columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        if (array_key_exists('columns', $this->searchable)) {
            $columns = [];
            foreach($this->searchable['columns'] as $column){
                $columns[] = $column;
            }
            return $columns;
        } else {
            return [];
        }
    }

    /**
     * Returns the order columns.
     *
     * @return array
     */
    protected function getOrders()
    {
        if (array_key_exists('orders', $this->searchable)) {
            $columns = [];
            foreach($this->searchable['orders'] as $column){
                $columns[] = $column;
            }
            return $columns;
        } else {
            return [];
        }
    }


    /**
     * Returns the tables that are to be joined.
     *
     * @return array
     */
    protected function getJoins()
    {
        return array_get($this->searchable, 'joins', []);
    }
    /**
     * Adds the sql joins to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    protected function makeJoins(\Illuminate\Database\Eloquent\Builder $query)
    {
        foreach ($this->getJoins() as $table => $keys) {
            $query->join($table, function ($join) use ($keys) {
                $join->on($keys[0], '=', $keys[1]);
                if (array_key_exists(2, $keys) && array_key_exists(3, $keys)) {
                    $join->where($keys[2], '=', $keys[3]);
                }
            });
        }
    }
}
