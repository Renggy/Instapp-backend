<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostComment extends Model
{
    use HasFactory;

    protected $table      = 'post_comments';
    protected $primaryKey = 'post_comment_id';

    protected $fillable = [
        'post_id',
        'user_id',
        'post_comment_text',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    protected function CreatedAt() : Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->diffForHumans(),
        );
    }
}
