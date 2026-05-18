<?php $__env->startSection('title', $creatorContent->title); ?>
<?php $__env->startSection('page-title', $creatorContent->title); ?>
<?php $__env->startSection('breadcrumb', 'Marketplace / ' . $creatorContent->title); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-5">

    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs px-2 py-0.5 rounded font-cinzel border
                        <?php if($creatorContent->type==='campaign_pack'): ?> border-gold-500/30 text-gold-400
                        <?php elseif($creatorContent->type==='monster'): ?> border-crimson-500/30 text-crimson-400
                        <?php elseif($creatorContent->type==='spell'): ?> border-arcane-500/30 text-arcane-400
                        <?php else: ?> border-green-500/30 text-green-400 <?php endif; ?>">
                        <?php echo e(strtoupper(str_replace('_',' ',$creatorContent->type))); ?>

                    </span>
                    <?php if($creatorContent->is_premium): ?>
                    <span class="text-xs px-2 py-0.5 bg-gold-500/20 border border-gold-500/30 text-gold-400 font-cinzel rounded">PREMIUM</span>
                    <?php endif; ?>
                </div>
                <h2 class="font-cinzel text-2xl font-bold text-stone-100"><?php echo e($creatorContent->title); ?></h2>
                <div class="text-stone-500 text-sm mt-1">by <span class="text-gold-400"><?php echo e($creatorContent->creator->name); ?></span></div>
            </div>
            <div class="text-right shrink-0">
                <div class="text-3xl font-cinzel font-black text-gold-400">
                    <?php echo e($creatorContent->price > 0 ? '$' . number_format($creatorContent->price, 2) : 'FREE'); ?>

                </div>
                <?php if($creatorContent->rating > 0): ?>
                <div class="text-gold-400 text-sm mt-1">★ <?php echo e(number_format($creatorContent->rating, 1)); ?> / 5.0</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if($creatorContent->description): ?>
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="rune-divider mb-4">✦ DESCRIPTION ✦</div>
        <p class="text-stone-300 font-crimson text-lg leading-relaxed"><?php echo e($creatorContent->description); ?></p>
    </div>
    <?php endif; ?>

    <?php if($creatorContent->content_body): ?>
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="rune-divider mb-4">✦ CONTENT ✦</div>
        <div class="text-stone-300 font-crimson text-lg leading-relaxed whitespace-pre-wrap">
            <?php echo e($creatorContent->content_body); ?>

        </div>
    </div>
    <?php endif; ?>

    
    <?php if(auth()->id() === $creatorContent->creator_id || auth()->user()->isAdmin()): ?>
    <div class="flex gap-3">
        <a href="<?php echo e(route('creator-content.edit', $creatorContent)); ?>"
           class="px-5 py-2.5 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel text-sm tracking-widest rounded-lg transition-all">
            EDIT CONTENT
        </a>
        <form method="POST" action="<?php echo e(route('creator-content.destroy', $creatorContent)); ?>"
              onsubmit="return confirm('Delete this content?')">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="submit" class="px-5 py-2.5 border border-crimson-500/30 hover:border-crimson-500/60 text-crimson-500 hover:text-crimson-400 font-cinzel text-sm tracking-widest rounded-lg transition-all">
                DELETE
            </button>
        </form>
    </div>
    <?php endif; ?>

    
    <?php if($creatorContent->reviews->count()): ?>
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="rune-divider mb-4">✦ REVIEWS ✦</div>
        <div class="space-y-4">
            <?php $__currentLoopData = $creatorContent->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-stone-800/40 rounded-lg p-4 border border-stone-700/50">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-cinzel text-stone-300 text-sm"><?php echo e($review->user->name); ?></span>
                    <span class="text-gold-400 text-sm"><?php echo e(str_repeat('★', $review->rating)); ?><?php echo e(str_repeat('☆', 5-$review->rating)); ?></span>
                </div>
                <?php if($review->review): ?>
                <p class="text-stone-500 font-crimson text-base"><?php echo e($review->review); ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\easydm\easydm_full\resources\views/creator/show.blade.php ENDPATH**/ ?>