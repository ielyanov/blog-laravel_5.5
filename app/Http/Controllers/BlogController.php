<?php

namespace App\Http\Controllers;

use App\Category;
use App\Article;
use App\Image;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function category($slug) {

    	$category = Category::where('slug', $slug)->first();

    	return view('blog.category', [
    		'category' => $category,
    		'articles' => $category->articles()->where('published', 1)->paginate(9)
    	]);
    }

    public function article($slug) {
		
		$article = Article::where('slug', $slug)->first();
			
    	return view('blog.article', [
    		'article' => $article,
			'image'   => Image::where('article_id', $article->id)->get(['imgsrc','miniature','title'])->first()
    	]);
    }
}
