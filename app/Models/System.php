<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 13:44
 * File: System.php
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class System extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * @var string[]
     */
    protected $fillable = ['key', 'value'];

    /**
     * @var bool
     */
    public $timestamps = false;
}
