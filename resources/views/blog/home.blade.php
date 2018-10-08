@extends('layouts.app')

@section('content')
    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
		<ol class="carousel-indicators">
		@forelse($articles as $key => $article)
			<li data-target="#myCarousel" 
			    data-slide-to="{{$key}}" 
			@if($key==0) 
				class="active" 
			@endif ></li>
		@empty
		@endforelse
		</ol>
		<div class="carousel-inner" role="listbox">
		@forelse($articles as $k => $article) 
			<div class="item  @if($k==0) active @endif ">
			  @if( !empty($imginfo = $article->getArticleImages()) )
				<img class="{{$key}}-slide" src="{{$imginfo->miniature}}" alt="">
			  @endif
				<div class="container">
					<div class="carousel-caption">
					  <h1>{{$article->title}}</h1>
					  <a class="btn btn-lg btn-primary" href="{{route('article', $article->slug)}}" role="button">Подробнее</a>
					</div>
				</div>
			</div>
		@empty
		@endforelse
		</div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->
@endsection