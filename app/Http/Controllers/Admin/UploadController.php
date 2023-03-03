<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 13:55
 * File: UploadController.php
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Services\UploadService;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class UploadController extends Controller
{
    /**
     * @var UploadService
     */
    protected UploadService $uploadService;

    /**
     * @var Filesystem
     */
    protected Filesystem $disk;

    /**
     * UploadController constructor.
     * @param UploadService $service
     */
    public function __construct(UploadService $service)
    {
        $this->uploadService = $service;
        $this->disk = $this->uploadService->disk();
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @Time 2022/9/4 14:11
     * @author qinghe
     */
    public function index(Request $request)
    {
        $dir = str_replace('\\', '/', $request->get('dir', '/'));
        $fileList = $this->uploadService->folderInfo($dir);

        return view('admin.upload.index', compact('fileList', 'dir'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|RedirectResponse|View
     * @Time 2022/9/4 14:12
     * @author qinghe
     */
    public function fileUpload(Request $request)
    {
        $dir = $request->dir;
        if ($dir == '') {
            return redirect()->back()->withErrors('非法参数');
        }

        if (!$this->uploadService->dirExists($dir)) {
            return redirect()->back()->withErrors('目录不存在');
        }

        return view('admin.upload.upload', compact('dir'));
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @Time 2022/9/4 14:12
     * @author qinghe
     */
    public function fileStore(Request $request)
    {
        $response = $this->uploadService->uploadFile($request);

        if ($response['status']) {
            return redirect($response['url'])->with('success', '上传成功');
        }

        return redirect()->back()->withErrors($response['msg']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Time 2022/9/4 14:13
     * @author qinghe
     */
    public function makeDir(Request $request): JsonResponse
    {
        $path = rtrim($request->dir, '/') . '/' . $request->dir_name;
        if ($this->disk->exists($path)) {
            return response()->json(['status' => 1, 'msg' => '目录已存在']);
        }

        try {
            if ($this->disk->makeDirectory($path)) {
                $status = ['status' => 0, 'msg' => '创建成功'];
            } else {
                throw new \Exception('目录创建失败');
            }
        } catch (\Exception $e) {
            $status = ['status' => 1, 'msg' => $e->getMessage()];
        }

        return response()->json($status);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Time 2022/9/4 14:14
     * @author qinghe
     */
    public function dirDelete(Request $request): JsonResponse
    {
        try {
            $this->disk->deleteDirectory($request->dir);
            return response()->json(['status' => 0]);
        } catch (\Exception $e) {
            return response()->json(['status' => 1, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Time 2022/9/4 14:14
     * @author qinghe
     */
    public function fileDelete(Request $request): JsonResponse
    {
        try {
            $this->disk->delete($request->file);
            return response()->json(['status' => 0]);
        } catch (\Exception $e) {
            return response()->json(['status' => 1, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @Time 2022/9/4 14:14
     * @author qinghe
     * */
    public function uploadimage(Request $request)
    {
        $message = '';
        if (!$this->disk->exists('/article')) {
            $message = 'article 文件夹不存在,请先创建';
        } else {
            $pathDir = date('Ymd');
            if (!$this->disk->exists('/article/' . $pathDir)) {
                $this->disk->makeDirectory('/article/' . $pathDir);
            }
        }

        if ($request->file('editormd-image-file')) {
            $path = 'uploads/article/' . $pathDir;
            $pic = $request->file('editormd-image-file');
            if ($pic->isValid()) {
                $newName = md5(time() . rand(0, 10000)) . '.' . $pic->getClientOriginalExtension();
                if ($this->disk->exists($path . '/' . $newName)) {
                    $message = '文件名已存在或文件已存在';
                } else {
                    if ($pic->move($path, $newName)) {
                        $url = asset($path . '/' . $newName);
                    } else {
                        $message = '系统异常，文件保存失败';
                    }
                }
            } else {
                $message = '文件无效';
            }
        } else {
            $message = 'Not File';
        }

        $data = array(
            'success' => empty($message) ? 1 : 0,
            'message' => $message,
            'url' => !empty($url) ? $url : ''
        );

        header('Content-Type:application/json;charset=utf8');
        exit(json_encode($data));
    }
}
