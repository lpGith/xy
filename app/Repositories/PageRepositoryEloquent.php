<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 09:51
 * File: PageRepositoryEloquent.php
 */

namespace App\Repositories;


use App\Models\Page;
use App\Repositories\Interfaces\PageRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;

class PageRepositoryEloquent extends BaseRepository implements PageRepository
{
    /**
     * @author qinghe
     * @Time 2022/9/4 09:54
     */
    public function model(): string
    {
        return Page::class;
    }

    /**
     * @throws RepositoryException
     * @author qinghe
     * @Time 2022/9/4 13:35
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param $alias
     * @return LengthAwarePaginator|Collection|mixed
     * @throws RepositoryException
     * @Time 2022/9/4 13:37
     * @author qinghe
     */
    public function aboutInfo($alias)
    {
        $where['link_alias'] = $alias;
        $this->applyConditions($where);

        return $this->first();
    }

    /**
     * @param $alias
     * @return false|LengthAwarePaginator|Collection|mixed
     * @throws RepositoryException
     * @Time 2022/9/4 13:39
     * @author qinghe
     */
    public function getAliasInfo($alias)
    {
        if (is_numeric($alias) && $alias>0){
            return $this->find($alias);
        }

        if ($alias!=''){
            return $this->aboutInfo($alias);
        }

        return false;
    }
}
