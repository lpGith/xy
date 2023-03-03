<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 21:27
 * File: Navigation.php
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Navigation extends Model implements Transformable
{

    use TransformableTrait;

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'url', 'sequence', 'state', 'article_cate_id', 'nav_type'];


    /**
     * @author qinghe
     * @Time 2022/9/3 21:28
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo('App\Models\Category','article_cate_id','id');
    }


    public function transform()
    {
        // TODO: Implement transform() method.
    }
}
