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
            'photo_id'  => 1,
            'role_id'   => 1,
            'is_active' => 1,
            'name'      => 'Guo-Xun Liu',
            'email'     => 'saberliou@gmail.com',
            'password'  => '$2y$10$WXJ98u8JXCZaOf9njHBe6O/Xl4H1QfbZ5.m.Ja2GUPJLBq7KM6oxC'
        ]);
        
        User::create([
            'photo_id'  => 2,
            'role_id'   => 1,
            'is_active' => 0,
            'name'      => 'saberLiou',
            'email'     => 'w830708tw@yahoo.com.tw',
            'password'  => '$2y$10$BLOeLSRlQ65EARrc.R6zNeGG8lBesqu3us7oc5d8cumT6UFkQrlpu'
        ]);
    }
}
