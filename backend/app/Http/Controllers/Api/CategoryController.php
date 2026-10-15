<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Category::all()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
        $data['slug'] = Str::slug($data['name']);

        return response()->json(['data' => Category::create($data)], 201);
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
        ]);
        $data['slug'] = Str::slug($data['name']);
        $category->update($data);

        return response()->json(['data' => $category]);
    }

    public function destroy(string $id)
    {
        Category::findOrFail($id)->delete();

        return response()->noContent();
    }
}
