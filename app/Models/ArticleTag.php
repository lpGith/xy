<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 15:27
 * File: ArticleTag.php
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;

class ArticleTag extends Model implements Transformable
{
    /**
     * @var string[]
     */
    protected $fillable = [
      'article_id','tag_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    public function transform()
    {
        // TODO: Implement transform() method.
    }
}
