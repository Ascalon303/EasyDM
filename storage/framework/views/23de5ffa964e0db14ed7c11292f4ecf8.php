
<?php $__env->startSection('title', 'Classes'); ?>
<?php $__env->startSection('page-title', 'Class Compendium'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">

    <div class="mb-6 text-stone-500 text-sm font-cinzel tracking-widest"><?php echo e(count($classes)); ?> CLASSES</div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <?php
        $classIcons = [
            'barbarian'=>'🪓','bard'=>'🎵','cleric'=>'⛪','druid'=>'🌿',
            'fighter'=>'⚔️','monk'=>'🥋','paladin'=>'🛡️','ranger'=>'🏹',
            'rogue'=>'🗡️','sorcerer'=>'🔥','warlock'=>'👁️','wizard'=>'📚',
        ];
        ?>

        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('classes.show', $class['index'])); ?>" class="card-hover bg-stone-900 rounded-xl p-6 text-center">
            <div class="text-4xl mb-3"><?php echo e($classIcons[$class['index']] ?? '⚡'); ?></div>
            <div class="font-cinzel text-stone-100 font-bold text-lg"><?php echo e($class['name']); ?></div>
            <div class="text-stone-600 text-xs font-cinzel tracking-widest mt-1">D&D 5E CLASS</div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anodm\EasyDM\resources\views/classes/index.blade.php ENDPATH**/ ?>