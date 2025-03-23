<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

use App\Models\Tag;


class TagsController extends Controller
{
    public function create(Request $request)
    {
        Gate::authorize('is_admin');

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|unique:tags,name',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validation->errors(),
            ], 422);
        }

        $tag = Tag::create([
            'name' => $request->input('name'),
        ]);

        return response()->json([
            'message' => 'Tag created successfully!',
            'data' => $tag,
        ], 201);
    }
}
