<?php

namespace App\Http\Controllers;

use App\Models\CreatorContent;
use Illuminate\Http\Request;

class CreatorContentController extends Controller
{
    public function index(Request $request)
    {
        $query = CreatorContent::with('creator');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $contents = $query->latest()->paginate(12);
        return view('creator.index', compact('contents'));
    }

    public function create()
    {
        $this->authorizeCreator();
        return view('creator.create');
    }

    public function store(Request $request)
    {
        $this->authorizeCreator();

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:campaign_pack,monster,spell,item',
            'price'       => 'required|numeric|min:0',
            'is_premium'  => 'boolean',
            'content_data' => 'nullable|string',
        ]);

        // Parse content_data JSON if provided
        if (!empty($validated['content_data'])) {
            $decoded = json_decode($validated['content_data'], true);
            $validated['content_data'] = $decoded ?? [];
        }

        $validated['creator_id'] = auth()->id();
        $validated['is_premium'] = $request->boolean('is_premium');

        $content = CreatorContent::create($validated);

        return redirect()->route('creator-content.show', $content)
                         ->with('success', 'Content published!');
    }

    public function show(CreatorContent $creatorContent)
    {
        $creatorContent->load('creator', 'reviews.user');
        return view('creator.show', compact('creatorContent'));
    }

    public function edit(CreatorContent $creatorContent)
    {
        $this->authorize('update', $creatorContent);
        return view('creator.edit', compact('creatorContent'));
    }

    public function update(Request $request, CreatorContent $creatorContent)
    {
        $this->authorize('update', $creatorContent);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:campaign_pack,monster,spell,item',
            'price'       => 'required|numeric|min:0',
            'is_premium'  => 'boolean',
            'content_data' => 'nullable|string',
        ]);

        if (!empty($validated['content_data'])) {
            $decoded = json_decode($validated['content_data'], true);
            $validated['content_data'] = $decoded ?? [];
        }

        $validated['is_premium'] = $request->boolean('is_premium');
        $creatorContent->update($validated);

        return redirect()->route('creator-content.show', $creatorContent)
                         ->with('success', 'Content updated!');
    }

    public function destroy(CreatorContent $creatorContent)
    {
        $this->authorize('delete', $creatorContent);
        $creatorContent->delete();
        return redirect()->route('creator-content.index')
                         ->with('success', 'Content deleted.');
    }

    private function authorizeCreator()
    {
        if (!in_array(auth()->user()->role, ['creator', 'admin'])) {
            abort(403, 'Only creators can publish content.');
        }
    }
}
