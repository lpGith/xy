<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 16:02
 * File: TagRepository.php
 */

namespace App\Repositories\Interfaces;


use Prettus\Repository\Contracts\RepositoryInterface;

interface TagRepository extends RepositoryInterface
{
    public function getModel();
}
