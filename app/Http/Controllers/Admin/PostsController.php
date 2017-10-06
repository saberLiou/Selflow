<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post, App\User, App\Photo, App\Category;
use App\Http\Requests\PostsRequest;
use Illuminate\Support\Facades\Session;
use JD\Cloudder\Facades\Cloudder;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(5);
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
            /* Trim file extension. */
            $extension = ".".$file->getClientOriginalExtension();
            $name = substr($file->getClientOriginalName(), 0, -strlen($extension));
            /* Save file name into database first. */
            $photo = Photo::create(['file' => $name]);
            /* Slug id with file name to avoid photos with same file name
               unlinked at the delete moment. */
            $name = strval($photo->id)."_".$photo->file;
            /* Update the slugged file name into database. */
            $photo->update(['file' => $name]);
            /* Copy file into /public/images. */
            // $file->move($photo->directory, $name);
            Cloudder::upload($file, $name, ['folder' => $photo->post_directory]);
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
            /* Trim file extension. */
            $extension = ".".$file->getClientOriginalExtension();
            $name = substr($file->getClientOriginalName(), 0, -strlen($extension));

            if (count($post->photo) > 0){
                /* Remove the file in /public/images first. */
                // unlink(public_path().$post->photo->file);
                Cloudder::destroy($post->photo->file, ['folder' => $post->photo->post_directory, 'invalidate' => true]);
                /* Slug id with file name to avoid photos with same file name
                   unlinked at the delete moment. */
                $name = strval($post->photo_id)."_".$name;
                /* Update the slugged file name into database. */
                Photo::findOrFail($post->photo_id)->update(['file' => $name]);
                /* Save the file in /public/images. */
                // $file->move($post->photo->directory, $name);
                Cloudder::upload($file, $name, ['folder' => $post->photo->post_directory]);
            }
            else{
                /* Save file name into database first. */
                $photo = Photo::create(['file' => $name]);
                /* Slug id with file name to avoid photos with same file name
                   unlinked at the delete moment. */
                $name = strval($photo->id)."_".$photo->file;
                /* Update the slugged file name into database. */
                $photo->update(['file' => $name]);
                /* Save the file in /public/images. */
                // $file->move($photo->directory, $name);
                Cloudder::upload($file, $name, ['folder' => $photo->post_directory]);
                /* Save photo id into posts table. */
                $input['photo_id'] = $photo->id;
            }
        }
        /* Update the author of the post if changed. */
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
        if (count($post->photo) > 0){
            /* Delete post photo from images storage path. */
            // unlink(public_path().$post->photo->file);
            Cloudder::destroy($post->photo->file, ['folder' => $post->photo->post_directory, 'invalidate' => true]);
            /* Delete post photo record from database. */
            $post->photo->delete();
        }
        $post->delete();
        return redirect('/admin/posts');
    }
}
