<?php $__env->startSection('title', 'New Encounter'); ?>
<?php $__env->startSection('page-title', 'New Encounter'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto" x-data="encounterBuilder()">

    <div class="deco-border bg-stone-900 rounded-xl p-8">

        <h2 class="font-cinzel text-xl font-bold text-gold-400 mb-8 tracking-widest">✦ BUILD ENCOUNTER</h2>

        <form method="POST" action="<?php echo e(route('encounters.store')); ?>" @submit="prepareSubmit">
            <?php echo csrf_field(); ?>

            <div class="space-y-8">

                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">ENCOUNTER NAME *</label>
                        <input type="text" name="name" required
                               class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none transition-all"
                               placeholder="Goblin Ambush">
                    </div>
                    <div>
                        <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">CAMPAIGN</label>
                        <select name="campaign_id" class="w-full bg-stone-800 border border-stone-700 focus:border-gold-500/50 rounded-lg px-4 py-3 text-stone-100 text-sm outline-none">
                            <option value="">— None —</option>
                            <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($c->id); ?>" <?php echo e($campaignId == $c->id ? 'selected' : ''); ?>><?php echo e($c->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-cinzel text-stone-200 font-semibold tracking-widest">⚔ ADVENTURING PARTY</h3>
                        <button type="button" @click="addPartyMember"
                                class="text-xs px-3 py-1.5 border border-gold-500/40 hover:border-gold-500 text-gold-400 font-cinzel tracking-wider rounded transition-all">
                            + ADD MEMBER
                        </button>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(member, i) in party" :key="i">
                            <div class="grid grid-cols-4 gap-3 items-end bg-stone-800/60 rounded-lg p-3">
                                <div>
                                    <label class="text-stone-500 text-xs font-cinzel tracking-widest block mb-1">NAME</label>
                                    <input type="text" x-model="member.name"
                                           class="w-full bg-stone-800 border border-stone-700 rounded px-3 py-2 text-stone-100 text-sm outline-none focus:border-gold-500/50"
                                           placeholder="Fighter">
                                </div>
                                <div>
                                    <label class="text-stone-500 text-xs font-cinzel tracking-widest block mb-1">CLASS</label>
                                    <select x-model="member.class" class="w-full bg-stone-800 border border-stone-700 rounded px-3 py-2 text-stone-100 text-sm outline-none">
                                        <option>Fighter</option><option>Wizard</option><option>Rogue</option>
                                        <option>Cleric</option><option>Paladin</option><option>Ranger</option>
                                        <option>Barbarian</option><option>Bard</option><option>Druid</option>
                                        <option>Monk</option><option>Sorcerer</option><option>Warlock</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-stone-500 text-xs font-cinzel tracking-widest block mb-1">LEVEL</label>
                                    <input type="number" x-model="member.level" min="1" max="20"
                                           class="w-full bg-stone-800 border border-stone-700 rounded px-3 py-2 text-stone-100 text-sm outline-none focus:border-gold-500/50"
                                           placeholder="5">
                                </div>
                                <div>
                                    <button type="button" @click="removePartyMember(i)"
                                            class="w-full py-2 text-crimson-500 hover:text-crimson-400 text-xs font-cinzel transition-colors border border-crimson-500/20 hover:border-crimson-400/40 rounded">
                                        REMOVE
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <p x-show="party.length === 0" class="text-stone-600 font-crimson italic text-center py-4">
                        Add party members to begin building your encounter.
                    </p>
                </div>

                
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-cinzel text-stone-200 font-semibold tracking-widest">🐉 MONSTERS</h3>
                        <button type="button" @click="addMonster"
                                class="text-xs px-3 py-1.5 border border-crimson-500/40 hover:border-crimson-500 text-crimson-400 font-cinzel tracking-wider rounded transition-all">
                            + ADD MONSTER
                        </button>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(monster, i) in monsters" :key="i">
                            <div class="grid grid-cols-4 gap-3 items-end bg-stone-800/60 rounded-lg p-3">
                                <div class="col-span-2">
                                    <label class="text-stone-500 text-xs font-cinzel tracking-widest block mb-1">MONSTER</label>
                                    <select x-model="monster.index" @change="updateMonsterName(i, $event)"
                                            class="w-full bg-stone-800 border border-stone-700 rounded px-3 py-2 text-stone-100 text-sm outline-none focus:border-gold-500/50">
                                        <option value="">— Select monster —</option>
                                        <?php $__currentLoopData = $monsterList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($m['index']); ?>" data-name="<?php echo e($m['name']); ?>" data-cr="<?php echo e($m['challenge_rating'] ?? 0); ?>"><?php echo e($m['name']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-stone-500 text-xs font-cinzel tracking-widest block mb-1">QUANTITY</label>
                                    <input type="number" x-model="monster.quantity" min="1" max="20"
                                           class="w-full bg-stone-800 border border-stone-700 rounded px-3 py-2 text-stone-100 text-sm outline-none focus:border-gold-500/50">
                                </div>
                                <div>
                                    <button type="button" @click="removeMonster(i)"
                                            class="w-full py-2 text-crimson-500 hover:text-crimson-400 text-xs font-cinzel transition-colors border border-crimson-500/20 hover:border-crimson-400/40 rounded">
                                        REMOVE
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <p x-show="monsters.length === 0" class="text-stone-600 font-crimson italic text-center py-4">
                        Add monsters to your encounter.
                    </p>
                </div>

                
                <input type="hidden" name="party_data" :value="JSON.stringify(party)">
                <input type="hidden" name="monster_data" :value="JSON.stringify(monsters)">

                
                <div class="bg-stone-800/40 rounded-xl p-4 border border-stone-700/50" x-show="party.length > 0 && monsters.length > 0">
                    <div class="text-stone-500 text-xs font-cinzel tracking-widest mb-2">ENCOUNTER SUMMARY</div>
                    <div class="flex gap-6 text-sm">
                        <div>
                            <span class="text-stone-500">Party:</span>
                            <span class="text-gold-400 font-cinzel ml-2" x-text="party.length + ' members'"></span>
                        </div>
                        <div>
                            <span class="text-stone-500">Monsters:</span>
                            <span class="text-crimson-400 font-cinzel ml-2"
                                  x-text="monsters.reduce((a,m) => a + parseInt(m.quantity||0), 0) + ' creatures'"></span>
                        </div>
                    </div>
                </div>

                
                <div class="flex gap-3">
                    <button type="submit"
                            :disabled="party.length === 0 || monsters.length === 0"
                            class="flex-1 py-3 bg-gold-500 hover:bg-gold-400 disabled:opacity-40 disabled:cursor-not-allowed text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all">
                        ✦ CREATE & ANALYZE
                    </button>
                    <a href="<?php echo e(route('encounters.index')); ?>"
                       class="px-6 py-3 border border-stone-700 text-stone-400 font-cinzel text-sm tracking-widest rounded-lg transition-all hover:border-stone-500">
                        CANCEL
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function encounterBuilder() {
    return {
        party: [
            { name: 'Fighter', class: 'Fighter', level: 5 },
            { name: 'Wizard',  class: 'Wizard',  level: 5 },
        ],
        monsters: [],

        addPartyMember() {
            this.party.push({ name: '', class: 'Fighter', level: 1 });
        },
        removePartyMember(i) {
            this.party.splice(i, 1);
        },
        addMonster() {
            this.monsters.push({ index: '', name: '', challenge_rating: 0, quantity: 1 });
        },
        removeMonster(i) {
            this.monsters.splice(i, 1);
        },
        updateMonsterName(i, event) {
        const sel = event.target;
        const opt = sel.options[sel.selectedIndex];
        this.monsters[i].name = opt.dataset.name || '';
        this.monsters[i].index = sel.value;
        this.monsters[i].challenge_rating = parseFloat(opt.dataset.cr) || 0;
        },
        prepareSubmit() {
            // data is bound via x-model, hidden inputs already updated
            return true;
        }
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\easydm\easydm_full\resources\views/encounters/create.blade.php ENDPATH**/ ?>