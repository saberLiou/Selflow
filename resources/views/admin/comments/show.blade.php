@extends('layouts.admin')
@section('content')
    @if (Session::has('delete_comment'))
        <div class="alert alert-info">{{ session('delete_comment') }}</div>
    @endif
    <h1>Comments of Post "<a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>"</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User Photo</th>
                <th>User</th>
                <th>Comment</th>
                <th>Created Time</th>
                <th>Updated Time</th>
                <th>Replies</th>
                <th>Edit Status</th>
                <th>Delete Comment</th>
            </tr>
        </thead>
        <tbody>
            @if (count($comments) > 0)
                @foreach ($comments as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td><img height="50" width="50" src="{{ $comment->user->photo ? Cloudder::secureShow($comment->user->photo->user_directory.$comment->user->photo->file) : 'https://placehold.it/50x50/?text=Unknown' }}" alt="{{ $comment->user->photo ? $comment->user->photo->file : 'Unknown' }}"></td>
                        <td>{{ $comment->user->name }}</td>
                        <td>{{ $comment->body }}</td>
                        <td>{{ $comment->created_at->diffForHumans() }}</td>
                        <td>{{ $comment->updated_at->diffForHumans() }}</td>
                        <td><a href="{{ route('admin.replies.show', $comment->id) }}"><button class="btn btn-info"><i class="fa fa-comments-o"></i> Show</button></a></td>
                        <td>
                            @if ($comment->is_active == 1)
                                {!! Form::model($comment, ['method' => 'PATCH', 'action' => ['Admin\PostCommentsController@update', $comment->id."@".$post->id]]) !!}
                                    <input type="hidden" name="is_active" value="0">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-close"></i> Inactive</button>
                                    </div>
                                {!! Form::close() !!}
                            @else
                                {!! Form::model($comment, ['method' => 'PATCH', 'action' => ['Admin\PostCommentsController@update', $comment->id."@".$post->id]]) !!}
                                    <input type="hidden" name="is_active" value="1">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Active</button>
                                    </div>
                                {!! Form::close() !!}
                            @endif
                        </td>
                        <td>
                            {!! Form::open(['method' => 'DELETE', 'action' => ['Admin\PostCommentsController@destroy', $comment->id."@".$post->id]]) !!}
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection