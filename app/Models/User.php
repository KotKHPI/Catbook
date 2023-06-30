<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public const LOCALE = [
        'en' => 'English',
        'es' => 'Español',
        'de' => 'Deutsch'
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function catName() {
        return $this->hasMany('App\Models\CatName');
    }

    public function comments() {
        return $this->hasMany('App\Models\Comment');
    }

    public function commentsOn()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->latest();
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function scopeWithMostCatNames(Builder $query) {
        return $query->withCount('catName')->orderBy('cat_name_count', 'desc');
    }

    public function scopeWithMostCatNamesLastMonth(Builder $query) {
        return $query->withCount(['catName' => function(Builder $query) {
            $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
        }])->has('catName', '>=', 2)
            ->orderBy('cat_name_count', 'desc');
    }

    public function scopeThatHasCommentedOnCat(Builder $query, CatName $catName) {
        return $query->whereHas('comments', function ($query) use ($catName) {
            return $query->where('commentable_id', '=', $catName->id)
                ->where('commentable_type', '=', CatName::class);
        });
    }

    public function scopeThatIsAnAdmin(Builder $query) {
        return $query->where('is_admin', true);
    }
}
