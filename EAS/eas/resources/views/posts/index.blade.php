@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    @if (count($posts) > 0)
        @foreach ($posts as $post)
            <div clas="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <img class="card-img" style="width:100%" src="/storage/cover_images/{{$post->cover_image}}" alt="{{$post->cover_image}}">
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <h3 class="card-title"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                            <h6>{!!$post->body!!}</h6>
                            {{-- <small>Written on {{$post->created_at}} by {{$post->user->name}}</small> --}}
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach
        {{-- {{ $posts->links() }} --}}
    @else
        <p>No posts found</p>
    @endif
@endsection