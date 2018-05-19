@extends('admin.layouts.app_admin')

@section('content')

<div class="container">

  @component('admin.components.breadcrumb')
    @slot('title') Редактирование записи @endslot
    @slot('parent') Главная @endslot
    @slot('active') Записи @endslot
  @endcomponent

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#default_panel">Основные поля</a></li>
	<li><a data-toggle="tab" href="#desc_panel">Описание</a></li>
    <li><a data-toggle="tab" href="#seo_panel">SEO поля</a></li>
  </ul>

  <form class="form-horizontal" action="{{route('admin.article.update', $article)}}" method="post">
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}

    {{-- Form include --}}
    @include('admin.articles.partials.form')

    <input type="hidden" name="modified_by" value="{{Auth::id()}}">
  </form>
</div>

@endsection
