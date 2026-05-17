<?php

namespace App\Http\Controllers;

use App\Services\DndApiService;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function __construct(private DndApiService $dndApi) {}

    public function index(Request $request)
    {
        $search  = $request->input('search', '');
        $results = $this->dndApi->getEquipment()['results'] ?? [];

        if ($search) {
            $results = array_filter($results, fn($e) =>
                str_contains(strtolower($e['name']), strtolower($search))
            );
        }

        $equipment = array_values($results);
        return view('equipment.index', compact('equipment', 'search'));
    }

    public function show(string $index)
    {
        $item = $this->dndApi->getEquipmentDetail($index);
        if (empty($item)) abort(404);
        return view('equipment.show', compact('item'));
    }
}
