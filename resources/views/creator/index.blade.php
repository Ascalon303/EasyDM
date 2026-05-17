@extends('layouts.app')
@section('title', 'Creator Content')
@section('page-title', 'Creator Marketplace')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Hero banner --}}
    <div class="deco-border bg-gradient-to-r from-stone-900 to-stone-800 rounded-xl p-6 mb-8 flex items-center justify-between">
        <div>
            <h2 class="font-cinzel text-2xl font-bold text-gold-400">Creator Marketplace</h2>
            <p class="text-stone-500 font-crimson italic mt-1">Discover homebrew campaigns, monsters, spells & items</p>
        </div>
        @if(auth()->user()->isCreator() || auth()->user()->isAdmin())
        <a href="{{ route('creator-content.create') }}"
           class="px-5 py-2.5 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-sm tracking-widest rounded-lg transition-all">
            ✦ PUBLISH CONTENT
        </a>
        @endif
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('creator-content.index') }}" class="mb-6 flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               class="flex-1 min-w-48 bg-stone-900 border border-stone-700 focus:border-gold-500/50 rounded-xl px-5 py-3 text-stone-100 text-sm outline-none"
               placeholder="Search content...">

        <select name="type" class="bg-stone-900 border border-stone-700 focus:border-gold-500/50 rounded-xl px-4 py-3 text-stone-100 text-sm outline-none">
            <option value="">All Types</option>
            @foreach(['campaign_pack'=>'Campaign Pack','monster'=>'Monster','spell'=>'Spell','item'=>'Item'] as $val => $label)
            <option value="{{ $val }}" {{ request('type')===$val?'selected':'' }}>{{ $label }}</option>
            @endforeach
        </select>

        <button type="submit" class="px-6 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-sm tracking-widest rounded-xl transition-all">
            FILTER
        </button>
    </form>

    @if($contents->count())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($contents as $content)
        <div class="card-hover bg-stone-900 rounded-xl overflow-hidden flex flex-col">

            {{-- Type badge header --}}
            <div class="px-5 pt-5 pb-3">
                <div class="flex items-start justify-between gap-2 mb-3">
                    <span class="text-xs px-2 py-0.5 rounded font-cinzel border
                        @if($content->type==='campaign_pack') border-gold-500/30 text-gold-400
                        @elseif($content->type==='monster') border-crimson-500/30 text-crimson-400
                        @elseif($content->type==='spell') border-arcane-500/30 text-arcane-400
                        @else border-green-500/30 text-green-400 @endif">
                        {{ strtoupper(str_replace('_',' ',$content->type)) }}
                    </span>
                    @if($content->is_premium)
                    <span class="text-xs px-2 py-0.5 bg-gold-500/20 border border-gold-500/30 text-gold-400 font-cinzel rounded">PREMIUM</span>
                    @endif
                </div>

                <h3 class="font-cinzel text-stone-100 font-bold text-lg leading-tight">{{ $content->title }}</h3>
                <p class="text-stone-500 text-sm font-crimson mt-2 leading-relaxed line-clamp-3">
                    {{ $content->description ?? 'No description provided.' }}
                </p>
            </div>

            <div class="flex-1"></div>

            {{-- Footer --}}
            <div class="px-5 pb-5 pt-3 border-t border-stone-800 flex items-center justify-between">
                <div>
                    <div class="text-gold-400 font-cinzel font-bold text-lg">
                        {{ $content->price > 0 ? '$' . number_format($content->price, 2) : 'FREE' }}
                    </div>
                    <div class="text-stone-600 text-xs font-cinzel">by {{ $content->creator->name }}</div>
                </div>
                <div class="flex items-center gap-2">
                    @if($content->rating > 0)
                    <div class="text-xs text-gold-400 font-cinzel">★ {{ number_format($content->rating, 1) }}</div>
                    @endif
                    <a href="{{ route('creator-content.show', $content) }}"
                       class="text-xs px-3 py-2 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel rounded-lg transition-all">
                        VIEW
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">{{ $contents->links() }}</div>

    @else
    <div class="text-center py-20 deco-border bg-stone-900/40 rounded-xl">
        <div class="text-6xl mb-4 opacity-20">🏪</div>
        <h3 class="font-cinzel text-xl text-stone-400 mb-2">No content yet</h3>
        <p class="text-stone-600 font-crimson italic mb-6">Be the first to publish homebrew content!</p>
        @if(auth()->user()->isCreator() || auth()->user()->isAdmin())
        <a href="{{ route('creator-content.create') }}"
           class="inline-block px-6 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all">
            PUBLISH FIRST CONTENT
        </a>
        @endif
    </div>
    @endif

</div>
@endsection
