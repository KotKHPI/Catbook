<?php

namespace App\Models;

use App\Scopes\LasestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['content', 'user_id'];

    public function catName()
    {
        return $this->belongsTo('App\Models\CatName', 'cat_name_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function scopeLatest(Builder $builder)
    {
        return $builder->orderBy(static::CREATED_AT, 'desc');
    }


    public static function boot ()
    {
        parent::boot();

        static::creating(function (Comment $comment) {
            Cache::tags(['cat-name'])->forget("cat-name-{$comment->cat_name_id}");
            Cache::tags(['cat-name'])->forget("mostCommented");
        });

//        static::addGlobalScope(new LasestScope());
    }
}
