<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'post_id';
    protected $fillable = [
        'user_id',
        'post_caption',
        'post_media_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id', 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id', 'post_id');
    }

    public function isLike()
    {
        return $this->hasOne(PostLike::class, 'post_id', 'post_id')->where('user_id', Auth::id());
    }

    // Attribute
    protected function CreatedAt() : Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->diffForHumans(),
        );
    }

    protected function postMediaUrl(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset('storage/' . $value),
        );
    }
}
