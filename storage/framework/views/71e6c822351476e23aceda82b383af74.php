<?php $__env->startSection('title', 'Browse Campaigns'); ?>
<?php $__env->startSection('page-title', 'Browse Campaigns'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto space-y-8">

    
    <?php if(session('success')): ?>
        <div class="bg-green-900/40 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg font-crimson">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="bg-red-900/40 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg font-crimson">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <?php if($joinedCampaigns->count()): ?>
    <div>
        <h2 class="font-cinzel text-gold-400 text-sm tracking-widest mb-4">✦ MY JOINED CAMPAIGNS</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php $__currentLoopData = $joinedCampaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-stone-900 rounded-xl p-5 deco-border">
                <div class="flex items-start justify-between mb-2">
                    <h3 class="font-cinzel text-stone-100 font-semibold"><?php echo e($c->title); ?></h3>
                    <span class="text-xs text-stone-500 font-cinzel"><?php echo e($c->encounters_count); ?> encounters</span>
                </div>
                <p class="text-stone-400 font-crimson text-sm mb-4"><?php echo e(Str::limit($c->description, 80)); ?></p>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-stone-500">DM: <?php echo e($c->user->name); ?></span>
                    <div class="flex items-center gap-2">
                        <a href="<?php echo e(route('campaigns.player-view', $c)); ?>"
                           class="text-xs text-gold-400 hover:text-gold-300 font-cinzel border border-gold-500/30 px-3 py-1 rounded transition-all">
                            VIEW
                        </a>
                        <form method="POST" action="<?php echo e(route('campaigns.leave', $c)); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="text-xs text-crimson-500 hover:text-crimson-400 font-cinzel border border-crimson-500/30 px-3 py-1 rounded transition-all"
                                    onclick="return confirm('Leave this campaign?')">
                                LEAVE
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    
    <div>
        <h2 class="font-cinzel text-gold-400 text-sm tracking-widest mb-4">✦ AVAILABLE CAMPAIGNS</h2>

        <?php if($campaigns->count()): ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-stone-900 rounded-xl p-5 deco-border">
                <div class="flex items-start justify-between mb-2">
                    <h3 class="font-cinzel text-stone-100 font-semibold"><?php echo e($campaign->title); ?></h3>
                    <span class="text-xs px-2 py-0.5 rounded bg-green-900/40 text-green-400 font-cinzel">
                        <?php echo e(strtoupper($campaign->status)); ?>

                    </span>
                </div>
                <?php if($campaign->world_name): ?>
                    <p class="text-gold-500/70 text-xs font-cinzel mb-2">🗺 <?php echo e($campaign->world_name); ?></p>
                <?php endif; ?>
                <p class="text-stone-400 font-crimson text-sm mb-4">
                    <?php echo e($campaign->description ? Str::limit($campaign->description, 100) : 'No description.'); ?>

                </p>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-stone-500">
                        DM: <?php echo e($campaign->user->name); ?> · <?php echo e($campaign->players_count); ?> players
                    </span>
                    <form method="POST" action="<?php echo e(route('campaigns.join', $campaign)); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="text-xs bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold px-3 py-1 rounded transition-all">
                            JOIN
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-6"><?php echo e($campaigns->links()); ?></div>

        <?php else: ?>
        <div class="bg-stone-900 rounded-xl p-12 text-center deco-border">
            <p class="text-stone-500 font-crimson text-lg">No campaigns available to join right now.</p>
        </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\easydm\easydm_full\resources\views/campaigns/browse.blade.php ENDPATH**/ ?>