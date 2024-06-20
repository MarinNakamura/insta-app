<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    public $timestamps = false; //do not save timestamps
    protected $table = 'category_post'; //needed when the table name is singular
    protected $fillable = ['category_id', 'post_id']; //list of columns for create() / createMany()

    // category_posts belongs to category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // category_posts belongs to post
    // public function post()
    // {
    //     return $this->belongsTo(Post::class);
    // }
}
