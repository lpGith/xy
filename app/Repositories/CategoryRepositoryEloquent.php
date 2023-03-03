<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 21:11
 * File: CategoryRepositoryEloquent.php
 */

namespace App\Repositories;


use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{

    /**
     * @author qinghe
     * @Time 2022/9/3 21:12
     */
    public function model(): string
    {
        return Category::class;
    }

    /**
     * @author qinghe
     * @Time 2022/9/3 21:15
     * @return mixed
     */
    public function getNestedList()
    {
        return $this->model->getNestedList('name', null , "&nbsp;&nbsp;&nbsp;&nbsp;");
    }

    /**
     * @param $input
     * @return bool
     * @Time 2022/9/3 21:16
     * @author qinghe
     */
    public function store($input): bool
    {
        if ($input['cate_id'] == 0) {
            return (bool)$this->model->create(['name' => $input['name']]);
        }

        $category = $this->model->find($input['cate_id']);

        if (!$category) {
            return false;
        }

        return (bool)$category->children()->create(['name' => $input['name']]);
    }

    /**
     * @param array $attributes
     * @param $id
     * @return bool
     * @throws ValidatorException
     * @Time 2022/9/3 21:19
     * @author qinghe
     */
    public function update(array $attributes, $id): bool
    {
        $input['name'] = $attributes['name'];
        $parentId = $attributes['cate_id'];

        $category = $this->model->find($id);

        //该分类不存在
        if (!$category) {
            return false;
        }
        //修改分类名
        //Update the cate_name by id
        if (!parent::update($input, $id)) {
            return false;
        }

        if ($parentId != 0 && $category->parent_id != $parentId) {

            $parentCategory = $this->model->find($parentId);

            if (!$parentCategory) {
                return false;
            }

            if (!$category->makeChildOf($parentCategory)) {
                return false;
            }

        } elseif ($category->parent_id != $parentId && $parentId == 0) {
            //顶级分类
            if (!$category->makeRoot()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @throws RepositoryException
     * @author qinghe
     * @Time 2022/9/3 21:17
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
