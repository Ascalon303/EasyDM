@extends('layouts.app')
@section('title', isset($campaign) ? 'Edit Campaign' : 'New Campaign')
@section('page-title', isset($campaign) ? 'Edit Campaign' : 'New Campaign')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="deco-border bg-stone-900 rounded-xl p-8">

        <h2 class="font-cinzel text-xl font-bold text-gold-400 mb-8 tracking-widest">
            {{ isset($campaign) ? '✦ EDIT CAMPAIGN' : '✦ FORGE NEW CAMPAIGN' }}
        </h2>

        <form method="POST" action="{{ isset($campaign) ? route('campaigns.update', $campaign) : route('campaigns.store') }}" class="space-y-6">
            @csrf
            @if(isset($campaign)) @method('PUT') @endif

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CAMPAIGN TITLE *</label>
                <input type="text" name="title" value="{{ old('title', $campaign->title ?? '') }}" required
                       class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm transition-all outline-none"
                       placeholder="The Lost Mine of Phandelver">
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">WORLD NAME</label>
                <input type="text" name="world_name" value="{{ old('world_name', $campaign->world_name ?? '') }}"
                       class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm transition-all outline-none"
                       placeholder="The Forgotten Realms">
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">STATUS</label>
                <select name="status" class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm transition-all outline-none">
                    @foreach(['planning' => 'Planning', 'active' => 'Active', 'paused' => 'Paused', 'completed' => 'Completed'] as $value => $label)
                        <option value="{{ $value }}" {{ old('status', $campaign->status ?? 'planning') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">DESCRIPTION</label>
                <textarea name="description" rows="5"
                          class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm transition-all outline-none resize-none font-crimson text-base"
                          placeholder="Describe your campaign world, lore, and hook...">{{ old('description', $campaign->description ?? '') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all hover:shadow-lg hover:shadow-gold-500/20">
                    {{ isset($campaign) ? '✦ SAVE CHANGES' : '✦ CREATE CAMPAIGN' }}
                </button>
                <a href="{{ isset($campaign) ? route('campaigns.show', $campaign) : route('campaigns.index') }}"
                   class="px-6 py-3 border border-stone-700 hover:border-stone-500 text-stone-400 hover:text-stone-200 font-cinzel text-sm tracking-widest rounded-lg transition-all">
                    CANCEL
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
