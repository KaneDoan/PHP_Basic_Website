@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-default">Go Back</a>
    <h1>{{$message->title}}</h1>
    <img style="width:100%" src="/storage/cover_images/{{$message->image}}">
    <br><br>
    <div>
        {!!$message->body!!}
    </div>
    <hr>
    <small>Written on {{$message->created_at}} by {{$message->user->name}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $message->user_id)
            <a href="/posts/{{$message->id}}/edit" class="btn btn-default">Edit</a>

            {!!Form::open(['action' => ['MessagesController@destroy', $message->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
@endsection