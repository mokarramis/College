<?php

namespace App\Service\Datatable;

use function PHPUnit\Framework\isJson;

class Datatable 
{
    protected $query = null;
    protected $request = null;

    public function __construct($request, $query, $searchWithlist=[])
    {
        $this->request = $request;
        $this->query = $this->queryBuilder($query, $request, $searchWithlist);
    }

    public function queryBuilder ($query, $request, $searchWithlist) 
    {
        $sort_field = $request->input('sort_field') ? $request->input('sort_field') : null;
        $sort_order = $request->input('sort_order') ? $request->input('sort_order') : 'asc';

        $search = $request->search;

        $x = [
            "content" => function ($query, $key, $value) {
                foreach ($value as $items => $item) {
                    return $query->whereHas('content', function($q) use ($items, $item){
                        $q->where($items, 'like', '%'.$item.'%');
                    });
                }
            }
        ];

        if ($search) {
            $search = isJson($search);
            foreach ($search as $key => $value) {
                if(!in_array($key, $searchWithlist)) continue;
                if (array_key_exists($key, $x)) {
                    $query = $x[$key]($query, $key, $value);
                } else {
                    $query = $query->where($key, $value);
                }
            }
        }

        if ($sort_field) {
            $query = $query->orderBy($sort_field, $sort_order);
        }

        return $query;
    }

}