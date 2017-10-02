<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post, App\User, App\Photo, App\Category;
use App\Http\Requests\PostsRequest;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(2);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where([
            ['is_active', 1],
            ['role_id', '<=', 2]
        ])->pluck('name', 'id')->all();
        $categories = Category::pluck('name', 'id')->all();
        return view('admin.posts.create', compact('users', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsRequest $request)
    {
        // return $request->all();
        $input = $request->all();

        if ($file = $request->file('photo')){
            $name = $file->getClientOriginalName();
            /* Save file original name into database. */
            $photo = Photo::create(['file' => $name]);
            /* Copy file into /public/images. */
            $file->move($photo->directory, $name);
            /* Save photo id into posts table. */
            $input['photo_id'] = $photo->id;
        }
        User::findOrFail($input['user_id'])->posts()->create($input);
        return redirect('/admin/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // not used.
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $users = User::where([
            ['is_active', 1],
            ['role_id', '<=', 2]
        ])->pluck('name', 'id')->all();
        $categories = Category::pluck('name', 'id')->all();
        return view('admin.posts.edit', compact('post', 'users', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostsRequest $request, $id)
    {
        // return $request->all();
        $input = $request->all();
        $post = Post::findOrFail($id);

        if ($file = $request->file('photo')){
            $name = $file->getClientOriginalName();
            if ($post->photo){
                /* Update the file in /public/images. */
                unlink(public_path().$post->photo->file);
                $file->move($post->photo->directory, $name);
                /* Update file original name into database. */
                Photo::findOrFail($post->photo_id)->update(['file' => $name]);
            }
            else{
                /* Save file original name into database. */
                $photo = Photo::create(['file' => $name]);
                /* Save the file in /public/images. */
                $file->move($photo->directory, $name);
                /* Save photo id into posts table. */
                $input['photo_id'] = $photo->id;
            }
        }

        if ($input['user_id'] != $post->user_id){
            $post->user_id = $input['user_id'];
        }
        $post->update($input);
        return redirect('/admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        Session::flash('delete_post', 'The No.'.$post->id.' post "'.$post->title.'" has been deleted.');
        if ($post->photo){
            /* Delete post photo from images storage path. */
            unlink(public_path().$post->photo->file);
            /* Delete post photo record from database. */
            $post->photo->delete();
        }
        $post->delete();
        return redirect('/admin/posts');
    }

    public function post($slug){
        $post = Post::findBySlugOrFail($slug);
        return view('post', compact('post'));
    }
}
