
<?php $__env->startSection('title', 'Admin Panel'); ?>
<?php $__env->startSection('page-title', 'Admin Panel'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto space-y-8">

    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <h2 class="font-cinzel text-xl font-bold text-gold-400 mb-6 tracking-widest">✦ SYSTEM OVERVIEW</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php $__currentLoopData = [
                ['label' => 'Total Users',     'value' => $stats['total_users'],     'icon' => '👥', 'color' => 'text-gold-400'],
                ['label' => 'Campaigns',       'value' => $stats['total_campaigns'], 'icon' => '📜', 'color' => 'text-arcane-400'],
                ['label' => 'Encounters',      'value' => $stats['total_encounters'],'icon' => '⚔️', 'color' => 'text-crimson-400'],
                ['label' => 'Creator Content', 'value' => $stats['total_contents'],  'icon' => '🏪', 'color' => 'text-green-400'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-stone-800/60 rounded-xl p-5 text-center">
                <div class="text-3xl mb-2"><?php echo e($card['icon']); ?></div>
                <div class="text-3xl font-cinzel font-bold <?php echo e($card['color']); ?>"><?php echo e($card['value']); ?></div>
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mt-1"><?php echo e(strtoupper($card['label'])); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="flex gap-4">
        <a href="<?php echo e(route('admin.users')); ?>"
           class="px-5 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-sm tracking-widest rounded-lg transition-all">
            MANAGE USERS
        </a>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anodm\EasyDM\resources\views/admin/index.blade.php ENDPATH**/ ?>