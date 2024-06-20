<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Category has many category_posts(pivot)
    public function categoryPosts()
    {
        return $this->hasMany(CategoryPost::class);
    }
}
