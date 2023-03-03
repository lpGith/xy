<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 15:19
 * File: SearchController.php
 */

namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepositoryEloquent;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Prettus\Repository\Exceptions\RepositoryException;

class SearchController extends Controller
{
    /**
     * @var ArticleRepositoryEloquent
     */
    protected ArticleRepositoryEloquent $article;

    /**
     * SearchController constructor.
     * @param ArticleRepositoryEloquent $article
     */
    public function __construct(ArticleRepositoryEloquent $article)
    {
        $this->article = $article;
    }

    /**
     * @param Request $request
     * @return Factory|View
     * @throws RepositoryException
     */
    public function index(Request $request)
    {
        $articles = $this->article->searchKeywordArticle($request->keyword);
        return view('default.search_article', compact('articles'));
    }
}
