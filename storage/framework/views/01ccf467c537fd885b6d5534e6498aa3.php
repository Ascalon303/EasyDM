
<?php $__env->startSection('title', 'Manage Users'); ?>
<?php $__env->startSection('page-title', 'User Management'); ?>
<?php $__env->startSection('breadcrumb', 'Admin / Users'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto">

    
    <form method="GET" action="<?php echo e(route('admin.users')); ?>" class="mb-6 flex gap-3">
        <input type="text" name="search" value="<?php echo e(request('search')); ?>"
               class="flex-1 bg-stone-900 border border-stone-700 focus:border-gold-500/50 rounded-xl px-5 py-3 text-stone-100 text-sm outline-none"
               placeholder="Search by name or email...">
        <select name="role" class="bg-stone-900 border border-stone-700 rounded-xl px-4 py-3 text-stone-100 text-sm outline-none">
            <option value="">All Roles</option>
            <?php $__currentLoopData = ['admin','dm','player','creator']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($r); ?>" <?php echo e(request('role')===$r?'selected':''); ?>><?php echo e(ucfirst($r)); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button type="submit" class="px-6 py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold text-sm tracking-widest rounded-xl transition-all">
            FILTER
        </button>
    </form>

    <div class="deco-border bg-stone-900 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-stone-800 bg-stone-800/40">
                    <th class="text-left px-5 py-4 text-stone-500 font-cinzel text-xs tracking-widest">USER</th>
                    <th class="text-left px-5 py-4 text-stone-500 font-cinzel text-xs tracking-widest">ROLE</th>
                    <th class="text-left px-5 py-4 text-stone-500 font-cinzel text-xs tracking-widest">JOINED</th>
                    <th class="text-right px-5 py-4 text-stone-500 font-cinzel text-xs tracking-widest">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-b border-stone-800/50 hover:bg-stone-800/20 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-gold-500 to-crimson-600 flex items-center justify-center font-cinzel font-bold text-stone-900 text-xs">
                                <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                            </div>
                            <div>
                                <div class="text-stone-200 font-semibold"><?php echo e($user->name); ?></div>
                                <div class="text-stone-500 text-xs"><?php echo e($user->email); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <form method="POST" action="<?php echo e(route('admin.users.role', $user)); ?>" class="flex items-center gap-2">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <select name="role" onchange="this.form.submit()"
                                    class="bg-stone-800 border border-stone-700 rounded px-2 py-1 text-stone-300 text-xs font-cinzel outline-none">
                                <?php $__currentLoopData = ['admin','dm','player','creator']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($r); ?>" <?php echo e($user->role===$r?'selected':''); ?>><?php echo e(strtoupper($r)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </form>
                    </td>
                    <td class="px-5 py-4 text-stone-500 text-xs font-cinzel">
                        <?php echo e($user->created_at->format('M d, Y')); ?>

                    </td>
                    <td class="px-5 py-4 text-right">
                        <?php if($user->id !== auth()->id()): ?>
                        <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>"
                              onsubmit="return confirm('Delete user <?php echo e($user->name); ?>?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                    class="text-xs text-crimson-500 hover:text-crimson-400 font-cinzel tracking-wider transition-colors">
                                DELETE
                            </button>
                        </form>
                        <?php else: ?>
                        <span class="text-xs text-stone-700 font-cinzel">YOU</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6"><?php echo e($users->links()); ?></div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\anodm\EasyDM\resources\views/admin/users.blade.php ENDPATH**/ ?>