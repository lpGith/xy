<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 18:10
 * File: ArticleTagRepository.php
 */

namespace App\Repositories\Interfaces;


use Prettus\Repository\Contracts\RepositoryInterface;

interface ArticleTagRepository extends RepositoryInterface
{
    public function getModel();
}
