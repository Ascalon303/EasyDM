<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DndApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.dnd_api.base_url', 'https://www.dnd5eapi.co/api');
    }

    private function get(string $endpoint): array
    {
        return Cache::remember("dnd_api_{$endpoint}", 3600, function () use ($endpoint) {
            $response = Http::timeout(10)->get("{$this->baseUrl}/{$endpoint}");
            return $response->successful() ? $response->json() : [];
        });
    }

    // --- MONSTERS ---
    public function getMonsters(): array
    {
        return $this->get('monsters');
    }

    public function getMonster(string $index): array
    {
        return $this->get("monsters/{$index}");
    }

    public function searchMonsters(string $query = '', string $crFilter = ''): array
    {
        $all = $this->getMonsters()['results'] ?? [];

        if ($query) {
            $all = array_filter($all, fn($m) => str_contains(strtolower($m['name']), strtolower($query)));
        }

        return array_values($all);
    }

    // --- SPELLS ---
    public function getSpells(): array
    {
        return $this->get('spells');
    }

    public function getSpell(string $index): array
    {
        return $this->get("spells/{$index}");
    }

    // --- CLASSES ---
    public function getClasses(): array
    {
        return $this->get('classes');
    }

    public function getClass(string $index): array
    {
        return $this->get("classes/{$index}");
    }

    // --- EQUIPMENT ---
    public function getEquipment(): array
    {
        return $this->get('equipment');
    }

    public function getEquipmentDetail(string $index): array
    {
        return $this->get("equipment/{$index}");
    }

    // --- RACES ---
    public function getRaces(): array
    {
        return $this->get('races');
    }
}
