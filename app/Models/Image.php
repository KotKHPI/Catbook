<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'cat_name_id'];

    public function catName()
    {
        return $this->belongsTo('App\Models\CatName');
    }

    public function url()
    {
        return Storage::url($this->path);
    }
}
