<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Image extends Model
{
    // Mass assigned
    protected $fillable = ['article_id', 'imgsrc', 'miniature','title'];

    public function articles()
    {
      return $this->belongsTo('App\Article');
    }
	
}
