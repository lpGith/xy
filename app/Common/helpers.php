<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 13:32
 * File: helpers.php
 */


use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

if (!function_exists('getCityById')) {
    /**
     * @param $ip
     * Time 2022/9/3 13:39
     * @author qinghe
     * */
    function getCityById($ip)
    {
        if ($ip == '') {
            $url = env('IP_URL_SINA');
            return json_decode(file_get_contents($url), true);
        }

        $url = env('IP_URL_TAOBAO');
        $ip = json_decode(file_get_contents($url));
        if ((string)$ip->code === '1') {
            return false;
        }


        return (array)$ip->data;
    }
}

if (!function_exists('session_user')) {
    /**
     * @param User|null $user
     * @Time 2023/3/3 14:22
     * @author qinghe
     * */
    function session_user(User $user = null)
    {
        if (is_null($user)) {
            $user = Session::get('user');
        } else {
            Session::put('user', $user);
        }

        return $user;
    }
}

if (!function_exists('cookie_user')) {
    /**
     * @param User|null $user
     * @Time 2023/3/3 14:22
     * @author qinghe
     * */
    function cookie_user(User $user = null, $isExpired = false): ?User
    {
        if ($isExpired) {
            $cookie = cookie('login_token', '', 60 * 24 * 30 * -1);
            Cookie::queue($cookie);
        } else {
            if (is_null($user)) {
                $cookie = Request::cookie('login_token');
                if (empty($cookie) === false) {
                    $user = User::find($cookie['user_id']);
                }
            } else {
                $data = ['user_id' => $user->id, 'unique' => uniqid(), 'last_login_time' => time(), 'user_agent' => Request::header('User-Agent')];
                $cookie = cookie('login_token', $data, 60 * 24 * 30);
                Cookie::queue($cookie);
            }
        }

        return $user;
    }
}
