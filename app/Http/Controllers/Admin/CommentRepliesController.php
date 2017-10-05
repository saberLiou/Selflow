<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comment, App\CommentReply;
use App\Http\Requests\RepliesRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CommentRepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // not uesd.
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
    public function store(RepliesRequest $request, $slug)
    {
        // return $request->all();
        $data = [
            'comment_id' => $request->comment_id,
            'user_id'    => Auth::user()->id,
            'body'       => $request->reply
        ];
        $reply = CommentReply::create($data);
        return redirect('/home/posts/'.$slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        $replies = $comment->replies;
        return view('admin.comments.replies.show', compact('comment', 'replies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // not uesd.
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reply_id = explode("@", $id)[0];
        $comment_id = explode("@", $id)[1];
        CommentReply::findOrFail($reply_id)->update($request->all());
        return redirect('/admin/comment/replies/'.$comment_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reply_id = explode("@", $id)[0];
        $comment_id = explode("@", $id)[1];
        $reply = CommentReply::findOrFail($reply_id);
        Session::flash('delete_reply', 'The No.'.$reply->id.' reply "'.str_limit($reply->body, 20).'" has been deleted.');
        $reply->delete();
        return redirect('/admin/comment/replies/'.$comment_id);
    }
}
