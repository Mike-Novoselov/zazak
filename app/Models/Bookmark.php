<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'url', 'description', 'image', 'category_id', 'user_id'];
//    protected $fillable = ['title', 'url', 'description', 'category_id', 'user_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'bookmark_tag');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}

