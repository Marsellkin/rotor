@extends('layout')

@section('title')
    {{ $forum->title }} (Стр. {{ $page->current }})
@stop

@section('content')

    @if (getUser() && ! $forum->closed)
        <div class="float-right">
            <a class="btn btn-success" href="/forums/create?fid={{ $forum->id }}">Создать тему</a>
        </div><br>
    @endif

    <h1>{{ $forum->title }}</h1>

    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/forums">Форум</a></li>

            @if ($forum->parent->id)
                <li class="breadcrumb-item"><a href="/forums/{{ $forum->parent->id }}">{{ $forum->parent->title }}</a></li>
            @endif

            <li class="breadcrumb-item active">{{ $forum->title }}</li>

            @if (isAdmin())
                <li class="breadcrumb-item"><a href="/admin/forums/{{  $forum->id  }}?page={{ $page->current }}">Управление</a></li>
            @endif
        </ol>
    </nav>

    @if ($forum->children->isNotEmpty() && $page->current == 1)
        <div class="act">

        @foreach ($forum->children as $child)

            <div class="b"><i class="fa fa-file-alt fa-lg text-muted"></i>
            <b><a href="/forums/{{ $child->id }}">{{ $child->title }}</a></b> ({{ $child->count_topics }}/{{ $child->count_posts }})</div>

            @if ($child->lastTopic->id)
                <div>
                    Тема: <a href="/topics/end/{{ $child->lastTopic->id }}">{{ $child->lastTopic->title }}</a><br>
                    @if ($child->lastTopic->lastPost->id)
                        Сообщение: {!! $child->lastTopic->lastPost->user->getProfile(null, false) !!} ({{ dateFixed($child->lastTopic->lastPost->created_at) }})
                    @endif
                </div>
            @else
                <div>Темы еще не созданы!</div>
            @endif
        @endforeach

        </div>
        <hr>
    @endif

    @if ($topics->isNotEmpty())
        @foreach ($topics as $topic)
            <div class="b" id="topic_{{ $topic->id }}">
                <i class="fa {{ $topic->getIcon() }} text-muted"></i>
                <b><a href="/topics/{{ $topic->id }}">{{ $topic->title }}</a></b> ({{ $topic->count_posts }})
            </div>
            <div>
                @if ($topic->lastPost)
                    {!! $topic->pagination() !!}
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

    <a href="/rules">Правила</a> /
    <a href="/forums/top/topics">Топ тем</a> /
    <a href="/forums/top/posts">Топ постов</a> /
    <a href="/forums/search?fid={{ $forum->id }}">Поиск</a><br>
@stop
