<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 13:41
 * File: ArticleController.php
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use App\Services\ImageUploads;
use App\Services\UploadService;
use BmobObject;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class ArticleController extends Controller
{
    /**
     * @var ArticleService
     */
    protected ArticleService $articleService;

    /**
     * @var BmobObject
     */
    protected $BmobObj;

    /**
     * ArticleController constructor.
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
        $show = config('mini.show');
        if ($show) {
            $this->BmobObj = new BmobObject('articles');
        }
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws RepositoryException
     * @Time 2022/9/3 20:28
     * @author qinghe
     */
    public function index(Request $request)
    {
        $articles = $this->articleService->search($request);

        return view('admin.article.index', compact('articles'));
    }

    /**
     * @author qinghe
     * @Time 2022/9/3 20:28
     */
    public function create()
    {
        return view('admin.article.create');
    }

    /**
     * @param Request $request
     * @param ImageUploads $uploadService
     * @return Application|RedirectResponse|Redirector
     * @throws ValidatorException
     * @Time 2022/9/3 20:29
     * @author qinghe
     */
    public function store(Request $request,ImageUploads $uploadService)
    {
        return $this->articleService->store($request,$uploadService);
    }

    /**
     * @param $id
     * @return Application|Factory|View
     * @Time 2022/9/3 20:30
     * @author qinghe
     */
    public function edit($id)
    {
        return view('admin.article.edit')->with($this->articleService->edit($id));
    }

    /**
     * @param Request $request
     * @param ImageUploads $imageUploads
     * @return Application|RedirectResponse|Redirector
     * @Time 2022/9/3 20:31
     * @author qinghe
     */
    public function update(Request $request,ImageUploads $imageUploads)
    {
        return $this->articleService->update($request,$imageUploads);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Time 2022/9/3 20:31
     * @author qinghe
     */
    public function destroy(Request $request): JsonResponse
    {
        return $this->articleService->destroy($request);
    }

    /**
     * @author qinghe
     * @Time 2022/9/3 20:41
     */
    public function miniArticleCreate()
    {
        $bmobObj = new BmobObject('categories');
        $result = $bmobObj->get();
        $select = "<select id='category' name='category' class='form-control'>";
        $select .= "<option value='0'>--请选择--</option>";

        foreach ($result as $v) {
            $selected = $v->objectId === 1 ? 'selected' : '';
            $select .= "<option value='" . $v->objectId . "' " . $selected . '>' . $v->name . '</option>';
        }

        $select .= '</select>';

        return view('admin.article.mini_create', compact('select'));
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @Time 2022/9/3 20:55
     * @author qinghe
     */
    public function miniArticleStore(Request $request)
    {
        $ret = $this->BmobObj->addRelPointer([['category', 'categories', $request->get('category')]]);
        $ret = $this->BmobObj->update($ret->objectId, [
            'title' => $request->get('title'),
            'read_counts' => (int)$request->get('read_counts'),
            'excerpt' => $request->get('excerpt'),
            'author' => $request->get('author'),
            'content' => $request->get('html-content'),
            'mdcontent' => $request->get('markdown-content')
        ]);

        if (!$ret) {
            return redirect()->back()->withErrors('系统异常，文章发布失败');
        }

        return redirect('admin/mini-index')->with('success', '文章添加成功');
    }
}
