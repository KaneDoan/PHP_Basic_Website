@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        <a href="/messages/create" class="btn btn-primary">Create message</a>
                        <h3>Your Blog messages</h3>
                        @if(count($messages) > 0)
                            <table class="table table-striped">
                                <tr>
                                    <th>Title</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                @foreach($messages as $message)
                                    <tr>
                                        <td>{{$message->title}}</td>
                                        <td><a href="/messages/{{$message->id}}/edit" class="btn btn-default">Edit</a></td>
                                        <td>
                                            {!!Form::open(['action' => ['messagesController@destroy', $message->id], 'method' => 'message', 'class' => 'pull-right'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                            {!!Form::close()!!}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <p>You have no messages</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
