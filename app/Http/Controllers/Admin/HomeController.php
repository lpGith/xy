<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 09:35
 * File: HomeController.php
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * @author qinghe
     * @Time 2022/9/4 09:35
     */
    public function index()
    {
        return view('admin.home');
    }
}
