<?php $__env->startSection('title', 'Edit ' . $character->name); ?>
<?php $__env->startSection('page-title', 'Edit Character'); ?>
<?php $__env->startSection('breadcrumb', 'Characters / ' . $character->name); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto" x-data="{ str: <?php echo e($character->ability_scores['str'] ?? 10); ?>, dex: <?php echo e($character->ability_scores['dex'] ?? 10); ?>, con: <?php echo e($character->ability_scores['con'] ?? 10); ?>, int: <?php echo e($character->ability_scores['int'] ?? 10); ?>, wis: <?php echo e($character->ability_scores['wis'] ?? 10); ?>, cha: <?php echo e($character->ability_scores['cha'] ?? 10); ?> }">

    <div class="deco-border bg-stone-900 rounded-xl p-8">

        <h2 class="font-cinzel text-xl font-bold text-gold-400 mb-8 tracking-widest">✦ EDIT CHARACTER</h2>

        <form method="POST" action="<?php echo e(route('characters.update', $character)); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CHARACTER NAME *</label>
                    <input type="text" name="name" value="<?php echo e(old('name', $character->name)); ?>" required
                           class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                </div>
                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">RACE *</label>
                    <select name="race" class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                        <?php $__currentLoopData = ['Human','Elf','Dwarf','Halfling','Gnome','Half-Elf','Half-Orc','Tiefling','Dragonborn','Aasimar','Tabaxi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $race): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php echo e(old('race',$character->race)===$race?'selected':''); ?>><?php echo e($race); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CLASS *</label>
                    <select name="class" class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                        <?php $__currentLoopData = ['Barbarian','Bard','Cleric','Druid','Fighter','Monk','Paladin','Ranger','Rogue','Sorcerer','Warlock','Wizard']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cls): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php echo e(old('class',$character->class)===$cls?'selected':''); ?>><?php echo e($cls); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">LEVEL</label>
                    <input type="number" name="level" value="<?php echo e(old('level',$character->level)); ?>" min="1" max="20"
                           class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                </div>
                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">BACKGROUND</label>
                    <input type="text" name="background" value="<?php echo e(old('background',$character->background)); ?>"
                           class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                </div>
            </div>

            <div>
                <div class="rune-divider mb-4">✦ COMBAT STATS ✦</div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">MAX HP</label>
                        <input type="number" name="max_hp" value="<?php echo e(old('max_hp',$character->max_hp)); ?>" min="1"
                               class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CURRENT HP</label>
                        <input type="number" name="current_hp" value="<?php echo e(old('current_hp',$character->current_hp)); ?>" min="0"
                               class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">ARMOR CLASS</label>
                        <input type="number" name="armor_class" value="<?php echo e(old('armor_class',$character->armor_class)); ?>" min="1"
                               class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                    </div>
                </div>
            </div>

            <div>
                <div class="rune-divider mb-4">✦ ABILITY SCORES ✦</div>
                <div class="grid grid-cols-6 gap-3">
                    <?php $__currentLoopData = [['key'=>'str','label'=>'STR'],['key'=>'dex','label'=>'DEX'],['key'=>'con','label'=>'CON'],['key'=>'int','label'=>'INT'],['key'=>'wis','label'=>'WIS'],['key'=>'cha','label'=>'CHA']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="text-center">
                        <label class="block text-gold-400 text-xs font-cinzel font-bold mb-2"><?php echo e($a['label']); ?></label>
                        <input type="number" name="<?php echo e($a['key']); ?>" x-model="<?php echo e($a['key']); ?>" min="1" max="30"
                               class="w-full bg-stone-800 border border-stone-700 rounded-lg px-2 py-3 text-stone-100 text-center text-lg font-cinzel font-bold outline-none">
                        <div class="text-stone-500 text-xs mt-1 font-cinzel"
                             x-text="(Math.floor((<?php echo e($a['key']); ?> - 10) / 2) >= 0 ? '+' : '') + Math.floor((<?php echo e($a['key']); ?> - 10) / 2)">
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <?php if($campaigns->count()): ?>
            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CAMPAIGN</label>
                <select name="campaign_id" class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                    <option value="">— None —</option>
                    <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($c->id); ?>" <?php echo e($character->campaign_id==$c->id?'selected':''); ?>><?php echo e($c->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php endif; ?>

            <div>
                <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">NOTES</label>
                <textarea name="notes" rows="3"
                          class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none resize-none font-crimson text-base"><?php echo e(old('notes',$character->notes)); ?></textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all">
                    ✦ SAVE CHANGES
                </button>
                <a href="<?php echo e(route('characters.show', $character)); ?>"
                   class="px-6 py-3 border border-stone-700 text-stone-400 font-cinzel text-sm tracking-widest rounded-lg transition-all hover:border-stone-500">
                    CANCEL
                </a>
            </div>
        </form>

        <div class="mt-8 pt-6 border-t border-stone-800">
            <form method="POST" action="<?php echo e(route('characters.destroy', $character)); ?>"
                  onsubmit="return confirm('Delete <?php echo e($character->name); ?>?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="text-crimson-500 hover:text-crimson-400 text-xs font-cinzel tracking-widest transition-colors">
                    ✕ DELETE CHARACTER
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\easydm\easydm_full\resources\views/characters/edit.blade.php ENDPATH**/ ?>