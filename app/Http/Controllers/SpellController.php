<?php

namespace App\Http\Controllers;

use App\Services\DndApiService;
use Illuminate\Http\Request;

class SpellController extends Controller
{
    public function __construct(private DndApiService $dndApi) {}

    public function index(Request $request)
    {
        $search  = $request->input('search', '');
        $results = $this->dndApi->getSpells()['results'] ?? [];

        if ($search) {
            $results = array_filter($results, fn($s) =>
                str_contains(strtolower($s['name']), strtolower($search))
            );
        }

        $spells = array_values($results);
        return view('spells.index', compact('spells', 'search'));
    }

    public function show(string $index)
    {
        $spell = $this->dndApi->getSpell($index);
        if (empty($spell)) abort(404);
        return view('spells.show', compact('spell'));
    }
}
