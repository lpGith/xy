<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 13:43
 * File: SystemRepositoryEloquent.php
 */

namespace App\Repositories;


use App\Models\System;
use App\Repositories\Interfaces\SystemRepository;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class SystemRepositoryEloquent extends BaseRepository implements SystemRepository
{
    private $config;

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->config = config('blog.system_key');
    }

    /**
     * @author qinghe
     * @Time 2022/9/4 13:45
     */
    public function model(): string
    {
        return System::class;
    }

    /**
     * @throws RepositoryException
     * @author qinghe
     * @Time 2022/9/4 13:47
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    /**
     * @author qinghe
     * @Time 2022/9/4 13:50
     */
    public function optionList(): array
    {
        //检索数据库表的所有数据
        $all = $this->all(['key', 'value']);

        $system = $this->initSystemKey();
        foreach ($all as $item) {
            $system[$item['key']] = $item['value'];
        }
        return $system;
    }


    /**
     * @author qinghe
     * @Time 2022/9/4 13:49
     */
    public function initSystemKey(): array
    {
        $init = [];
        $configs = array_flip($this->config);

        foreach ($configs as $k => $v) {
            $init[$k] = '';
        }

        return $init;
    }

    /**
     * @param array $data
     * @return bool
     * @throws ValidatorException
     * @Time 2022/9/4 13:50
     * @author qinghe
     */
    public function store(array $data): bool
    {
        if (!$data) {
            return false;
        }

        unset($data['_token']);
        foreach ($data as $key => $value) {
            if (in_array($key, $this->config)) {
                $this->updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        return true;
    }
}
