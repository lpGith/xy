<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 09:40
 * File: Link.php
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Link extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * @var string[]
     */
    protected $fillable = ['name','url','sequence'];
}
