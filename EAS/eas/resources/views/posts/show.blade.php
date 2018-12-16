@extends('layouts.app')

@section('content')
    <a class="btn btn-dark" href="/posts">Go Back</a>
    <h1>{{$post->title}}</h1>
    <img style="width:100%" src="/storage/cover_images/{{$post->cover_image}}" alt="{{$post->cover_image}}">
    <br>
    <br>
    <div>
        {!!$post->body!!}
    </div>
    <hr>
    {{-- <small>written on {{$post->created_at}} by {{$post->user->name}}</small> --}}
    <hr>
    {{-- @if (!Auth::guest())
        @if (Auth::user()->id == $post->user_id) --}}
            <a href="/posts/{{$post->id}}/edit" class="btn btn-info">Edit</a>

            {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        {{-- @endif
    @endif --}}
@endsection