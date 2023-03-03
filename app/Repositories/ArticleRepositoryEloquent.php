<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 13:44
 * File: ArticleRepositoryEloquent.php
 */

namespace App\Repositories;

use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepository;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;

class ArticleRepositoryEloquent extends BaseRepository implements ArticleRepository
{

    /**
     * @author qinghe
     * Time 2022/9/3 15:40
     */
    public function model(): string
    {
        return Article::class;
    }

    /**
     * @param array $where
     * Time 2022/9/3 15:42
     * @throws RepositoryException
     * @author qinghe
     *
     */
    public function search(array $where)
    {
        if (count($where) > 0) {
            //将给定的条件应运用模型
            $this->applyConditions($where);
        }

        return $this->orderBy('id', 'desc')->paginate(15);
    }

    /**
     * @param $keyword
     * Time 2022/9/3 15:46
     * @throws RepositoryException
     * @author qinghe
     *
     */
    public function searchKeywordArticle($keyword)
    {
        $search = '%' . $keyword . '%';
        $this->applyConditions([['title', 'like', $search]]);

        return $this->paginate(15, ['id', 'title', 'desc', 'user_id', 'cate_id', 'read_count', 'created_at', 'list_pic']);
    }

    /**
     * 查询文章发布日期
     * @author qinghe
     * Time 2022/9/3 15:59
     */
    public function selectDate(): array
    {
        return DB::select('select `id`,`title`,`created_at` from `blg_articles` ORDER BY `id` desc');
    }

    /**
     * @param $year
     * @param $month
     * Time 2022/9/3 16:01
     * @return array
     * @author qinghe
     */
    public function selectByDate($year, $month): array
    {
        if ($month < 10) {
            $month = '0' . $month;
        }

        return DB::select("select `id`,`title`,`created_at` from `blg_articles` where date_format(created_at,'%Y%m') =" . $year . $month);
    }
}
