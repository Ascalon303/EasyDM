<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function index()
    {
        $characters = auth()->user()->characters()->with('campaign')->latest()->paginate(12);
        return view('characters.index', compact('characters'));
    }

    public function create()
    {
        $campaigns = auth()->user()->joinedCampaigns()->get();
        return view('characters.create', compact('campaigns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'race'          => 'required|string|max:100',
            'class'         => 'required|string|max:100',
            'level'         => 'required|integer|min:1|max:20',
            'background'    => 'nullable|string|max:100',
            'max_hp'        => 'required|integer|min:1',
            'current_hp'    => 'required|integer|min:0',
            'armor_class'   => 'required|integer|min:1',
            'campaign_id'   => 'nullable|exists:campaigns,id',
            'notes'         => 'nullable|string',
        ]);

        $validated['ability_scores'] = [
            'str' => $request->input('str', 10),
            'dex' => $request->input('dex', 10),
            'con' => $request->input('con', 10),
            'int' => $request->input('int', 10),
            'wis' => $request->input('wis', 10),
            'cha' => $request->input('cha', 10),
        ];

        $character = auth()->user()->characters()->create($validated);

        return redirect()->route('characters.show', $character)
                         ->with('success', 'Character created!');
    }

    public function show(Character $character)
    {
        $this->authorize('view', $character);
        return view('characters.show', compact('character'));
    }

    public function edit(Character $character)
    {
        $this->authorize('update', $character);
        $campaigns = auth()->user()->joinedCampaigns()->get();
        return view('characters.edit', compact('character', 'campaigns'));
    }

    public function update(Request $request, Character $character)
    {
        $this->authorize('update', $character);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'race'        => 'required|string|max:100',
            'class'       => 'required|string|max:100',
            'level'       => 'required|integer|min:1|max:20',
            'background'  => 'nullable|string|max:100',
            'max_hp'      => 'required|integer|min:1',
            'current_hp'  => 'required|integer|min:0',
            'armor_class' => 'required|integer|min:1',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'notes'       => 'nullable|string',
        ]);

        $validated['ability_scores'] = [
            'str' => $request->input('str', 10),
            'dex' => $request->input('dex', 10),
            'con' => $request->input('con', 10),
            'int' => $request->input('int', 10),
            'wis' => $request->input('wis', 10),
            'cha' => $request->input('cha', 10),
        ];

        $character->update($validated);

        return redirect()->route('characters.show', $character)
                         ->with('success', 'Character updated!');
    }

    public function destroy(Character $character)
    {
        $this->authorize('delete', $character);
        $character->delete();
        return redirect()->route('characters.index')->with('success', 'Character deleted.');
    }
}
