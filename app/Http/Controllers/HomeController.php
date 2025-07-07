<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user      = $request->user();
        $followingIds = $user->followings()->pluck('users.user_id');
        $userIds   = $followingIds->push($user->user_id);
        $posts     = Post::whereIn('user_id', $userIds)
            ->with(['user', 'isLike'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->get();

        return ApiResponse::success($posts);
    }

    public function suggest(Request $request)
    {
        $user = $request->user();
        $following   = $user->followings()->pluck('users.user_id');
        $suggestions = User::where('user_id', '!=', $user->user_id)
            ->withCount('followers')
            ->orderByDesc('followers_count')
            ->limit(5)
            ->get();

        // Tambahkan atribut 'is_following' ke setiap user yang disarankan
        // untuk menandakan apakah user yang login sudah mengikuti mereka.
        $suggestions->each(function ($suggestedUser) use ($following) {
            $suggestedUser->is_following = $following->contains($suggestedUser->user_id);
        });

        return ApiResponse::success($suggestions);
    }
}
