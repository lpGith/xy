<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 19:29
 * File: ArticlePresenter.php
 */

namespace App\Presenters;


use App\Repositories\ArticleRepositoryEloquent;
use App\Repositories\ArticleTagRepositoryEloquent;
use App\Transformers\ArticleTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class ArticlePresenter extends FractalPresenter
{
    /**
     * @var ArticleRepositoryEloquent
     */
    protected ArticleRepositoryEloquent $article;

    /**
     * ArticlePresenter constructor.
     * @param ArticleRepositoryEloquent $article
     * @throws \Exception
     */
    public function __construct(ArticleRepositoryEloquent $article)
    {
        $this->article = $article;
        parent::__construct();
    }


    /**
     * @author qinghe
     * @Time 2022/9/4 19:33
     */
    public function getTransformer(): ArticleTransformer
    {
        return new ArticleTransformer();
    }

    /**
     * @param $title
     * @return string
     * @Time 2022/9/4 19:34
     * @author qinghe
     */
    public function formatTitle($title): string
    {
        if (strlen($title) <= 20) {
            return $title;
        } else {
            return mb_substr($title, 0, 20, 'utf-8') . '...';
        }
    }

    /**
     * @author qinghe
     * @Time 2022/9/4 19:34
     */
    public function hotArticleList()
    {
        return $this->article
            ->orderBy('read_count', 'desc')
            ->paginate(5, ['id', 'title', 'read_count', 'created_at', 'list_pic']);
    }
}
