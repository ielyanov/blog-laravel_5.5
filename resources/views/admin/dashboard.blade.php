@extends('admin.layouts.app_admin')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <div class="jumbotron">
		  <a href="{{route('admin.category.index')}}" class="btn btn-primary">
            Категорий <span class="badge">{{$count_categories}}</span>
		  </a>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="jumbotron">
		  <a href="{{route('admin.article.index')}}" class="btn btn-primary">
            Записей <span class="badge">{{$count_articles}}</span>
		  </a>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="jumbotron">
		  <a href="#" class="btn btn-primary">
            Посетителей <span class="badge">0</span>
		  </a>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="jumbotron">
		  <a href="#" class="btn btn-primary">
            Сегодня <span class="badge">0</span>
		  </a>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <a class="btn btn-block btn-success" href="{{route('admin.category.create')}}">Создать категорию</a>
        @foreach ($categories as $category)
          <a class="list-group-item" href="{{route('admin.category.edit', $category)}}">
            {{$category->title}} <span class="badge">{{$category->articles()->count()}}</span>
          </a>
        @endforeach
      </div>
      <div class="col-sm-6">
        <a class="btn btn-block btn-success" href="{{route('admin.article.create')}}">Создать запись</a>
        @foreach ($articles as $article)
          <a class="list-group-item" href="{{route('admin.article.edit', $article)}}">
            {{$article->title}}
            <span class="badge">
              {{$article->categories()->pluck('title')->implode(', ')}}
            </span>
          </a>
        @endforeach
      </div>
    </div>
  </div>
@endsection
