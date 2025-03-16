<?php

namespace App\Http\Controllers\Api;
use App\Models\Quote;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = Quote::all();
        return response()->json([
            'message' => 'Quotes retrieved successfully!',
            'data' => $quotes,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateQuotes = validator::make($request->all(), [
            'content' => 'required|string',
            'author' => 'required|string',
        ]);

        if($validateQuotes->fails()){
            return response()->json([
                'message' => $validateQuotes->errors(),
            ], 422);
        }

        $quote = Quote::create([
            'content' => $request->content,
            'author' => $request->author,
            'user_id' => Auth::user()->id,
        ]);

        return response()->json([
            'message' => 'Quote created successfully!',
            'data' => $quote,
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quote = Quote::find($id);
        
        if (!$quote) {
            return response()->json([
                'message' => 'Quote not found!',
            ], 404);
        }

        $quote->increment('popularity');

        return response()->json([
            'message' => 'Quote retrieved successfully!',
            'data' => $quote,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $quote = Quote::find($id);

        if (!$quote) {
            return response()->json([
                'message' => 'Quote not found!',
            ], 404);
        }

        $validate = Validator::make($request->all(), [
            'content' => 'sometimes|string',
            'author' => 'sometimes|string',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors(),
            ], 422);
        }

        $quote->update($request->only(['content', 'author']));

        return response()->json([
            'message' => 'Quote updated successfully!',
            'data' => $quote,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quote = Quote::find($id);

        if(!$quote){
            return Response()->json([
                'message' => 'Quote not Found!',
            ], 422);
        }

        $quote->delete();

        return response()->json([
            'message' => 'Quote deleted successfully!'
        ]);
    }
}
