<div class="container">
    @if (count($user->posts) > 0)
        @foreach (App\Category::all() as $category)
            @if (count($user->posts()->whereCategoryId($category->id)->get()) > 0)
                <a href="{{ route('home', $category->slug) }}"><h1>{{ $category->name }}</h1></a><hr>
            @endif
            <div class="panel panel-group col-md-8 col-md-offset-4">
                @foreach ($user->posts()->whereCategoryId($category->id)->get() as $post)
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
        @endforeach
    @else
        <div class="panel panel-default col-md-8 col-md-offset-4">
            <div class="panel-heading text-center">
                <h4>You have no post in any flow.</h4>
            </div>
            @if (Auth::user()->isAuthor())
                <div class="panel-body text-center">
                    <h4><a href="{{ route('posts.create') }}">Click to create one</a></h4>
                </div>
            @endif
        </div>
    @endif
</dvi>