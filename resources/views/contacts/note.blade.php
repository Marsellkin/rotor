@extends('layout')

@section('title')
    {{ trans('contacts.note_title') }} {{ $contact->contactor->login }}
@stop

@section('content')

    <h1>{{ trans('contacts.note_title') }} {{ $contact->contactor->login }}</h1>

    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/menu">{{ trans('common.menu') }}</a></li>
            <li class="breadcrumb-item"><a href="/contacts">{{ trans('contacts.title') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('contacts.note') }}</li>
        </ol>
    </nav>

    <div class="form">
        <form method="post" action="/contacts/note/{{ $contact->id }}">
            <input type="hidden" name="token" value="{{ $_SESSION['token'] }}">

            <div class="form-group{{ hasError('msg') }}">
                <label for="msg">{{ trans('contacts.note') }}:</label>
                <textarea class="form-control markItUp" id="msg" rows="5" name="msg" placeholder="{{ trans('contacts.note_text') }}">{{ getInput('msg', $contact->text) }}</textarea>
                {!! textError('msg') !!}
            </div>

            <button class="btn btn-primary">{{ trans('contacts.edit') }}</button>
        </form>
    </div>
@stop
