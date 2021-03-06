@extends('layout')

@section('title')
    Ошибки / Автобаны
@stop

@section('content')

    <h1>Ошибки / Автобаны</h1>

    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/admin">Панель</a></li>
            <li class="breadcrumb-item active">Ошибки / Автобаны</li>
        </ol>
    </nav>

    @if (empty(setting('errorlog')))
        <span class="text-danger"><b>Внимание! Запись логов выключена в настройках!</b></span><br>
    @endif

    <ol class="breadcrumb">
        @foreach ($lists as $key => $value)
            <li class="breadcrumb-item">
                @if ($key === $code)
                    <b>{{ $value }}</b>
                @else
                    <a href="/admin/errors?code={{ $key }}">{{ $value }}</a>
                @endif
            </li>
        @endforeach
    </ol>

    @if ($logs->isNotEmpty())

        @foreach ($logs as $data)
            <div class="b">
                <i class="fa fa-file"></i>
                <b>{{ $data->request }}</b> ({{ dateFixed($data->created_at) }})
            </div>
            <div>
                Referer: {{ $data->referer ?: 'Не определено' }}<br>
                Пользователь: {!! $data->user->getProfile() !!}<br>
                <span class="data">({{ $data->brow }}, {{ $data->ip }})</span>
            </div>
        @endforeach

        {!! pagination($page) !!}

        Всего записей: <b>{{ $page->total }}</b><br><br>

        @if (isAdmin('boss'))
            <i class="fa fa-trash-alt"></i> <a href="/admin/errors/clear?token={{ $_SESSION['token'] }}">Очистить</a><br>
        @endif

    @else
        {!! showError('Записей еще нет!') !!}
    @endif
@stop
