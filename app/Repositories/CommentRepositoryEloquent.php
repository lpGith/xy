<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 09:29
 * File: CommentRepositoryEloquent.php
 */

namespace App\Repositories;


use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;

class CommentRepositoryEloquent extends BaseRepository implements CommentRepository
{

    /**
     * @author qinghe
     * @Time 2022/9/4 09:31
     */
    public function model(): string
    {
       return Comment::class;
    }

    /**
     * @throws RepositoryException
     * @author qinghe
     * @Time 2022/9/4 09:32
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
