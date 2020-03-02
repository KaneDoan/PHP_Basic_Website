@extends('layouts.app')

@section('content')
    <h1>
        Messages
    </h1>

    @if(count($messages)>1)
        @foreach($messages as $message)
            <div class="well">
                <h3><a href="/messages/{{$message->id}}">{{$message->title}}</a></h3>
                <small>Written on {{$message->created_at}}</small>
            </div>
    @else
        <p>No post found</p>
    @endif
@endsection