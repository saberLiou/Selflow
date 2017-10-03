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

Route::get('/post/{slug}', ['as' => 'home.post', 'uses' => 'AdminPostsController@post']);
Route::post('/post/{slug}/comments', ['as' => 'home.comment', 'uses' => 'PostCommentsController@store']);
Route::post('/post/{slug}/comment/replies', ['as' => 'home.reply', 'uses' => 'CommentRepliesController@store']);

Route::group(['middleware' => 'admin'], function(){
    Route::resource('/admin/users', 'AdminUsersController');
    Route::resource('/admin/posts', 'AdminPostsController');
    Route::resource('/admin/categories', 'AdminCategoriesController');
    Route::resource('/admin/photos', 'AdminPhotosController');
    Route::delete('/admin/photos_multi_delete', 'AdminPhotosController@multiDestroy');
    // Route::resource('/admin/comments', 'PostCommentsController');
    // Route::resource('/admin/comment/replies', 'CommentRepliesController');
    
    Route::get('/admin/comments', ['as' => 'comments.index', 'uses' => 'PostCommentsController@index']);
    Route::get('/admin/comments/{comment}', ['as' => 'comments.show', 'uses' => 'PostCommentsController@show']);
    Route::patch('/admin/comments/{comment}', ['as' => 'comments.update', 'uses' => 'PostCommentsController@update']);
    Route::delete('/admin/comments/{comment}', ['as' => 'comments.destroy', 'uses' => 'PostCommentsController@destroy']);

    Route::get('/admin/comment/replies/{reply}', ['as' => 'replies.show', 'uses' => 'CommentRepliesController@show']);
    Route::patch('/admin/comment/replies/{reply}', ['as' => 'replies.update', 'uses' => 'CommentRepliesController@update']);
    Route::delete('/admin/comment/replies/{reply}', ['as' => 'replies.destroy', 'uses' => 'CommentRepliesController@destroy']);
});

/* Check if admin.blade.php works. */
// Route::get('/admin', function(){
//     return view('layouts.admin');
// });