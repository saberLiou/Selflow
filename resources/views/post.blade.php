@extends('layouts.blog-post')
@section('content')
    <!-- Title -->
    <h1>{{ $post->title }}</h1>
    <!-- Author -->
    <p class="lead">
        by <a href="#">{{ $post->user->name }}</a>
    </p>
    <hr>
    <!-- Date/Time -->
    <p><span class="glyphicon glyphicon-time"></span> Posted {{ $post->created_at->diffForHumans() }}</p>
    <hr>
    <!-- Preview Image -->
    <img class="img-responsive" src="{{ $post->photo ? $post->photo->file : 'https://placehold.it/900x300/?text=No%20Photo' }}" alt="{{ $post->photo ? $post->photo->file : 'Unknown' }}">
    <hr>
    <!-- Post Content -->
    <p>{{ $post->body }}</p>
    <hr>
    <!-- Comments and Replies-->

    <!-- Posted Comments and Replies-->
    @foreach ($post->comments as $comment)
        @if ($comment->is_active)
            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img height="64" width="64" class="media-object" src="{{ $comment->user->photo ? $comment->user->photo->file : 'https://placehold.it/64x64/?text=Unknown' }}" alt="{{ $comment->user->photo ? $comment->user->photo->file : 'Unknown' }}">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">{{ $comment->user->name }}
                        <small>{{ $comment->created_at->diffForHumans() }}</small>
                    </h4>
                    {{ $comment->body }}

                    <!-- Replies -->
                    @foreach ($comment->replies as $reply)
                        @if ($reply->is_active)
                            <div class="media">
                                <a class="pull-left" href="#">
                                    <img height="64" width="64" class="media-object" src="{{ $reply->user->photo ? $reply->user->photo->file : 'https://placehold.it/64x64/?text=Unknown' }}" alt="{{ $reply->user->photo ? $reply->user->photo->file : 'Unknown' }}">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading">{{ $reply->user->name }}
                                        <small>{{ $reply->created_at->diffForHumans() }}</small>
                                    </h4>
                                    {{ $reply->body }}
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if (Auth::check())
                        <!-- Reply Form -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img height="64" width="64" class="media-object" src="{{ Auth::user()->photo ? Auth::user()->photo->file : 'https://placehold.it/64x64/?text=Unknown' }}" alt="{{ Auth::user()->photo ? Auth::user()->photo->file : 'Unknown' }}">
                            </a>
                            <div class="media-body">
                                {!! Form::open(['method' => 'POST', 'action' => ['CommentRepliesController@store', $post->id]])!!}
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

    @if (Auth::check())
        <!-- Comment Form -->
        <div class="media">
            <a class="pull-left" href="#">
                <img height="64" width="64" class="media-object" src="{{ Auth::user()->photo ? Auth::user()->photo->file : 'https://placehold.it/64x64/?text=Unknown' }}" alt="{{ Auth::user()->photo ? Auth::user()->photo->file : 'Unknown' }}">
            </a>
            <div class="media-body">
                {!! Form::open(['method' => 'POST', 'action' => ['PostCommentsController@store', $post->id]])!!}
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
@endsection