<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 15:18
 * File: PageController.php
 */

namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;
use App\Repositories\PageRepositoryEloquent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Prettus\Repository\Exceptions\RepositoryException;

class PageController extends Controller
{
    /**
     * @var PageRepositoryEloquent
     */
    protected PageRepositoryEloquent $page;

    /**
     * PageController constructor.
     * @param PageRepositoryEloquent $page
     */
    public function __construct(PageRepositoryEloquent $page)
    {
        $this->page = $page;
    }

    /**
     * @param $alias
     * @return Application|Factory|View
     * @throws RepositoryException
     * @Time 2022/9/4 15:19
     * @author qinghe
     */
    public function index($alias)
    {
        $page = $this->page->getAliasInfo($alias);

        if(!$page){
            abort(404);
        }

        return view('default.show_page', compact('page'));
    }

    /**
     * 关于页面
     * @return Factory|View
     * @throws RepositoryException
     */
    public function about()
    {
        $page = $this->page->aboutInfo('about');

        if (!$page) {
            abort(404);
        }

        return view('default.show_page', compact('page'));
    }
}
