<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ResetPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-pwd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reset admin password';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        askUsername:
        $username = $this->ask('请输入要重置密码的账号');
        $admin = User::query()->where('name', $username)->first();
        if (!$admin) {
            $this->error('账号不存在');
            goto askUsername;
        }

        enterPassword:
        $password = $this->secret('请输入密码[6-20位包含数字字母大小写组合]');

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\w\W]{6,20}$/', $password)) {
            $this->error('密码格式错误');
            goto enterPassword;
        }

        if ($password !== $this->secret('请再次输入密码[6-20位包含数字字母大小写组合]')) {
            $this->error('密码确认错误');
            goto enterPassword;
        }

        $admin->password = md5($password);
        $admin->save();

        $this->info('重置密码成功');
    }
}
