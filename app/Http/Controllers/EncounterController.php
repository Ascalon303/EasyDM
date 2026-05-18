<?php

namespace App\Http\Controllers;

use App\Models\Encounter;
use App\Models\Campaign;
use App\Services\DndApiService;
use App\Services\EncounterAnalysisService;
use App\Services\AiService;
use Illuminate\Http\Request;

class EncounterController extends Controller
{
    public function __construct(
        private DndApiService $dndApi,
        private EncounterAnalysisService $analysisService,
        private AiService $aiService,
    ) {}

    public function index()
    {
        $encounters = auth()->user()->encounters()->with('campaign')->latest()->paginate(12);
        return view('encounters.index', compact('encounters'));
    }

    public function create(Request $request)
    {
        $campaigns = auth()->user()->campaigns()->get();
        $campaignId = $request->input('campaign_id');
        $monsterList = $this->dndApi->getMonsters()['results'] ?? [];
        return view('encounters.create', compact('campaigns', 'campaignId', 'monsterList'));
    }

    public function store(Request $request)
    {
        
        $request->merge([
            'party_data'   => json_decode($request->input('party_data'), true) ?? [],
            'monster_data' => json_decode($request->input('monster_data'), true) ?? [],
        ]);

        $request->validate([
            'name'        => 'required|string|max:255',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'party_data'  => 'required|array|min:1',
            'monster_data' => 'required|array|min:1',
        ]);

        $encounter = auth()->user()->encounters()->create([
            'campaign_id'  => $request->campaign_id,
            'name'         => $request->name,
            'party_data'   => $request->party_data,
            'monster_data' => $request->monster_data,
        ]);

        return redirect()->route('encounters.analyze', $encounter)
                         ->with('success', 'Encounter created! Running analysis...');
    }

    public function show(Encounter $encounter)
    {
    $this->authorize('view', $encounter);

    $party    = $encounter->party_data ?? [];
    $monsters = $encounter->monster_data ?? [];

    $analysis = null;
    if (!empty($party) && !empty($monsters)) {
        $analysis = $this->analysisService->analyze($party, $monsters);
        $analysis['party_size'] = count($party);
    }

    return view('encounters.show', compact('encounter', 'analysis'));
}

    public function edit(Encounter $encounter)
    {
        $this->authorize('update', $encounter);
        $campaigns   = auth()->user()->campaigns()->get();
        $monsterList = $this->dndApi->getMonsters()['results'] ?? [];
        return view('encounters.edit', compact('encounter', 'campaigns', 'monsterList'));
    }

    public function update(Request $request, Encounter $encounter)
    {
        $this->authorize('update', $encounter);

        $request->merge([
        'party_data'   => json_decode($request->input('party_data'), true) ?? [],
        'monster_data' => json_decode($request->input('monster_data'), true) ?? [],
        ]);

        $request->validate([
            'name'        => 'required|string|max:255',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'party_data'  => 'required|array|min:1',
            'monster_data' => 'required|array|min:1',
        ]);

        $encounter->update([
            'campaign_id'  => $request->campaign_id,
            'name'         => $request->name,
            'party_data'   => $request->party_data,
            'monster_data' => $request->monster_data,
            'ai_analysis'  => null,
            'difficulty'   => null,
        ]);

        return redirect()->route('encounters.analyze', $encounter);
    }

    public function destroy(Encounter $encounter)
    {
        $this->authorize('delete', $encounter);
        $encounter->delete();
        return redirect()->route('encounters.index')->with('success', 'Encounter deleted.');
    }

    public function analyze(Encounter $encounter)
    {
        $this->authorize('view', $encounter);

        $party    = $encounter->party_data ?? [];
        $monsters = $encounter->monster_data ?? [];

        // Enrich monsters with CR data from API if missing
        foreach ($monsters as &$monster) {
            if ((!isset($monster['challenge_rating']) || $monster['challenge_rating'] == 0) && isset($monster['index']) && $monster['index'] !== '') {
                $detail = $this->dndApi->getMonster($monster['index']);
                $monster['challenge_rating'] = $detail['challenge_rating'] ?? 0;
                $monster['hit_points']       = $detail['hit_points'] ?? 0;
            }
        }

        $analysis = $this->analysisService->analyze($party, $monsters);
        $analysis['party_size'] = count($party);

        $aiText = $this->aiService->analyzeEncounter($party, $monsters, $analysis);

        $encounter->update([
            'difficulty'  => $analysis['difficulty'],
            'ai_analysis' => $aiText,
            'monster_data' => $monsters,
        ]);

        return view('encounters.show', compact('encounter', 'analysis'));
    }
}
