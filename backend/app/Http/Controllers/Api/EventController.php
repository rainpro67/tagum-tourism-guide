<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of published events.
     *
     * Query parameters:
     *   ?upcoming=1   — only events whose start_date is in the future
     *   ?category=slug — filter by category slug
     *
     * Returns { "data": [...] } with category and place eager-loaded.
     * Results are sorted by start_date ascending (earliest first).
     */
    public function index(Request $request): JsonResponse
    {
        $query = Event::with(['category', 'place'])
            ->where('is_published', true);

        if ($request->boolean('upcoming')) {
            $query->where('start_date', '>', now());
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        $events = $query->orderBy('start_date', 'asc')->get();

        return response()->json(['data' => $events]);
    }

    /**
     * Store a newly created event in storage (admin only).
     *
     * Slug is auto-generated from the title.
     * created_by is set to the authenticated user's id.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'category_id' => 'nullable|exists:categories,id',
            'place_id'    => 'nullable|exists:places,id',
            'venue_name'  => 'nullable|string|max:255',
            'image_path'  => 'nullable|string|max:255',
            'is_published'=> 'boolean',
        ]);

        $validated['slug']       = Str::slug($validated['title']);
        $validated['created_by'] = $request->user()->id;

        $event = Event::create($validated);
        $event->load(['category', 'place']);

        return response()->json(['data' => $event], 201);
    }

    /**
     * Display the specified event by slug.
     *
     * Returns { "data": event } or 404 if not found.
     */
    public function show(string $slug): JsonResponse
    {
        $event = Event::with(['category', 'place'])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json(['data' => $event]);
    }

    /**
     * Update the specified event in storage (admin only).
     *
     * Slug is regenerated if the title changes.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'start_date'  => 'sometimes|required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'category_id' => 'nullable|exists:categories,id',
            'place_id'    => 'nullable|exists:places,id',
            'venue_name'  => 'nullable|string|max:255',
            'image_path'  => 'nullable|string|max:255',
            'is_published'=> 'boolean',
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $event->update($validated);
        $event->load(['category', 'place']);

        return response()->json(['data' => $event]);
    }

    /**
     * Remove the specified event from storage (admin only).
     */
    public function destroy(string $id): JsonResponse
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(['message' => 'Event deleted successfully.']);
    }
}
