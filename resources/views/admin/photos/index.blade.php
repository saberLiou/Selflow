@extends('layouts.admin')
@section('content')
    @if (Session::has('delete_photo'))
        <div class="alert alert-info">{{ session('delete_photo') }}</div>
    @endif
    <h1>Photos</h1>
    {!! Form::open(['method' => 'DELETE', 'action' => 'Admin\PhotosController@multiDestroy', 'class' => 'form-inline']) !!}
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>File Name</th>
                    <th>Owned by</th>
                    <th>Created Time</th>
                    <th>Updated Time</th>
                    @if ($photos)
                        <th>Delete Photo</th>
                        <th class="text-center"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button><br/><input type="checkbox" id="delete_all_check"></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if (count($photos) > 0)
                    @foreach ($photos as $photo)
                        <tr>
                            <td>{{ $photo->id }}</td>
                            @if ($photo->user) 
                                <td><img height="50" width="50" src="{{ Cloudder::secureShow($photo->user_directory.$photo->file) }}" alt="{{ $photo->file }}"></td>
                            @elseif ($photo->post)
                                <td><img height="50" width="50" src="{{ Cloudder::secureShow($photo->post_directory.$photo->file) }}" alt="{{ $photo->file }}"></td>
                            @else 
                                <td><img height="50" width="50" src="{{ Cloudder::secureShow($photo->directory.$photo->file) }}" alt="{{ $photo->file }}"></td>
                            @endif
                            <td>{{ $photo->file }}</td>
                            @if ($photo->user)
                                <td>{{ 'User: '.$photo->user->name }}</td>
                            @elseif ($photo->post)
                                <td>{{ 'Post: '.$photo->post->title }}</td>
                            @else
                                <td>{{ "None." }}</td>
                            @endif
                            <td>{{ $photo->created_at->diffForHumans() }}</td>
                            <td>{{ $photo->updated_at->diffForHumans() }}</td>
                            <td>
                                {!! Form::open(['method' => 'DELETE', 'action' => ['Admin\PhotosController@destroy', $photo->id]]) !!}
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                {!! Form::close() !!}
                            </td>
                            <td class="text-center"><input class="delete_check" type="checkbox" name="delete_photos[]" value="{{ $photo->id }}"></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    {!! Form::close() !!}
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $('#delete_all_check').click(function(){
                if (this.checked){
                    $('.delete_check').each(function(){
                        this.checked = true;
                    });
                }
                else{
                    $('.delete_check').each(function(){
                        this.checked = false;
                    });
                }
            });
        });
    </script>
@endsection