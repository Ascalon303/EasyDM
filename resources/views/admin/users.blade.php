@extends('layouts.app')
@section('title', 'Manage Users')
@section('page-title', 'User Management')
@section('breadcrumb', 'Admin / Users')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Search/Filter --}}
    <form method="GET" action="{{ route('admin.users') }}" class="mb-6 flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               class="flex-1 bg-stone-900 border border-stone-700 focus:border-gold-500/50 rounded-xl px-5 py-3 text-stone-100 text-sm outline-none"
               placeholder="Search by name or email...">
        <select name="role" class="bg-stone-900 border border-stone-700 rounded-xl px-4 py-3 text-stone-100 text-sm outline-none">
            <option value="">All Roles</option>
            @foreach(['admin','dm','player','creator'] as $r)
            <option value="{{ $r }}" {{ request('role')===$r?'selected':'' }}>{{ ucfirst($r) }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-6 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-sm tracking-widest rounded-xl transition-all">
            FILTER
        </button>
    </form>

    <div class="deco-border bg-stone-900 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-stone-800 bg-stone-800/40">
                    <th class="text-left px-5 py-4 text-stone-500 font-cinzel text-xs tracking-widest">USER</th>
                    <th class="text-left px-5 py-4 text-stone-500 font-cinzel text-xs tracking-widest">ROLE</th>
                    <th class="text-left px-5 py-4 text-stone-500 font-cinzel text-xs tracking-widest">JOINED</th>
                    <th class="text-right px-5 py-4 text-stone-500 font-cinzel text-xs tracking-widest">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b border-stone-800/50 hover:bg-stone-800/20 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-gold-500 to-crimson-600 flex items-center justify-center font-cinzel font-bold text-stone-900 text-xs">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="text-stone-200 font-semibold">{{ $user->name }}</div>
                                <div class="text-stone-500 text-xs">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <form method="POST" action="{{ route('admin.users.role', $user) }}" class="flex items-center gap-2">
                            @csrf @method('PUT')
                            <select name="role" onchange="this.form.submit()"
                                    class="bg-stone-800 border border-stone-700 rounded px-2 py-1 text-stone-300 text-xs font-cinzel outline-none">
                                @foreach(['admin','dm','player','creator'] as $r)
                                <option value="{{ $r }}" {{ $user->role===$r?'selected':'' }}>{{ strtoupper($r) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td class="px-5 py-4 text-stone-500 text-xs font-cinzel">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-5 py-4 text-right">
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                              onsubmit="return confirm('Delete user {{ $user->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="text-xs text-crimson-500 hover:text-crimson-400 font-cinzel tracking-wider transition-colors">
                                DELETE
                            </button>
                        </form>
                        @else
                        <span class="text-xs text-stone-700 font-cinzel">YOU</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>

</div>
@endsection
