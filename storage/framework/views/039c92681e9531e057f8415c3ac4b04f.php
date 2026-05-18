<?php $__env->startSection('title', 'Spells'); ?>
<?php $__env->startSection('page-title', 'Spell Compendium'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto">

    
    <form method="GET" action="<?php echo e(route('spells.index')); ?>" class="mb-8 flex gap-3">
        <input type="text" name="search" value="<?php echo e($search); ?>"
               class="flex-1 bg-stone-900 border border-stone-700 focus:border-gold-500/50 rounded-xl px-5 py-3 text-stone-100 text-sm outline-none transition-all"
               placeholder="Search spells...">
        <button type="submit"
                class="px-6 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-sm tracking-widest rounded-xl transition-all">
            SEARCH
        </button>
        <?php if($search): ?>
        <a href="<?php echo e(route('spells.index')); ?>" class="px-4 py-3 border border-stone-700 text-stone-400 hover:text-stone-200 font-cinzel text-sm rounded-xl transition-all">CLEAR</a>
        <?php endif; ?>
    </form>

    <div class="mb-4 text-stone-500 text-sm font-cinzel tracking-widest"><?php echo e(count($spells)); ?> SPELLS FOUND</div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
        <?php $__currentLoopData = $spells; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spell): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('spells.show', $spell['index'])); ?>" class="card-hover bg-stone-900 rounded-xl p-4">
            <div class="text-2xl mb-2">✨</div>
            <div class="font-cinzel text-stone-200 text-sm font-semibold leading-tight"><?php echo e($spell['name']); ?></div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if(empty($spells)): ?>
    <div class="text-center py-20">
        <div class="text-4xl mb-3 opacity-30">✨</div>
        <p class="text-stone-500 font-crimson italic">No spells found.</p>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\easydm\easydm_full\resources\views/spells/index.blade.php ENDPATH**/ ?>