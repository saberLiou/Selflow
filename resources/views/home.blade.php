@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if (Session::has('delete_your_post'))
                    <div class="alert alert-info">{{ session('delete_your_post') }}</div>
                @endif
                @if (count($posts) > 0)
                    <div class="panel panel-group">
                        @foreach ($posts as $post)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <a href="{{ route('posts.show', $post->slug) }}"><h4>{{ $post->title }}</h4></a>
                                </div>

                                <div class="panel-body">
                                    <a href="{{ route('posts.show', $post->slug) }}">
                                        <img height="600" width="600" class="img-responsive img-rounded center-block" src="{{ $post->photo ? $post->photo->file : 'https://placehold.it/600x600/?text=No%20Photo' }}" alt="{{ $post->photo ? $post->photo->file : 'Unknown' }}">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            <h4>There's no post in this flow.</h4>
                        </div>
                        @if (Auth::user()->isAuthor())
                            <div class="panel-body text-center">
                                <h4><a href="{{ route('posts.create') }}">Click to create a post</a></h4>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
