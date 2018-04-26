@extends('layout')

@section('title')
    Перевод денег
@stop

@section('content')

    <h1>Перевод денег</h1>

    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/menu">Мое меню</a></li>
            <li class="breadcrumb-item active">Перевод денег</li>
        </ol>
    </nav>

    В наличии: {{ plural(getUser('money'), setting('moneyname')) }}<br><br>

    @if (getUser('point') >= setting('sendmoneypoint'))
        <div class="form">
            <form action="/transfers/send" method="post">
                <input type="hidden" name="token" value="{{ $_SESSION['token'] }}">

                @if ($user)
                    <i class="fa fa-money-bill-alt"></i> Перевод для <b>{{ $user->login }}</b>:<br><br>
                    <input type="hidden" name="user" value="{{ $user->login }}">
                @else
                    <div class="form-group{{ hasError('user') }}">
                        <label for="inputUser">Логин пользователя</label>
                        <input name="user" class="form-control" id="inputUser" maxlength="20" placeholder="Логин пользователя" value="{{ getInput('user') }}" required>
                        {!! textError('user') !!}
                    </div>
                @endif

                <div class="form-group{{ hasError('money') }}">
                    <label for="inputMoney">Сумма</label>
                    <input name="money" class="form-control" id="inputMoney" placeholder="Сумма" value="{{ getInput('money') }}" required>
                    {!! textError('money') !!}
                </div>

                <div class="form-group{{ hasError('msg') }}">
                    <label for="msg">Комментарий:</label>
                    <textarea class="form-control markItUp" id="msg" rows="5" name="msg" placeholder="Комментарий">{{ getInput('msg') }}</textarea>
                    {!! textError('msg') !!}
                </div>

                <button class="btn btn-primary">Перевести</button>
            </form>
        </div><br>
    @else
       {!! showError('Ошибка! Для перевода денег вам необходимо набрать '.plural(setting('sendmoneypoint'), setting('scorename')).'!') !!}
    @endif

@stop