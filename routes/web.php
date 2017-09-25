<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(['middleware' => 'admin'], function(){
    Route::resource('/admin/users', 'AdminUsersController');
    Route::resource('/admin/posts', 'AdminPostsController');
});
/* Check if admin.blade.php works. */
// Route::get('/admin', function(){
//     return view('layouts.admin');
// });

/* Default data if artisan refresh the migrations. */
// use App\Role, App\User, App\Category;

// Route::get('/after_refresh', function(){
//     Role::create(['name' => 'administrator']);
//     Role::create(['name' => 'author']);
//     Role::create(['name' => 'subscriber']);

//     User::create(['role_id' => 1, 'is_active' => 1, 'name' => 'Guo-Xun Liu', 'email' => 'saberliou@gmail.com', 'password' => '$2y$10$WXJ98u8JXCZaOf9njHBe6O/Xl4H1QfbZ5.m.Ja2GUPJLBq7KM6oxC']);
//     User::create(['role_id' => 1, 'is_active' => 0, 'name' => 'saberLiou', 'email' => 'w830708tw@yahoo.com.tw', 'password' => '$2y$10$BLOeLSRlQ65EARrc.R6zNeGG8lBesqu3us7oc5d8cumT6UFkQrlpu']);
     
//     Category::create(['name' => 'Uncategorized']);
// });