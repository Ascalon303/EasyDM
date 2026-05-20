
<?php $__env->startSection('title', 'Characters'); ?>
<?php $__env->startSection('page-title', 'Characters'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-cinzel text-2xl font-bold text-stone-100">Your Characters</h2>
            <p class="text-stone-500 font-crimson italic mt-1"><?php echo e($characters->total()); ?> adventurers</p>
        </div>
        <a href="<?php echo e(route('characters.create')); ?>"
           class="px-5 py-2.5 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-sm tracking-widest rounded-lg transition-all hover:shadow-lg hover:shadow-gold-500/20">
            ✦ NEW CHARACTER
        </a>
    </div>

    <?php if($characters->count()): ?>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php $__currentLoopData = $characters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $character): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card-hover bg-stone-900 rounded-xl overflow-hidden">

            
            <div class="p-5 bg-gradient-to-r from-stone-900 to-stone-800 border-b border-stone-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-cinzel text-stone-100 font-bold text-lg"><?php echo e($character->name); ?></h3>
                        <p class="text-gold-400/70 text-sm font-cinzel tracking-wider mt-0.5">
                            Lv.<?php echo e($character->level); ?> <?php echo e($character->race); ?> <?php echo e($character->class); ?>

                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-stone-700 flex items-center justify-center text-2xl">
                        <?php
                        $icons = ['Fighter'=>'⚔️','Wizard'=>'📚','Rogue'=>'🗡️','Cleric'=>'⛪','Paladin'=>'🛡️','Ranger'=>'🏹','Barbarian'=>'🪓','Bard'=>'🎵','Druid'=>'🌿','Monk'=>'🥋','Sorcerer'=>'🔥','Warlock'=>'👁️'];
                        echo $icons[$character->class] ?? '⚡';
                        ?>
                    </div>
                </div>
            </div>

            
            <div class="px-5 pt-4">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-xs font-cinzel text-stone-500 tracking-widest">HIT POINTS</span>
                    <span class="text-xs font-cinzel text-stone-400"><?php echo e($character->current_hp); ?> / <?php echo e($character->max_hp); ?></span>
                </div>
                <div class="w-full bg-stone-800 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all duration-500
                        <?php if($character->hp_percentage > 60): ?> bg-green-500
                        <?php elseif($character->hp_percentage > 30): ?> bg-yellow-500
                        <?php else: ?> bg-red-500 <?php endif; ?>"
                        style="width: <?php echo e($character->hp_percentage); ?>%">
                    </div>
                </div>
            </div>

            
            <div class="px-5 py-4 flex items-center gap-4 text-sm">
                <div class="flex items-center gap-1.5">
                    <span class="text-stone-500 text-xs font-cinzel">AC</span>
                    <span class="text-gold-400 font-cinzel font-bold"><?php echo e($character->armor_class); ?></span>
                </div>
                <?php if($character->background): ?>
                <div class="text-stone-600 text-xs font-cinzel tracking-wider">• <?php echo e($character->background); ?></div>
                <?php endif; ?>
                <?php if($character->campaign): ?>
                <div class="ml-auto text-gold-400/50 text-xs font-cinzel">📜 <?php echo e(Str::limit($character->campaign->title, 15)); ?></div>
                <?php endif; ?>
            </div>

            
            <div class="px-5 pb-5 flex gap-2">
                <a href="<?php echo e(route('characters.show', $character)); ?>"
                   class="flex-1 text-center text-xs py-2 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel tracking-wider rounded-lg transition-all">
                    VIEW
                </a>
                <a href="<?php echo e(route('characters.edit', $character)); ?>"
                   class="flex-1 text-center text-xs py-2 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel tracking-wider rounded-lg transition-all">
                    EDIT
                </a>
            </div>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mt-8"><?php echo e($characters->links()); ?></div>

    <?php else: ?>
    <div class="text-center py-20 deco-border bg-stone-900/40 rounded-xl">
        <div class="text-6xl mb-4 opacity-20">⚔️</div>
        <h3 class="font-cinzel text-xl text-stone-400 mb-2">No characters yet</h3>
        <p class="text-stone-600 font-crimson italic mb-6">Roll your first adventurer and begin the journey.</p>
        <a href="<?php echo e(route('characters.create')); ?>"
           class="inline-block px-6 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all">
            CREATE CHARACTER
        </a>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anodm\EasyDM\resources\views/characters/index.blade.php ENDPATH**/ ?>