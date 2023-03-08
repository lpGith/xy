<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AdminInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'init admin account';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if (!User::query()->whereId(1)->exists()) {
            User::query()->create([
                'id' => 1,
                'name' => 'qinghe',
                'email' => '1043974411@qq.com',
                'password' => md5('1043974411@qq.com')
            ]);
        }

        return 1;
    }
}
