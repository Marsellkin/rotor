@extends('layout')

@section('title')
    {{ trans('guestbooks.title', ['page' => $page->current]) }}
@stop

@section('content')

    <h1>{{ trans('guestbooks.header') }}</h1>

    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active">{{ trans('guestbooks.header') }}</li>
        </ol>
    </nav>

    <a href="/rules">{{ trans('common.rules') }}</a> /
    <a href="/smiles">{{ trans('common.smiles') }}</a> /
    <a href="/tags">{{ trans('common.tags') }}</a>

    @if (isAdmin())
        / <a href="/admin/guestbooks?page={{ $page->current }}">{{ trans('common.management') }}</a>
    @endif
    <hr>

    @if ($posts->isNotEmpty())
        @foreach ($posts as $data)

            <div class="post">
                <div class="b">

                    @if (getUser() && getUser('id') != $data->user_id)
                        <div class="float-right">
                            <a href="#" onclick="return postReply(this)" data-toggle="tooltip" title="{{ trans('common.reply') }}"><i class="fa fa-reply text-muted"></i></a>
                            <a href="#" onclick="return postQuote(this)" data-toggle="tooltip" title="{{ trans('common.quote') }}"><i class="fa fa-quote-right text-muted"></i></a>

                            <a href="#" onclick="return sendComplaint(this)" data-type="{{ App\Models\Guestbook::class }}" data-id="{{ $data->id }}" data-token="{{ $_SESSION['token'] }}" data-page="{{ $page->current }}" rel="nofollow" data-toggle="tooltip" title="{{ trans('common.complain') }}"><i class="fa fa-bell text-muted"></i></a>
                        </div>
                    @endif

                    @if (getUser() && getUser('id') == $data->user_id && $data->created_at + 600 > SITETIME)
                        <div class="float-right">
                            <a href="/guestbooks/edit/{{ $data->id }}" data-toggle="tooltip" title="{{ trans('common.edit') }}"><i class="fa fa-pencil-alt text-muted"></i></a>
                        </div>
                    @endif

                    <div class="img">
                        {!! $data->user->getAvatar() !!}

                        @if ($data->user_id)
                            {!! $data->user->getOnline() !!}
                        @endif
                    </div>

                    @if ($data->user_id)
                        <b>{!! $data->user->getProfile() !!}</b> <small>({{ dateFixed($data->created_at) }})</small><br>
                        {!! $data->user->getStatus() !!}
                    @else
                        <b class="author" data-login="{{ setting('guestsuser') }}">{{ setting('guestsuser') }}</b> <small>({{ dateFixed($data->created_at) }})</small>
                    @endif
                </div>

                <div class="message">{!! bbCode($data->text) !!}</div>

                @if ($data->edit_user_id)
                    <small><i class="fa fa-exclamation-circle text-danger"></i> {{ trans('guestbooks.edited') }}: {{ $data->editUser->login }} ({{ dateFixed($data->updated_at) }})</small><br>
                @endif

                @if (isAdmin())
                    <span class="data">({{ $data->brow }}, {{ $data->ip }})</span>
                @endif

                @if ($data->reply)
                    <br><span style="color:#ff0000">{{ trans('guestbooks.answer') }}: {!! bbCode($data->reply) !!}</span>
                @endif
            </div>
        @endforeach

        {!! pagination($page) !!}

    @else
        {!! showError(trans('guestbooks.empty_messages')) !!}
    @endif

    @if (getUser())
        <div class="form">
            <form action="/guestbooks/add" method="post">
                <input type="hidden" name="token" value="{{ $_SESSION['token'] }}">
                <div class="form-group{{ hasError('msg') }}">
                    <label for="msg">{{ trans('guestbooks.message') }}:</label>
                    <textarea class="form-control markItUp" id="msg" rows="5" name="msg" placeholder="{{ trans('guestbooks.message_text') }}" required>{{ getInput('msg') }}</textarea>
                    {!! textError('msg') !!}
                </div>

                <button class="btn btn-primary">{{ trans('guestbooks.write') }}</button>
            </form>
        </div><br>

    @elseif (setting('bookadds') == 1)

        <div class="form">
            <form action="/guestbooks/add" method="post">
                <input type="hidden" name="token" value="{{ $_SESSION['token'] }}">

                <div class="form-group{{ hasError('msg') }}">
                    <label for="msg">{{ trans('guestbooks.message') }}:</label>
                    <textarea class="form-control" id="msg" rows="5" name="msg" placeholder="{{ trans('guestbooks.message_text') }}" required>{{ getInput('msg') }}</textarea>
                    {!! textError('msg') !!}
                </div>

                {!! view('app/_captcha') !!}

                <button class="btn btn-primary">{{ trans('guestbooks.write') }}</button>
            </form>
        </div><br>

    @else
        {!! showError(trans('guestbooks.not_authorized')) !!}
    @endif
@stop
