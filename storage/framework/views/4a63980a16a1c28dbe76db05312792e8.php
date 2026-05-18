<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – AnoDM</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&family=Crimson+Text:ital,wght@0,400;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={darkMode:'class',theme:{extend:{fontFamily:{cinzel:['Cinzel','serif'],crimson:['Crimson Text','serif']},colors:{stone:{950:'#0c0a09',900:'#1c1917',800:'#292524',700:'#44403c'},gold:{400:'#fbbf24',500:'#f59e0b'},crimson:{400:'#f87171',500:'#ef4444'}}}}}</script>
    <style>
        body{background:#0c0a09;color:#e7e5e4;font-family:'Inter',sans-serif;}
        .auth-card{border:1px solid rgba(251,191,36,0.15);box-shadow:0 0 40px rgba(0,0,0,0.5),inset 0 0 40px rgba(0,0,0,0.2);}
        input:focus{outline:none;border-color:rgba(251,191,36,0.5)!important;box-shadow:0 0 10px rgba(251,191,36,0.1);}
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4" style="background:radial-gradient(ellipse at 50% 0%,rgba(251,191,36,0.06) 0%,transparent 60%),#0c0a09">

    <div class="w-full max-w-md">

        
        <div class="text-center mb-10">
            <a href="<?php echo e(route('home')); ?>" class="inline-block">
                <div class="font-cinzel font-black text-4xl tracking-widest"><span class="text-gold-400">ANO</span><span class="text-crimson-400">DM</span></div>
            </a>
            <p class="text-stone-500 font-crimson italic mt-2">The Dungeon Master's Companion</p>
        </div>

        <div class="auth-card bg-stone-900 rounded-2xl p-8">

            <h2 class="font-cinzel text-xl font-semibold text-gold-400 text-center mb-8 tracking-widest">ENTER THE REALM</h2>

            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
                <?php echo csrf_field(); ?>

                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">EMAIL</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required
                           class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 text-stone-100 text-sm transition-all"
                           placeholder="your@email.com">
                </div>

                <div>
                    <label class="block text-stone-400 text-xs font-cinzel tracking-widest mb-2">PASSWORD</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                               class="w-full bg-stone-800 border border-stone-700 rounded-lg px-4 py-3 pr-10 text-stone-100 text-sm transition-all"
                               placeholder="••••••••">
                        <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-200 transition-colors" onclick="togglePassword('password', this)" aria-label="Toggle password visibility">
                            <svg xmlns="http://www.w3.org/2000/svg" class="eye-open w-5 h-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="eye-closed w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a20.94 20.94 0 0 1 5.06-6.94"></path>
                                <path d="M1 1l22 22"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="accent-gold-500">
                    <label for="remember" class="text-stone-400 text-sm">Remember me</label>
                </div>

                <button type="submit"
                        class="w-full py-3 bg-gold-500 hover:bg-gold-400 text-stone-900 font-cinzel font-bold tracking-widest rounded-lg transition-all hover:shadow-lg hover:shadow-gold-500/20 mt-2">
                    ✦ ENTER REALM
                </button>
            </form>

            <div class="text-center mt-6 text-stone-500 text-sm">
                No account?
                <a href="<?php echo e(route('register')); ?>" class="text-gold-400 hover:text-gold-300 transition-colors font-cinzel text-xs tracking-wider ml-1">REGISTER</a>
            </div>

        </div>
    </div>

    <script>
        function togglePassword(fieldId, btn) {
            const field = document.getElementById(fieldId);
            const openIcon = btn.querySelector('.eye-open');
            const closedIcon = btn.querySelector('.eye-closed');
            if (field.type === 'password') {
                field.type = 'text';
                if (openIcon) openIcon.classList.remove('hidden');
                if (closedIcon) closedIcon.classList.add('hidden');
            } else {
                field.type = 'password';
                if (openIcon) openIcon.classList.add('hidden');
                if (closedIcon) closedIcon.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\anodm\EasyDM\resources\views/auth/login.blade.php ENDPATH**/ ?>