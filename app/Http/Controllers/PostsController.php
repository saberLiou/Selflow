<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category, App\Photo, App\User, App\Post;
use App\Http\Requests\PostsRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // not used.
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->all();
        return view('posts.create', compact('categories'));
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
            /* Save file name into database first. */
            $photo = Photo::create(['file' => $name]);
            /* Slug id with file name to avoid photos with same file name
               unlinked at the delete moment. */
            $name = strval($photo->id)."_".substr($photo->file, 8);
            /* Update the slugged file name into database. */
            $photo->update(['file' => $name]);
            /* Copy file into /public/images. */
            $file->move($photo->directory, $name);
            /* Save photo id into posts table. */
            $input['photo_id'] = $photo->id;
        }
        $post = User::findOrFail(Auth::user()->id)->posts()->create($input);
        return redirect('/home/posts/'.$post->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::findBySlugOrFail($slug);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::findBySlugOrFail($slug);
        $categories = Category::pluck('name', 'id')->all();
        return view('posts.edit', compact('post', 'categories'));
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
            if (count($post->photo) > 0){
                /* Remove the file in /public/images first. */
                unlink(public_path().$post->photo->file);
                /* Slug id with file name to avoid photos with same file name
                   unlinked at the delete moment. */
                $name = strval($post->photo_id)."_".$name;
                /* Update the slugged file name into database. */
                Photo::findOrFail($post->photo_id)->update(['file' => $name]);
                /* Save the file in /public/images. */
                $file->move($post->photo->directory, $name);
            }
            else{
                /* Save file name into database first. */
                $photo = Photo::create(['file' => $name]);
                /* Slug id with file name to avoid photos with same file name
                   unlinked at the delete moment. */
                $name = strval($photo->id)."_".substr($photo->file, 8);
                /* Update the slugged file name into database. */
                $photo->update(['file' => $name]);
                /* Save the file in /public/images. */
                $file->move($photo->directory, $name);
                /* Save photo id into posts table. */
                $input['photo_id'] = $photo->id;
            }
        }
        /* Update the category id of the post if changed. */
        if ($input['category_id'] != $post->category_id){
            Session::flash('change_category', 'Your post "'.$post->title
                .'" in Flow "'.$post->category->name.'" has been changed to Flow "'
                .Category::findOrFail($input['category_id'])->name.'" now!');
        }
        $post->update($input);
        return redirect('/home/posts/'.$post->slug);
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
        $post_category = $post->category;
        Session::flash('delete_your_post', 'Your post "'.$post->title.'" in Flow "'.$post_category->name.'" has been deleted successfully!');
        if (count($post->photo) > 0){
            /* Delete post photo from images storage path. */
            unlink(public_path().$post->photo->file);
            /* Delete post photo record from database. */
            $post->photo->delete();
        }
        $post->delete();
        return redirect('/home/'.$post_category->slug);
    }
}
