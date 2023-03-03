<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 15:06
 * File: CommentService.php
 */

namespace App\Services;


use App\Models\Comment;
use App\Repositories\CommentRepositoryEloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Prettus\Validator\Exceptions\ValidatorException;

class CommentService
{
    /**
     * @var CommentRepositoryEloquent
     */
    protected CommentRepositoryEloquent $comment;

    /**
     * CommentService constructor.
     * @param CommentRepositoryEloquent $comment
     */
    public function __construct(CommentRepositoryEloquent $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param array $arrData
     * @return false|LengthAwarePaginator|Collection|mixed
     * @throws ValidatorException
     * @Time 2022/9/4 15:07
     * @author qinghe
     */
    public function store(array $arrData)
    {
        $comment = $this->comment->create($arrData);
        if ($comment) {
            return $comment;
        } else {
            return false;
        }
    }

    /**
     * @param $comment_id
     * @return mixed
     * @Time 2022/9/4 15:07
     * @author qinghe
     */
    public function selectByParentId($comment_id)
    {
        return $comment = Comment::where('id', $comment_id)->orderBy('created_at', 'desc')->first();
    }

    /**
     * @param Request $request
     * @return array
     * @Time 2022/9/4 15:08
     * @author qinghe
     */
    public function basicFields(Request $request): array
    {
        return array_merge($request->intersect([
            'user_id',
            'parent_id',
            'article_id',
            'content',
            'name',
            'email',
            'website',
            'ip',
            'city',
            'target_name',
        ]));
    }
}
