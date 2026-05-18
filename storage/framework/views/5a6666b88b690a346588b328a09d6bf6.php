<?php $__env->startSection('title', $monster['name']); ?>
<?php $__env->startSection('page-title', $monster['name']); ?>
<?php $__env->startSection('breadcrumb', 'Monsters / ' . $monster['name']); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">

    <div class="grid md:grid-cols-3 gap-6">

        
        <div class="md:col-span-2 space-y-5">

            
            <div class="deco-border bg-stone-900 rounded-xl p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="font-cinzel text-2xl font-bold text-stone-100"><?php echo e($monster['name']); ?></h2>
                        <p class="text-gold-400/70 font-crimson italic text-lg mt-1">
                            <?php echo e($monster['size'] ?? ''); ?> <?php echo e($monster['type'] ?? ''); ?>

                            <?php if(!empty($monster['subtype'])): ?> (<?php echo e($monster['subtype']); ?>) <?php endif; ?>
                            <?php if(!empty($monster['alignment'])): ?> • <?php echo e($monster['alignment']); ?> <?php endif; ?>
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-cinzel font-black text-crimson-400">CR <?php echo e($monster['challenge_rating'] ?? '?'); ?></div>
                        <div class="text-stone-600 text-xs font-cinzel tracking-wider"><?php echo e(number_format($monster['xp'] ?? 0)); ?> XP</div>
                    </div>
                </div>
            </div>

            
            <div class="deco-border bg-stone-900 rounded-xl p-6">
                <div class="grid grid-cols-3 gap-4 mb-5">
                    <?php $__currentLoopData = [
                        ['label' => 'Armor Class', 'value' => collect($monster['armor_class'] ?? [])->pluck('value')->first() ?? '—'],
                        ['label' => 'Hit Points', 'value' => ($monster['hit_points'] ?? '—') . ' (' . ($monster['hit_points_roll'] ?? '—') . ')'],
                        ['label' => 'Speed', 'value' => collect($monster['speed'] ?? [])->map(fn($v,$k) => "$k $v")->implode(', ') ?: '—'],
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-stone-800/60 rounded-lg p-3 text-center">
                        <div class="text-stone-400 text-xs font-cinzel tracking-widest mb-1"><?php echo e(strtoupper($stat['label'])); ?></div>
                        <div class="text-stone-100 font-cinzel font-semibold text-sm"><?php echo e($stat['value']); ?></div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div class="rune-divider mb-4">✦ ABILITIES ✦</div>
                <div class="grid grid-cols-6 gap-2">
                    <?php $__currentLoopData = ['strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ability): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $val = $monster[$ability] ?? 10;
                        $mod = floor(($val - 10) / 2);
                        $modStr = ($mod >= 0 ? '+' : '') . $mod;
                    ?>
                    <div class="bg-stone-800/60 rounded-lg p-3 text-center">
                        <div class="text-gold-400 text-xs font-cinzel tracking-widest"><?php echo e(strtoupper(substr($ability,0,3))); ?></div>
                        <div class="text-stone-100 font-cinzel font-bold text-lg"><?php echo e($val); ?></div>
                        <div class="text-stone-400 text-xs">(<?php echo e($modStr); ?>)</div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <?php if(!empty($monster['special_abilities'])): ?>
            <div class="deco-border bg-stone-900 rounded-xl p-6">
                <div class="rune-divider mb-4">✦ SPECIAL ABILITIES ✦</div>
                <div class="space-y-4">
                    <?php $__currentLoopData = $monster['special_abilities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ability): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <div class="font-cinzel text-gold-400 text-sm font-semibold"><?php echo e($ability['name']); ?></div>
                        <p class="text-stone-400 font-crimson text-base mt-1 leading-relaxed">
                            <?php echo e(collect($ability['desc'] ?? [])->join(' ') ?: ($ability['desc'] ?? '')); ?>

                        </p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if(!empty($monster['actions'])): ?>
            <div class="deco-border bg-stone-900 rounded-xl p-6">
                <div class="rune-divider mb-4">✦ ACTIONS ✦</div>
                <div class="space-y-4">
                    <?php $__currentLoopData = $monster['actions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <div class="font-cinzel text-crimson-400 text-sm font-semibold"><?php echo e($action['name']); ?></div>
                        <p class="text-stone-400 font-crimson text-base mt-1 leading-relaxed"><?php echo e($action['desc'] ?? ''); ?></p>
                        <?php if(!empty($action['attack_bonus'])): ?>
                            <div class="text-xs text-stone-600 mt-1 font-cinzel">Attack Bonus: +<?php echo e($action['attack_bonus']); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if(!empty($monster['legendary_actions'])): ?>
            <div class="deco-border bg-stone-900 rounded-xl p-6 border-arcane-500/20">
                <div class="rune-divider mb-4">✦ LEGENDARY ACTIONS ✦</div>
                <div class="space-y-4">
                    <?php $__currentLoopData = $monster['legendary_actions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <div class="font-cinzel text-arcane-400 text-sm font-semibold"><?php echo e($action['name']); ?></div>
                        <p class="text-stone-400 font-crimson text-base mt-1 leading-relaxed"><?php echo e($action['desc'] ?? ''); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

        </div>

        
        <div class="space-y-4">

            <div class="deco-border bg-stone-900 rounded-xl p-5">
                <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-4">TRAITS</div>
                <div class="space-y-3 text-sm">

                    <?php if(!empty($monster['proficiency_bonus'])): ?>
                    <div class="flex justify-between">
                        <span class="text-stone-500 font-cinzel text-xs">PROFICIENCY</span>
                        <span class="text-gold-400 font-cinzel">+<?php echo e($monster['proficiency_bonus']); ?></span>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($monster['senses'])): ?>
                    <div>
                        <div class="text-stone-500 font-cinzel text-xs mb-1">SENSES</div>
                        <div class="text-stone-300 text-xs">
                            <?php $__currentLoopData = $monster['senses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sense => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div><?php echo e(ucfirst(str_replace('_',' ',$sense))); ?>: <?php echo e($val); ?></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($monster['languages'])): ?>
                    <div>
                        <div class="text-stone-500 font-cinzel text-xs mb-1">LANGUAGES</div>
                        <div class="text-stone-300 text-xs"><?php echo e($monster['languages']); ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($monster['damage_immunities'])): ?>
                    <div>
                        <div class="text-stone-500 font-cinzel text-xs mb-1">IMMUNITIES</div>
                        <div class="flex flex-wrap gap-1">
                            <?php $__currentLoopData = $monster['damage_immunities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dmg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="text-xs px-2 py-0.5 bg-stone-800 text-stone-400 rounded font-cinzel"><?php echo e(is_array($dmg) ? ($dmg['name'] ?? '') : $dmg); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($monster['damage_resistances'])): ?>
                    <div>
                        <div class="text-stone-500 font-cinzel text-xs mb-1">RESISTANCES</div>
                        <div class="flex flex-wrap gap-1">
                            <?php $__currentLoopData = $monster['damage_resistances']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dmg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="text-xs px-2 py-0.5 bg-stone-800 text-stone-400 rounded font-cinzel"><?php echo e(is_array($dmg) ? ($dmg['name'] ?? '') : $dmg); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($monster['condition_immunities'])): ?>
                    <div>
                        <div class="text-stone-500 font-cinzel text-xs mb-1">CONDITION IMMUNITIES</div>
                        <div class="flex flex-wrap gap-1">
                            <?php $__currentLoopData = $monster['condition_immunities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cond): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="text-xs px-2 py-0.5 bg-stone-800 text-stone-400 rounded font-cinzel"><?php echo e(is_array($cond) ? ($cond['name'] ?? '') : $cond); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <a href="<?php echo e(route('encounters.create')); ?>"
               class="block w-full text-center py-3 border border-gold-500/30 hover:border-gold-500/60 text-gold-400 hover:text-gold-300 font-cinzel text-xs tracking-widest rounded-xl transition-all">
                ✦ USE IN ENCOUNTER
            </a>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\easydm\easydm_full\resources\views/monsters/show.blade.php ENDPATH**/ ?>