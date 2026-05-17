<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiService
{
    public function analyzeEncounter(array $party, array $monsters, array $analysis): string
    {
        $prompt = $this->buildPrompt($party, $monsters, $analysis);

        try {
            $apiKey = env('GEMINI_API_KEY');

            if (!$apiKey) {
                return $this->fallbackAnalysis($analysis);
            }

            $response = Http::post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}",
                [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ],
                    'generationConfig' => [
                        'maxOutputTokens' => 600,
                        'temperature'     => 0.7,
                    ],
                ]
            );

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text')
                    ?? $this->fallbackAnalysis($analysis);
            }

            return $this->fallbackAnalysis($analysis);

        } catch (\Exception $e) {
            return $this->fallbackAnalysis($analysis);
        }
    }

    private function buildPrompt(array $party, array $monsters, array $analysis): string
    {
        $partyStr = collect($party)->map(fn($p) =>
            "- Level {$p['level']} {$p['class']} ({$p['name']})"
        )->implode("\n");

        $monsterStr = collect($monsters)->map(fn($m) =>
            "- {$m['quantity']}x {$m['name']} (CR {$m['challenge_rating']})"
        )->implode("\n");

        $partySize = $analysis['party_size'] ?? count($party);

        return <<<PROMPT
You are an expert D&D 5e Dungeon Master assistant. Analyze this encounter and provide tactical advice.

**PARTY** ({$partySize} members):
{$partyStr}

**MONSTERS**:
{$monsterStr}

**CALCULATED STATS**:
- Difficulty: {$analysis['difficulty']}
- Total CR: {$analysis['total_cr']}
- Adjusted XP: {$analysis['adjusted_xp']}
- Action Economy: {$analysis['action_economy']}
- TPK Risk: {$analysis['tpk_risk']}

Provide a concise analysis covering:
1. Overall difficulty assessment
2. Key threats and party vulnerabilities
3. Tactical recommendations for the DM
4. Suggested adjustments if encounter feels unbalanced
5. How the monsters would behave tactically

Keep response under 400 words. Use D&D terminology correctly.
PROMPT;
    }

    private function fallbackAnalysis(array $analysis): string
    {
        $difficulty = strtoupper($analysis['difficulty'] ?? 'UNKNOWN');
        $tpk        = $analysis['tpk_risk'] ?? 'Unknown';
        $economy    = $analysis['action_economy'] ?? 'Unknown';
        $cr         = $analysis['total_cr'] ?? '?';
        $xp         = number_format($analysis['adjusted_xp'] ?? 0);

        return <<<TEXT
**Encounter Analysis**

**Difficulty Rating:** {$difficulty}

**Total Challenge Rating:** {$cr} | **Adjusted XP:** {$xp}

**TPK Risk:** {$tpk}

**Action Economy:** {$economy}

**General Tactical Notes:**
This encounter has been analyzed using standard D&D 5e XP thresholds. The adjusted XP accounts for the action economy multiplier based on monster count.

Consider the following when running this encounter:
- Monitor player HP closely and have escape routes available if the encounter escalates unexpectedly
- Use monster abilities strategically — stagger them rather than unleashing everything at once
- Legendary actions and lair actions (if applicable) can dramatically shift difficulty mid-fight
- If players are struggling, have weaker monsters flee at half HP to ease pressure

*Note: Configure GEMINI_API_KEY in .env for full AI-powered narrative analysis.*
TEXT;
    }
}