@extends('layouts.app')
@section('title', $class['name'])
@section('page-title', $class['name'])
@section('breadcrumb', 'Classes / ' . $class['name'])

@section('content')
<div class="max-w-4xl mx-auto space-y-5">

    {{-- Header --}}
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-cinzel text-3xl font-black text-gold-400">{{ $class['name'] }}</h2>
                <div class="flex items-center gap-4 mt-2 text-sm">
                    <span class="text-stone-400 font-cinzel">
                        Hit Die: <span class="text-crimson-400 font-bold">d{{ $class['hit_die'] ?? '?' }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Proficiencies --}}
    @if(!empty($class['proficiencies']))
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="rune-divider mb-4">✦ PROFICIENCIES ✦</div>
        <div class="flex flex-wrap gap-2">
            @foreach($class['proficiencies'] as $prof)
            <span class="px-3 py-1 bg-stone-800 border border-stone-700 text-stone-300 font-cinzel text-xs rounded-lg">
                {{ $prof['name'] }}
            </span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Saving Throws --}}
    @if(!empty($class['saving_throws']))
    <div class="deco-border bg-stone-900 rounded-xl p-5">
        <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-3">SAVING THROWS</div>
        <div class="flex gap-3">
            @foreach($class['saving_throws'] as $st)
            <span class="px-4 py-2 bg-gold-500/10 border border-gold-500/30 text-gold-400 font-cinzel text-sm font-bold rounded-lg">
                {{ strtoupper($st['name']) }}
            </span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Subclasses --}}
    @if(!empty($class['subclasses']))
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="rune-divider mb-4">✦ SUBCLASSES ✦</div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            @foreach($class['subclasses'] as $sub)
            <div class="bg-stone-800/60 rounded-lg p-3 text-center">
                <div class="font-cinzel text-arcane-400 text-sm font-semibold">{{ $sub['name'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Proficiency Choices --}}
    @if(!empty($class['proficiency_choices']))
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="rune-divider mb-4">✦ PROFICIENCY CHOICES ✦</div>
        @foreach($class['proficiency_choices'] as $choice)
        <div class="mb-4">
            <div class="text-stone-400 text-sm mb-2">
                Choose <span class="text-gold-400 font-cinzel font-bold">{{ $choice['choose'] ?? 1 }}</span> from:
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach($choice['from']['options'] ?? [] as $opt)
                <span class="px-2 py-1 bg-stone-800 text-stone-400 font-cinzel text-xs rounded border border-stone-700">
                    {{ $opt['item']['name'] ?? ($opt['choice']['desc'] ?? '?') }}
                </span>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection
