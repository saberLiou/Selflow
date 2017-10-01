@extends('layouts.admin')
@section('content')
    @if (Session::has('delete_reply'))
        <div class="alert alert-info">{{ session('delete_reply') }}</div>
    @endif
    <h1>Replies of Comment "{{ $comment->body }}"<br>on Post "<a href="{{ route('home.post', $comment->post->slug) }}">{{ $comment->post->title }}</a>"</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User Photo</th>
                <th>User</th>
                <th>Reply</th>
                <th>Created Time</th>
                <th>Updated Time</th>
                <th>Edit Status</th>
                <th>Delete Reply</th>
            </tr>
        </thead>
        <tbody>
            @if ($replies)
                @foreach ($replies as $reply)
                    <tr>
                        <td>{{ $reply->id }}</td>
                        <td><img height="50" width="50" src="{{ $reply->user->photo ? $reply->user->photo->file : 'https://placehold.it/50x50/?text=Unknown' }}" alt="{{ $reply->user->photo ? $reply->user->photo->file : 'Unknown' }}"></td>
                        <td>{{ $reply->user->name }}</td>
                        <td>{{ $reply->body }}</td>
                        <td>{{ $reply->created_at->diffForHumans() }}</td>
                        <td>{{ $reply->updated_at->diffForHumans() }}</td>
                        <td>
                            @if ($reply->is_active == 1)
                                {!! Form::model($reply, ['method' => 'PATCH', 'action' => ['CommentRepliesController@update', $reply->id."@".$comment->id]]) !!}
                                    <input type="hidden" name="is_active" value="0">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-close"></i> Inactive</button>
                                    </div>
                                {!! Form::close() !!}
                            @else
                                {!! Form::model($reply, ['method' => 'PATCH', 'action' => ['CommentRepliesController@update', $reply->id."@".$comment->id]]) !!}
                                    <input type="hidden" name="is_active" value="1">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Active</button>
                                    </div>
                                {!! Form::close() !!}
                            @endif
                        </td>
                        <td>
                            {!! Form::open(['method' => 'DELETE', 'action' => ['CommentRepliesController@destroy', $reply->id."@".$comment->id]]) !!}
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