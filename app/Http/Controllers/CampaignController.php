<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = auth()->user()->campaigns()->withCount('encounters')->latest()->paginate(12);
        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('campaigns.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'world_name'  => 'nullable|string|max:255',
            'status'      => 'required|in:planning,active,paused,completed',
        ]);

        $campaign = auth()->user()->campaigns()->create($validated);

        return redirect()->route('campaigns.show', $campaign)
                         ->with('success', 'Campaign created!');
    }

    public function show(Campaign $campaign)
    {
        $this->authorize('view', $campaign);
        $encounters = $campaign->encounters()->latest()->get();
        $players    = $campaign->players()->get();
        return view('campaigns.show', compact('campaign', 'encounters', 'players'));
    }

    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        return view('campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'world_name'  => 'nullable|string|max:255',
            'status'      => 'required|in:planning,active,paused,completed',
        ]);

        $campaign->update($validated);

        return redirect()->route('campaigns.show', $campaign)
                         ->with('success', 'Campaign updated!');
    }

    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);
        $campaign->delete();
        return redirect()->route('campaigns.index')
                         ->with('success', 'Campaign deleted.');
    }
}
