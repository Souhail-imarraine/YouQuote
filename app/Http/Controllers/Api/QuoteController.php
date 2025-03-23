<?php

namespace App\Http\Controllers\Api;
use App\Models\Quote;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
    {
        $user = auth::user();

        if(Gate::allows('is_admin')) {
            $quotes = Quote::withCount('likedByUsers')->paginate(100);
        }else {
            // $quotes = Quote::where('user_id', $user->id)->get();
            $quotes = Quote::where('user_id', $user->id)->withCount('likedByUsers')->get();
        }

        if(!$quotes){
            return response()->json([
                'message' => 'Quote not found!',
            ], 402);
        }


        return response()->json([
            'message' => 'Quotes retrieved successfully!',
            'data' => $quotes->values(),
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
            'tags' => 'sometimes|array',
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

        if ($request->has('tags')) {
            $quote->tags()->attach($request->input('tags'));
        }


           return response()->json([
            'message' => 'Quote created successfully!',
            'data' => $quote->load(['tags']),
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
        $user = Auth::user();

        // check is admin
        if(Gate::allows('is_admin')){
            $quote = Quote::find($id);
        }else{
            $quote = Quote::where('user_id', $user->id)->where('id', $id)->first();
        }

        if (!$quote) {
            return response()->json([
                'message' => 'Quote not found or you do not have permission to update this quote.',
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
        $user = Auth::user();
        if(Gate::allows('is_admin')){
            $quote = Quote::find($id);
        }else {
            $quote = Quote::where('user_id', $user->id)->where('id', $id)->first();
        }

        if(!$quote){
            return Response()->json([
                'message' => 'Quote not found or you do not have permission to delete this quote.',
            ], 422);
        }

        $quote->delete();

        return response()->json([
            'message' => 'Quote deleted successfully!'
        ]);
    }
}
