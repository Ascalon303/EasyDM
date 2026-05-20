
<?php $__env->startSection('title', $campaign->title); ?>
<?php $__env->startSection('page-title', $campaign->title); ?>
<?php $__env->startSection('breadcrumb', 'Browse Campaigns / ' . $campaign->title); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-6">

    
    <?php if(session('success')): ?>
        <div class="bg-green-900/40 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg font-crimson">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <div class="deco-border bg-stone-900 rounded-xl p-6 flex items-start justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h2 class="font-cinzel text-2xl font-bold text-stone-100"><?php echo e($campaign->title); ?></h2>
                <span class="text-xs px-2 py-0.5 rounded font-cinzel
                    <?php if($campaign->status === 'active'): ?> bg-green-900/40 text-green-400 border border-green-500/20
                    <?php elseif($campaign->status === 'planning'): ?> bg-yellow-900/40 text-yellow-400 border border-yellow-500/20
                    <?php else: ?> bg-stone-800 text-stone-400 border border-stone-700 <?php endif; ?>">
                    <?php echo e(strtoupper($campaign->status)); ?>

                </span>
            </div>
            <?php if($campaign->world_name): ?>
                <div class="text-gold-400/60 text-sm font-cinzel tracking-widest">🌍 <?php echo e($campaign->world_name); ?></div>
            <?php endif; ?>
            <?php if($campaign->description): ?>
                <p class="text-stone-400 font-crimson text-lg italic mt-3"><?php echo e($campaign->description); ?></p>
            <?php endif; ?>
            <div class="text-stone-500 text-xs font-cinzel mt-3">DM: <?php echo e($campaign->user->name); ?></div>
        </div>

        
        <form method="POST" action="<?php echo e(route('campaigns.leave', $campaign)); ?>" class="shrink-0">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="submit"
                    onclick="return confirm('Are you sure you want to leave this campaign?')"
                    class="px-4 py-2 border border-crimson-500/40 hover:border-crimson-400 text-crimson-500 hover:text-crimson-400 font-cinzel text-xs tracking-widest rounded-lg transition-all">
                LEAVE CAMPAIGN
            </button>
        </form>
    </div>

    
    <div>
        <h3 class="font-cinzel text-gold-400 text-sm tracking-widest mb-4">✦ ENCOUNTERS (<?php echo e($encounters->count()); ?>)</h3>

        <?php if($encounters->count()): ?>
        <div class="space-y-3">
            <?php $__currentLoopData = $encounters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $encounter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-stone-900 rounded-xl p-4 flex items-center justify-between deco-border">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-stone-800 flex items-center justify-center text-xl">⚔️</div>
                    <div>
                        <div class="font-cinzel text-stone-100 font-semibold"><?php echo e($encounter->name); ?></div>
                        <div class="text-stone-500 text-xs font-cinzel tracking-wider mt-0.5">
                            <?php echo e(count($encounter->monster_data ?? [])); ?> monster types ·
                            <?php echo e(count($encounter->party_data ?? [])); ?> party members
                        </div>
                    </div>
                </div>
                <?php if($encounter->difficulty): ?>
                    <span class="text-xs font-cinzel px-2 py-1 rounded border
                        <?php if($encounter->difficulty === 'easy'): ?>   border-green-500/30 text-green-400
                        <?php elseif($encounter->difficulty === 'medium'): ?> border-yellow-500/30 text-yellow-400
                        <?php elseif($encounter->difficulty === 'hard'): ?>   border-orange-500/30 text-orange-400
                        <?php else: ?> border-red-500/30 text-red-400 <?php endif; ?>">
                        <?php echo e(strtoupper($encounter->difficulty)); ?>

                    </span>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <div class="text-center py-12 deco-border bg-stone-900/40 rounded-xl">
            <div class="text-4xl mb-3 opacity-20">⚔️</div>
            <p class="text-stone-500 font-crimson italic">No encounters added yet.</p>
        </div>
        <?php endif; ?>
    </div>

    
    <div>
        <a href="<?php echo e(route('campaigns.browse')); ?>"
           class="text-stone-500 hover:text-gold-400 font-cinzel text-xs tracking-widest transition-all">
            ← BACK TO BROWSE
        </a>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anodm\EasyDM\resources\views/campaigns/player-view.blade.php ENDPATH**/ ?>