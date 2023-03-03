<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 15:20
 * File: TagController.php
 */

namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;
use App\Repositories\TagRepositoryEloquent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class TagController extends Controller
{
    /**
     * @var TagRepositoryEloquent
     */
    protected TagRepositoryEloquent $tag;

    /**
     * TagController constructor.
     * @param TagRepositoryEloquent $tag
     */
    public function __construct(TagRepositoryEloquent $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @param $id
     * @return Application|Factory|View
     * @Time 2022/9/4 15:21
     * @author qinghe
     */
    public function index($id)
    {
        $tag = $this->tag->find($id);
        $articles = $tag->article()
            ->orderby('sort', 'desc')
            ->orderby('id', 'desc')
            ->paginate(15);

        return view('default.tag_article', compact('articles', 'tag'));
    }
}
