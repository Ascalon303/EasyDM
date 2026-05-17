<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; 

class AiService
{
    public function analyzeEncounter(array $party, array $monsters, array $analysis): string
    {
        $prompt = $this->buildPrompt($party, $monsters, $analysis);

        try {
            $apiKey = env('GEMINI_API_KEY');

            if (!$apiKey) {
                Log::warning('AiService: GEMINI_API_KEY tidak ditemukan, menggunakan fallback.'); // ← TAMBAHKAN
                return $this->fallbackAnalysis($analysis);
            }

            $response = Http::post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}",
                [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ],
                    'generationConfig' => [
                    'maxOutputTokens' => 3000,
                    'temperature'     => 0.7,
                    'thinkingConfig'  => [
                        'thinkingBudget' => 0,  // ← nonaktifkan thinking mode
                    ],
                ],
                ]
            );

            if ($response->successful()) {
                $text = $response->json('candidates.0.content.parts.0.text');

                if (!$text) {
                    Log::warning('AiService: Response Gemini kosong.', [ // ← TAMBAHKAN
                        'response_body' => $response->json()
                    ]);
                }

                return $text ?? $this->fallbackAnalysis($analysis);
            }

            Log::error('AiService: Request Gemini gagal.', [ // ← TAMBAHKAN
                'status'        => $response->status(),
                'response_body' => $response->json()
            ]);

            return $this->fallbackAnalysis($analysis);

        } catch (\Exception $e) {
            Log::error('AiService: Exception saat memanggil Gemini.', [ // ← TAMBAHKAN
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString()
            ]);
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

Keep response under 600 words. Use D&D terminology correctly.
PROMPT;
    }

    private function fallbackAnalysis(array $analysis): string
    {
        $difficulty = strtoupper($analysis['difficulty'] ?? 'UNKNOWN');
        $tpk        = $analysis['tpk_risk'] ?? 'Unknown';
        $economy    = $analysis['action_economy'] ?? 'Unknown';
        $cr         = $analysis['total_cr'] ?? '?';
        $xp         = number_format($analysis['adjusted_xp'] ?? 0);

        $tacticalNotes = match($analysis['difficulty'] ?? '') {
            'deadly' => "This encounter is **extremely dangerous** and likely to result in a Total Party Kill. Consider splitting the monsters into waves, giving the party environmental advantages, or adding an escape route. Make sure players know fleeing is a valid option.",
            'hard'   => "This encounter will push the party to their limits. Resource management is critical — encourage players to use all available abilities. Have a contingency plan if things spiral out of control.",
            'medium' => "A well-balanced encounter. The party should be able to handle this with smart play. Reward good tactics and positioning. A few lucky rolls from the monsters could make things interesting.",
            'easy'   => "The party has a clear advantage here. Consider adding a secondary objective (protect an NPC, retrieve an item) to make the encounter more engaging beyond just combat.",
            default  => "This encounter is below the party's power level. Use it as a resource-free warm-up, or add complications like traps, terrain hazards, or reinforcements to keep it interesting.",
        };

        return <<<TEXT
**Difficulty Rating:** {$difficulty}

**Total Challenge Rating:** {$cr} | **Adjusted XP:** {$xp}

**TPK Risk:** {$tpk}

**Action Economy:** {$economy}

**Tactical Notes:**
{$tacticalNotes}
TEXT;
    }
}