<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostComment;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function show (Post $id)
    {
        $id
            ->load(['user', 'comments.user', 'isLike'])
            ->loadCount('likes');
        return ApiResponse::success($id);
    }

    public function comment(Request $request, Post $id)
    {
        $req = $request->validate(['comment' => 'required']);

        PostComment::create([
            'post_id' => $id->post_id,
            'user_id' => Auth::id(),
            'post_comment_text' => $req['comment']
        ]);
        return ApiResponse::created();
    }

    public function like(Post $id)
    {
        $postLike = PostLike::where('user_id', Auth::id())
            ->where('post_id', $id->post_id)
            ->first();

        if ( $postLike) $postLike->delete();
        if (!$postLike) PostLike::create([
            'user_id' => Auth::id(),
            'post_id' => $id->post_id
        ]);
        return ApiResponse::success();
    }
}
