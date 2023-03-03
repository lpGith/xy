<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 09:35
 * File: LinkController.php
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\LinkRepositoryEloquent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Prettus\Validator\Exceptions\ValidatorException;

class LinkController extends Controller
{
    /**
     * @var LinkRepositoryEloquent
     */
    protected LinkRepositoryEloquent $link;

    /**
     * LinkController constructor.
     * @param LinkRepositoryEloquent $link
     */
    public function __construct(LinkRepositoryEloquent $link)
    {
        $this->link = $link;
    }

    /**
     * @author qinghe
     * @Time 2022/9/4 09:43
     */
    public function index()
    {
        $links = $this->link->all();
        return view('admin.link.index', compact('links'));
    }

    /**
     * 新建链接表单页
     * Show a form for creating a new resource.
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.link.create');
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @throws ValidatorException
     * @Time 2022/9/4 09:43
     * @author qinghe
     */
    public function store(Request $request)
    {
        if ($this->link->create($request->all())) {
            return redirect('admin/link')->with('success', '友情链接添加成功');
        }

        return redirect()->back()->withErrors('系统异常，友情链接添加失败');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     * @Time 2022/9/4 09:44
     * @author qinghe
     */
    public function edit($id)
    {
        $link = $this->link->find($id);

        return view('admin.link.edit', compact('link'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|RedirectResponse|Redirector
     * @throws ValidatorException
     * @Time 2022/9/4 09:44
     * @author qinghe
     */
    public function update(Request $request, $id)
    {
        if ($this->link->update($request->all(), $id)) {
            return redirect('admin/link')->with('success', '友情链接修改成功');
        }

        return redirect()->back()->withErrors('友情链接修改失败');
    }

    /**
     * @param $id
     * @return JsonResponse
     * @Time 2022/9/4 09:45
     * @author qinghe
     */
    public function destroy($id): JsonResponse
    {
        if ($this->link->delete($id)) {
            return response()->json(['status' => 0]);
        }

        return response()->json(['status' => 1]);
    }
}
