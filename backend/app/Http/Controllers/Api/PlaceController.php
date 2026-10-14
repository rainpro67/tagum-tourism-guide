<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlaceController extends Controller
{
    public function index(Request $request)
    {
        $places = Place::with('category')
            ->when($request->category, fn ($q, $c) =>
                $q->whereHas('category', fn ($q) => $q->where('slug', $c)))
            ->when($request->search, fn ($q, $s) =>
                $q->where(fn ($q) => $q
                    ->where('name', 'like', "%{$s}%")
                    ->orWhere('description', 'like', "%{$s}%")))
            ->when($request->boolean('featured'), fn ($q) =>
                $q->where('is_featured', true))
            ->get();

        return response()->json(['data' => $places]);
    }

    public function show(string $slug)
    {
        $place = Place::with('category')->where('slug', $slug)->firstOrFail();

        return response()->json(['data' => $place]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean',
            // add any other columns from your migration
        ]);
        $data['slug'] = Str::slug($data['name']);

        $place = Place::create($data);

        return response()->json(['data' => $place->load('category')], 201);
    }

    public function update(Request $request, string $id)
    {
        $place = Place::findOrFail($id);
        $data = $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'sometimes|required|exists:categories,id',
            'is_featured' => 'boolean',
        ]);
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $place->update($data);

        return response()->json(['data' => $place->load('category')]);
    }

    public function destroy(string $id)
    {
        Place::findOrFail($id)->delete();

        return response()->noContent();
    }
}
