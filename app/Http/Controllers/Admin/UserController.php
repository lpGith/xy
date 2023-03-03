<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 14:16
 * File: UserController.php
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use App\Services\ImageUploads;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Prettus\Validator\Exceptions\ValidatorException;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected UserRepository $user;

    /**
     * UserController constructor.
     * @param UserRepositoryEloquent $user
     */
    public function __construct(UserRepositoryEloquent $user)
    {
        $this->user = $user;
    }

    /**
     * @author qinghe
     * @Time 2022/9/4 14:21
     */
    public function index(): Factory|\Illuminate\Contracts\View\View|Application
    {
        $users = $this->user->all(['id', 'name', 'email', 'user_pic'])->toArray();

        return view('admin.user.index', compact('users'));
    }

    /**
     * @author qinghe
     * @Time 2022/9/4 14:21
     */
    public function create(): Factory|\Illuminate\Contracts\View\View|Application
    {
        return view('admin.user.create');
    }

    /**
     * @param Request $request
     * @param ImageUploads $imageUploads
     * @return Application|RedirectResponse|Redirector
     * @throws ValidatorException
     * @Time 2022/9/4 14:22
     * @author qinghe
     */
    public function store(Request $request, ImageUploads $imageUploads): Redirector|RedirectResponse|Application
    {
        if ($request->hasFile('user_pic')) {
            $file = $request->file('user_pic');

            $upload = $imageUploads->uploadAvatar($file);
            if (!$upload['status']) {
                return redirect()->back()->withErrors($upload['msg']);
            }
        }

        $avatarFileName = $upload['fileName'] ?? '';

        if ($this->user->store($request->all(), $avatarFileName)) {
            return redirect('admin/user')->with('success', '用户添加成功');
        }

        return redirect()->back()->withErrors('系统异常，用户添加失败');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     * @Time 2022/9/4 14:27 cdn
     * @author qinghe
     */
    public function edit($id): Factory|View|Application
    {
        $user = $this->user->find($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * @param Request $request
     * @param $id
     * @param ImageUploads $imageUploads
     * @return Application|Redirector|RedirectResponse
     * @throws ValidatorException
     */
    public function update(Request $request, $id, ImageUploads $imageUploads): Redirector|RedirectResponse|Application
    {
        $user = $this->user->find($id);

        if ($request->hasFile('user_pic')) {
            $file = $request->file('user_pic');

            $upload = $imageUploads->uploadAvatar($file);

            if (!$upload['status']) {
                return redirect()->back()->withErrors($upload['msg']);
            }
        }

        $avatarFileName = $upload['fileName'] ?? '';

        if ($this->user->update($request->all(), $id, $avatarFileName)) {
            if ($avatarFileName != '' && $user['user_pic'] != '') {
                Storage::disk('upload')->delete('avatar/' . $user['user_pic']);
            }

            return redirect('admin/user')->with('success', ' 用户修改成功');
        }

        return redirect()->back()->withErrors('用户修改失败');
    }

    /**
     * @param $id
     * @return JsonResponse
     * @Time 2022/9/4 14:26
     * @author qinghe
     */
    public function destroy($id): JsonResponse
    {
        //删除用户头像
        $user = $this->user->find($id);
        $path = public_path('uploads/avatar') . DIRECTORY_SEPARATOR . $user->user_pic;
        @unlink($path);

        if ($user->delete()) {
            return response()
                ->json([
                    'status' => 0
                ]);
        }

        return response()
            ->json([
                'status' => 1
            ]);
    }
}
