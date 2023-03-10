<?php

namespace App\Presenters;


use App\Repositories\UserRepositoryEloquent;
use App\Transformers\UserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class UserPresenter extends FractalPresenter
{
    /**
     * @var UserRepositoryEloquent
     */
    protected UserRepositoryEloquent $user;

    /**
     * UserPresenter constructor.
     * @param UserRepositoryEloquent $user
     * @throws \Exception
     */
    public function __construct(UserRepositoryEloquent $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Get Transformer
     * @return UserTransformer
     */
    public function getTransformer(): UserTransformer
    {
        // TODO: Implement getTransformer() method.
        return new UserTransformer();
    }

    /**
     * 获取作者信息
     * Get the user info
     * @param int $userId
     * @return mixed
     */
    public function getUserInfo(int $userId = 0)
    {
        $columns = ['id', 'name', 'user_pic'];

        if ($userId > 0) {
           return $this->user->find($userId, $columns);
        }

        return $this->user->first($columns);
    }

}
