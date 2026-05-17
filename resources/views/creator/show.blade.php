@extends('layouts.app')
@section('title', $creatorContent->title)
@section('page-title', $creatorContent->title)
@section('breadcrumb', 'Marketplace / ' . $creatorContent->title)

@section('content')
<div class="max-w-4xl mx-auto space-y-5">

    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs px-2 py-0.5 rounded font-cinzel border
                        @if($creatorContent->type==='campaign_pack') border-gold-500/30 text-gold-400
                        @elseif($creatorContent->type==='monster') border-crimson-500/30 text-crimson-400
                        @elseif($creatorContent->type==='spell') border-arcane-500/30 text-arcane-400
                        @else border-green-500/30 text-green-400 @endif">
                        {{ strtoupper(str_replace('_',' ',$creatorContent->type)) }}
                    </span>
                    @if($creatorContent->is_premium)
                    <span class="text-xs px-2 py-0.5 bg-gold-500/20 border border-gold-500/30 text-gold-400 font-cinzel rounded">PREMIUM</span>
                    @endif
                </div>
                <h2 class="font-cinzel text-2xl font-bold text-stone-100">{{ $creatorContent->title }}</h2>
                <div class="text-stone-500 text-sm mt-1">by <span class="text-gold-400">{{ $creatorContent->creator->name }}</span></div>
            </div>
            <div class="text-right shrink-0">
                <div class="text-3xl font-cinzel font-black text-gold-400">
                    {{ $creatorContent->price > 0 ? '$' . number_format($creatorContent->price, 2) : 'FREE' }}
                </div>
                @if($creatorContent->rating > 0)
                <div class="text-gold-400 text-sm mt-1">★ {{ number_format($creatorContent->rating, 1) }} / 5.0</div>
                @endif
            </div>
        </div>
    </div>

    @if($creatorContent->description)
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="rune-divider mb-4">✦ DESCRIPTION ✦</div>
        <p class="text-stone-300 font-crimson text-lg leading-relaxed">{{ $creatorContent->description }}</p>
    </div>
    @endif

    {{-- Creator actions --}}
    @if(auth()->id() === $creatorContent->creator_id || auth()->user()->isAdmin())
    <div class="flex gap-3">
        <a href="{{ route('creator-content.edit', $creatorContent) }}"
           class="px-5 py-2.5 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel text-sm tracking-widest rounded-lg transition-all">
            EDIT CONTENT
        </a>
        <form method="POST" action="{{ route('creator-content.destroy', $creatorContent) }}"
              onsubmit="return confirm('Delete this content?')">
            @csrf @method('DELETE')
            <button type="submit" class="px-5 py-2.5 border border-crimson-500/30 hover:border-crimson-500/60 text-crimson-500 hover:text-crimson-400 font-cinzel text-sm tracking-widest rounded-lg transition-all">
                DELETE
            </button>
        </form>
    </div>
    @endif

    {{-- Reviews --}}
    @if($creatorContent->reviews->count())
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="rune-divider mb-4">✦ REVIEWS ✦</div>
        <div class="space-y-4">
            @foreach($creatorContent->reviews as $review)
            <div class="bg-stone-800/40 rounded-lg p-4 border border-stone-700/50">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-cinzel text-stone-300 text-sm">{{ $review->user->name }}</span>
                    <span class="text-gold-400 text-sm">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5-$review->rating) }}</span>
                </div>
                @if($review->review)
                <p class="text-stone-500 font-crimson text-base">{{ $review->review }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
