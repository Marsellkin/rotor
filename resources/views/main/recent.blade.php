@section('title')
    Последняя активность
@stop

<h1>Последняя активность</h1>

<nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item active">Последняя активность</li>
    </ol>
</nav>

<div class="b"><i class="fab fa-forumbee fa-lg text-muted"></i> <b>Последние темы</b></div>
{{ recentTopics() }}

<div class="b"><i class="fa fa-download fa-lg text-muted"></i> <b>Последние файлы</b></div>
{{ recentFiles() }}

<div class="b"><i class="fa fa-globe fa-lg text-muted"></i> <b>Последние статьи</b></div>
{{ recentBlogs() }}

<div class="b"><i class="fa fa-image fa-lg text-muted"></i> <b>Последние фотографии</b></div>
{{  recentPhotos() }}
