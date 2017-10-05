@extends('layouts.admin')
@section('content')
    @if (Session::has('delete_post'))
        <div class="alert alert-info">{{ session('delete_post') }}</div>
    @endif
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
                <th>Comments</th>
                <th>Edit Post</th>
            </tr>
        </thead>
        <tbody>
            @if (count($posts) > 0)
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td><img height="50" width="50" src="{{ $post->photo ? $post->photo->file : 'https://placehold.it/50x50/?text=Unknown' }}" alt="{{ $post->photo ? $post->photo->file : 'Unknown' }}"></td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->category->name }}</td>
                        <td><a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a></td>
                        <td>{{ str_limit($post->body, 50) }}</td>
                        <td>{{ $post->created_at->diffForHumans() }}</td>
                        <td>{{ $post->updated_at->diffForHumans() }}</td>
                        <td><a href="{{ route('admin.comments.show', $post->id) }}"><button class="btn btn-info"><i class="fa fa-comments"></i> Show</button></a></td>
                        <td><a href="{{ route('admin.posts.edit', $post->id) }}"><button class="btn btn-primary"><i class="fa fa-edit"></i> Edit</button></a></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-5">
            {{ $posts->render() }}
        </div>
    </div>
@endsection