<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function addToFavorites(Quote $quote)
    {
        $user = Auth::user();

        // dd($user);
        // Vérifier si la citation est déjà dans les favoris
        if (!$user->favoriteQuotes->contains($quote->id)) {

            $user->favoriteQuotes()->attach($quote->id);
            return response()->json([
                'message' => 'Quote added to favorites successfully!',
            ], 200);
        }

        return response()->json([
            'message' => 'Quote is already in favorites.',
        ], 409);
    }

    public function removeFromFavorites(Quote $quote)
    {
        $user = Auth::user();

        if ($user->favoriteQuotes->contains($quote->id)) {
            $user->favoriteQuotes()->detach($quote->id);
            return response()->json([
                'message' => 'Quote removed from favorites successfully!',
            ], 200);
        }

        return response()->json([
            'message' => 'Quote is not in favorites.',
        ], 404);
    }

    public function getFavorites()
    {
        $user = Auth::user();

        $favorites = $user->favoriteQuotes()
            ->withCount('likedByUsers')
            ->get();

        return response()->json([
            'message' => 'Favorites retrieved successfully!',
            'data' => $favorites,
        ], 200);
    }
}
