<?php

namespace App\Http\Controllers;

use App\Services\DndApiService;
use Illuminate\Http\Request;

class MonsterController extends Controller
{
    public function __construct(private DndApiService $dndApi) {}

    public function index(Request $request)
    {
        $search  = $request->input('search', '');
        $results = $this->dndApi->getMonsters()['results'] ?? [];

        if ($search) {
            $results = array_filter($results, fn($m) =>
                str_contains(strtolower($m['name']), strtolower($search))
            );
        }

        $monsters = array_values($results);
        return view('monsters.index', compact('monsters', 'search'));
    }

    public function show(string $index)
    {
        $monster = $this->dndApi->getMonster($index);
        if (empty($monster)) abort(404);
        return view('monsters.show', compact('monster'));
    }
}
