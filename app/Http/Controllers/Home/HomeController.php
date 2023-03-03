<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 15:16
 * File: HomeController.php
 */

namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepositoryEloquent;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * @var ArticleRepositoryEloquent
     */
    protected ArticleRepositoryEloquent $article;

    /**
     * HomeController constructor.
     * @param ArticleRepositoryEloquent $article
     */
    public function __construct(ArticleRepositoryEloquent $article)
    {
        $this->article = $article;
    }

    /**
     * Show the resource dashboard.
     * @return Factory|View
     */
    public function index()
    {
        $articles = $this->article
            ->with('category')
            ->orderBy('sort','desc')
            ->orderBy('id','desc')
            ->paginate(15,['id','title','desc','created_at','read_count','cate_id','comment_count','list_pic']);

        return view('default.home',compact('articles'));
    }

    /**
     * @author qinghe
     * @Time 2022/9/4 15:17
     */
    public function player()
    {
        return view('default.player');
    }
}
