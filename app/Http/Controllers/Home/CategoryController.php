<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 15:03
 * File: CategoryController.php
 */

namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepositoryEloquent;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class CategoryController extends Controller
{

    /**
     * @var CategoryRepositoryEloquent
     */
    protected CategoryRepositoryEloquent $category;

    /**
     * CategoryController constructor.
     * @param CategoryRepositoryEloquent $category
     */
    public function __construct(CategoryRepositoryEloquent $category)
    {
        $this->category = $category;
    }

    /**
     * 通过分类查询文章
     * Get the category and select the specified articles.
     * @param $id
     * @return Factory|View
     */
    public function index($id)
    {
        $category = $this->category->find($id);
        $articles = $category->article()
            ->orderBy('sort', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15,['id','title','desc','created_at','read_count','cate_id','comment_count','list_pic']);

        return view('default.category_article', compact('category', 'articles'));
    }
}
