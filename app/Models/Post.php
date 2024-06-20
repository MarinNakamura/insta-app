<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    // Post has many category_post(pivot table)
    public function categoryPosts()
    {
        return $this->hasMany(CategoryPost::class);
    }

    // post belongs to user
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // post has many likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // return true if the $this post is liked by auth user
    public function isLiked()
    {
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
        // exists() - return true if the where() returns records
    }
}
