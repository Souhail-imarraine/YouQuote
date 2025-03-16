<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quote; // Assure-toi d'importer le modèle Quote
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MostPopularController extends Controller
{
    /**
     * Récupérer les citations les plus populaires.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function mostPopular(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'limit' => 'sometimes|integer|min:1|max:100',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors(),
            ], 422);
        }

        $limit = $request->input('limit', 10);

        $quotes = Quote::orderBy('popularity', 'desc')->limit($limit)->get();

        if ($quotes->isEmpty()) {
            return response()->json([
                'message' => 'No quotes found!',
            ], 404);
        }

        return response()->json([
            'message' => 'Most popular quotes retrieved successfully!',
            'data' => $quotes,
        ], 200);
    }
}
