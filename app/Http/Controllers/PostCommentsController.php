<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post, App\Comment;
use App\Http\Requests\CommentsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::orderBy('id')->orderBy('post_id')->get();
        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // not used.
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentsRequest $request, $id)
    {
        // return $request->all();
        $data = [
            'post_id' => $id,
            'user_id' => Auth::user()->id,
            'body'    => $request->body
        ];
        Comment::create($data);
        return redirect('/post/'.$id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $comments = $post->comments;
        return view('admin.comments.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // not used.
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id comment id (+ post id from show page)
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment_id = explode("@", $id)[0];
        $post_id = explode("@", $id)[1];
        Comment::findOrFail($comment_id)->update($request->all());
        return redirect('/admin/comments/'.$post_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id comment id (+ post id from show page)
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment_id = explode("@", $id)[0];
        $post_id = explode("@", $id)[1];
        $comment = Comment::findOrFail($comment_id);
        if ($post_id == ""){
            Session::flash('delete_comment', 'The No.'.$comment->id.' comment "'.str_limit($comment->body, 20).'"on post "'.$comment->post->title.'" has been deleted.');
        }
        else{
            Session::flash('delete_comment', 'The No.'.$comment->id.' comment "'.str_limit($comment->body, 20).'" has been deleted.');
        }
        $comment->delete();
        return redirect('/admin/comments/'.$post_id);
    }
}
