<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 18:10
 * File: ArticleTagRepositoryEloquent.php
 */

namespace App\Repositories;


use App\Models\ArticleTag;
use App\Repositories\Interfaces\ArticleTagRepository;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;

class ArticleTagRepositoryEloquent extends BaseRepository implements ArticleTagRepository
{

    /**
     * @author qinghe
     * Time 2022/9/3 18:11
     */
    public function model(): string
    {
        return ArticleTag::class;
    }

    /**
     * @throws RepositoryException
     * @author qinghe
     * Time 2022/9/3 18:12
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @author qinghe
     * Time 2022/9/3 18:13
     */
    public function getModel(): Model
    {
        return $this->model;
    }
}
