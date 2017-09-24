@extends('layouts.admin')
@section('content')
    <h1>Posts</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Author</th>
                <th>Category</th>
                <th>Title</th>
                <th>Body</th>
                <th>Created Time</th>
                <th>Updated Time</th>
                <th><div class="col-sm-offset-3">Action<div></th>
            </tr>
        </thead>
        <tbody>
            @if ($posts)
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td><img height="50" width="50" src="{{ $post->photo ? $post->photo->file : 'https://placehold.it/50x50/?text=Unknown' }}" alt="{{ $post->photo ? $post->photo->file : 'Unknown' }}"></td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->category_id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->body }}</td>
                        <td>{{ $post->created_at->diffForHumans() }}</td>
                        <td>{{ $post->updated_at->diffForHumans() }}</td>
                        <td>
                            <div class="row">
                                <div class="col-sm-4">
                                    <a href="{{ route('posts.edit', $post->id) }}"><button class="btn btn-primary"><i class="fa fa-wrench"></i> Edit</button></a>
                                </div>
                                <div class="col-sm-5">
                                    {!! Form::open(['method' => 'DELETE', 'action' => ['AdminPostsController@destroy', $post->id]]) !!}
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection