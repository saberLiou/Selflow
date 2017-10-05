@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 class="text-center">Opps, You Got a Wrong Page!</h1></div>

                    <div class="panel-body text-center">
                        <a href="#" onclick="window.history.back()">Return to Previous Page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection