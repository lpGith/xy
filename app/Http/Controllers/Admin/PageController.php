<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 09:50
 * File: PageController.php
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\PageRepositoryEloquent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Prettus\Validator\Exceptions\ValidatorException;

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
     * @author qinghe
     * @Time 2022/9/4 13:40
     */
    public function index()
    {
        $pages = $this->page->all();
        return view('admin.page.index', compact('pages'));
    }

    /**
     * @author qinghe
     * @Time 2022/9/4 13:40
     */
    public function create()
    {
        return view('admin.page.create');
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @throws ValidatorException
     * @Time 2022/9/4 13:41
     * @author qinghe
     */
    public function store(Request $request)
    {
        if ($this->page->create($request->all())) {
            return redirect('admin/page')->with('success', '创建成功');
        }

        return redirect()->back()->withErrors('创建失败');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     * @Time 2022/9/4 13:41
     * @author qinghe
     */
    public function edit($id)
    {
        $page = $this->page->find($id);
        return view('admin.page.edit', compact('page'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|RedirectResponse|Redirector
     * @throws ValidatorException
     * @Time 2022/9/4 13:42
     * @author qinghe
     */
    public function update(Request $request, $id)
    {
        if ($this->page->update($request->all(), $id)) {
            return redirect('admin/page')->with('success', '修改成功');
        }

        return redirect()->back()->withErrors('修改失败');
    }

    /**
     * @param $id
     * @return JsonResponse
     * @Time 2022/9/4 13:42
     * @author qinghe
     */
    public function destroy($id): JsonResponse
    {
        if ($this->page->delete($id)) {
            return response()->json(['status' => 0]);
        }

        return response()->json(['status' => 1]);
    }
}
