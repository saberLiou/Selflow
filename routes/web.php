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
    $categories = App\Category::all();
    return view('welcome', compact('categories'));
})->name('brand');

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::group(['middleware' => 'author'], function(){
        Route::resource('/home/posts', 'PostsController', ['except' => 'show']);
    });
    Route::get('/home/posts/{slug}', 'PostsController@show')->name('posts.show');
    Route::post('/home/posts/{slug}/comment', 'Admin\PostCommentsController@store')->name('posts.comment');
    Route::post('/home/posts/{slug}/comment/reply', 'Admin\CommentRepliesController@store')->name('posts.reply');
    Route::resource('/home/users', 'UsersController', ['except' => ['create', 'store', 'destroy']]);
    Route::get('/home/{category}', 'HomeController@index')->name('home');
});

Route::group(['middleware' => 'admin'], function(){
    Route::resource('/admin/users', 'Admin\UsersController', ['as' => 'admin']);
    Route::resource('/admin/posts', 'Admin\PostsController', ['as' => 'admin', 'except' => 'show']);
    Route::resource('/admin/categories', 'Admin\CategoriesController', ['as' => 'admin', 'except' => ['create', 'show']]);
    Route::resource('/admin/photos', 'Admin\PhotosController', ['as' => 'admin', 'except' => ['show', 'edit', 'update']]);
    Route::delete('/admin/photos_multi_delete', 'Admin\PhotosController@multiDestroy', ['as' => 'admin'])->name('admin.photos.multi.destroy');
    
    Route::get('/admin/comments', 'Admin\PostCommentsController@index')->name('admin.comments.index');
    Route::get('/admin/comments/{comment}', 'Admin\PostCommentsController@show')->name('admin.comments.show');
    Route::patch('/admin/comments/{comment}', 'Admin\PostCommentsController@update')->name('admin.comments.update');
    Route::delete('/admin/comments/{comment}', 'Admin\PostCommentsController@destroy')->name('admin.comments.destroy');

    Route::get('/admin/comment/replies/{reply}', 'Admin\CommentRepliesController@show')->name('admin.replies.show');
    Route::patch('/admin/comment/replies/{reply}', 'Admin\CommentRepliesController@update')->name('admin.replies.update');
    Route::delete('/admin/comment/replies/{reply}', 'Admin\CommentRepliesController@destroy')->name('admin.replies.destroy');
});