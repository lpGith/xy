<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 09:45
 * File: NavigationController.php
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\NavigationRepositoryEloquent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Prettus\Validator\Exceptions\ValidatorException;

class NavigationController extends Controller
{
    /**
     * @var NavigationRepositoryEloquent
     */
    protected NavigationRepositoryEloquent $navigation;

    /**
     * NavigationController constructor.
     * @param NavigationRepositoryEloquent $navigation
     */
    public function __construct(NavigationRepositoryEloquent $navigation)
    {
        $this->navigation = $navigation;
    }

    /**
     * @author qinghe
     * @Time 2022/9/4 09:47
     */
    public function index()
    {
        $navigations = $this->navigation
            ->with(['category'])
            ->orderBy('sequence', 'desc')
            ->all();

        return view('admin.navigation.index', compact('navigations'));
    }

    /**
     * @author qinghe
     * @Time 2022/9/4 09:47
     */
    public function create()
    {
        return view('admin.navigation.create');
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @throws ValidatorException
     * @Time 2022/9/4 09:48
     * @author qinghe
     */
    public function store(Request $request)
    {
        if ($this->navigation->create($request->all())) {
            return redirect('admin/navigation')->with('success', '导航添加成功');
        }

        return redirect()->back()->withErrors('导航添加失败');
    }

    /**
     * @param $id
     * @return Application|Factory|\Illuminate\View\View
     * @Time 2022/9/4 09:48
     * @author qinghe
     */
    public function edit($id)
    {
        $navigation = $this->navigation->find($id);

        return view('admin.navigation.edit', compact('navigation'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|RedirectResponse|Redirector
     * @throws ValidatorException
     * @Time 2022/9/4 09:49
     * @author qinghe
     */
    public function update(Request $request, $id)
    {
        if ($this->navigation->update($request->all(), $id)) {
            return redirect('admin/navigation')->with('success', '修改成功');
        }

        return redirect()->back()->withErrors('修改失败');
    }

    /**
     * @param $id
     * @return JsonResponse
     * @Time 2022/9/4 09:49
     * @author qinghe
     */
    public function destroy($id): JsonResponse
    {
        if ($this->navigation->delete($id)) {
            return response()->json(['status' => 0]);
        }

        return response()->json(['status' => 1]);
    }
}
