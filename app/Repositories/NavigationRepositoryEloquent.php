<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 21:25
 * File: NavigationRepositoryEloquent.php
 */

namespace App\Repositories;


use App\Models\Navigation;
use App\Repositories\Interfaces\NavigationRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class NavigationRepositoryEloquent extends BaseRepository implements NavigationRepository
{

    /**
     * @author qinghe
     * @Time 2022/9/3 21:28
     */
    public function model(): string
    {
        return Navigation::class;
    }

    /**
     * @throws RepositoryException
     * @author qinghe
     * @Time 2022/9/3 21:29
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 设置分类分导航
     *
     * @param int $categoryId
     * @param string $categoryName
     * @return bool
     * @throws ValidatorException
     * @Time 2022/9/3 21:30
     * @author qinghe
     */
    public function setCategoryNav(int $categoryId, string $categoryName): bool
    {
        $where = [
            ['article_cate_id', '=', $categoryId],
            ['nav_type', '=', 1]
        ];
        $navigation = $this->findWhere($where);
        if (!$navigation->isEmpty()) {
            return true;
        }

        $create['article_cate_id'] = $categoryId;
        $create['nav_type'] = 1;
        $create['name'] = $categoryName;
        $create['url'] = route('category', ['id' => $categoryId]);

        if ($this->create($create)) {
            return true;
        }

        return false;
    }
}
