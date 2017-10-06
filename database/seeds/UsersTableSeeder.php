<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id'   => 1,
            'is_active' => 1,
            'name'      => 'admin',
            'email'     => 'admin@gmail.com',
            'password'  => '$2y$10$.6qMVrfjTW454HsnTmlwBuy/1vBmMQ7zxTO/4Yeojx.Dem8A9XkbK',
            'pwd_num'   => 5
        ]);
    }
}
