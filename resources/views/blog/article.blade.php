@extends('layouts.app')

@section('title', $article->meta_title)
@section('meta_keyword', $article->meta_keyword)
@section('meta_description', $article->meta_description)

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1>{{$article->title}}</h1>
				@if (isset($image))
	                <img src="{{$image->imgsrc}}" 
				         alt="{{$image->title or $article->description_short}}"  
						 width="400px" 
						 title="{{$image->title or $article->description_short}}"><br/>
	            @endif
				<p>{!!$article->description!!}</p>
			</div>
		</div>
	</div>
@endsection