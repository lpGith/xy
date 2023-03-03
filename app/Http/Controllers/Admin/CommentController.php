<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 09:29
 * File: CommentController.php
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\CommentRepositoryEloquent;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * @var CommentRepositoryEloquent
     */
    protected CommentRepositoryEloquent $comment;

    /**
     * CommentController constructor.
     * @param CommentRepositoryEloquent $comment
     */
    public function __construct(CommentRepositoryEloquent $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @author qinghe
     * @Time 2022/9/4 09:33
     */
    public function index()
    {
        $comments = $this->comment->orderBy('id','desc')->paginate(15);

        return view('admin.comment.index',compact('comments'));
    }

    /**
     * @param $id
     * @return JsonResponse
     * @Time 2022/9/4 09:34
     * @author qinghe
     */
    public function destroy($id): JsonResponse
    {
        if($this->comment->delete($id)) {
            return response()->json(['status' => 0]);
        }
        return response()->json(['status' => 1]);
    }
}
