@extends('layouts.app')

@section('title', $category->title)

@section('content')

    <div class="container">
		<div class="row">
			<div class="col-sm-12">
	          <h1>{{$category->title}}</h1> 
			  <span>{{$category->articles()->count()}} posts</span>
	        </div>
		</div>
	</div>
	
	<div class="container">
		@forelse ($articles as $key => $article)
		  @if($key == 0 || $key%3 == 0 )
			<div class="row">
		  @endif
				<div class="col-sm-4">
				    <a href="{{route('article', $article->slug)}}">
					   <h2>{{$article->title}}</h2>
					  @if ( !empty($imginfo = $article->getArticleImages($article->id)) )
	                    <img src="{{$imginfo->miniature}}" 
				             alt="{{$imginfo->title or $article->description_short}}"  
						     title="{{$imginfo->title or $article->description_short}}"><br/>
	                  @endif
				    </a>
				      <p>{!!$article->description_short!!}</p>
				</div>
		  @if($key%3 == 2 || count($articles) - 1 == $key  )
			</div>
		  @endif
		@empty
			<h2 class="text-center">Пусто</h2>
		@endforelse

		{{$articles->links()}}
	</div>

@endsection