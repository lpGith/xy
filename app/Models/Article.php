<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 13:49
 * File: Article.php
 */

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;

class Article extends Model implements Transformable
{
    use HasFilter;

    /**
     * @var string[]
     */
    protected $fillable = [
        'content', 'html_content', 'title', 'desc', 'user_id', 'cate_id', 'read_count', 'created_at', 'list_pic'
    ];

    /**
     * @author qinghe
     * Time 2022/9/3 14:16
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @author qinghe
     * Time 2022/9/3 15:26
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'cate_id');
    }

    /**
     * @author qinghe
     * Time 2022/9/3 15:29
     */
    public function articleTag(): HasMany
    {
        return $this->hasMany(ArticleTag::class, 'article_id', 'id');
    }

    /**
     * @author qinghe
     * Time 2022/9/3 15:34
     */
    public function tag(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'article_tags', 'article_id', 'tag_id');
    }

    /**
     * @author qinghe
     * Time 2022/9/3 15:39
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function transform()
    {
        // TODO: Implement transform() method.
    }
}
