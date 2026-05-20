<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Campaign;
use App\Models\Encounter;
use App\Models\Character;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@easydm.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'bio'      => 'System administrator of EasyDM.',
        ]);

        // Demo DM
        $dm = User::create([
            'name'     => 'Gandalf the DM',
            'email'    => 'dm@easydm.com',
            'password' => Hash::make('password'),
            'role'     => 'dm',
            'bio'      => 'Veteran Dungeon Master with 10 years of experience.',
        ]);

        // Demo Player
        $player = User::create([
            'name'     => 'Frodo Baggins',
            'email'    => 'player@easydm.com',
            'password' => Hash::make('password'),
            'role'     => 'player',
        ]);

        // Demo Creator
        $creator = User::create([
            'name'     => 'The Homebrew Wizard',
            'email'    => 'creator@easydm.com',
            'password' => Hash::make('password'),
            'role'     => 'creator',
        ]);

        // Demo Campaign
        $campaign = Campaign::create([
            'user_id'     => $dm->id,
            'title'       => 'The Lost Mine of Phandelver',
            'description' => 'A classic adventure in the Forgotten Realms, perfect for new adventurers.',
            'world_name'  => 'The Forgotten Realms',
            'status'      => 'active',
        ]);

        // Demo Encounter
        Encounter::create([
            'user_id'     => $dm->id,
            'campaign_id' => $campaign->id,
            'name'        => 'Goblin Ambush',
            'difficulty'  => 'medium',
            'party_data'  => [
                ['name' => 'Aria', 'class' => 'Rogue',   'level' => 3],
                ['name' => 'Thor', 'class' => 'Fighter',  'level' => 3],
                ['name' => 'Zara', 'class' => 'Cleric',   'level' => 3],
                ['name' => 'Finn', 'class' => 'Wizard',   'level' => 3],
            ],
            'monster_data' => [
                ['index' => 'goblin', 'name' => 'Goblin', 'challenge_rating' => 0.25, 'quantity' => 4],
                ['index' => 'bugbear', 'name' => 'Bugbear', 'challenge_rating' => 1, 'quantity' => 1],
            ],
            'ai_analysis' => "**Encounter Analysis**\n\nThis encounter is considered Medium difficulty for a party of four Level 3 adventurers.\n\nThe goblins will use their Nimble Escape ability to disengage and hide as bonus actions, making them frustrating targets. The bugbear leads from the back, using Surprise on the first round if possible for an extra 2d6 damage.\n\n**Key Threats:** Bugbear surprise attack is the primary danger. Goblins will focus fire on the squishiest target (likely the Wizard).\n\n**Tactical Advice:** Have the bugbear attempt to separate a party member. Goblins should retreat and snipe from cover.\n\n**Suggested Adjustment:** If the party is underperforming, have 1-2 goblins flee at half HP.",
        ]);

        // Demo Character
        Character::create([
            'user_id'      => $player->id,
            'campaign_id'  => $campaign->id,
            'name'         => 'Aria Swiftblade',
            'race'         => 'Elf',
            'class'        => 'Rogue',
            'level'        => 3,
            'background'   => 'Criminal',
            'max_hp'       => 22,
            'current_hp'   => 18,
            'armor_class'  => 14,
            'ability_scores' => ['str'=>10,'dex'=>17,'con'=>13,'int'=>12,'wis'=>10,'cha'=>8],
            'notes'        => 'Former spy for the Zhentarim. Now trying to go straight.',
        ]);

        // Demo Creator Content
        \App\Models\CreatorContent::create([
            'creator_id'  => $creator->id,
            'title'       => 'The Abyssal Dungeon Pack',
            'description' => 'A 5-level dungeon crawl through the Abyss, complete with custom demons, traps, and a terrifying boss encounter.',
            'type'        => 'campaign_pack',
            'price'       => 4.99,
            'is_premium'  => true,
            'download_count' => 47,

            'content_body' => 'This pack contains 5 dungeon levels, 12 encounters, and 8 NPCs.',
            'file_path' => 'content/abyssal-dungeon-pack.pdf',
            'file_type' => 'pdf',
            'file_size' => 2048000,
        ]);

        $this->command->info('✦ EasyDM seeded successfully!');
        $this->command->table(['Email', 'Password', 'Role'], [
            ['admin@easydm.com',   'password', 'admin'],
            ['dm@easydm.com',      'password', 'dm'],
            ['player@easydm.com',  'password', 'player'],
            ['creator@easydm.com', 'password', 'creator'],
        ]);
    }
}
