@extends('layout')

@section('title')
    Мои закладки
@stop

@section('content')
    <h1>Мои закладки</h1>

    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/forums">Форум</a></li>
            <li class="breadcrumb-item active">Мои закладки</li>
        </ol>
    </nav>

    @if ($topics->isNotEmpty())
        <form action="/forums/bookmarks/delete?page={{ $page->current }}" method="post">
            <input type="hidden" name="token" value="{{ $_SESSION['token'] }}">
            @foreach ($topics as $topic)
                <div class="b">
                    <input type="checkbox" name="del[]" value="{{ $topic->id }}">

                    <i class="fa {{ $topic->topic->getIcon() }} text-muted"></i>
                    <b><a href="/topics/{{ $topic->id }}">{{ $topic->title }}</a></b>
                    ({{ $topic->count_posts }}{!! ($topic->count_posts > $topic->bookmark_posts) ? '/<span style="color:#00cc00">+' . ($topic->count_posts - $topic->bookmark_posts) . '</span>' : '' !!})
                </div>

                <div>
                    {!! $topic->topic->pagination() !!}
                    Автор: {!! $topic->topic->user->getProfile(null, false) !!} /
                    Посл.: {!! $topic->topic->lastPost->user->getProfile(null, false) !!}
                    ({{ dateFixed($topic->topic->lastPost->created_at) }})
                </div>
            @endforeach

            <button class="btn btn-sm btn-danger">Удалить выбранное</button>
        </form>

        {!! pagination($page) !!}
    @else
        {!! showError('Закладок еще нет!') !!}
    @endif
@stop
