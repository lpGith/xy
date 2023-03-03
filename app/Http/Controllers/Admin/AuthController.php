<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 20:58
 * File: AuthController.php
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{

    /**
     * @author qinghe
     * @Time 2022/9/9 16:46
     */
    public function index(Request $request): View|Factory|Redirector|Application|RedirectResponse
    {
        $cookie = $request->cookie('login_token');

        if (empty($cookie) === false or empty(session('user')) === false) {
            $user = User::find($cookie['user_id']);
            session_user($user);

            return redirect('admin/qh');
        }

        return view('admin.login');
    }

    /**
     * @param LoginRequest $request
     * @return Application|RedirectResponse|Redirector
     * @Time 2022/9/9 18:30
     * @author qinghe
     */
    public function login(Request $request): Redirector|RedirectResponse|Application
    {
        try {

            $data = $request->all();
            $password = $data['password'];
            $email = $data['email'];

            $user = User::where([
                'email' => $email,
                'password' => bcrypt($password),
            ])->firstOrFail();

            $is_remember = $request->input('remember');

            session_user($user);

            if (strcasecmp($is_remember, 'on') === 0) {
                cookie_user($user);
            }

            return redirect('admin/qh');
        } catch (\Exception $exception) {
            Log::error('login-error', [$exception->getMessage()]);
            return redirect('admin/login');
        }
    }

    /**
     * @author qinghe
     * @Time 2022/9/11 21:41
     */
    public function logout(): Redirector|Application|RedirectResponse
    {
        session()->flush();
        cookie_user(null, true);

        return redirect('login')->with('success', '退出成功');
    }

}
