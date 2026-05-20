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
        $user = auth()->user();

        $isOwner  = $campaign->user_id === $user->id;
        $isAdmin  = $user->isAdmin();
        $isPlayer = $campaign->players()->where('user_id', $user->id)->exists();

        if (!$isOwner && !$isAdmin && !$isPlayer) {
            abort(403, 'You are not a member of this campaign.');
        }

        $encounters = $campaign->encounters()->latest()->get();
        $players    = $campaign->players()->get();
        return view('campaigns.show', compact('campaign', 'encounters', 'players'));
    }

    public function edit(Campaign $campaign)
    {
        if ($campaign->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        return view('campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        if ($campaign->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

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
        if ($campaign->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $campaign->delete();
        return redirect()->route('campaigns.index')
                         ->with('success', 'Campaign deleted.');
    }

    // Halaman browse semua campaign yang bisa di-join
    public function browse()
    {
        $userId = auth()->id();

        $campaigns = Campaign::where('status', '!=', 'completed')
            ->whereDoesntHave('players', fn($q) => $q->where('user_id', $userId))
            ->where('user_id', '!=', $userId)
            ->with('user')
            ->withCount('players')
            ->latest()
            ->paginate(12);

        $joinedCampaigns = auth()->user()->joinedCampaigns()->withCount('encounters')->get();

        return view('campaigns.browse', compact('campaigns', 'joinedCampaigns'));
    }

    // Join campaign
    public function join(Campaign $campaign)
    {
        $user = auth()->user();

        if ($campaign->user_id === $user->id) {
            return back()->with('error', 'You cannot join your own campaign.');
        }

        if ($campaign->players()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'You are already in this campaign.');
        }

        $campaign->players()->attach($user->id);

        return back()->with('success', "Joined \"{$campaign->title}\" successfully!");
    }

    // Leave campaign
    public function leave(Campaign $campaign)
    {
        auth()->user()->joinedCampaigns()->detach($campaign->id);

        return back()->with('success', "Left \"{$campaign->title}\".");
    }

    // Kick player dari campaign (hanya DM pemilik)
    public function kick(Campaign $campaign, $userId)
    {
        if ($campaign->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Only the campaign owner can kick players.');
        }

        $campaign->players()->detach($userId);

        return back()->with('success', 'Player has been removed from the campaign.');
    }

    // Player view campaign (read-only)
    public function playerView(Campaign $campaign)
    {
        $isMember = $campaign->players()->where('user_id', auth()->id())->exists();
        if (!$isMember) {
            return redirect()->route('campaigns.browse')->with('error', 'You are not a member of this campaign.');
        }

        $encounters = $campaign->encounters()->latest()->get();
        return view('campaigns.player-view', compact('campaign', 'encounters'));
    }
}