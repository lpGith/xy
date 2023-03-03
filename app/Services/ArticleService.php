<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 13:43
 * File: ArticleService.php
 */

namespace App\Services;

use App\Repositories\ArticleRepositoryEloquent;
use App\Repositories\TagRepositoryEloquent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class ArticleService
{
    /**
     * @var ArticleRepositoryEloquent
     */
    protected ArticleRepositoryEloquent $article;

    /**
     * @var TagRepositoryEloquent
     */
    protected TagRepositoryEloquent $tag;

    /**
     * ArticleService constructor.
     * @param ArticleRepositoryEloquent $article
     * @param TagRepositoryEloquent $tag
     */
    public function __construct(ArticleRepositoryEloquent $article, TagRepositoryEloquent $tag)
    {
        $this->article = $article;
        $this->tag = $tag;
    }

    /**
     * @param Request $request
     * Time 2022/9/3 17:54
     * @throws RepositoryException
     * @author qinghe
     *
     */
    public function search(Request $request)
    {
        $where = [];
        if ($request->has('title')) {
            $where[] = ['title', 'like', '%' . $request->title . '%'];
        }

        if ($request->has('cate_id')) {
            $where[] = ['cate', '=', $request->cate_id];
        }

        return $this->article->with([
            'user', 'category'
        ])->search($where);
    }

    /**
     * @param Request $request
     * @param ImageUploads $uploadService
     * @return Application|RedirectResponse|Redirector
     * @throws ValidatorException
     * @Time 2022/9/3 20:12
     * @author qinghe
     */
    public function store(Request $request, ImageUploads $uploadService): Redirector|Application|RedirectResponse
    {
        if ($request->hasFile('list_pic')) {
            $file = $request->file('list_pic');

            $upload = $uploadService->uploadAvatar($file);
            if (!$upload['status']) {
                return redirect()->back()->withErrors($upload['msg']);
            }
        }

        $fileName = $upload['fileName'] ?? '';

        $article = $this->article->create(array_merge($this->_basicFields($request), [
            'user_id' => Auth::id() ?: 1,
        ], ['list_pic' => $fileName]));

        if (!$article) {
            return redirect()->back()->withErrors('系统异常，文章发布失败');
        }

        if ($request->has('tags')) {
            $this->_getArticleTagService()->store($article->id, $request->tags);
        }

        return redirect('admin/article')->with('success', '文章添加成功');
    }

    /**
     * @param  $id
     * @return array
     * @Time 2022/9/3 20:18
     * @author qinghe
     */
    public function edit($id): array
    {
        $article = $this->article->find($id);
        $tags = $article->articleTag;
        $tagIdList = $this->_getArticleTagService()->tagIdList($tags, false);

        return compact('article', 'tagIdList');
    }

    /**
     * @param Request $request
     * @param ImageUploads $imageUploads
     * @return Application|RedirectResponse|Redirector
     * @Time 2022/9/3 20:22
     * @author qinghe
     */
    public function update(Request $request, ImageUploads $imageUploads)
    {
        if ($request->hasFile('list_pic')) {
            $file = $request->file('list_pic');

            $upload = $imageUploads->uploadAvatar($file);

            if (!$upload['status']) {
                return redirect()->back()->withErrors($upload['msg']);
            }
        }

        $fileName = $upload['fileName'] ?? '';

        $article = $this->article->with('tag:id,name')->find($request->id);
        $article->fill(array_merge($this->_basicFields($request), ['list_pic' => $fileName]));

        if (!$article->save()) {
            return redirect()->back()->withErrors('修改文章失败');
        }


        $this->_getArticleTagService()->updateArticleTags((int)$request->id, $request->tags);

        return redirect('admin/article')->with('success', '文章修改成功');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Time 2022/9/3 20:23
     * @author qinghe
     */
    public function destroy(Request $request): JsonResponse
    {
        $article = $this->article->find($request->id);

        //删除文章封面图
        $path = public_path('uploads/avatar') . DIRECTORY_SEPARATOR . $article->list_pic;
        @unlink($path);


        if (!$article->delete()) {
            return response()->json([
                'status' => 1
            ]);
        }


        return response()->json(['status' => 0]);
    }

    /**
     * @param Request $request
     * @Time 2022/9/3 20:25
     * @author qinghe
     * */
    public function updateComment(Request $request)
    {
        $article = $this->article->find($request->id);
        $article->comment_count = $article->comment_count + 1;
        $article->update([
            'comment_count' => $article->comment_count
        ]);
    }

    /**
     * @param Request $request
     * Time 2022/9/3 17:58
     * @author qinghe
     * */
    protected function _basicFields(Request $request): array
    {

        return array_merge($request->only([
            'title',
            'keyword',
            'desc',
            'cate_id',
            'user_id',
        ]), [
            'content' => $request->get('markdown-content'),
            'html_content' => $request->get('html-content')
        ]);
    }

    /**
     * @author qinghe
     * Time 2022/9/3 18:02
     */
    private function _getArticleTagService()
    {
        return app(ArticleTagService::class);
    }
}
