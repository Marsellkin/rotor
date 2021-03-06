@extends('layout')

@section('title')
    API интерфейс
@stop

@section('content')
    <h1>API интерфейс</h1>

    <i class="fa fa-cog"></i> <b><a href="/api">api</a></b> - Главная страница с описанием интерфейса<br>
    <i class="fa fa-cog"></i> <b><a href="/api/users">api/users</a></b> - Возвращает данные пользователя. GET: Параметры: token, ответ: массив данных из профиля пользователя<br>
    <i class="fa fa-cog"></i> <b><a href="/api/messages">api/messages</a></b> Возвращает приватные письма пользователя - GET: Параметры: token, count = 10, Ответ: total - кол. сообщений, messages - массив приватных сообщений<br>
    <i class="fa fa-cog"></i> <b><a href="/api/forums">api/forums</a></b> Возвращает сообщения из темы в форуме - GET: Параметры: token, id, Ответ: id - id темы, author - автор темы, title - заголовок темы, messages - массив постов<br>

    <br>Для доступа к данным нужен API-ключ, которые можно получить на странице мои данные<br><br>

    Пример использования
<pre class="prettyprint linenums">/api/users?token=Ключ</pre>

    Возвращает json
<pre class="prettyprint linenums">
{
  "login": "admin",
  "email": "my@domain.com",
  "name": "Александр",
  "country": "Россия",
  "city": "Москва",
  "site": "http://pizdec.ru",
  "icq": "364466",
  "skype": "vantuzilla",
  "gender": "male",
  "birthday": "11.12.1981",
  "newwall": 0,
  "point": 8134,
  "money": 110675,
  "ban": 0,
  "allprivat": 1,
  "newprivat": 0,
  "status": "<span style=\"color:#ff0000\">Господин ПЖ</span>",
  "avatar": "",
  "picture": "",
  "rating": 567,
  "lastlogin": 1502102146
}
</pre>
@stop
