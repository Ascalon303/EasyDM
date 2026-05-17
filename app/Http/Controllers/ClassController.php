<?php

namespace App\Http\Controllers;

use App\Services\DndApiService;

class ClassController extends Controller
{
    public function __construct(private DndApiService $dndApi) {}

    public function index()
    {
        $classes = $this->dndApi->getClasses()['results'] ?? [];
        return view('classes.index', compact('classes'));
    }

    public function show(string $index)
    {
        $class = $this->dndApi->getClass($index);
        if (empty($class)) abort(404);
        return view('classes.show', compact('class'));
    }
}
