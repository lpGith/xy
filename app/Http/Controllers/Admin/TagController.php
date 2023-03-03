<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 13:52
 * File: TagController.php
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\TagRepositoryEloquent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Prettus\Validator\Exceptions\ValidatorException;

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
     * @author qinghe
     * @Time 2022/9/4 13:53
     */
    public function index()
    {
        $tags = $this->tag->paginate('15');

        return view('admin.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new tag.
     * 显示创建新标签的表单
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     * 将新建的标签保存
     * @return Application|RedirectResponse|Redirector
     * @throws ValidatorException
     */
    public function store(Request $request)
    {
        $data = [];
        $data['name'] = $request->name;

        if ($this->tag->create($data)) {
            return redirect('/admin/tag')->with('success', '添加标签成功');
        }

        return redirect(route('admin.tag.create'))->withErrors('标签添加失败');
    }

    /**
     * Show the form for editing the specified resource.
     * 显示编辑指定资源的表单。
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $tag = $this->tag->find($id);
        return view('admin.tag.edit', compact('tag'));
    }

    /**
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param $id
     * @return Application|Redirector|RedirectResponse
     * @throws ValidatorException
     */
    public function update(Request $request, $id)
    {
        $data = [];
        $data['tag_name'] = $request->name;
        if ($this->tag->update($data, $id)) {
            return redirect('/admin/tag')->with('success', '标签修改成功');
        }

        return redirect()->back()->withErrors('标签修改失败');
    }

    /**
     * @param $id
     * @return JsonResponse
     * @Time 2022/9/4 13:54
     * @author qinghe
     */
    public function destroy($id): JsonResponse
    {
        if ($this->tag->delete($id)) {
            return response()->json(['status' => 0]);
        }

        return response()->json(['status' => 1]);
    }
}
