<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LasestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class CatName extends Model
{
    use SoftDeletes;

    protected $fillable =['name', 'age', 'user_id'];
    use HasFactory;

    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->latest(); // Second variant using Local Query
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query) {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public static function boot ()
    {
        static::addGlobalScope(new DeletedAdminScope());

        parent::boot();

//        static::addGlobalScope(new LasestScope());

        static::deleting(function (CatName $catName) {
            $catName->comments()->delete();
        });

        static::restoring(function (CatName $catName) {
            $catName->comments()->restore();
        });
    }
}
