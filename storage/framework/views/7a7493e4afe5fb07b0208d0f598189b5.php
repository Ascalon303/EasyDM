<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'AnoDM'); ?> – AnoDM</title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Crimson+Text:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        cinzel:  ['Cinzel', 'serif'],
                        crimson: ['Crimson Text', 'serif'],
                        inter:   ['Inter', 'sans-serif'],
                    },
                    colors: {
                        stone: {
                            950: '#0c0a09',
                            900: '#1c1917',
                            800: '#292524',
                            700: '#44403c',
                            600: '#57534e',
                        },
                        gold: {
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        },
                        crimson: {
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                        },
                        arcane: {
                            400: '#c084fc',
                            500: '#a855f7',
                            600: '#9333ea',
                        },
                    },
                }
            }
        }
    </script>

    <style>
        body { background-color: #0c0a09; color: #e7e5e4; font-family: 'Inter', sans-serif; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #1c1917; }
        ::-webkit-scrollbar-thumb { background: #57534e; border-radius: 3px; }

        /* Decorative border */
        .deco-border {
            border: 1px solid rgba(251,191,36,0.2);
            box-shadow: 0 0 20px rgba(251,191,36,0.05), inset 0 0 20px rgba(0,0,0,0.3);
        }

        /* Gold glow */
        .gold-glow { box-shadow: 0 0 15px rgba(251,191,36,0.3); }

        /* Card hover effect */
        .card-hover {
            transition: all 0.3s ease;
            border: 1px solid rgba(251,191,36,0.1);
        }
        .card-hover:hover {
            border-color: rgba(251,191,36,0.4);
            box-shadow: 0 0 20px rgba(251,191,36,0.1);
            transform: translateY(-2px);
        }

        /* Difficulty badges */
        .diff-easy   { color: #4ade80; border-color: #4ade80; }
        .diff-medium  { color: #facc15; border-color: #facc15; }
        .diff-hard    { color: #fb923c; border-color: #fb923c; }
        .diff-deadly  { color: #f87171; border-color: #f87171; }

        /* Sidebar active */
        .nav-active { background: rgba(251,191,36,0.1); border-left: 3px solid #fbbf24; color: #fbbf24; }

        /* Animate fade in */
        @keyframes fadeInUp {
            from { opacity:0; transform:translateY(16px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .fade-in { animation: fadeInUp 0.4s ease forwards; }

        /* Parchment text style */
        .parchment { font-family: 'Crimson Text', serif; }

        /* Rune divider */
        .rune-divider {
            text-align: center;
            color: rgba(251,191,36,0.4);
            letter-spacing: 0.5rem;
            font-family: 'Cinzel', serif;
            font-size: 0.75rem;
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="min-h-screen flex">

    
    <?php if(auth()->guard()->check()): ?>
        <?php echo $__env->make('components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    
    <div class="flex-1 flex flex-col <?php echo e(auth()->check() ? 'ml-64' : ''); ?>">

        
        <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        
        <?php if(session('success')): ?>
            <div class="mx-6 mt-4 p-4 bg-green-900/30 border border-green-500/30 rounded-lg text-green-400 text-sm fade-in flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="mx-6 mt-4 p-4 bg-red-900/30 border border-red-500/30 rounded-lg text-red-400 text-sm fade-in flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="mx-6 mt-4 p-4 bg-red-900/30 border border-red-500/30 rounded-lg text-red-400 text-sm fade-in">
                <ul class="list-disc list-inside space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        
        <main class="flex-1 p-6 fade-in">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        
        <footer class="text-center py-4 text-stone-600 text-xs font-cinzel tracking-widest border-t border-stone-800">
            ✦ ANODM &copy; <?php echo e(date('Y')); ?> — FORGE YOUR LEGEND ✦
        </footer>
    </div>

    
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\laragon\www\easydm\easydm_full\resources\views/layouts/app.blade.php ENDPATH**/ ?>