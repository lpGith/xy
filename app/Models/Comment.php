<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 15:35
 * File: Comment.php
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Comment extends Model implements Transformable
{

    use TransformableTrait;

    protected $fillable = [
        'user_id', 'article_id', 'parent_id', 'content', 'name', 'email', 'website', 'avatar', 'ip', 'city', 'target_name'
    ];

    /**
     * @author qinghe
     * Time 2022/9/3 15:38
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * @author qinghe
     * Time 2022/9/3 15:39
     */
    public function replys(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function transform()
    {
        // TODO: Implement transform() method.
    }
}
