@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    @if(count($messages) > 0)
        @foreach($messages as $message)
            <div class="well">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:100%" src="/storage/image/{{$messages->image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/posts/{{$message->id}}">{{$message->title}}</a></h3>
                        <small>Written on {{$message->created_at}} by {{$message->user->name}}</small>
                    </div>
                </div>
            </div>
        @endforeach
        {{$message->links()}}
    @else
        <p>No messages found</p>
    @endif
@endsection