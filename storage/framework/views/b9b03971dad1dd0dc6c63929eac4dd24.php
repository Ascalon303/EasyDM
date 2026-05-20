<aside class="fixed left-0 top-0 h-full w-64 bg-stone-900 border-r border-stone-800 flex flex-col z-40 overflow-y-auto">

    
    <div class="p-6 border-b border-stone-800">
        <a href="<?php echo e(route('dashboard')); ?>" class="block">
            <div class="text-gold-400 font-cinzel font-black text-2xl tracking-widest">ANO<span class="text-crimson-400">DM</span></div>
            <div class="text-stone-500 text-xs tracking-[0.3rem] mt-1 font-cinzel">FORGE YOUR LEGEND</div>
        </a>
    </div>

    
    <div class="p-4 border-b border-stone-800">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gold-500 to-crimson-600 flex items-center justify-center font-cinzel font-bold text-stone-900 text-sm">
                <?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?>

            </div>
            <div class="flex-1 min-w-0">
                <div class="text-stone-200 text-sm font-semibold truncate"><?php echo e(auth()->user()->name); ?></div>
                <div class="text-gold-400 text-xs font-cinzel uppercase tracking-widest"><?php echo e(auth()->user()->role); ?></div>
            </div>
        </div>
    </div>

    
    <nav class="flex-1 p-3 space-y-1">

        
        <div class="text-stone-600 text-xs font-cinzel tracking-widest px-3 py-2">NAVIGATION</div>

        <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-stone-400 hover:text-gold-400 hover:bg-stone-800 transition-all <?php echo e(request()->routeIs('dashboard') ? 'nav-active' : ''); ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
            Dashboard
        </a>

        
        <?php if(auth()->user()->isDM() || auth()->user()->isAdmin()): ?>
        <div class="text-stone-600 text-xs font-cinzel tracking-widest px-3 py-2 mt-4">DUNGEON MASTER</div>

        <a href="<?php echo e(route('campaigns.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-stone-400 hover:text-gold-400 hover:bg-stone-800 transition-all <?php echo e(request()->routeIs('campaigns.*') ? 'nav-active' : ''); ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            Campaigns
        </a>

        <a href="<?php echo e(route('encounters.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-stone-400 hover:text-gold-400 hover:bg-stone-800 transition-all <?php echo e(request()->routeIs('encounters.*') ? 'nav-active' : ''); ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Encounters
        </a>
        <?php endif; ?>

        
        <?php if(auth()->user()->isPlayer() || auth()->user()->isAdmin()): ?>
        <div class="text-stone-600 text-xs font-cinzel tracking-widest px-3 py-2 mt-4">PLAYER</div>

        <a href="<?php echo e(route('characters.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-stone-400 hover:text-gold-400 hover:bg-stone-800 transition-all <?php echo e(request()->routeIs('characters.*') ? 'nav-active' : ''); ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Characters
        </a>

        <a href="<?php echo e(route('campaigns.browse')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-stone-400 hover:text-gold-400 hover:bg-stone-800 transition-all <?php echo e(request()->routeIs('campaigns.browse') ? 'nav-active' : ''); ?>">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
        Browse Campaigns
        </a>
        <?php endif; ?>

        
        <div class="text-stone-600 text-xs font-cinzel tracking-widest px-3 py-2 mt-4">D&D COMPENDIUM</div>

        <a href="<?php echo e(route('monsters.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-stone-400 hover:text-gold-400 hover:bg-stone-800 transition-all <?php echo e(request()->routeIs('monsters.*') ? 'nav-active' : ''); ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            Monsters
        </a>

        <a href="<?php echo e(route('spells.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-stone-400 hover:text-gold-400 hover:bg-stone-800 transition-all <?php echo e(request()->routeIs('spells.*') ? 'nav-active' : ''); ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            Spells
        </a>

        <a href="<?php echo e(route('classes.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-stone-400 hover:text-gold-400 hover:bg-stone-800 transition-all <?php echo e(request()->routeIs('classes.*') ? 'nav-active' : ''); ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            Classes
        </a>

        <a href="<?php echo e(route('equipment.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-stone-400 hover:text-gold-400 hover:bg-stone-800 transition-all <?php echo e(request()->routeIs('equipment.*') ? 'nav-active' : ''); ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            Equipment
        </a>

        
        <div class="text-stone-600 text-xs font-cinzel tracking-widest px-3 py-2 mt-4">MARKETPLACE</div>

        <a href="<?php echo e(route('creator-content.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-stone-400 hover:text-gold-400 hover:bg-stone-800 transition-all <?php echo e(request()->routeIs('creator-content.*') ? 'nav-active' : ''); ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            Creator Content
        </a>

        
        <?php if(auth()->user()->isAdmin()): ?>
        <div class="text-stone-600 text-xs font-cinzel tracking-widest px-3 py-2 mt-4">SYSTEM</div>
        <a href="<?php echo e(route('admin.index')); ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-stone-400 hover:text-gold-400 hover:bg-stone-800 transition-all <?php echo e(request()->routeIs('admin.*') ? 'nav-active' : ''); ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Admin Panel
        </a>
        <?php endif; ?>

    </nav>

    
    <div class="p-4 border-t border-stone-800">
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-stone-500 hover:text-crimson-400 hover:bg-stone-800 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Sign Out
            </button>
        </form>
    </div>

</aside>
<?php /**PATH D:\laragon\www\easydm\easydm_full\resources\views/components/sidebar.blade.php ENDPATH**/ ?>