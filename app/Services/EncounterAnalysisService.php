<?php

namespace App\Services;

class EncounterAnalysisService
{
    // XP thresholds per character level [easy, medium, hard, deadly]
    private array $xpThresholds = [
        1  => [25, 50, 75, 100],
        2  => [50, 100, 150, 200],
        3  => [75, 150, 225, 400],
        4  => [125, 250, 375, 500],
        5  => [250, 500, 750, 1100],
        6  => [300, 600, 900, 1400],
        7  => [350, 750, 1100, 1700],
        8  => [450, 900, 1400, 2100],
        9  => [550, 1100, 1600, 2400],
        10 => [600, 1200, 1900, 2800],
        11 => [800, 1600, 2400, 3600],
        12 => [1000, 2000, 3000, 4500],
        13 => [1100, 2200, 3400, 5100],
        14 => [1250, 2500, 3800, 5700],
        15 => [1400, 2800, 4300, 6400],
        16 => [1600, 3200, 4800, 7200],
        17 => [2000, 3900, 5900, 8800],
        18 => [2100, 4200, 6300, 9500],
        19 => [2400, 4900, 7300, 10900],
        20 => [2800, 5700, 8500, 12700],
    ];

    // CR to XP mapping
    private array $crToXp = [
        '0' => 10, '1/8' => 25, '1/4' => 50, '1/2' => 100,
        1 => 200, 2 => 450, 3 => 700, 4 => 1100, 5 => 1800,
        6 => 2300, 7 => 2900, 8 => 3900, 9 => 5000, 10 => 5900,
        11 => 7200, 12 => 8400, 13 => 10000, 14 => 11500, 15 => 13000,
        16 => 15000, 17 => 18000, 18 => 20000, 19 => 22000, 20 => 25000,
        21 => 33000, 22 => 41000, 23 => 50000, 24 => 62000, 30 => 155000,
    ];

    // Monster count multiplier
    private array $multipliers = [
        1 => 1.0, 2 => 1.5, 3 => 2.0, 7 => 2.5, 11 => 3.0, 15 => 4.0,
    ];

    public function analyze(array $party, array $monsters): array
    {
        $partyXpThresholds = $this->calculatePartyThresholds($party);
        $monsterXp         = $this->calculateMonsterXp($monsters);
        $adjustedXp        = $this->applyMultiplier($monsterXp, array_sum(array_column($monsters, 'quantity')));
        $difficulty        = $this->getDifficulty($adjustedXp, $partyXpThresholds);
        $totalCr           = $this->getTotalCr($monsters);

        return [
            'difficulty'          => $difficulty,
            'adjusted_xp'         => $adjustedXp,
            'raw_monster_xp'      => $monsterXp,
            'total_cr'            => $totalCr,
            'party_thresholds'    => $partyXpThresholds,
            'monster_count'       => array_sum(array_column($monsters, 'quantity')),
            'action_economy'      => $this->assessActionEconomy($party, $monsters),
            'tpk_risk'            => $this->assessTpkRisk($difficulty, $monsters),
        ];
    }

    private function calculatePartyThresholds(array $party): array
    {
        $thresholds = [0, 0, 0, 0];
        foreach ($party as $member) {
            $level = max(1, min(20, (int)($member['level'] ?? 1)));
            foreach ($this->xpThresholds[$level] as $i => $xp) {
                $thresholds[$i] += $xp;
            }
        }
        return [
            'easy'   => $thresholds[0],
            'medium' => $thresholds[1],
            'hard'   => $thresholds[2],
            'deadly' => $thresholds[3],
        ];
    }

    private function calculateMonsterXp(array $monsters): int
    {
        $total = 0;
        foreach ($monsters as $monster) {
            $cr  = $monster['challenge_rating'] ?? 0;
            $qty = (int)($monster['quantity'] ?? 1);
            $xp  = $this->crToXp[(string)$cr] ?? $this->crToXp[$cr] ?? 0;
            $total += $xp * $qty;
        }
        return $total;
    }

    private function applyMultiplier(int $xp, int $count): int
    {
        $multiplier = 1.0;
        foreach ($this->multipliers as $threshold => $mult) {
            if ($count >= $threshold) $multiplier = $mult;
        }
        return (int)($xp * $multiplier);
    }

    private function getDifficulty(int $adjustedXp, array $thresholds): string
    {
        if ($adjustedXp >= $thresholds['deadly']) return 'deadly';
        if ($adjustedXp >= $thresholds['hard'])   return 'hard';
        if ($adjustedXp >= $thresholds['medium'])  return 'medium';
        if ($adjustedXp >= $thresholds['easy'])    return 'easy';
        return 'trivial';
    }

    private function getTotalCr(array $monsters): float
    {
        $total = 0;
        foreach ($monsters as $monster) {
            $cr  = $monster['challenge_rating'] ?? 0;
            $qty = (int)($monster['quantity'] ?? 1);
            $total += (float)$cr * $qty;
        }
        return $total;
    }

    private function assessActionEconomy(array $party, array $monsters): string
    {
        $partySize    = count($party);
        $monsterCount = array_sum(array_column($monsters, 'quantity'));

        if ($monsterCount > $partySize * 2) return 'Monsters have overwhelming action advantage';
        if ($monsterCount > $partySize)     return 'Monsters have slight action advantage';
        if ($monsterCount < $partySize)     return 'Party has action advantage';
        return 'Action economy is balanced';
    }

    private function assessTpkRisk(string $difficulty, array $monsters): string
    {
        return match($difficulty) {
            'deadly' => 'HIGH - Total Party Kill is very possible',
            'hard'   => 'MODERATE - Multiple casualties likely',
            'medium' => 'LOW - Manageable with decent rolls',
            'easy'   => 'MINIMAL - Party should handle this comfortably',
            default  => 'NONE - This is a trivial encounter',
        };
    }
}
