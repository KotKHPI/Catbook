<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    public function catName() {
        return $this->belongsToMany('App\Models\CatName')->withTimestamps()->as('tagged');
    }
}
