<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LasestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class CatName extends Model
{
    use SoftDeletes;
    use Taggable;

    protected $fillable =['name', 'age', 'user_id'];
    use HasFactory;

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->latest(); // Second variant using Local Query
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query) {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public function scopeLatestWithRelations(Builder $query)
    {
        return $query->latest()
            ->withCount('comments')
            ->with('user')
            ->with('tags');
    }
}
