@extends('layout_simple')

@section('title')
    {{ $blog->title }}
@stop

@section('content')

    <h1>{{ $blog->title }}</h1>

    {!! bbCode($blog->text) !!}

    <br><br>

    URL: <a href="{{ siteUrl() }}/articles/{{ $blog->id }}">{{ siteUrl(true) }}/articles/{{ $blog->id }}</a>
@stop
