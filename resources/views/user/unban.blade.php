@extends('layout')

@section('title')
    Исправительная
@stop

@section('content')

    <h1>Исправительная</h1>

    Если вы не злостный нарушитель, но по какой-то причине получили строгое нарушение и хотите от него избавиться - тогда вы попали по адресу.<br>
    Здесь самое лучшее место, чтобы встать на путь исправления<br><br>
    Снять нарушение можно раз в месяц при условии, что с вашего последнего бана вы не нарушали правил и были добросовестным участником сайта<br>
    Также вы должны будете выплатить банку штраф в размере {{  plural(100000, setting('moneyname')) }}<br>
    Если с момента вашего последнего бана прошло менее месяца или у вас нет на руках суммы для штрафа, тогда строгое нарушение снять не удастся<br><br>
    Общее число строгих нарушений: <b>{{ $user->totalban }}</b><br>

    @if ($daytime > 0 && $user->totalban > 0)
        Суток прошедших с момента последнего нарушения: <b>{{ $daytime }}</b><br>
    @else
        Дата последнего нарушения не указана<br>
    @endif

    Денег на руках: <b>{{ plural($user->money, setting('moneyname')) }}</b><br><br>

    @if ($user->totalban > 0 && $daytime >= 30 && $user->money >= 100000)

        <form method="post" action="/unban">
            <button class="btn btn-primary"><i class="fa fa-check"></i> Снять нарушение</button>
        </form>
    @else
        <b>Вы не можете снять нарушение</b><br>
        Возможно у вас нет нарушений, не прошло еще 30 суток или недостаточная сумма на счете<br><br>
    @endif

@stop
