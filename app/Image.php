<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $fillable = ['article_id', 'imgsrc', 'miniature','title'];

    public function articles()
    {
      return $this->belongsTo(Article::class);
    }
	
}
