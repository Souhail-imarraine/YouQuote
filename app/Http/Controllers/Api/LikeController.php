<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Quote $quote)
    {
        $user = Auth::user();

        if (!$quote->likedByUsers->contains($user->id)) {
            $quote->likedByUsers()->attach($user->id);
            return response()->json([
                'message' => 'Quote liked successfully!',
            ], 200);
        }

        return response()->json([
            'message' => 'You have already liked this quote.',
        ], 409);
    }

    public function unlike(Quote $quote)
    {
        $user = Auth::user();

        if ($quote->likedByUsers->contains($user->id)) {
            $quote->likedByUsers()->detach($user->id);
            return response()->json([
                'message' => 'Quote unliked successfully!',
            ], 200);
        }

        return response()->json([
            'message' => 'You have not liked this quote.',
        ], 404);
    }
}
