<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 14:17
 * File: Category.bak.php
 */

namespace App\Models;


use Baum\Node;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Prettus\Repository\Contracts\Transformable;

class Categorys extends  Node implements Transformable
{
    /**
     * @var string
     */
    protected $table = 'blg_categories';

    /**
     * @var string[]
     */
    protected $fillable = [
      'name'
    ];

    /**
     * @author qinghe
     * Time 2022/9/3 15:25
     */
    public function article(): HasOne
    {
        return $this->hasOne(Article::class,'cate_id','id');
    }

    public function transform()
    {
        // TODO: Implement transform() method.
    }
}
