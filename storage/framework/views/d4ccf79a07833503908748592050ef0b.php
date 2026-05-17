<?php $__env->startSection('title', 'Edit Encounter'); ?>
<?php $__env->startSection('page-title', 'Edit Encounter'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto" x-data="encounterBuilder(<?php echo e(json_encode($encounter->party_data ?? [])); ?>, <?php echo e(json_encode($encounter->monster_data ?? [])); ?>)">

    <div class="deco-border bg-stone-900 rounded-xl p-8">

        <h2 class="font-cinzel text-xl font-bold text-gold-400 mb-8 tracking-widest">✦ EDIT ENCOUNTER</h2>

        <form method="POST" action="<?php echo e(route('encounters.update', $encounter)); ?>" @submit="prepareSubmit">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

            <div class="space-y-8">

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">NAME *</label>
                        <input type="text" name="name" value="<?php echo e(old('name', $encounter->name)); ?>" required
                               class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CAMPAIGN</label>
                        <select name="campaign_id" class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                            <option value="">— None —</option>
                            <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c->id); ?>" <?php echo e($encounter->campaign_id==$c->id?'selected':''); ?>><?php echo e($c->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-cinzel text-stone-200 font-semibold tracking-widest">⚔ PARTY</h3>
                        <button type="button" @click="addPartyMember"
                                class="text-xs px-3 py-1.5 border border-gold-500/40 hover:border-gold-500 text-gold-400 font-cinzel rounded transition-all">
                            + ADD
                        </button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(m, i) in party" :key="i">
                            <div class="grid grid-cols-4 gap-3 items-end bg-stone-800/60 rounded-lg p-3">
                                <div><input type="text" x-model="m.name" placeholder="Name" class="w-full bg-stone-800 border border-stone-700 rounded px-3 py-2 text-stone-100 text-sm outline-none"></div>
                                <div>
                                    <select x-model="m.class" class="w-full bg-stone-800 border border-stone-700 rounded px-3 py-2 text-stone-100 text-sm outline-none">
                                        <option>Fighter</option><option>Wizard</option><option>Rogue</option><option>Cleric</option><option>Paladin</option><option>Ranger</option><option>Barbarian</option><option>Bard</option><option>Druid</option><option>Monk</option><option>Sorcerer</option><option>Warlock</option>
                                    </select>
                                </div>
                                <div><input type="number" x-model="m.level" min="1" max="20" class="w-full bg-stone-800 border border-stone-700 rounded px-3 py-2 text-stone-100 text-sm outline-none"></div>
                                <div><button type="button" @click="removePartyMember(i)" class="w-full py-2 text-crimson-500 font-cinzel text-xs border border-crimson-500/20 rounded">REMOVE</button></div>
                            </div>
                        </template>
                    </div>
                </div>

                
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-cinzel text-stone-200 font-semibold tracking-widest">🐉 MONSTERS</h3>
                        <button type="button" @click="addMonster"
                                class="text-xs px-3 py-1.5 border border-crimson-500/40 hover:border-crimson-500 text-crimson-400 font-cinzel rounded transition-all">
                            + ADD
                        </button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(m, i) in monsters" :key="i">
                            <div class="grid grid-cols-4 gap-3 items-end bg-stone-800/60 rounded-lg p-3">
                                <div class="col-span-2">
                                    <select x-model="m.index" @change="updateMonsterName(i, $event)"
                                            class="w-full bg-stone-800 border border-stone-700 rounded px-3 py-2 text-stone-100 text-sm outline-none">
                                        <option value="">— Select —</option>
                                        <?php $__currentLoopData = $monsterList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($mon['index']); ?>" data-name="<?php echo e($mon['name']); ?>" data-cr="<?php echo e($mon['challenge_rating'] ?? 0); ?>"><?php echo e($mon['name']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div><input type="number" x-model="m.quantity" min="1" class="w-full bg-stone-800 border border-stone-700 rounded px-3 py-2 text-stone-100 text-sm outline-none"></div>
                                <div><button type="button" @click="removeMonster(i)" class="w-full py-2 text-crimson-500 font-cinzel text-xs border border-crimson-500/20 rounded">REMOVE</button></div>
                            </div>
                        </template>
                    </div>
                </div>

                <input type="hidden" name="party_data" :value="JSON.stringify(party)">
                <input type="hidden" name="monster_data" :value="JSON.stringify(monsters)">

                <div class="flex gap-3">
                    <button type="submit"
                            :disabled="party.length === 0 || monsters.length === 0"
                            class="flex-1 py-3 bg-gold-500 hover:bg-gold-400 disabled:opacity-40 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all">
                        ✦ SAVE & RE-ANALYZE
                    </button>
                    <a href="<?php echo e(route('encounters.show', $encounter)); ?>"
                       class="px-6 py-3 border border-stone-700 text-stone-400 font-cinzel text-sm tracking-widest rounded-lg transition-all">
                        CANCEL
                    </a>
                </div>

            </div>
        </form>

        <div class="mt-8 pt-6 border-t border-stone-800">
            <form method="POST" action="<?php echo e(route('encounters.destroy', $encounter)); ?>"
                  onsubmit="return confirm('Delete this encounter?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="text-crimson-500 hover:text-crimson-400 text-xs font-cinzel tracking-widest">
                    ✕ DELETE ENCOUNTER
                </button>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function encounterBuilder(initialParty, initialMonsters) {
    return {
        party: initialParty.length ? initialParty : [{ name: '', class: 'Fighter', level: 5 }],
        monsters: initialMonsters.length ? initialMonsters : [],
        addPartyMember() { this.party.push({ name: '', class: 'Fighter', level: 1 }); },
        removePartyMember(i) { this.party.splice(i, 1); },
        addMonster() { this.monsters.push({ index: '', name: '', challenge_rating: 0, quantity: 1 }); },
        removeMonster(i) { this.monsters.splice(i, 1); },
        updateMonsterName(i, event) {
        const opt = event.target.options[event.target.selectedIndex];
        this.monsters[i].name = opt.dataset.name || '';
        this.monsters[i].challenge_rating = parseFloat(opt.dataset.cr) || 0;
    },
        prepareSubmit() { return true; }
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\easydm\easydm_full\resources\views/encounters/edit.blade.php ENDPATH**/ ?>