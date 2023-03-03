<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 15:30
 * File: Tag.php
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Prettus\Repository\Contracts\Transformable;

class Tag extends Model implements Transformable
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'article_num'
    ];

    /**
     * @author qinghe
     * Time 2022/9/3 15:32
     */
    public function article(): BelongsToMany
    {
        return $this->belongsToMany(Article::class,'article_tags','tag_id','article_id');
    }

    public function transform()
    {

    }
}
