
<?php $__env->startSection('title', 'Encounters'); ?>
<?php $__env->startSection('page-title', 'Encounters'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-cinzel text-2xl font-bold text-stone-100">Your Encounters</h2>
            <p class="text-stone-500 font-crimson italic mt-1"><?php echo e($encounters->total()); ?> encounters built</p>
        </div>
        <a href="<?php echo e(route('encounters.create')); ?>"
           class="px-5 py-2.5 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-sm tracking-widest rounded-lg transition-all hover:shadow-lg hover:shadow-gold-500/20">
            ✦ NEW ENCOUNTER
        </a>
    </div>

    <?php if($encounters->count()): ?>
    <div class="space-y-3">
        <?php $__currentLoopData = $encounters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $encounter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card-hover bg-stone-900 rounded-xl p-5 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-stone-800 flex items-center justify-center text-2xl">⚔️</div>
                <div>
                    <h3 class="font-cinzel text-stone-100 font-semibold"><?php echo e($encounter->name); ?></h3>
                    <div class="flex items-center gap-3 mt-1">
                        <?php if($encounter->campaign): ?>
                            <span class="text-gold-400/60 text-xs font-cinzel">📜 <?php echo e($encounter->campaign->title); ?></span>
                        <?php endif; ?>
                        <span class="text-stone-600 text-xs"><?php echo e(count($encounter->monster_data ?? [])); ?> monster types</span>
                        <span class="text-stone-600 text-xs"><?php echo e(count($encounter->party_data ?? [])); ?> members</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <?php if($encounter->difficulty): ?>
                    <span class="text-xs font-cinzel px-2 py-1 rounded border
                        <?php if($encounter->difficulty === 'easy'): ?>   border-green-500/30 text-green-400
                        <?php elseif($encounter->difficulty === 'medium'): ?> border-yellow-500/30 text-yellow-400
                        <?php elseif($encounter->difficulty === 'hard'): ?>   border-orange-500/30 text-orange-400
                        <?php else: ?> border-red-500/30 text-red-400 <?php endif; ?>">
                        <?php echo e(strtoupper($encounter->difficulty)); ?>

                    </span>
                <?php else: ?>
                    <span class="text-xs text-stone-600 font-cinzel">NOT ANALYZED</span>
                <?php endif; ?>

                <a href="<?php echo e(route('encounters.show', $encounter)); ?>"
                   class="text-xs px-3 py-1.5 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel rounded transition-all">
                    VIEW
                </a>
                <?php if(!$encounter->ai_analysis): ?>
                <a href="<?php echo e(route('encounters.analyze', $encounter)); ?>"
                   class="text-xs px-3 py-1.5 bg-arcane-600/20 border border-arcane-500/30 hover:border-arcane-500/60 text-arcane-400 font-cinzel rounded transition-all">
                    ANALYZE
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mt-6"><?php echo e($encounters->links()); ?></div>

    <?php else: ?>
    <div class="text-center py-20 deco-border bg-stone-900/40 rounded-xl">
        <div class="text-6xl mb-4 opacity-20">⚔️</div>
        <h3 class="font-cinzel text-xl text-stone-400 mb-2">No encounters yet</h3>
        <p class="text-stone-600 font-crimson italic mb-6">Build your first encounter and let AI analyze it.</p>
        <a href="<?php echo e(route('encounters.create')); ?>"
           class="inline-block px-6 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all">
            CREATE FIRST ENCOUNTER
        </a>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anodm\EasyDM\resources\views/encounters/index.blade.php ENDPATH**/ ?>