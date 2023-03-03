<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 14:30
 * File: ArticleController.php
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Repositories\ArticleRepositoryEloquent;
use App\Repositories\CommentRepositoryEloquent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * @var ArticleRepositoryEloquent
     */
    protected ArticleRepositoryEloquent $article;

    /**
     * @var CommentRepositoryEloquent
     */
    protected CommentRepositoryEloquent $comment;

    /**
     * ArticleController constructor.
     * @param ArticleRepositoryEloquent $article
     * @param CommentRepositoryEloquent $comment
     */
    public function __construct(ArticleRepositoryEloquent $article, CommentRepositoryEloquent $comment)
    {
        $this->article = $article;
        $this->comment = $comment;
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View
     * @Time 2022/9/4 15:02
     * @author qinghe
     */
    public function index(Request $request, $id)
    {
        $article = $this->article->with('tag:id,name')->find($id);
        $article->read_count = $article->read_count + 1;
        $article->save();
        $comments = $article->comments()->where('parent_id', 0)->orderBy('created_at', 'desc')->get();

        for ($i = 0; $i < sizeof($comments); $i++) {
            $comments[$i]->created_at_diff = $comments[$i]->created_at->diffForHumans();
            $comments[$i]->avatar_text = mb_substr($comments[$i]->name??'匿名', 0, 1, 'utf-8');
            $replys = $comments[$i]->replys;
            for ($j = 0; $j < sizeof($replys); $j++) {
                $replys[$j]->created_at_diff = $replys[$j]->created_at->diffForHumans();
                $replys[$j]->avatar_text = mb_substr($replys[$j]->name, 0, 1, 'utf-8');
            }
        }

        $inputs = new CommentInputs;
        if (Auth::id()) {
            $inputs->name = Auth::user()->name;
            $inputs->email = Auth::user()->email;
            $inputs->website = env('APP_URL');
        } else {
            $comment = Comment::where('ip', $request->ip())->orderBy('created_at', 'desc')->first();
            if ($comment) {
                $inputs->name = $comment->name;
                $inputs->email = $comment->email;
                $inputs->website = $comment->website;
            }
        }
        return view('default.show_article', compact('article', 'comments', 'inputs'));
    }

    /**
     * @author qinghe
     * @Time 2022/9/4 15:01
     */
    public function selectDate()
    {
        $articles = $this->article->selectDate();
        return view('default.date_article', compact('articles'));
    }
}
