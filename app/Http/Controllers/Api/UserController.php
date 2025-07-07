<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\RequestPosting;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show($username)
    {
        $data = User::where('user_name', $username)
            ->withCount('post')
            ->withCount('followers')
            ->withCount('followings')
            ->firstOrFail();
        return ApiResponse::success($data);
    }

    public function post($username)
    {
        $data = Post::whereHas('user', fn($q) => $q->where('user_name', $username))
            ->withCount('likes')
            ->withCount('comments')
            ->latest()
            ->get();
        return ApiResponse::success($data);
    }

    public function storePost(RequestPosting $request, $username)
    {
        $user = User::where('user_name', $username)->firstOrFail();
        $path = $request->file('image')->store('posts', 'public');
        $post = Post::create([
            'user_id'          => $user->user_id,
            'post_caption'     => $request->caption,
            'post_media_url'   => $path,
        ]);
        return ApiResponse::created();
    }

    public function follow(Request $request, $username)
    {
        $userToFollow = User::where('user_name', $username)->firstOrFail();

        $request->user()->followings()->toggle($userToFollow->user_id);

        return ApiResponse::success();
    }

    public function isFollow(Request $request, $username)
    {
        $userToFollow = User::where('user_name', $username)->firstOrFail();

        $isFollowing = $request
            ->user()
            ->followings()
            ->where('users.user_id', $userToFollow->user_id)
            ->exists();

        return ApiResponse::success($isFollowing);
    }
}
