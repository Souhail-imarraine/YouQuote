<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilterQuoteController extends Controller
{
    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterByLength(Request $request)
    {
        // Valider le paramètre "min_words" (nombre minimum de mots)
        $validate = Validator::make($request->all(), [
            'min_words' => 'required|integer|min:1', // Doit être un entier positif
        ]);

        // Si la validation échoue, renvoyer une réponse d'erreur
        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors(),
            ], 422);
        }

        // Récupérer le nombre minimum de mots
        $minWords = $request->input('min_words');

        $quotes = Quote::all()->filter(function ($quote) use ($minWords) {
            return str_word_count($quote->content) >= $minWords;
        });

        if ($quotes->isEmpty()) {
            return response()->json([
                'message' => 'No quotes found with the specified length!',
            ], 404);
        }

        return response()->json([
            'message' => 'Quotes filtered by length successfully!',
            'data' => $quotes->values(),
        ], 200);
    }
}
