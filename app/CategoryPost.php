<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    protected $table = 'category_post';
    public $timestamps = false;

    protected $fillable = [
        'post_id', 'category_id'
    ];

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function Post()
    {
        return $this->belongsTo(Post::class);
    }
}
