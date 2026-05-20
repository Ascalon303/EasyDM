
<?php $__env->startSection('title', $encounter->name); ?>
<?php $__env->startSection('page-title', $encounter->name); ?>
<?php $__env->startSection('breadcrumb', 'Encounters / ' . $encounter->name); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto space-y-6">

    
    <div class="deco-border bg-stone-900 rounded-xl p-6 flex items-center justify-between">
        <div>
            <h2 class="font-cinzel text-2xl font-bold text-stone-100"><?php echo e($encounter->name); ?></h2>
            <?php if($encounter->campaign): ?>
                <div class="text-gold-400/60 text-sm font-cinzel tracking-widest mt-1">
                    📜 <?php echo e($encounter->campaign->title); ?>

                </div>
            <?php endif; ?>
        </div>
        <div class="flex items-center gap-3">
            <?php if($encounter->difficulty): ?>
                <span class="text-sm font-cinzel px-4 py-1.5 rounded border
                    <?php if($encounter->difficulty === 'easy'): ?>   border-green-500/40 text-green-400 bg-green-900/20
                    <?php elseif($encounter->difficulty === 'medium'): ?> border-yellow-500/40 text-yellow-400 bg-yellow-900/20
                    <?php elseif($encounter->difficulty === 'hard'): ?>   border-orange-500/40 text-orange-400 bg-orange-900/20
                    <?php else: ?> border-red-500/40 text-red-400 bg-red-900/20 <?php endif; ?>">
                    <?php echo e(strtoupper($encounter->difficulty)); ?>

                </span>
            <?php endif; ?>
            <a href="<?php echo e(route('encounters.analyze', $encounter)); ?>"
               class="px-4 py-2 bg-arcane-600 hover:bg-arcane-500 text-stone-100 font-cinzel text-xs font-bold tracking-widest rounded-lg transition-all">
                🤖 RE-ANALYZE
            </a>
            <a href="<?php echo e(route('encounters.edit', $encounter)); ?>"
               class="px-4 py-2 border border-stone-700 hover:border-gold-500/50 text-stone-400 hover:text-gold-400 font-cinzel text-xs tracking-widest rounded-lg transition-all">
                EDIT
            </a>
        </div>
    </div>

    
    <?php if(isset($analysis)): ?>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <?php
        $statCards = [
            ['label' => 'Difficulty',    'value' => strtoupper($analysis['difficulty']),             'color' => match($analysis['difficulty']) { 'easy'=>'text-green-400','medium'=>'text-yellow-400','hard'=>'text-orange-400','deadly'=>'text-red-400',default=>'text-stone-400'}],
            ['label' => 'Adjusted XP',   'value' => number_format($analysis['adjusted_xp']) . ' XP', 'color' => 'text-gold-400'],
            ['label' => 'Total CR',      'value' => $analysis['total_cr'],                           'color' => 'text-arcane-400'],
            ['label' => 'Monster Count', 'value' => $analysis['monster_count'],                      'color' => 'text-crimson-400'],
        ];
        ?>

        <?php $__currentLoopData = $statCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-stone-900 rounded-xl p-5 deco-border text-center">
            <div class="text-2xl font-cinzel font-bold <?php echo e($card['color']); ?>"><?php echo e($card['value']); ?></div>
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mt-1"><?php echo e(strtoupper($card['label'])); ?></div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="bg-stone-900 rounded-xl p-5 deco-border">
        <h3 class="font-cinzel text-stone-400 text-xs tracking-widest mb-4">✦ PARTY XP THRESHOLDS</h3>
        <div class="grid grid-cols-4 gap-3">
            <?php $__currentLoopData = ['easy' => 'text-green-400', 'medium' => 'text-yellow-400', 'hard' => 'text-orange-400', 'deadly' => 'text-red-400']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="text-center">
                <div class="text-lg font-cinzel font-bold <?php echo e($color); ?>">
                    <?php echo e(number_format($analysis['party_thresholds'][$level])); ?>

                </div>
                <div class="text-stone-600 text-xs font-cinzel tracking-widest mt-0.5"><?php echo e(strtoupper($level)); ?></div>
                <?php if($analysis['adjusted_xp'] >= $analysis['party_thresholds'][$level]): ?>
                    <div class="text-xs text-gold-400 mt-0.5">✦</div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="grid md:grid-cols-2 gap-4">
        <div class="bg-stone-900 rounded-xl p-5 deco-border">
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-2">ACTION ECONOMY</div>
            <p class="text-stone-300 font-crimson text-lg"><?php echo e($analysis['action_economy']); ?></p>
        </div>
        <div class="bg-stone-900 rounded-xl p-5 deco-border">
            <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-2">TPK RISK</div>
            <p class="text-crimson-400 font-crimson text-lg"><?php echo e($analysis['tpk_risk']); ?></p>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if($encounter->ai_analysis): ?>
    <div class="bg-stone-900 rounded-xl p-6 deco-border">
        <div class="flex items-center gap-2 mb-4">
            <span class="text-arcane-400 text-lg">🤖</span>
            <h3 class="font-cinzel text-arcane-400 text-sm tracking-widest">AI ENCOUNTER ANALYSIS</h3>
        </div>
        <div class="prose prose-invert prose-sm max-w-none">
            <div class="text-stone-300 font-crimson text-lg leading-relaxed prose prose-invert prose-sm max-w-none">
                <?php echo \Illuminate\Support\Str::markdown($encounter->ai_analysis); ?>

            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="grid md:grid-cols-2 gap-6">

        
        <div class="bg-stone-900 rounded-xl p-5 deco-border">
            <h3 class="font-cinzel text-gold-400 text-xs tracking-widest mb-4">⚔ ADVENTURING PARTY</h3>
            <div class="space-y-2">
                <?php $__currentLoopData = $encounter->party_data ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center justify-between py-2 border-b border-stone-800/50">
                    <span class="text-stone-200 text-sm"><?php echo e($member['name'] ?? 'Adventurer'); ?></span>
                    <div class="text-right">
                        <span class="text-gold-400 font-cinzel text-xs">Lv.<?php echo e($member['level'] ?? 1); ?></span>
                        <span class="text-stone-500 text-xs ml-2"><?php echo e($member['class'] ?? ''); ?></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="bg-stone-900 rounded-xl p-5 deco-border">
            <h3 class="font-cinzel text-crimson-400 text-xs tracking-widest mb-4">🐉 MONSTERS</h3>
            <div class="space-y-2">
                <?php $__currentLoopData = $encounter->monster_data ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monster): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center justify-between py-2 border-b border-stone-800/50">
                    <span class="text-stone-200 text-sm"><?php echo e($monster['name'] ?? $monster['index']); ?></span>
                    <div class="flex items-center gap-3">
                        <span class="text-stone-500 text-xs">CR <?php echo e($monster['challenge_rating'] ?? '?'); ?></span>
                        <span class="text-crimson-400 font-cinzel text-xs">×<?php echo e($monster['quantity'] ?? 1); ?></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anodm\EasyDM\resources\views/encounters/show.blade.php ENDPATH**/ ?>