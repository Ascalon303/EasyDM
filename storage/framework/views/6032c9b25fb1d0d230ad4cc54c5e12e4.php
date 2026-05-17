<header class="sticky top-0 z-30 bg-stone-900/95 backdrop-blur border-b border-stone-800 px-6 py-3 flex items-center justify-between">

    
    <div>
        <h1 class="font-cinzel text-gold-400 font-semibold text-lg tracking-wider"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
        <?php if (! empty(trim($__env->yieldContent('breadcrumb')))): ?>
            <div class="text-stone-500 text-xs mt-0.5"><?php echo $__env->yieldContent('breadcrumb'); ?></div>
        <?php endif; ?>
    </div>

    
    <div class="flex items-center gap-4">

        <?php if(auth()->guard()->check()): ?>
            
            <a href="<?php echo e(route('profile.show')); ?>" class="flex items-center gap-2 text-stone-400 hover:text-gold-400 transition-colors text-sm">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gold-500 to-crimson-600 flex items-center justify-center font-cinzel font-bold text-stone-900 text-xs">
                    <?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?>

                </div>
                <span class="hidden md:block"><?php echo e(auth()->user()->name); ?></span>
            </a>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="text-stone-400 hover:text-gold-400 text-sm transition-colors font-cinzel">Login</a>
            <a href="<?php echo e(route('register')); ?>" class="px-4 py-1.5 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-semibold text-sm rounded transition-colors">Join</a>
        <?php endif; ?>

    </div>
</header>
<?php /**PATH D:\laragon\www\easydm\easydm_full\resources\views/components/navbar.blade.php ENDPATH**/ ?>