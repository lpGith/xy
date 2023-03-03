<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 16:02
 * File: TagRepositoryEloquent.php
 */

namespace App\Repositories;


use App\Models\Tag;
use App\Repositories\Interfaces\TagRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;

class TagRepositoryEloquent extends BaseRepository implements TagRepository
{
    /**
     * @author qinghe
     * Time 2022/9/3 16:04
     */
    public function model(): string
    {
        return Tag::class;
    }

    /**
     * @throws RepositoryException
     * @author qinghe
     * Time 2022/9/3 16:05
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param $tagName
     * Time 2022/9/3 16:09
     * @author qinghe
     * */
    public function findName($tagName)
    {
        $tag = $this->findByField('name', $tagName, ['id', 'name']);
        $data = [];
        if (!$tag->isEmpty()) {
            $tempData = $tag->toArray();
            $data = $tempData[0];
        }

        return $data;
    }
}
