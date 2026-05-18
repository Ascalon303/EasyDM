<?php $__env->startSection('title', $spell['name']); ?>
<?php $__env->startSection('page-title', $spell['name']); ?>
<?php $__env->startSection('breadcrumb', 'Spells / ' . $spell['name']); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto space-y-5">

    
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-cinzel text-2xl font-bold text-stone-100"><?php echo e($spell['name']); ?></h2>
                <p class="text-arcane-400/80 font-crimson italic text-lg mt-1">
                    <?php if(isset($spell['level'])): ?>
                        <?php echo e($spell['level'] == 0 ? 'Cantrip' : 'Level ' . $spell['level'] . ' spell'); ?>

                    <?php endif; ?>
                    <?php if(!empty($spell['school']['name'])): ?> — <?php echo e($spell['school']['name']); ?> <?php endif; ?>
                </p>
            </div>
            <div class="text-4xl">✨</div>
        </div>
    </div>

    
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
            <?php $__currentLoopData = [
                ['label' => 'Casting Time', 'value' => $spell['casting_time'] ?? '—'],
                ['label' => 'Range',        'value' => $spell['range'] ?? '—'],
                ['label' => 'Duration',     'value' => $spell['duration'] ?? '—'],
                ['label' => 'Components',   'value' => implode(', ', $spell['components'] ?? [])],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-stone-800/60 rounded-lg p-3 text-center">
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-1"><?php echo e(strtoupper($item['label'])); ?></div>
                <div class="text-stone-100 text-sm font-cinzel"><?php echo e($item['value'] ?: '—'); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if(!empty($spell['material'])): ?>
        <div class="bg-stone-800/40 rounded-lg p-3 text-sm text-stone-400 font-crimson italic">
            <span class="font-cinzel text-xs text-stone-500 not-italic">MATERIAL: </span><?php echo e($spell['material']); ?>

        </div>
        <?php endif; ?>

        <div class="flex gap-4 mt-4 text-xs font-cinzel">
            <?php if(!empty($spell['ritual'])): ?>
                <span class="px-2 py-1 bg-arcane-500/20 border border-arcane-500/30 text-arcane-400 rounded">RITUAL</span>
            <?php endif; ?>
            <?php if(!empty($spell['concentration'])): ?>
                <span class="px-2 py-1 bg-gold-500/20 border border-gold-500/30 text-gold-400 rounded">CONCENTRATION</span>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="rune-divider mb-4">✦ DESCRIPTION ✦</div>
        <div class="space-y-3">
            <?php $__currentLoopData = $spell['desc'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $para): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p class="text-stone-300 font-crimson text-lg leading-relaxed"><?php echo e($para); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if(!empty($spell['higher_level'])): ?>
        <div class="mt-5 pt-5 border-t border-stone-800">
            <div class="text-gold-400 font-cinzel text-xs tracking-widest mb-2">AT HIGHER LEVELS</div>
            <?php $__currentLoopData = $spell['higher_level']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $para): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p class="text-stone-400 font-crimson text-base leading-relaxed"><?php echo e($para); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>

    
    <?php if(!empty($spell['classes'])): ?>
    <div class="deco-border bg-stone-900 rounded-xl p-5">
        <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-3">AVAILABLE TO</div>
        <div class="flex flex-wrap gap-2">
            <?php $__currentLoopData = $spell['classes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('classes.show', $class['index'])); ?>"
               class="px-3 py-1 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel text-xs rounded transition-all">
                <?php echo e($class['name']); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\easydm\easydm_full\resources\views/spells/show.blade.php ENDPATH**/ ?>