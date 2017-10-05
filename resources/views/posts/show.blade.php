@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if (Session::has('change_category'))
                    <div class="alert alert-info">{{ session('change_category') }}</div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if (Auth::user()->isAuthor())
                            <div class="pull-right">
                                <a href="{{ route('posts.edit', $post->slug) }}"><button class="btn btn-info">Edit</button></a>
                            </div>
                        @endif
                        <!-- Title -->
                        <h1>{{ $post->title }}</h1>
                        <div class="links pull-right" >
                                <a href="{{ route('home', $post->category->slug) }}">Flow | {{$post->category->name}}</a>
                            </div>
                        <!-- Author -->
                        <p class="lead">
                            Posted by <a href="{{ route('users.show', $post->user->id) }}">{{ $post->user->name }}</a> {{ $post->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="panel-body">
                        <!-- Preview Image -->
                        <img height="600" width="600" class="img-responsive img-rounded center-block" src="{{ $post->photo ? $post->photo->file : 'https://placehold.it/900x300/?text=No%20Photo' }}" alt="{{ $post->photo ? $post->photo->file : 'Unknown' }}">
                        <hr>
                        <!-- Post Content -->
                        <p>{!! $post->body !!}</p>
                        <hr>
                        
                        <!-- Comments and Replies-->

                        <!-- Posted Comments and Replies-->
                        @foreach ($post->comments as $comment)
                            @if ($comment->is_active)
                                <!-- Comment -->
                                <div class="media">
                                    <a class="pull-left" href="{{ route('users.show', $comment->user->id) }}">
                                        <img height="64" width="64" class="media-object img-rounded" src="{{ $comment->user->photo ? $comment->user->photo->file : 'https://placehold.it/64x64/?text=Unknown' }}" alt="{{ $comment->user->photo ? $comment->user->photo->file : 'Unknown' }}">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><a href="{{ route('users.show', $comment->user->id) }}">{{ $comment->user->name }}</a>
                                            <small>{{ $comment->created_at->diffForHumans() }}</small>
                                        </h4>
                                        {{ $comment->body }}

                                        <!-- Replies -->
                                        @foreach ($comment->replies as $reply)
                                            @if ($reply->is_active)
                                                <div class="media">
                                                    <a class="pull-left" href="{{ route('users.show', $reply->user->id) }}">
                                                        <img height="64" width="64" class="media-object img-rounded" src="{{ $reply->user->photo ? $reply->user->photo->file : 'https://placehold.it/64x64/?text=Unknown' }}" alt="{{ $reply->user->photo ? $reply->user->photo->file : 'Unknown' }}">
                                                    </a>
                                                    <div class="media-body">
                                                        <h4 class="media-heading"><a href="{{ route('users.show', $reply->user->id) }}">{{ $reply->user->name }}</a>
                                                            <small>{{ $reply->created_at->diffForHumans() }}</small>
                                                        </h4>
                                                        {{ $reply->body }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        
                                        <!-- Reply Form -->
                                        @if (Auth::user()->is_active)
                                            <div class="media">
                                                <a class="pull-left" href="{{ route('users.show', Auth::user()->id) }}">
                                                    <img height="64" width="64" class="media-object img-rounded" src="{{ Auth::user()->photo ? Auth::user()->photo->file : 'https://placehold.it/64x64/?text=Unknown' }}" alt="{{ Auth::user()->photo ? Auth::user()->photo->file : 'Unknown' }}">
                                                </a>
                                                <div class="media-body">
                                                    {!! Form::open(['method' => 'POST', 'action' => ['Admin\CommentRepliesController@store', $post->slug]])!!}
                                                        {!! Form::hidden('comment_id', $comment->id) !!}
                                                        <div class="form-group{{ $errors->has('reply') ? ' has-error' : '' }}">
                                                            {!! Form::text('reply', null, ['class' => 'form-control', 'placeholder' => 'Make a reply...']) !!}
                                                            <small class="text-danger">{{ $errors->first('reply') }}</small>
                                                        </div>
                                                        <div class="form-group pull-right">
                                                            {!! Form::submit('Reply', ['class' => 'btn btn-primary']) !!}
                                                        </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <!-- Comment Form -->
                        @if (Auth::user()->is_active)
                            <div class="media">
                                <a class="pull-left" href="{{ route('users.show', Auth::user()->id) }}">
                                    <img height="64" width="64" class="media-object img-rounded" src="{{ Auth::user()->photo ? Auth::user()->photo->file : 'https://placehold.it/64x64/?text=Unknown' }}" alt="{{ Auth::user()->photo ? Auth::user()->photo->file : 'Unknown' }}">
                                </a>
                                <div class="media-body">
                                    {!! Form::open(['method' => 'POST', 'action' => ['Admin\PostCommentsController@store', $post->slug]])!!}
                                        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                            {!! Form::text('body', null, ['class' => 'form-control', 'placeholder' => 'Leave a commnet...']) !!}
                                            <small class="text-danger">{{ $errors->first('body') }}</small>
                                        </div>
                                        <div class="form-group pull-right">
                                            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection