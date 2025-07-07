<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('q');
        $data  = User::query()
            ->where(function ($q) use($query) {
                $q->where('user_name', 'LIKE', "%{$query}%")
                ->orWhere('user_full_name', 'LIKE', "%{$query}%");
            })
            ->where('user_id', '!=', Auth::id())
            ->get();
        return ApiResponse::success($data);
    }
}
