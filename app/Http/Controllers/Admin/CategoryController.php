<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 21:10
 * File: CategoryController.php
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepositoryEloquent;
use App\Repositories\NavigationRepositoryEloquent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Prettus\Validator\Exceptions\ValidatorException;

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
     * @author qinghe
     * @Time 2022/9/3 21:21
     */
    public function index()
    {
        $category = $this->category->getNestedList();
        return view('admin.category.index', compact('category'));
    }

    /**
     * @author qinghe
     * @Time 2022/9/3 21:22
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @Time 2022/9/3 21:22
     * @author qinghe
     */
    public function store(Request $request)
    {
        $result = $this->category->store($request->all());

        if ($result) {
            return redirect('admin/category')->with('success', '分类添加成功');
        }

        return redirect(route('admin/category/create'))->withErrors('分类添加失败');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     * @Time 2022/9/3 21:23
     * @author qinghe
     */
    public function edit($id)
    {
        $category = $this->category->find($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|RedirectResponse|Redirector
     * @throws ValidatorException
     * @Time 2022/9/3 21:23
     * @author qinghe
     */
    public function update(Request $request, $id)
    {
        $result = $this->category->update($request->all(), $id);

        if ($result) {
            return redirect('admin/category')->with('success', '修改成功');
        }

        return redirect()->back()->withErrors('分类修改失败');
    }


    /**
     * @param $id
     * @return JsonResponse
     * @Time 2022/9/3 21:24
     * @author qinghe
     */
    public function destroy($id): JsonResponse
    {
        if ($this->category->delete($id)) {
            return response()->json(['status' => 0]);
        }
        return response()->json(['status' => 1]);
    }

    /**
     * @param NavigationRepositoryEloquent $nav
     * @param $id
     * @return RedirectResponse
     * @throws ValidatorException
     * @Time 2022/9/3 21:24
     * @author qinghe
     */
    public function setNavigation(NavigationRepositoryEloquent $nav, $id): RedirectResponse
    {
        $category = $this->category->find($id);

        if ($nav->setCategoryNav($category->id, $category->name)) {
            return redirect()->back()->with('success', '设置成功');
        }

        return redirect()->back()->withErrors('设置失败');
    }
}
