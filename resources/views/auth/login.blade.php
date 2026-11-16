<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Portal Masuk - SIM Kurikulum YPI Ali Masykur</title>

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

    <!-- MAIN LOGIN CARD -->
    <div class="max-w-md w-full mx-auto my-auto py-6">
        
        <!-- Header Branding -->
        <div class="text-center mb-6 space-y-2">
            <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 p-1.5 shadow-card mx-auto flex items-center justify-center">
                <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo YPI Ali Masykur" class="w-full h-full object-contain">
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight text-slate-900">SIM Kurikulum Terpadu</h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">YPI Ali Masykur Wonosobo</p>
            </div>
        </div>

        <!-- Login Form Surface -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-8 space-y-5">
            
            <!-- Error Alerts -->
            @if(isset($errors) && $errors->any())
                <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2">
                    <span class="material-symbols-outlined text-base shrink-0">error</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                    <span class="material-symbols-outlined text-base text-emerald-600 shrink-0">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-slate-800 text-xs flex items-center gap-2">
                    <span class="material-symbols-outlined text-base text-brand-700 shrink-0">info</span>
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
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 cursor-pointer">
                            <span class="material-symbols-outlined text-base" id="password-toggle-icon">visibility</span>
                        </button>
                    </div>

                    <!-- Peringatan Caps Lock Otomatis (Micro-UX) -->
                    <div id="caps-lock-warning" class="hidden text-amber-800 bg-amber-50 border border-amber-200/90 text-[11px] rounded-xl px-3 py-1.5 flex items-center gap-1.5 mt-1 transition-all">
                        <span class="material-symbols-outlined text-sm text-amber-600">warning</span>
                        <span>Perhatian: <strong>Caps Lock</strong> Anda dalam keadaan aktif.</span>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-3.5 h-3.5 rounded text-brand-800 accent-brand-800">
                        <span class="text-slate-600 text-[11px]">Ingat saya di perangkat ini</span>
                    </label>
                    <button type="button" onclick="openForgotPasswordModal()" class="text-brand-800 hover:underline font-semibold text-[11px] cursor-pointer">
                        Lupa sandi?
                    </button>
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

    <!-- ======================================================== -->
    <!-- MODAL PEMULIHAN KATA SANDI (FORGOT PASSWORD) -->
    <!-- ======================================================== -->
    <div id="forgot-password-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 {{ session('forgot_error') || (isset($openForgotModal) && $openForgotModal) ? '' : 'hidden' }} flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-floating border border-slate-100 space-y-4 animate-in fade-in zoom-in-95 duration-150 my-auto">
            
            <!-- Header Modal -->
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-2xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-lg">lock_reset</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Bantuan Lupa Kata Sandi</h3>
                        <p class="text-[11px] text-slate-500">Pemulihan akses akun portal akademik</p>
                    </div>
                </div>
                <button type="button" onclick="closeForgotPasswordModal()" class="w-8 h-8 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>

            <!-- Tab Selector: Reset Mandiri vs Hubungi Admin IT -->
            <div class="flex items-center p-1 bg-slate-100 rounded-2xl text-xs font-semibold">
                <button type="button" id="tab-btn-self" onclick="switchForgotTab('self')" class="flex-1 py-1.5 rounded-xl bg-white text-slate-800 shadow-subtle text-center transition-all cursor-pointer">
                    Reset Mandiri
                </button>
                <button type="button" id="tab-btn-admin" onclick="switchForgotTab('admin')" class="flex-1 py-1.5 rounded-xl text-slate-500 hover:text-slate-800 text-center transition-all cursor-pointer">
                    Layanan Admin IT
                </button>
            </div>

            <!-- TAB 1: FORM RESET MANDIRI -->
            <div id="tab-content-self" class="space-y-3.5">
                @if(session('forgot_error'))
                    <div class="p-3 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2">
                        <span class="material-symbols-outlined text-base shrink-0">error</span>
                        <span>{{ session('forgot_error') }}</span>
                    </div>
                @endif

                <p class="text-[11px] text-slate-600 leading-relaxed">
                    Verifikasi kepemilikan akun dengan memasukkan <strong>Email resmi</strong> serta <strong>Username login</strong> atau <strong>NIP</strong> yang terdaftar:
                </p>

                <form method="POST" action="{{ route('password.reset.submit') }}" class="space-y-3 text-xs">
                    @csrf

                    <!-- Email Resmi -->
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 block">Email Resmi Terdaftar</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base">mail</span>
                            <input type="email" name="email" required value="{{ old('email') }}"
                                   placeholder="contoh: guru.ahmad@alimasykur.sch.id" 
                                   class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200/90 rounded-xl text-slate-800 text-xs placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                        </div>
                    </div>

                    <!-- Username atau NIP -->
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 block">Username Login atau NIP</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base">badge</span>
                            <input type="text" name="nip_or_username" required value="{{ old('nip_or_username') }}"
                                   placeholder="contoh: guru.ahmad atau 19850101..." 
                                   class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200/90 rounded-xl text-slate-800 text-xs placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                        </div>
                    </div>

                    <!-- Kata Sandi Baru -->
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 block">Kata Sandi Baru (Min. 6 Karakter)</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base">lock</span>
                            <input id="new-password-input" type="password" name="password" required minlength="6"
                                   placeholder="Masukkan kata sandi baru" 
                                   class="w-full pl-9 pr-9 py-2 bg-slate-50 border border-slate-200/90 rounded-xl text-slate-800 text-xs placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                            <button type="button" onclick="toggleFieldVisibility('new-password-input', 'new-pass-toggle-icon')" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-0.5 cursor-pointer">
                                <span class="material-symbols-outlined text-sm" id="new-pass-toggle-icon">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- Konfirmasi Kata Sandi Baru -->
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700 block">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base">lock_clock</span>
                            <input id="confirm-password-input" type="password" name="password_confirmation" required minlength="6"
                                   placeholder="Ulangi kata sandi baru" 
                                   class="w-full pl-9 pr-9 py-2 bg-slate-50 border border-slate-200/90 rounded-xl text-slate-800 text-xs placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                            <button type="button" onclick="toggleFieldVisibility('confirm-password-input', 'confirm-pass-toggle-icon')" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-0.5 cursor-pointer">
                                <span class="material-symbols-outlined text-sm" id="confirm-pass-toggle-icon">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Form -->
                    <div class="pt-2 flex items-center justify-end gap-2 border-t border-slate-100">
                        <button type="button" onclick="closeForgotPasswordModal()" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white font-semibold text-xs transition-all shadow-subtle flex items-center gap-1.5 cursor-pointer">
                            <span class="material-symbols-outlined text-sm">check</span>
                            <span>Simpan Sandi Baru</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB 2: HUBUNGI ADMIN IT -->
            <div id="tab-content-admin" class="hidden space-y-3 text-xs text-slate-600">
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5">
                    <div class="flex items-center gap-2 text-slate-900 font-bold">
                        <span class="material-symbols-outlined text-brand-700 text-base">support_agent</span>
                        <span>Pusat Layanan Bantuan IT Yayasan</span>
                    </div>
                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        Apabila Anda lupa Email atau NIP terdaftar, Admin Sistem dapat mereset kata sandi Anda secara manual melalui panel Manajemen Pengguna.
                    </p>
                </div>

                <!-- WhatsApp Direct Link -->
                <a href="https://wa.me/6281234567890?text=Halo%20Admin%20IT%20SIM%20Kurikulum%20YPI%20Ali%20Masykur%2C%20saya%20memerlukan%20bantuan%20reset%20kata%20sandi%20akun%20saya." 
                   target="_blank" rel="noopener noreferrer"
                   class="p-3 rounded-2xl border border-emerald-200 bg-emerald-50/60 hover:bg-emerald-100/60 text-emerald-950 flex items-center justify-between transition-colors group cursor-pointer">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-base">chat</span>
                        </div>
                        <div>
                            <div class="font-bold text-xs text-slate-900">Hubungi via WhatsApp</div>
                            <div class="text-[10px] text-slate-500">Respon cepat Sekretariat &amp; Tim IT</div>
                        </div>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 group-hover:text-emerald-700 text-base">open_in_new</span>
                </a>

                <!-- Email Direct Link -->
                <a href="mailto:sekretariat@alimasykur.sch.id?subject=Bantuan%20Reset%20Sandi%20SIM%20Kurikulum"
                   class="p-3 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-800 flex items-center justify-between transition-colors group cursor-pointer">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-base">mail</span>
                        </div>
                        <div>
                            <div class="font-bold text-xs text-slate-900">Kirim Email Resmi</div>
                            <div class="text-[10px] text-slate-500">sekretariat@alimasykur.sch.id</div>
                        </div>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 group-hover:text-slate-700 text-base">arrow_forward</span>
                </a>

                <!-- Jam Operasional -->
                <div class="text-[11px] text-slate-400 flex items-center gap-1.5 pt-1">
                    <span class="material-symbols-outlined text-sm">schedule</span>
                    <span>Jam Layanan: Senin – Sabtu, 07.30 – 15.30 WIB</span>
                </div>
            </div>

        </div>
    </div>

    <!-- FOOTER COPYRIGHT -->
    <div class="max-w-md w-full mx-auto text-center text-xs text-slate-400 py-2">
        © 2024–2026 YPI Ali Masykur Wonosobo.
    </div>

    <!-- SCRIPTS -->
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

        function toggleFieldVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input || !icon) return;
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }

        function openForgotPasswordModal() {
            const modal = document.getElementById('forgot-password-modal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeForgotPasswordModal() {
            const modal = document.getElementById('forgot-password-modal');
            if (modal) modal.classList.add('hidden');
        }

        function switchForgotTab(tab) {
            const selfContent = document.getElementById('tab-content-self');
            const adminContent = document.getElementById('tab-content-admin');
            const selfBtn = document.getElementById('tab-btn-self');
            const adminBtn = document.getElementById('tab-btn-admin');

            if (tab === 'self') {
                selfContent.classList.remove('hidden');
                adminContent.classList.add('hidden');
                selfBtn.className = 'flex-1 py-1.5 rounded-xl bg-white text-slate-800 shadow-subtle text-center transition-all cursor-pointer font-bold';
                adminBtn.className = 'flex-1 py-1.5 rounded-xl text-slate-500 hover:text-slate-800 text-center transition-all cursor-pointer font-semibold';
            } else {
                selfContent.classList.add('hidden');
                adminContent.classList.remove('hidden');
                adminBtn.className = 'flex-1 py-1.5 rounded-xl bg-white text-slate-800 shadow-subtle text-center transition-all cursor-pointer font-bold';
                selfBtn.className = 'flex-1 py-1.5 rounded-xl text-slate-500 hover:text-slate-800 text-center transition-all cursor-pointer font-semibold';
            }
        }

        // Keyboard Escape closes modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeForgotPasswordModal();
            }
        });

        // Deteksi Caps Lock
        const passwordInput = document.getElementById('password-input');
        const capsLockWarning = document.getElementById('caps-lock-warning');
        if (passwordInput && capsLockWarning) {
            ['keydown', 'keyup'].forEach(eventType => {
                passwordInput.addEventListener(eventType, function(event) {
                    if (event.getModifierState && event.getModifierState('CapsLock')) {
                        capsLockWarning.classList.remove('hidden');
                    } else {
                        capsLockWarning.classList.add('hidden');
                    }
                });
            });

            passwordInput.addEventListener('blur', function() {
                capsLockWarning.classList.add('hidden');
            });
        }
    </script>
</body>
</html>
