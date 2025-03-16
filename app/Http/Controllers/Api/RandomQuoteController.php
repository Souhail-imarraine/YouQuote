<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Quote;
use Illuminate\Http\Request;


class RandomQuoteController extends Controller
{
    public function random(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'count' => 'sometimes|integer|min:1|max:10',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors(),
            ], 422);
        }

        $count = $request->input('count', 1);
        $quotes = Quote::inRandomOrder()->limit($count)->get();

        if ($quotes->isEmpty()) {
            return response()->json([
                'message' => 'No quotes found!',
            ], 404);
        }

        return response()->json([
            'message' => 'Random quotes retrieved successfully!',
            'data' => $quotes,
        ], 200);
    }
}
