<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Favorite;
use App\Models\Place;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // GET /api/favorites
    public function index(Request $request)
    {
        $favorites = Favorite::where('user_id', $request->user()->id)
            ->with('favoritable')
            ->get();

        return response()->json(['data' => $favorites]);
    }

    // POST /api/favorites
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:place,event',
            'id'   => 'required|integer',
        ]);

        $model = $validated['type'] === 'place' ? Place::class : Event::class;

        $item = $model::find($validated['id']);

        if (! $item) {
            return response()->json(['message' => 'Not found'], 404);
        }

        // firstOrCreate prevents duplicate rows
        $favorite = Favorite::firstOrCreate([
            'user_id'          => $request->user()->id,
            'favoritable_type' => $model,
            'favoritable_id'   => $item->id,
        ]);

        return response()->json(['data' => $favorite]);
    }

    // DELETE /api/favorites/{id}
    public function destroy(Request $request, $id)
    {
        // Only search among the logged-in user's own favorites
        $favorite = Favorite::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (! $favorite) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $favorite->delete();

        return response()->json(['message' => 'Removed']);
    }
}