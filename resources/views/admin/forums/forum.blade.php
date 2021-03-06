@extends('layout')

@section('title')
    {{ $forum->title }} (Стр. {{ $page->current }})
@stop

@section('content')

    <div class="float-right">
        <a class="btn btn-success" href="/forums/create?fid={{ $forum->id }}">Создать тему</a>
    </div><br>

    <h1>{{ $forum->title }}</h1>

    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/admin">Панель</a></li>
            <li class="breadcrumb-item"><a href="/admin/forums">Форум</a></li>

            @if ($forum->parent->id)
                <li class="breadcrumb-item"><a href="/admin/forums/{{ $forum->parent->id }}">{{ $forum->parent->title }}</a></li>
            @endif

            <li class="breadcrumb-item active">{{ $forum->title }}</li>
            <li class="breadcrumb-item"><a href="/forums/{{ $forum->id  }}?page={{ $page->current }}">Обзор</a></li>
        </ol>
    </nav>

    @if ($topics->isNotEmpty())
            @foreach ($topics as $topic)
                <div class="b" id="topic_{{ $topic->id }}">

                    <div class="float-right">
                        <a href="/admin/topics/edit/{{ $topic->id }}" title="Редактировать"><i class="fa fa-pencil-alt text-muted"></i></a>
                        <a href="/admin/topics/move/{{ $topic->id }}" title="Перенести"><i class="fa fa-arrows-alt text-muted"></i></a>
                        <a href="/admin/topics/delete/{{ $topic->id }}?page={{ $page->current }}&amp;token={{ $_SESSION['token'] }}" onclick="return confirm('Вы действительно хотите удалить данную тему?')" title="Удалить"><i class="fa fa-times text-muted"></i></a>
                    </div>

                    <i class="fa {{ $topic->getIcon() }} text-muted"></i>
                    <b><a href="/admin/topics/{{ $topic->id }}">{{ $topic->title }}</a></b> ({{ $topic->count_posts }})
                </div>
                <div>
                    @if ($topic->lastPost)
                        {!! $topic->pagination('/admin/topics') !!}
                        Сообщение: {!! $topic->lastPost->user->getProfile(null, false) !!} ({{ dateFixed($topic->lastPost->created_at) }})
                    @endif
                </div>
            @endforeach
        {!! pagination($page) !!}

    @elseif ($forum->closed)
        {!! showError('В данном разделе запрещено создавать темы!') !!}
    @else
        {!! showError('Тем еще нет, будь первым!') !!}
    @endif
@stop
