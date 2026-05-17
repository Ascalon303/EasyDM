@extends('layouts.app')
@section('title', 'Publish Content')
@section('page-title', 'Publish Content')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="deco-border bg-stone-900 rounded-xl p-8">

        <h2 class="font-cinzel text-xl font-bold text-gold-400 mb-8 tracking-widest">✦ PUBLISH NEW CONTENT</h2>

        <form method="POST" action="{{ route('creator-content.store') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">TITLE *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none"
                       placeholder="Dungeon of the Forgotten King">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">TYPE *</label>
                    <select name="type" class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                        @foreach(['campaign_pack'=>'Campaign Pack','monster'=>'Monster','spell'=>'Spell','item'=>'Item'] as $val => $label)
                        <option value="{{ $val }}" {{ old('type')===$val?'selected':'' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">PRICE (USD)</label>
                    <input type="number" name="price" value="{{ old('price', 0) }}" min="0" step="0.01"
                           class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none"
                           placeholder="0.00">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_premium" id="is_premium" value="1" class="accent-gold-500 w-4 h-4" {{ old('is_premium') ? 'checked' : '' }}>
                <label for="is_premium" class="text-stone-400 text-sm font-cinzel tracking-wider">MARK AS PREMIUM CONTENT</label>
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">DESCRIPTION</label>
                <textarea name="description" rows="5"
                          class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none resize-none font-crimson text-base"
                          placeholder="Describe your content...">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CONTENT DATA (JSON)</label>
                <textarea name="content_data" rows="6"
                          class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-xs outline-none resize-none font-mono"
                          placeholder='{"description": "A dark dungeon...", "encounters": [], "npcs": []}'>{{ old('content_data') }}</textarea>
                <p class="text-stone-600 text-xs mt-1 font-cinzel">Optional: raw JSON data for your content</p>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all hover:shadow-lg hover:shadow-gold-500/20">
                    ✦ PUBLISH CONTENT
                </button>
                <a href="{{ route('creator-content.index') }}"
                   class="px-6 py-3 border border-stone-700 text-stone-400 font-cinzel text-sm tracking-widest rounded-lg transition-all hover:border-stone-500">
                    CANCEL
                </a>
            </div>
        </form>

    </div>
</div>
@endsection
