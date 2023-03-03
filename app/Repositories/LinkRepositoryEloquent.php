<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 09:36
 * File: LinkRepositoryEloquent.php
 */

namespace App\Repositories;


use App\Models\Link;
use App\Repositories\Interfaces\LinkRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;

class LinkRepositoryEloquent extends BaseRepository implements LinkRepository
{
    /**
     * @author qinghe
     * @Time 2022/9/4 09:41
     */
    public function model(): string
    {
        return Link::class;
    }

    /**
     * @throws RepositoryException
     * @author qinghe
     * @Time 2022/9/4 09:41
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
