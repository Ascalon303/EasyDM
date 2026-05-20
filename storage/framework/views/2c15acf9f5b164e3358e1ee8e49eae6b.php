
<?php $__env->startSection('title', $character->name); ?>
<?php $__env->startSection('page-title', $character->name); ?>
<?php $__env->startSection('breadcrumb', 'Characters / ' . $character->name); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-6">

    
    <div class="deco-border bg-stone-900 rounded-xl p-6 flex items-start justify-between gap-4">
        <div>
            <h2 class="font-cinzel text-3xl font-black text-stone-100"><?php echo e($character->name); ?></h2>
            <p class="text-gold-400/80 font-cinzel text-lg mt-1">
                Level <?php echo e($character->level); ?> <?php echo e($character->race); ?> <?php echo e($character->class); ?>

            </p>
            <?php if($character->background): ?>
            <p class="text-stone-500 font-crimson italic mt-1"><?php echo e($character->background); ?></p>
            <?php endif; ?>
        </div>
        <div class="flex gap-2 shrink-0">
            <a href="<?php echo e(route('characters.edit', $character)); ?>"
               class="px-4 py-2 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel text-xs tracking-widest rounded-lg transition-all">
                EDIT
            </a>
        </div>
    </div>

    
    <div class="grid grid-cols-3 gap-4">

        
        <div class="deco-border bg-stone-900 rounded-xl p-5 text-center">
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-3">HIT POINTS</div>
            <div class="text-4xl font-cinzel font-black
                <?php if($character->hp_percentage > 60): ?> text-green-400
                <?php elseif($character->hp_percentage > 30): ?> text-yellow-400
                <?php else: ?> text-red-400 <?php endif; ?>">
                <?php echo e($character->current_hp); ?>

            </div>
            <div class="text-stone-500 text-sm font-cinzel mt-0.5">/ <?php echo e($character->max_hp); ?></div>
            <div class="mt-3 w-full bg-stone-800 rounded-full h-2">
                <div class="h-2 rounded-full
                    <?php if($character->hp_percentage > 60): ?> bg-green-500
                    <?php elseif($character->hp_percentage > 30): ?> bg-yellow-500
                    <?php else: ?> bg-red-500 <?php endif; ?>"
                    style="width:<?php echo e($character->hp_percentage); ?>%">
                </div>
            </div>
        </div>

        
        <div class="deco-border bg-stone-900 rounded-xl p-5 text-center">
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-3">ARMOR CLASS</div>
            <div class="text-4xl font-cinzel font-black text-gold-400"><?php echo e($character->armor_class); ?></div>
            <div class="text-stone-500 text-xs font-cinzel mt-2">AC</div>
        </div>

        
        <div class="deco-border bg-stone-900 rounded-xl p-5 text-center">
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-3">LEVEL</div>
            <div class="text-4xl font-cinzel font-black text-arcane-400"><?php echo e($character->level); ?></div>
            <div class="text-stone-500 text-xs font-cinzel mt-2">
                Prof. Bonus: +<?php echo e(ceil($character->level / 4) + 1); ?>

            </div>
        </div>
    </div>

    
    <?php if(!empty($character->ability_scores)): ?>
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="rune-divider mb-5">✦ ABILITY SCORES ✦</div>
        <div class="grid grid-cols-3 md:grid-cols-6 gap-3">
            <?php $__currentLoopData = ['str'=>'STRENGTH','dex'=>'DEXTERITY','con'=>'CONSTITUTION','int'=>'INTELLIGENCE','wis'=>'WISDOM','cha'=>'CHARISMA']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $val = $character->ability_scores[$key] ?? 10;
                $mod = floor(($val - 10) / 2);
                $modStr = ($mod >= 0 ? '+' : '') . $mod;
            ?>
            <div class="bg-stone-800/60 rounded-xl p-4 text-center border border-stone-700/50">
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-1"><?php echo e(strtoupper(substr($key,0,3))); ?></div>
                <div class="text-gold-400 text-3xl font-cinzel font-black"><?php echo e($val); ?></div>
                <div class="text-stone-300 text-sm font-cinzel mt-1 font-bold"><?php echo e($modStr); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if($character->notes): ?>
    <div class="deco-border bg-stone-900 rounded-xl p-6">
        <div class="rune-divider mb-4">✦ NOTES ✦</div>
        <p class="text-stone-400 font-crimson text-lg leading-relaxed"><?php echo e($character->notes); ?></p>
    </div>
    <?php endif; ?>

    
    <?php if($character->campaign): ?>
    <div class="deco-border bg-stone-900 rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-1">CAMPAIGN</div>
            <div class="font-cinzel text-gold-400 font-semibold"><?php echo e($character->campaign->title); ?></div>
        </div>
        <a href="<?php echo e(route('campaigns.show', $character->campaign)); ?>"
           class="text-xs px-3 py-2 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel rounded-lg transition-all">
            VIEW CAMPAIGN
        </a>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anodm\EasyDM\resources\views/characters/show.blade.php ENDPATH**/ ?>