<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/11/17
 * Time: 17:33
 * File: HasFilter.php
 */

namespace App\Traits;

use App\Filters\QueryFilter;
use Illuminate\Database\Query\Builder;

trait HasFilter
{
    /**
     * @param $query
     * @param QueryFilter $filter
     * @return Builder
     * @Time 2022/11/17 17:53
     * @author qinghe
     */
    public function scopeFilter($query, QueryFilter $filter): Builder
    {
        return $filter->apply($query);
    }
}
