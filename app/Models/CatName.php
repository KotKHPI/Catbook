<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatName extends Model
{
    use SoftDeletes;

    protected $fillable =['name', 'age'];
    use HasFactory;

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public static function boot ()
    {
        parent::boot();

//        static::deleting(function (CatName $catName) {
//            $catName->comments()->delete();
//        });
    }
}
