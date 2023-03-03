<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name'=>'admin',
            'email'=>'462369233@qq.com',
            'password'=>bcrypt('kesixin.xin')
        ]);
    }
}
