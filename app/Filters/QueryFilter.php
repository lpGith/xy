<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/11/17
 * Time: 17:46
 * File: QueryFilter.php
 */

namespace App\Filters;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * class QueryFilter
 */
abstract class QueryFilter
{
    protected Request $request;
    protected Builder $builder;

    /**
     * QueryFilter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

    }


    /**
     * @param Builder $builder
     * @return Builder
     * @Time 2022/11/17 17:52
     * @author qinghe
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (!empty($value) && method_exists($this, Str::camel($name))) {
                call_user_func_array([$this, Str::camel($name)], array_filter([$value]));
            }
        }

        return $this->builder;
    }


    /**
     * @author qinghe
     * @Time 2022/11/17 17:49
     */
    public function filters(): array
    {
        return $this->request->all();
    }
}
