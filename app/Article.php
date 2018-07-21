<?php

namespace App;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Article extends Model
{
    // Mass assigned
    protected $fillable = ['title', 'slug', 'description_short', 'description', 'meta_title', 'meta_description', 'meta_keyword', 'published', 'created_by', 'modified_by'];

    // Mutators
    public function setSlugAttribute($value) {
      $this->attributes['slug'] = Str::slug( mb_substr($this->title, 0, 40) . "-" . \Carbon\Carbon::now()->format('dmyHi'), '-');
    }

    public function categories()
    {
      return $this->morphToMany('App\Category', 'categoryable');
    }
	
    public function images()
    {
      return $this->hasOne('App\Image','article_id','id');
    }
	
    public function scopeLastArticles($query, $count)
    {
      return $query->orderBy('created_at', 'desc')->take($count)->get();
    }
	public function getArticleImages($article_id)
    {
      return DB::table('images')->where('article_id', $article_id)->get(['imgsrc','miniature','title'])->first();
    }
}
