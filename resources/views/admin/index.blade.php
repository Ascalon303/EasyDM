@extends('layouts.app')
@section('title', 'Admin Panel')
@section('page-title', 'Admin Panel')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <h2 class="font-cinzel text-xl font-bold text-gold-400 mb-6 tracking-widest">✦ SYSTEM OVERVIEW</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach([
                ['label' => 'Total Users',     'value' => $stats['total_users'],     'icon' => '👥', 'color' => 'text-gold-400'],
                ['label' => 'Campaigns',       'value' => $stats['total_campaigns'], 'icon' => '📜', 'color' => 'text-arcane-400'],
                ['label' => 'Encounters',      'value' => $stats['total_encounters'],'icon' => '⚔️', 'color' => 'text-crimson-400'],
                ['label' => 'Creator Content', 'value' => $stats['total_contents'],  'icon' => '🏪', 'color' => 'text-green-400'],
            ] as $card)
            <div class="bg-stone-800/60 rounded-xl p-5 text-center">
                <div class="text-3xl mb-2">{{ $card['icon'] }}</div>
                <div class="text-3xl font-cinzel font-bold {{ $card['color'] }}">{{ $card['value'] }}</div>
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mt-1">{{ strtoupper($card['label']) }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="flex gap-4">
        <a href="{{ route('admin.users') }}"
           class="px-5 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-sm tracking-widest rounded-lg transition-all">
            MANAGE USERS
        </a>
    </div>

</div>
@endsection
