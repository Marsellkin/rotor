@extends('layout')

@section('title')
    Реклама на сайте
@stop

@section('content')

    <div class="float-right">
        <a class="btn btn-success" href="/reklama/create">Разместить рекламу</a>
    </div><br>

    <h1>Реклама на сайте</h1>

    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/menu">Мое меню</a></li>
            <li class="breadcrumb-item active">Реклама на сайте</li>
        </ol>
    </nav>

    @if ($adverts->isNotEmpty())
        @foreach($adverts as $data)
            <div class="b">
                <i class="fa fa-check-circle"></i>
                <b><a href="{{ $data->site }}">{{ $data->name }}</a></b> ({!! $data->user->getProfile() !!})
            </div>

            Истекает: {{ dateFixed($data->deleted_at) }}<br>

            @if ($data->color)
                Цвет: <span style="color:{{ $data->color }}">{{ $data->color }}</span>,
            @else
                Цвет: нет,
            @endif

            @if ($data->bold)
                Жирный текст: есть<br>
            @else
                Жирный текст: нет<br>
            @endif
        @endforeach

        {!! pagination($page) !!}

        Всего ссылок: <b>{{ $page->total }}</b><br><br>
    @else
        {!! showError('В данный момент рекламных ссылок еще нет!') !!}
    @endif
@stop
