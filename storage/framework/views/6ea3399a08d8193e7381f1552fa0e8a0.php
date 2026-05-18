<?php $__env->startSection('title', 'Profile'); ?>
<?php $__env->startSection('page-title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto space-y-6">

    
    <div class="deco-border bg-stone-900 rounded-xl p-8 flex items-start gap-6">
        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-gold-500 to-crimson-600 flex items-center justify-center font-cinzel font-black text-stone-900 text-3xl shrink-0">
            <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

        </div>
        <div class="flex-1">
            <h2 class="font-cinzel text-2xl font-bold text-stone-100"><?php echo e($user->name); ?></h2>
            <div class="text-gold-400 font-cinzel text-sm tracking-widest mt-1"><?php echo e(strtoupper($user->role)); ?></div>
            <div class="text-stone-500 text-sm mt-1"><?php echo e($user->email); ?></div>
            <?php if($user->bio): ?>
            <p class="text-stone-400 font-crimson text-lg italic mt-3"><?php echo e($user->bio); ?></p>
            <?php endif; ?>
        </div>
        <a href="<?php echo e(route('profile.edit')); ?>"
           class="shrink-0 px-4 py-2 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel text-xs tracking-widest rounded-lg transition-all">
            EDIT
        </a>
    </div>

    
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-stone-900 deco-border rounded-xl p-5 text-center">
            <div class="text-2xl font-cinzel font-bold text-gold-400"><?php echo e($user->campaigns()->count()); ?></div>
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mt-1">CAMPAIGNS</div>
        </div>
        <div class="bg-stone-900 deco-border rounded-xl p-5 text-center">
            <div class="text-2xl font-cinzel font-bold text-arcane-400"><?php echo e($user->encounters()->count()); ?></div>
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mt-1">ENCOUNTERS</div>
        </div>
        <div class="bg-stone-900 deco-border rounded-xl p-5 text-center">
            <div class="text-2xl font-cinzel font-bold text-crimson-400"><?php echo e($user->characters()->count()); ?></div>
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mt-1">CHARACTERS</div>
        </div>
    </div>

    
    <div class="bg-stone-900 deco-border rounded-xl p-5 text-center">
        <div class="text-stone-500 text-xs font-cinzel tracking-widest">ADVENTURER SINCE</div>
        <div class="text-stone-300 font-cinzel mt-1"><?php echo e($user->created_at->format('F j, Y')); ?></div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\easydm\easydm_full\resources\views/profile/show.blade.php ENDPATH**/ ?>