<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Portal Masuk - SIM Kurikulum YPI Alfa Ali Masykur</title>

    <!-- Favicon Logo Yayasan -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-yayasan.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-yayasan.png') }}">

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        },
                    },
                    boxShadow: {
                        'card': '0 1px 3px 0 rgba(15, 23, 42, 0.06), 0 1px 2px -1px rgba(15, 23, 42, 0.06)',
                        'floating': '0 12px 30px -10px rgba(15, 23, 42, 0.08), 0 4px 6px -2px rgba(15, 23, 42, 0.03)',
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-[#f4f6fa] text-slate-800 font-sans min-h-screen flex flex-col justify-between p-4 sm:p-6 selection:bg-brand-100 selection:text-brand-900 antialiased">

    <!-- TOP MINIMALIST NAV -->
    <div class="max-w-md w-full mx-auto flex items-center justify-between text-xs py-2">
        <a href="{{ url('/') }}" class="flex items-center gap-2 text-slate-600 hover:text-slate-900 font-semibold transition-colors">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            <span>Halaman Utama</span>
        </a>
        <a href="{{ route('guide.index') }}" class="text-slate-500 hover:text-slate-800 transition-colors">
            Panduan &amp; Bantuan
        </a>
    </div>

    <!-- MAIN LOGIN CARD -->
    <div class="max-w-md w-full mx-auto my-auto py-6">
        
        <!-- Header Branding -->
        <div class="text-center mb-6 space-y-2">
            <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 p-1.5 shadow-card mx-auto flex items-center justify-center">
                <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo Yayasan YPI Alfa Ali Masykur" class="w-full h-full object-contain">
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight text-slate-900">SIM Kurikulum Terpadu</h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">YPI Alfa Ali Masykur Wonosobo</p>
            </div>
        </div>

        <!-- Login Form Surface -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-8 space-y-5">
            
            <!-- Error Alerts -->
            @if(isset($errors) && $errors->any())
                <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">error</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-slate-800 text-xs flex items-center gap-2">
                    <span class="material-symbols-outlined text-base text-brand-700">info</span>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            <!-- Authentication Form -->
            <form method="POST" action="{{ route('login.submit') }}" class="space-y-4 text-xs">
                @csrf

                <!-- NIP / Email Input -->
                <div class="space-y-1.5">
                    <label class="font-semibold text-slate-700 block" for="identity-input">
                        Email Resmi / NIP / Username
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base">person</span>
                        <input id="identity-input" name="identity" type="text" required
                               value="{{ old('identity') }}"
                               placeholder="Masukkan Email, NIP, atau Username" 
                               class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-200/90 rounded-2xl text-slate-800 text-xs placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all shadow-subtle">
                    </div>
                </div>

                <!-- Password Input with Toggle -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="font-semibold text-slate-700" for="password-input">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base">lock</span>
                        <input id="password-input" name="password" type="password" required
                               placeholder="Masukkan kata sandi Anda" 
                               class="w-full pl-9 pr-10 py-2.5 bg-slate-50 border border-slate-200/90 rounded-2xl text-slate-800 text-xs placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all shadow-subtle">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1">
                            <span class="material-symbols-outlined text-base" id="password-toggle-icon">visibility</span>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-3.5 h-3.5 rounded text-brand-800 accent-brand-800">
                        <span class="text-slate-600 text-[11px]">Ingat saya di perangkat ini</span>
                    </label>
                    <a href="mailto:admin@alimasykur.sch.id?subject=Bantuan%20Akses%20SIM%20Kurikulum" class="text-brand-800 hover:underline font-semibold text-[11px]">
                        Lupa sandi?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full py-2.5 px-4 rounded-2xl bg-brand-800 hover:bg-brand-900 text-white font-semibold text-xs transition-all shadow-subtle flex items-center justify-center gap-1.5 mt-2 cursor-pointer">
                    <span>Masuk ke Portal Akademik</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </button>
            </form>

        </div>

    </div>

    <!-- FOOTER COPYRIGHT -->
    <div class="max-w-md w-full mx-auto text-center text-xs text-slate-400 py-2">
        © 2024–2026 Yayasan Pendidikan Islam Alfa Ali Masykur Wonosobo.
    </div>

    <!-- TOGGLE PASSWORD SCRIPT -->
    <script>
        function togglePasswordVisibility() {
            const input = document.getElementById('password-input');
            const icon = document.getElementById('password-toggle-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>
