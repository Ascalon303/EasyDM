<?php $__env->startSection('title', 'Publish Content'); ?>
<?php $__env->startSection('page-title', 'Publish Content'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">

    <div class="deco-border bg-stone-900 rounded-xl p-8">

        <h2 class="font-cinzel text-xl font-bold text-gold-400 mb-8 tracking-widest">✦ PUBLISH NEW CONTENT</h2>

        <form method="POST" action="<?php echo e(route('creator-content.store')); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">TITLE *</label>
                <input type="text" name="title" value="<?php echo e(old('title')); ?>" required
                       class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none"
                       placeholder="Dungeon of the Forgotten King">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">TYPE *</label>
                    <select name="type" class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                        <?php $__currentLoopData = ['campaign_pack'=>'Campaign Pack','monster'=>'Monster','spell'=>'Spell','item'=>'Item']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val); ?>" <?php echo e(old('type')===$val?'selected':''); ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">PRICE (USD)</label>
                    <input type="number" name="price" value="<?php echo e(old('price', 0)); ?>" min="0" step="0.01"
                           class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none"
                           placeholder="0.00">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_premium" id="is_premium" value="1" class="accent-gold-500 w-4 h-4" <?php echo e(old('is_premium') ? 'checked' : ''); ?>>
                <label for="is_premium" class="text-stone-400 text-sm font-cinzel tracking-wider">MARK AS PREMIUM CONTENT</label>
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">DESCRIPTION</label>
                <textarea name="description" rows="5"
                          class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none resize-none font-crimson text-base"
                          placeholder="Describe your content..."><?php echo e(old('description')); ?></textarea>
            </div>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CONTENT</label>
                <textarea name="content_body" id="content_body" rows="12"
                        class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none resize-none font-crimson"
                        placeholder="Write your full content here — story, lore, stat blocks, encounters..."><?php echo e(old('content_body')); ?></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all hover:shadow-lg hover:shadow-gold-500/20">
                    ✦ PUBLISH CONTENT
                </button>
                <a href="<?php echo e(route('creator-content.index')); ?>"
                   class="px-6 py-3 border border-stone-700 text-stone-400 font-cinzel text-sm tracking-widest rounded-lg transition-all hover:border-stone-500">
                    CANCEL
                </a>
            </div>
        </form>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\easydm\easydm_full\resources\views/creator/create.blade.php ENDPATH**/ ?>