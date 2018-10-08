<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Category;
use App\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.articles.index', [
          'articles' => Article::orderBy('created_at', 'desc')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.articles.create', [
          'article'    => [],
          'categories' => Category::with('children')->where('parent_id', 0)->get(),
          'delimiter'  => ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$validator = $request->validate([
            'title' => 'required|string|max:255',
			'description'       => 'required|string|min:6',
            'image_title'       => 'string|max:255',
			'meta_title'        => 'required|string|max:255', 
        ]);
		
        $article = Article::create($request->all());

        if($request->input('categories')) :
           $article->categories()->attach($request->input('categories'));
        endif;
			
		if($request->file('images')):
		    $imageName = time() . '.' . $request->file('images')->getClientOriginalExtension();
            $request->file('images')->move(public_path('images'), $imageName);
			$miniature = $this->resize($imageName, 300, 200);
			
		    $article->images()->create([
		       'imgsrc' => '/images/'.$imageName, 
			   'title' => $request->input('image_title'), 
			   'miniature' => $miniature
			]);
		endif;

        return redirect()->route('admin.article.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', [
          'article'    => $article,
          'categories' => Category::with('children')->where('parent_id', 0)->get(),
		  'image'      => Image::where('article_id', $article->id)->get(['imgsrc','miniature','title'])->first(),
          'delimiter'  => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
		$validator = $request->validate([
            'title' => 'required|string|max:255',
			'description'       => 'required|string|min:6',
            'image_title'       => 'string|max:255',
			'meta_title'        => 'required|string|max:255', 
        ]);
		
        $article->update($request->except('slug'));

        $article->categories()->detach();
        if($request->input('categories')) :
          $article->categories()->attach($request->input('categories'));
        endif;
			
		if($request->file('images') && !$request->input('deleteimg')):
		   $article->images()->delete();
		   $imageName = time() . '.' . $request->file('images')->getClientOriginalExtension();
           $request->file('images')->move(public_path('images'), $imageName);
		   $miniature = $this->resize($imageName, 300, 200);
		   
		   $article->images()->create(['imgsrc' => '/images/'.$imageName, 'miniature' => $miniature]);
		endif;
		
		if($request->input('image_title') && !$request->input('deleteimg')):
		   $article->images()->update(['title' => $request->input('image_title')]);
		endif;
		
		if($request->input('deleteimg')):
		   $article->images()->delete();
		endif;

        return redirect()->route('admin.article.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->categories()->detach();
		$article->images()->delete();
        $article->delete();

        return redirect()->route('admin.article.index');
    }

	/**
	* Метод изменяет размер фотографий
	* @param Название фото и размеры
	* @return Путь до фото
	*/
    public function resize($image, $w_o = 300, $h_o = 200) { 
	
	    $savepath = '/images/miniature/'.$w_o.'_'.$h_o.'_'.$image;	
	    
		$image = $_SERVER['DOCUMENT_ROOT'].'/images/'.$image;	
	
        list($w_i, $h_i, $type) = getimagesize($image); 
	
        $types = array("", "gif", "jpeg", "png"); 
	
        $ext = $types[$type]; 
	
        if($ext) { 
          $func = 'imagecreatefrom'.$ext; // Получаем название функции, соответствующую типу, для создания изображения 
          $img_i = $func($image); 
        }else{
          return false;
		}
	
        $img_o = imagecreatetruecolor($w_o, $h_o); 
        imagecopyresampled($img_o, $img_i, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i); 
		/* Переносим изображение из исходного в выходное, масштабируя его */
        $func = 'image'.$ext; // Получаем название функции, для сохранения результата 
	
        $func($img_o, $_SERVER['DOCUMENT_ROOT'].$savepath); 
		
		return $savepath;
  }
  
}
