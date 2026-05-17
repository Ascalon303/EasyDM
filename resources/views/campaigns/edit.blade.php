@extends('layouts.app')
@section('title', 'Edit Campaign')
@section('page-title', 'Edit Campaign')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="deco-border bg-stone-900 rounded-xl p-8">

        <h2 class="font-cinzel text-xl font-bold text-gold-400 mb-8 tracking-widest">✦ EDIT CAMPAIGN</h2>

        <form method="POST" action="{{ route('campaigns.update', $campaign) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CAMPAIGN TITLE *</label>
                <input type="text" name="title" value="{{ old('title', $campaign->title) }}" required
                       class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm transition-all outline-none">
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">WORLD NAME</label>
                <input type="text" name="world_name" value="{{ old('world_name', $campaign->world_name) }}"
                       class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm transition-all outline-none">
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">STATUS</label>
                <select name="status" class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                    @foreach(['planning' => 'Planning', 'active' => 'Active', 'paused' => 'Paused', 'completed' => 'Completed'] as $value => $label)
                        <option value="{{ $value }}" {{ old('status', $campaign->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">DESCRIPTION</label>
                <textarea name="description" rows="5"
                          class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm transition-all outline-none resize-none font-crimson text-base">{{ old('description', $campaign->description) }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all">
                    ✦ SAVE CHANGES
                </button>
                <a href="{{ route('campaigns.show', $campaign) }}"
                   class="px-6 py-3 border border-stone-700 hover:border-stone-500 text-stone-400 font-cinzel text-sm tracking-widest rounded-lg transition-all">
                    CANCEL
                </a>
            </div>
        </form>

        {{-- Delete --}}
        <div class="mt-8 pt-6 border-t border-stone-800">
            <form method="POST" action="{{ route('campaigns.destroy', $campaign) }}"
                  onsubmit="return confirm('Delete this campaign? This cannot be undone.')">
                @csrf @method('DELETE')
                <button type="submit" class="text-crimson-500 hover:text-crimson-400 text-xs font-cinzel tracking-widest transition-colors">
                    ✕ DELETE CAMPAIGN
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
