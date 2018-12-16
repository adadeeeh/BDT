@extends('layouts.app')

@section('content')
<h1>Post Anggota</h1>
{!! Form::open(['action' => 'AnggotaController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {{Form::label('band', 'Nama Band')}}
        {{Form::text('band', '', ['class' => 'form-control', 'placeholder' => 'Nama Band'])}}
    </div>
    <div class="form-group">
        {{Form::label('anggota', 'Anggota')}}
        {{Form::textarea('anggota', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Daftar Anggota'])}}
    </div>
    {{-- <div class="form-group">
        {{Form::file('cover_image')}}
    </div> --}}
    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
{!! Form::close() !!}
@endsection