<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 14:17
 * File: UserRepositoryEloquent.php
 */

namespace App\Repositories;


use App\Models\User;
use App\Repositories\Interfaces\UserRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{

    /**
     * @author qinghe
     * @Time 2022/9/4 14:18
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * @throws RepositoryException
     * @author qinghe
     * @Time 2022/9/4 14:18
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param array $input
     * @param $avatar
     * @return bool
     * @throws ValidatorException
     * @Time 2022/9/4 14:19
     * @author qinghe
     */
    public function store(array $input, $avatar): bool
    {
        $attr['email'] = $input['email'];
        $attr['name'] = $input['name'];
        $attr['password'] = bcrypt($input['password']);

        if ($avatar != '') {
            $attr['user_pic'] = $avatar;
        }

        if (parent::create($attr)) {
            return true;
        }

        return false;
    }

    /**
     * @param array $input
     * @param $id
     * @param string $avatar
     * @return bool
     * @throws ValidatorException
     * @Time 2022/9/4 14:19
     * @author qinghe
     */
    public function update(array $input, $id, string $avatar = ''): bool
    {
        $attr['email'] = $input['email'];
        $attr['name'] = $input['name'];
        if ($input['password'] != '') {
            $attr['password'] = bcrypt($input['password']);
        }

        if ($avatar != '') {
            $attr['user_pic'] = $avatar;
        }

        if (parent::update($attr, $id)) {
            return true;
        }

        return false;
    }

    /**
     * @author qinghe
     * @Time 2022/9/4 14:20
     */
    public function getUserInfo()
    {
        $columns = ['id', 'name', 'user_pic', 'email'];
        return $this->first($columns);
    }
}
