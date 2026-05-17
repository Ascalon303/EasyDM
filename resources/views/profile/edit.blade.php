@extends('layouts.app')
@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile')

@section('content')
<div class="max-w-2xl mx-auto space-y-5">

    {{-- Profile info --}}
    <div class="deco-border bg-stone-900 rounded-xl p-8">
        <h2 class="font-cinzel text-lg font-bold text-gold-400 mb-6 tracking-widest">✦ PROFILE INFORMATION</h2>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">NAME *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">EMAIL *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">BIO</label>
                <textarea name="bio" rows="3"
                          class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none resize-none font-crimson text-base"
                          placeholder="Tell your story, adventurer...">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <button type="submit"
                    class="w-full py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all">
                ✦ SAVE PROFILE
            </button>
        </form>
    </div>

    {{-- Change password --}}
    <div class="deco-border bg-stone-900 rounded-xl p-8">
        <h2 class="font-cinzel text-lg font-bold text-gold-400 mb-6 tracking-widest">✦ CHANGE PASSWORD</h2>

        <form method="POST" action="{{ route('profile.password') }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CURRENT PASSWORD</label>
                <input type="password" name="current_password" required
                       class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">NEW PASSWORD</label>
                <input type="password" name="password" required minlength="8"
                       class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CONFIRM NEW PASSWORD</label>
                <input type="password" name="password_confirmation" required
                       class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
            </div>

            <button type="submit"
                    class="w-full py-3 border border-stone-600 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel font-bold tracking-widest rounded-lg transition-all">
                UPDATE PASSWORD
            </button>
        </form>
    </div>

</div>
@endsection
