<?php $__env->startSection('title', isset($campaign) ? 'Edit Campaign' : 'New Campaign'); ?>
<?php $__env->startSection('page-title', isset($campaign) ? 'Edit Campaign' : 'New Campaign'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">

    <div class="deco-border bg-stone-900 rounded-xl p-8">

        <h2 class="font-cinzel text-xl font-bold text-gold-400 mb-8 tracking-widest">
            <?php echo e(isset($campaign) ? '✦ EDIT CAMPAIGN' : '✦ FORGE NEW CAMPAIGN'); ?>

        </h2>

        <form method="POST" action="<?php echo e(isset($campaign) ? route('campaigns.update', $campaign) : route('campaigns.store')); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php if(isset($campaign)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CAMPAIGN TITLE *</label>
                <input type="text" name="title" value="<?php echo e(old('title', $campaign->title ?? '')); ?>" required
                       class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm transition-all outline-none"
                       placeholder="The Lost Mine of Phandelver">
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">WORLD NAME</label>
                <input type="text" name="world_name" value="<?php echo e(old('world_name', $campaign->world_name ?? '')); ?>"
                       class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm transition-all outline-none"
                       placeholder="The Forgotten Realms">
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">STATUS</label>
                <select name="status" class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm transition-all outline-none">
                    <?php $__currentLoopData = ['planning' => 'Planning', 'active' => 'Active', 'paused' => 'Paused', 'completed' => 'Completed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>" <?php echo e(old('status', $campaign->status ?? 'planning') === $value ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">DESCRIPTION</label>
                <textarea name="description" rows="5"
                          class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm transition-all outline-none resize-none font-crimson text-base"
                          placeholder="Describe your campaign world, lore, and hook..."><?php echo e(old('description', $campaign->description ?? '')); ?></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all hover:shadow-lg hover:shadow-gold-500/20">
                    <?php echo e(isset($campaign) ? '✦ SAVE CHANGES' : '✦ CREATE CAMPAIGN'); ?>

                </button>
                <a href="<?php echo e(isset($campaign) ? route('campaigns.show', $campaign) : route('campaigns.index')); ?>"
                   class="px-6 py-3 border border-stone-700 hover:border-stone-500 text-stone-400 hover:text-stone-200 font-cinzel text-sm tracking-widest rounded-lg transition-all">
                    CANCEL
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\easydm\easydm_full\resources\views/campaigns/create.blade.php ENDPATH**/ ?>