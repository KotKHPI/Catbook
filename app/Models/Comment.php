<?php

namespace App\Models;

use App\Scopes\LasestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function catName()
    {
        return $this->belongsTo('App\Models\CatName', 'cat_name_id');
    }

    public function scopeLatest(Builder $builder)
    {
        return $builder->orderBy(static::CREATED_AT, 'desc');
    }


    public static function boot ()
    {
        parent::boot();

//        static::addGlobalScope(new LasestScope());
    }
}
