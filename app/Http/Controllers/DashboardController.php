<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = match($user->role) {
            'admin' => $this->adminStats(),
            'dm'    => $this->dmStats($user),
            'player' => $this->playerStats($user),
            'creator' => $this->creatorStats($user),
            default => [],
        };

        return view('dashboard.index', compact('user', 'stats'));
    }

    private function adminStats(): array
    {
        return [
            'total_users'    => \App\Models\User::count(),
            'total_campaigns' => \App\Models\Campaign::count(),
            'total_encounters' => \App\Models\Encounter::count(),
            'total_contents'  => \App\Models\CreatorContent::count(),
            'recent_users'   => \App\Models\User::latest()->take(5)->get(),
        ];
    }

    private function dmStats($user): array
    {
        return [
            'campaigns'      => $user->campaigns()->withCount('encounters')->latest()->take(5)->get(),
            'total_campaigns' => $user->campaigns()->count(),
            'total_encounters' => $user->encounters()->count(),
            'recent_encounters' => $user->encounters()->with('campaign')->latest()->take(5)->get(),
        ];
    }

    private function playerStats($user): array
    {
        return [
            'characters'     => $user->characters()->latest()->take(5)->get(),
            'total_characters' => $user->characters()->count(),
            'joined_campaigns' => $user->joinedCampaigns()->count(),
        ];
    }

    private function creatorStats($user): array
    {
        return [
            'contents'       => $user->creatorContents()->latest()->take(5)->get(),
            'total_contents' => $user->creatorContents()->count(),
            'total_downloads' => $user->creatorContents()->sum('download_count'),
        ];
    }
}
