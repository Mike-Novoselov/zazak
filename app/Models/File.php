<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['file_path', 'file_type', 'bookmark_id'];

    public function bookmark()
    {
        return $this->belongsTo(Bookmark::class);
    }
}
