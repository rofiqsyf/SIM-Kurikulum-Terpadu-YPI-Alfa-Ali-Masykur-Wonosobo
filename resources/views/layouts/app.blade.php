<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'SIM Kurikulum') - YPI Alfa Ali Masykur</title>
    
    <!-- Favicon Logo Yayasan -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-yayasan.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-yayasan.png') }}">

    <!-- Preconnect & DNS-Prefetch for External Assets -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="dns-prefetch" href="https://cdn.tailwindcss.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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
                            950: '#022c22',
                        },
                    },
                    borderRadius: {
                        '2xl': '1rem',
                        '3xl': '1.5rem',
                        '4xl': '2rem',
                    },
                    boxShadow: {
                        'subtle': '0 1px 3px 0 rgba(0, 0, 0, 0.04)',
                        'card': '0 4px 20px -2px rgba(15, 23, 42, 0.04), 0 2px 6px -1px rgba(15, 23, 42, 0.02)',
                        'soft': '0 10px 30px -5px rgba(15, 23, 42, 0.05)',
                        'floating': '0 20px 40px -10px rgba(15, 23, 42, 0.1), 0 1px 3px 0 rgba(15, 23, 42, 0.05)',
                    }
                }
            }
        };
    </script>
    
    <style>
        body {
            font-feature-settings: "cv02", "cv03", "cv04", "cv11";
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        /* Refined minimalist scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .material-symbols-outlined.fill {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* Modern UI micro-interactions */
        button, a, input, select, textarea {
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        button:active, a.btn-action:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body class="bg-[#f4f6fa] text-slate-800 font-sans min-h-screen flex flex-col antialiased selection:bg-brand-100 selection:text-brand-900">

    <!-- MOBILE SIDEBAR BACKDROP -->
    <div id="sidebar-backdrop" onclick="toggleMobileSidebar()" 
         class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity"></div>

    <!-- MAIN SIDEBAR -->
    <aside id="main-sidebar" 
           class="fixed inset-y-0 left-0 w-64 bg-white border-r border-slate-100 z-50 flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
        
        <div class="flex flex-col h-full overflow-hidden">
            <!-- Brand Header -->
            <div class="h-20 px-6 flex items-center justify-between shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-2xl bg-white border border-slate-200/80 p-1 flex items-center justify-center shadow-subtle group-hover:border-brand-500 transition-colors">
                        <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo Yayasan Ali Masykur" class="w-full h-full object-contain">
                    </div>

                    <div class="flex flex-col">
                        <span class="text-sm font-extrabold tracking-tight text-slate-900 leading-tight group-hover:text-brand-800 transition-colors">SIM Kurikulum</span>
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mt-0.5">Alfa Ali Masykur</span>
                    </div>

                </a>
                <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden text-slate-400 hover:text-slate-600 p-1 rounded-xl">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>


            <!-- Unit Affiliation Badge -->
            <div class="px-5 pb-3 shrink-0">
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                        <div class="flex flex-col min-w-0">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400">Unit Lembaga</span>
                            <span class="text-xs font-bold text-slate-800 truncate" title="{{ auth()->user()->unit->nama_unit ?? 'Seluruh Unit Yayasan' }}">
                                {{ auth()->user()->unit->nama_unit ?? 'Pusat Yayasan' }}
                            </span>
                        </div>

                    </div>

                    <span class="text-[10px] font-bold bg-white text-brand-800 border border-slate-200 px-2 py-0.5 rounded-lg shadow-subtle">
                        {{ auth()->user()->unit->kode_unit ?? 'YPI' }}
                    </span>
                </div>

            </div>


            <!-- Navigation Links -->
            <div class="flex-1 px-4 py-2 overflow-y-auto space-y-6">
                <!-- Group 1: Academic -->
                <div>
                    <span class="px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-2">
                        Menu Utama
                    </span>
                    <nav class="space-y-1">
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-800 font-bold shadow-subtle' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('dashboard') ? 'text-brand-700' : 'text-slate-400' }}">dashboard</span>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('curriculum.index') }}" 
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all {{ request()->routeIs('curriculum.index') ? 'bg-brand-50 text-brand-800 font-bold shadow-subtle' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('curriculum.index') ? 'text-brand-700' : 'text-slate-400' }}">account_tree</span>
                            <span>Kurikulum &amp; Silabus</span>
                        </a>

                        <a href="{{ route('usulan.index') }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all {{ request()->routeIs('usulan.index') ? 'bg-brand-50 text-brand-800 font-bold shadow-subtle' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('usulan.index') ? 'text-brand-700' : 'text-slate-400' }}">rate_review</span>
                                <span>Riwayat Usulan</span>
                            </div>

                            @php
                                $pendingQuery = \App\Models\UsulanPerubahan::where('status', 'Menunggu Persetujuan');
                                if (auth()->user()->isGuru()) {
                                    $pendingQuery->where('pengusul_id', auth()->id());
                                } elseif (!auth()->user()->canAccessAllUnits() && auth()->user()->unit_id) {
                                    $pendingQuery->where('unit_id', auth()->user()->unit_id);
                                }
                                $pendingCount = $pendingQuery->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ request()->routeIs('usulan.index') ? 'bg-brand-700 text-white' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $pendingCount }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('kegiatan.index') }}" 
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all {{ request()->routeIs('kegiatan.index') ? 'bg-brand-50 text-brand-800 font-bold shadow-subtle' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('kegiatan.index') ? 'text-brand-700' : 'text-slate-400' }}">local_activity</span>
                            <span>Kokurikuler &amp; Ekstra</span>
                        </a>

                        <a href="{{ route('jurnal.index') }}" 
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all {{ request()->routeIs('jurnal.index') ? 'bg-brand-50 text-brand-800 font-bold shadow-subtle' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('jurnal.index') ? 'text-brand-700' : 'text-slate-400' }}">edit_calendar</span>
                            <span>Jurnal &amp; Tahfidz</span>
                        </a>

                        <a href="{{ route('guide.index') }}" 
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all {{ request()->routeIs('guide.index') ? 'bg-brand-50 text-brand-800 font-bold shadow-subtle' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('guide.index') ? 'text-brand-700' : 'text-slate-400' }}">menu_book</span>
                            <span>Panduan SOP</span>
                        </a>
                    </nav>
                </div>


                <!-- Group 2: Governance & Admin -->
                <div>
                    <span class="px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-2">
                        Tata Kelola
                    </span>
                    <nav class="space-y-1">
                        <a href="{{ route('arsip.index') }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all {{ request()->routeIs('arsip.*') ? 'bg-brand-50 text-brand-800 font-bold shadow-subtle' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('arsip.*') ? 'text-brand-700' : 'text-slate-400' }}">inventory_2</span>
                                <span>Arsip &amp; Supervisi</span>
                            </div>
                            @php
                                $arsipPerluQuery = \App\Models\ArsipDokumen::where('status_verifikasi', 'Perlu Dilengkapi');
                                if (!auth()->user()->canAccessAllUnits() && auth()->user()->unit_id) {
                                    $arsipPerluQuery->where('unit_id', auth()->user()->unit_id);
                                }
                                $arsipPerluCount = $arsipPerluQuery->count();
                            @endphp
                            @if($arsipPerluCount > 0)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ request()->routeIs('arsip.*') ? 'bg-brand-700 text-white' : 'bg-amber-100 text-amber-800' }}" title="{{ $arsipPerluCount }} dokumen perlu dilengkapi">
                                    {{ $arsipPerluCount }}
                                </span>
                            @endif
                        </a>

                        @if(auth()->user()->canAccessAllUnits())
                            <a href="{{ route('yayasan.monitoring') }}" 
                               class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all {{ request()->routeIs('yayasan.monitoring') ? 'bg-brand-50 text-brand-800 font-bold shadow-subtle' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                                <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('yayasan.monitoring') ? 'text-brand-700' : 'text-slate-400' }}">domain</span>
                                <span>Monitoring 3 Unit</span>
                            </a>
                        @endif

                        @if(auth()->user()->isAdmin() || auth()->user()->isYayasan() || auth()->user()->isWakaKurikulum() || auth()->user()->isKepalaSekolah())
                            <a href="{{ route('admin.users') }}" 
                               class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all {{ request()->routeIs('admin.users') ? 'bg-brand-50 text-brand-800 font-bold shadow-subtle' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                                <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.users') ? 'text-brand-700' : 'text-slate-400' }}">manage_accounts</span>
                                <span>{{ auth()->user()->isWakaKurikulum() ? 'Guru & Beban Jam' : (auth()->user()->isKepalaSekolah() ? 'Dewan Guru Unit' : 'Pengguna & Peran') }}</span>
                            </a>
                        @endif
                    </nav>
                </div>


                <!-- Need Help Card (matching reference design) -->
                <div class="p-4 rounded-3xl bg-slate-50/80 border border-slate-100 text-center space-y-2">
                    <div class="w-10 h-10 rounded-2xl bg-brand-100 text-brand-800 mx-auto flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-lg">support_agent</span>
                    </div>

                    <div class="space-y-0.5">
                        <h5 class="text-xs font-bold text-slate-800">Butuh Bantuan?</h5>
                        <p class="text-[11px] text-slate-500 leading-tight">Konsultasi SOP &amp; perumusan TP</p>
                    </div>

                    <a href="{{ route('guide.index') }}" class="inline-flex items-center justify-center px-4 py-1.5 rounded-full bg-brand-800 hover:bg-brand-900 text-white text-[11px] font-semibold shadow-subtle transition-all">
                        Buka Panduan
                    </a>
                </div>

            </div>


            <!-- Bottom: User Profile Row -->
            <div class="p-4 border-t border-slate-100 bg-white shrink-0">
                <div class="flex items-center justify-between">
                    <button type="button" onclick="openUserProfileModal()" 
                            class="flex items-center gap-2.5 min-w-0 cursor-pointer p-1.5 -ml-1.5 rounded-2xl hover:bg-slate-50 transition-colors text-left" 
                            title="Buka Profil Akun">
                        <div class="w-9 h-9 rounded-2xl bg-brand-50 border border-brand-200/80 flex items-center justify-center font-bold text-xs text-brand-800 shrink-0 shadow-subtle">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>

                        <div class="flex flex-col min-w-0">
                            <span class="text-xs font-bold text-slate-900 truncate leading-tight hover:text-brand-800 transition-colors">
                                {{ auth()->user()->name }}
                            </span>
                            <span class="text-[11px] text-slate-500 truncate leading-tight mt-0.5">
                                {{ auth()->user()->peran->nama_peran ?? 'Pendidik' }}
                            </span>
                        </div>

                    </button>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline shrink-0">
                        @csrf
                        <button type="submit" title="Keluar Sistem" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer">
                            <span class="material-symbols-outlined text-lg">logout</span>
                        </button>
                    </form>
                </div>

            </div>


        </div>

    </aside>

    <!-- MAIN SHELL -->
    <div class="lg:pl-64 flex flex-col flex-1 min-h-screen">
        
        <!-- STICKY TOPBAR HEADER (Unified & Clean) -->
        <header class="sticky top-0 z-30 h-16 bg-white/80 backdrop-blur-md border-b border-slate-100/90 flex items-center justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 flex-1 min-w-0">
                <!-- Hamburger Button for Mobile -->
                <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                    <span class="material-symbols-outlined text-xl">menu</span>
                </button>

                <!-- Functional Global Search Form -->
                <form method="GET" action="{{ route('curriculum.index') }}" class="relative w-full max-w-xs sm:max-w-md">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                    <input type="search" name="q" value="{{ request('q') }}"
                           placeholder="Cari CP, TP, atau Materi..." 
                           class="w-full pl-10 pr-4 py-2 text-xs bg-slate-50/80 hover:bg-slate-100/80 focus:bg-white text-slate-800 placeholder-slate-400 border border-slate-200/70 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600 transition-all">
                </form>
            </div>


            <!-- Right Controls -->
            <div class="flex items-center gap-3 shrink-0">
                <!-- Live Date Indicator (Matches Reference UI Top Right Date) -->
                <div class="hidden xl:flex items-center gap-2 text-xs font-semibold text-slate-500 bg-slate-50 px-3.5 py-1.5 rounded-full border border-slate-200/60">
                    <span class="material-symbols-outlined text-sm text-brand-700">calendar_today</span>
                    <span>{{ now()->locale('id')->translatedFormat('d F Y, l') }}</span>
                </div>


                <!-- Academic Year Badge -->
                <div class="hidden md:flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 text-slate-600 text-xs font-medium border border-slate-200/60">
                    <span>2024/2025</span>
                    <span class="text-slate-300">•</span>
                    <span class="text-brand-800 font-bold">Ganjil</span>
                </div>


                <!-- Realtime Notification Center -->
                <div class="relative" id="notif-wrapper">
                    <button type="button" id="notif-bell-btn" onclick="toggleNotificationDropdown()" 
                            class="relative p-2 rounded-2xl text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors focus:outline-none" 
                            title="Pusat Notifikasi Realtime">
                        <span class="material-symbols-outlined text-xl">notifications</span>
                        <!-- Pulsing badge -->
                        <span id="notif-badge" class="hidden absolute top-1 right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-rose-600 text-white text-[10px] font-bold flex items-center justify-center ring-2 ring-white">
                            0
                        </span>
                    </button>

                    <!-- Dropdown Popover Surface -->
                    <div id="notif-dropdown" 
                         class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-3xl shadow-floating border border-slate-100 z-50 overflow-hidden text-xs">
                        <!-- Dropdown Header -->
                        <div class="px-5 py-3.5 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-900">Notifikasi</span>
                                <span id="notif-unread-tag" class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-brand-50 text-brand-800 hidden">
                                    0 Baru
                                </span>
                            </div>

                            <button type="button" onclick="markAllNotificationsAsRead()" 
                                    class="text-[11px] text-brand-800 hover:underline font-semibold">
                                Tandai Semua Dibaca
                            </button>
                        </div>


                        <!-- Notification Items Container -->
                        <div id="notif-list" class="divide-y divide-slate-100 max-h-80 overflow-y-auto">
                            <div class="p-6 text-center text-slate-400 text-xs">
                                Memuat notifikasi...
                            </div>

                        </div>


                        <!-- Dropdown Footer -->
                        <div class="p-3 bg-slate-50/60 border-t border-slate-100 text-center">
                            <a href="{{ route('usulan.index') }}" class="text-[11px] font-semibold text-slate-600 hover:text-brand-800 block">
                                Buka Riwayat Usulan Lengkap →
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        </header>

        <!-- FLASH NOTIFICATION TOASTS -->
        <div class="px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full pt-4">
            @if(session('success'))
                <div class="mb-4 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center justify-between shadow-subtle">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-base text-emerald-600">check_circle</span>
                        <span>{{ session('success') }}</span>
                    </div>

                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">
                        <span class="material-symbols-outlined text-base">close</span>
                    </button>
                </div>

            @endif

            @if(session('info'))
                <div class="mb-4 p-3.5 rounded-xl bg-slate-100 border border-slate-200 text-slate-800 text-xs font-medium flex items-center justify-between shadow-subtle">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-base text-brand-700">info</span>
                        <span>{{ session('info') }}</span>
                    </div>

                    <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-700">
                        <span class="material-symbols-outlined text-base">close</span>
                    </button>
                </div>

            @endif

            @if(session('error') || (isset($errors) && $errors->any()))
                <div class="mb-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium flex items-center justify-between shadow-subtle">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-base text-rose-600">error</span>
                        <span>{{ session('error') ?? ($errors->first() ?? '') }}</span>
                    </div>

                    <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-800">
                        <span class="material-symbols-outlined text-base">close</span>
                    </button>
                </div>

            @endif
        </div>


        <!-- MAIN PAGE CONTENT -->
        <main class="flex-1 w-full pb-16">
            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="border-t border-slate-200/70 bg-white px-4 sm:px-6 lg:px-8 py-4">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-500">
                <span>© 2024–2026 Yayasan Pendidikan Islam Alfa Ali Masykur Wonosobo.</span>
                <div class="flex items-center gap-4">
                    <a href="{{ route('guide.index') }}" class="hover:text-slate-800 transition-colors">Panduan SOP</a>
                    <span>•</span>
                    <span>Versi 3.0.0 (Minimalist Pro)</span>
                </div>

            </div>

        </footer>

    </div>


    <!-- GLOBAL PROPOSAL SLIDE-OVER DRAWER -->
    <div id="global-proposal-backdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden transition-opacity" onclick="closeGlobalProposalModal()"></div>
    
    <div id="global-proposal-drawer" 
         class="fixed inset-y-0 right-0 w-full sm:w-[500px] bg-white z-50 shadow-floating transform translate-x-full transition-transform duration-200 ease-in-out flex flex-col justify-between overflow-hidden">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between shrink-0 bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-lg">edit_document</span>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-slate-900" id="drawer-form-title">Ajukan Usulan Kurikulum</h3>
                    <p class="text-[11px] text-slate-500">SOP-KUR-01 • Verifikasi oleh Kepala Sekolah</p>
                </div>

            </div>

            <button type="button" onclick="closeGlobalProposalModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>


        <!-- Form Body -->
        <form method="POST" action="{{ route('curriculum.proposal.store') }}" class="p-6 flex-1 overflow-y-auto space-y-4 text-xs">
            @csrf
            
            <!-- Hidden context fields for hierarchy linkages -->
            <input type="hidden" name="data_id" id="proposal_data_id" value="">
            <input type="hidden" name="target_parent_id" id="proposal_target_parent_id" value="">

            <!-- Mata Pelajaran -->
            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Mata Pelajaran</label>
                <select name="mapel_id" id="proposal_mapel_id" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600 focus:border-brand-600">
                    @foreach(\App\Models\MataPelajaran::with('kurikulum.unit')->get() as $mp)
                        <option value="{{ $mp->id }}">
                            {{ $mp->nama_mapel }} ({{ $mp->kurikulum->unit->nama_unit ?? 'SMP Alfa' }})
                        </option>
                    @endforeach
                </select>
            </div>


            <!-- Tipe Perubahan & Objek Data -->
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Jenis Usulan</label>
                    <select name="jenis_usulan" id="proposal_jenis_usulan" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600 focus:border-brand-600">
                        <option value="Tambah">Tambah Baru</option>
                        <option value="Ubah">Ubah Data</option>
                        <option value="Hapus">Hapus Data</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Tingkat Objek</label>
                    <select name="objek_data" id="proposal_objek_data" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600 focus:border-brand-600">
                        <option value="TP">Tujuan Pembelajaran (TP)</option>
                        <option value="Materi">Materi Pokok / Sub-Materi</option>
                        <option value="CP">Capaian Pembelajaran (CP)</option>
                    </select>
                </div>

            </div>


            <!-- Judul Usulan -->
            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Judul / Ringkasan Usulan</label>
                <input type="text" name="judul_usulan" id="proposal_judul_usulan" required 
                       placeholder="misal: Penambahan Materi Zakat Perniagaan Kontekstual"
                       class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600 focus:border-brand-600">
            </div>


            <!-- Rincian Konten Usulan -->
            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Rumusan / Deskripsi Usulan Baru</label>
                <textarea name="deskripsi_usulan" id="proposal_deskripsi_usulan" rows="3" 
                          placeholder="Tuliskan rumusan lengkap TP atau uraian materi ajar yang diusulkan..."
                          class="w-full bg-slate-50 border border-slate-200 rounded-lg p-3 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600 focus:border-brand-600 leading-relaxed"></textarea>
            </div>


            <!-- Alokasi Beban JP & Media Ajar -->
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Beban JP</label>
                    <input type="number" name="beban_jp" id="proposal_beban_jp" value="4" min="1" max="64"
                           class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600 focus:border-brand-600">
                </div>

                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Media / Modul Ajar</label>
                    <input type="text" name="media_ajar" id="proposal_media_ajar" placeholder="misal: LKPD Praktik Fiqih"
                           class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600 focus:border-brand-600">
                </div>

            </div>


            <!-- Rasional Pedagogis -->
            <div class="space-y-1 pt-1">
                <div class="flex items-center justify-between">
                    <label class="font-semibold text-slate-700 flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm text-brand-700">psychology</span>
                        <span>Rasional Pedagogis (Wajib Sesuai SOP)</span>
                    </label>
                    <span class="text-[10px] text-slate-400">Taksonomi C1–C6</span>
                </div>

                <textarea name="alasan_pengajuan" id="proposal_alasan_pengajuan" required rows="3" 
                          placeholder="Jelaskan kebutuhan rasional, tingkat Taksonomi Bloom (C1-C6), dan integrasi nilai kepesantrenan..."
                          class="w-full bg-slate-50 border border-slate-200 rounded-lg p-3 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600 focus:border-brand-600 leading-relaxed"></textarea>
                <p class="text-[10px] text-slate-400">Rasional ini akan menjadi dasar utama Kepala Sekolah dalam menyetujui atau memberikan catatan perbaikan.</p>
            </div>


            <!-- Footer Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeGlobalProposalModal()" 
                        class="px-3.5 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 rounded-lg bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base">send</span>
                    <span>Kirim Pengajuan</span>
                </button>
            </div>

        </form>
    </div>

    <!-- ======================================================== -->
    <!-- GLOBAL USER PROFILE MODAL -->
    <!-- ======================================================== -->
    <div id="profile-modal-backdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden transition-opacity" onclick="closeUserProfileModal()"></div>
    
    <div id="profile-modal" 
         class="fixed inset-0 z-50 hidden overflow-y-auto p-4 sm:p-6 flex items-center justify-center pointer-events-none">
        
        <div class="pointer-events-auto bg-white rounded-3xl shadow-floating border border-slate-100 max-w-lg w-full overflow-hidden transform transition-all duration-200">
            <!-- Modal Header with gradient brand styling -->
            <div class="relative bg-gradient-to-r from-brand-800 to-brand-900 p-6 text-white text-center">
                <button type="button" onclick="closeUserProfileModal()" 
                        class="absolute top-4 right-4 text-white/70 hover:text-white p-1 rounded-full hover:bg-white/10 transition-colors cursor-pointer"
                        title="Tutup">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>

                <!-- Avatar with Initial -->
                <div class="relative w-20 h-20 mx-auto mb-3">
                    <div class="w-20 h-20 rounded-full bg-white text-brand-800 font-black text-2xl flex items-center justify-center shadow-card border-4 border-white/20">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="absolute bottom-0 right-1 w-4 h-4 rounded-full bg-emerald-400 border-2 border-white shadow-subtle" title="Status: Aktif"></span>
                </div>

                <h3 class="text-base font-extrabold tracking-tight">{{ auth()->user()->name }}</h3>
                <p class="text-xs text-white/80 font-medium mt-0.5">
                    {{ auth()->user()->peran->nama_peran ?? 'Pendidik' }} • {{ auth()->user()->unit->nama_unit ?? 'YPI Alfa Ali Masykur' }}
                </p>
                <div class="mt-2.5 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 text-white text-[11px] font-semibold border border-white/20">
                    <span class="material-symbols-outlined text-xs">verified_user</span>
                    <span>NIP: {{ auth()->user()->nip ?? 'G-202401' }}</span>
                </div>
            </div>

            <!-- Modal Body Details -->
            <div class="p-6 space-y-5 text-xs max-h-[70vh] overflow-y-auto">
                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                        <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block">Email Akun</span>
                        <span class="font-bold text-slate-800 break-all">{{ auth()->user()->email }}</span>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                        <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block">No. Telepon / WhatsApp</span>
                        <span class="font-bold text-slate-800">{{ auth()->user()->nomor_telepon ?? '0812-3456-7890' }}</span>
                    </div>
                </div>

                <!-- Penugasan Mata Pelajaran & Jam Beban Mengajar -->
                @php
                    $userPenugasan = auth()->user()->penugasan()->with('mataPelajaran')->get();
                    $sumJp = $userPenugasan->sum('beban_jp');
                @endphp
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-slate-900 text-xs flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm text-brand-700">assignment_ind</span>
                            <span>Penugasan Mata Pelajaran &amp; Beban JP</span>
                        </span>
                        @if($sumJp > 0)
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-brand-50 text-brand-800 border border-brand-200">
                                Total: {{ $sumJp }} JP / Pekan
                            </span>
                        @endif
                    </div>

                    @if($userPenugasan->count() > 0)
                        <div class="divide-y divide-slate-100 border border-slate-100 rounded-2xl overflow-hidden bg-slate-50/50">
                            @foreach($userPenugasan as $pg)
                                <div class="p-3 flex items-center justify-between">
                                    <div>
                                        <span class="font-bold text-slate-800 block text-xs">{{ $pg->mataPelajaran->nama_mapel ?? 'Mata Pelajaran' }}</span>
                                        <span class="text-[11px] text-slate-500">Tahun Ajaran {{ $pg->tahun_ajaran }} • Semester {{ ucfirst($pg->semester) }}</span>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-xl bg-white border border-slate-200 font-bold text-slate-700 text-[11px]">
                                        {{ $pg->beban_jp ?? 4 }} JP
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center text-slate-500 text-xs">
                            <span class="material-symbols-outlined text-2xl text-slate-300 block mb-1">school</span>
                            Tidak ada penugasan mengajar langsung untuk akun ini (Peran: {{ auth()->user()->peran->nama_peran ?? 'Pendidik' }}).
                        </div>
                    @endif
                </div>

                <!-- Ringkasan Kinerja & Aktivitas -->
                <div class="space-y-2">
                    <span class="font-bold text-slate-900 text-xs flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm text-brand-700">insights</span>
                        <span>Aktivitas &amp; Produktivitas</span>
                    </span>
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-base font-bold text-slate-800 block">{{ auth()->user()->jurnalKerja()->count() }}</span>
                            <span class="text-[10px] text-slate-500 font-medium">Agenda Kerja</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-base font-bold text-emerald-700 block">{{ auth()->user()->jurnalMengajar()->count() }}</span>
                            <span class="text-[10px] text-slate-500 font-medium">Jurnal KBM</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-base font-bold text-brand-800 block">{{ auth()->user()->usulanDiajukan()->count() }}</span>
                            <span class="text-[10px] text-slate-500 font-medium">Usulan TP</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions inside Modal -->
                <div class="pt-2 border-t border-slate-100 flex items-center justify-between gap-3">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.users') }}" 
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                            <span class="material-symbols-outlined text-sm">manage_accounts</span>
                            <span>Manajemen Pengguna</span>
                        </a>
                    @else
                        <div></div>
                    @endif

                    <div class="flex items-center gap-2">
                        <button type="button" onclick="closeUserProfileModal()" 
                                class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors cursor-pointer">
                            Tutup
                        </button>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-semibold transition-colors flex items-center gap-1 cursor-pointer">
                                <span class="material-symbols-outlined text-sm">logout</span>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT UTILITIES -->
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('main-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const isOpen = !sidebar.classList.contains('-translate-x-full');
            
            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                document.body.style.overflow = '';
            } else {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function openGlobalProposalModal(objek = 'TP', judul = '', dataId = null, targetParentId = null, mapelId = null) {
            const drawer = document.getElementById('global-proposal-drawer');
            const backdrop = document.getElementById('global-proposal-backdrop');
            
            drawer.classList.remove('translate-x-full');
            backdrop.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            if (objek) {
                const sel = drawer.querySelector('#proposal_objek_data');
                if (sel) sel.value = objek;
            }
            if (judul) {
                const inp = drawer.querySelector('#proposal_judul_usulan');
                if (inp) inp.value = judul;
            }
            if (dataId) {
                const inp = drawer.querySelector('#proposal_data_id');
                if (inp) inp.value = dataId;
            } else {
                const inp = drawer.querySelector('#proposal_data_id');
                if (inp) inp.value = '';
            }
            if (targetParentId) {
                const inp = drawer.querySelector('#proposal_target_parent_id');
                if (inp) inp.value = targetParentId;
            } else {
                const inp = drawer.querySelector('#proposal_target_parent_id');
                if (inp) inp.value = '';
            }
            if (mapelId) {
                const sel = drawer.querySelector('#proposal_mapel_id');
                if (sel) sel.value = mapelId;
            }
        }

        function closeGlobalProposalModal() {
            const drawer = document.getElementById('global-proposal-drawer');
            const backdrop = document.getElementById('global-proposal-backdrop');
            drawer.classList.add('translate-x-full');
            backdrop.classList.add('hidden');
            document.body.style.overflow = '';
        }

        // ==========================================
        // USER PROFILE MODAL HANDLERS
        // ==========================================
        function openUserProfileModal() {
            const modal = document.getElementById('profile-modal');
            const backdrop = document.getElementById('profile-modal-backdrop');
            if (modal && backdrop) {
                modal.classList.remove('hidden');
                backdrop.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeUserProfileModal() {
            const modal = document.getElementById('profile-modal');
            const backdrop = document.getElementById('profile-modal-backdrop');
            if (modal && backdrop) {
                modal.classList.add('hidden');
                backdrop.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        // Close on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeGlobalProposalModal();
                closeUserProfileModal();
                closeNotificationDropdown();
                const rejectModal = document.getElementById('reject-modal');
                if (rejectModal) rejectModal.classList.add('hidden');
                const propModal = document.getElementById('proposal-detail-modal');
                if (propModal) propModal.classList.add('hidden');
                const jModal = document.getElementById('jurnal-modal');
                if (jModal) jModal.classList.add('hidden');
                const tModal = document.getElementById('tahfidz-modal');
                if (tModal) tModal.classList.add('hidden');
                const uModal = document.getElementById('modal-tambah-user');
                if (uModal) uModal.classList.add('hidden');
                const aModal = document.getElementById('modal-penugasan-guru');
                if (aModal) aModal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });

        // ==========================================
        // REALTIME NOTIFICATION ENGINE
        // ==========================================
        let lastNotificationId = 0;
        let isDropdownOpen = false;

        function toggleNotificationDropdown() {
            const dropdown = document.getElementById('notif-dropdown');
            isDropdownOpen = !isDropdownOpen;
            if (isDropdownOpen) {
                dropdown.classList.remove('hidden');
                syncRealtime(false);
            } else {
                dropdown.classList.add('hidden');
            }
        }

        function closeNotificationDropdown() {
            const dropdown = document.getElementById('notif-dropdown');
            if (dropdown) {
                dropdown.classList.add('hidden');
                isDropdownOpen = false;
            }
        }

        // Close dropdown when clicked outside
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('notif-wrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                closeNotificationDropdown();
            }
        });

        function playSoftChime() {
            try {
                const AudioCtx = window.AudioContext || window.webkitAudioContext;
                if (!AudioCtx) return;
                const ctx = new AudioCtx();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(880, ctx.currentTime); // A5
                osc.frequency.exponentialRampToValueAtTime(1320, ctx.currentTime + 0.15); // E6
                gain.gain.setValueAtTime(0.08, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.35);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.35);
            } catch (err) {
                // AudioContext autoplay restrictions are handled silently
            }
        }

        function showRealtimeToast(notif) {
            const container = document.getElementById('realtime-toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = "pointer-events-auto bg-white border border-slate-200/90 shadow-floating rounded-2xl p-4 flex items-start gap-3 transition-all duration-300 transform translate-y-3 opacity-0";
            
            let icon = 'notifications';
            let iconColor = 'text-brand-700 bg-brand-50';
            if (notif.tipe === 'proposal_approved') {
                icon = 'check_circle';
                iconColor = 'text-emerald-700 bg-emerald-50';
            } else if (notif.tipe === 'proposal_rejected') {
                icon = 'feedback';
                iconColor = 'text-rose-700 bg-rose-50';
            } else if (notif.tipe === 'proposal_created') {
                icon = 'rate_review';
                iconColor = 'text-amber-700 bg-amber-50';
            }

            toast.innerHTML = `
                <div class="w-8 h-8 rounded-xl ${iconColor} flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-base">${icon}</span>
                </div>

                <div class="flex-1 min-w-0 text-xs">
                    <div class="flex items-center justify-between gap-1 mb-0.5">
                        <span class="font-bold text-slate-900 truncate">${notif.judul || 'Pemberitahuan Sistem'}</span>
                        <span class="text-[10px] text-slate-400 shrink-0">Baru saja</span>
                    </div>

                    <p class="text-[11px] text-slate-600 line-clamp-2 leading-relaxed">${notif.pesan}</p>
                    ${notif.tautan ? `<a href="${notif.tautan}" class="inline-block mt-1 text-[11px] font-semibold text-brand-800 hover:underline">Buka Rincian →</a>` : ''}
                </div>

                <button type="button" class="text-slate-400 hover:text-slate-600 p-0.5" onclick="this.closest('.pointer-events-auto').remove()">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            `;

            container.appendChild(toast);
            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-3', 'opacity-0');
            });

            playSoftChime();

            // Auto-dismiss after 6 seconds
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 6000);
        }

        function renderNotificationList(items) {
            const listEl = document.getElementById('notif-list');
            if (!listEl) return;

            if (!items || items.length === 0) {
                listEl.innerHTML = `
                    <div class="p-8 text-center text-slate-400 text-xs">
                        <span class="material-symbols-outlined text-2xl mb-1 text-slate-300 block">notifications_none</span>
                        <span>Tidak ada notifikasi saat ini</span>
                    </div>

                `;
                return;
            }

            listEl.innerHTML = items.map(n => {
                let icon = 'notifications';
                let iconColor = 'text-brand-700 bg-brand-50';
                if (n.tipe === 'proposal_approved') {
                    icon = 'check_circle';
                    iconColor = 'text-emerald-700 bg-emerald-50';
                } else if (n.tipe === 'proposal_rejected') {
                    icon = 'feedback';
                    iconColor = 'text-rose-700 bg-rose-50';
                } else if (n.tipe === 'proposal_created') {
                    icon = 'rate_review';
                    iconColor = 'text-amber-700 bg-amber-50';
                }

                const bgUnread = !n.dibaca ? 'bg-brand-50/30' : '';

                return `
                    <div onclick="clickNotification(${n.id}, '${n.tautan || ''}')" 
                         class="p-3.5 flex items-start gap-3 hover:bg-slate-50 transition-colors cursor-pointer ${bgUnread}">
                        <div class="w-8 h-8 rounded-lg ${iconColor} flex items-center justify-center shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-base">${icon}</span>
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-1">
                                <span class="font-bold text-slate-900 truncate ${!n.dibaca ? 'text-brand-950 font-extrabold' : ''}">${n.judul}</span>
                                <span class="text-[10px] text-slate-400 shrink-0">${n.waktu}</span>
                            </div>

                            <p class="text-[11px] text-slate-600 line-clamp-2 mt-0.5 leading-relaxed">${n.pesan}</p>
                        </div>

                        ${!n.dibaca ? '<span class="w-2 h-2 rounded-full bg-brand-600 shrink-0 mt-2"></span>' : ''}
                    </div>

                `;
            }).join('');
        }

        async function syncRealtime(isBackground = true) {
            try {
                const res = await fetch(`{{ route('realtime.sync') }}?last_notification_id=${lastNotificationId}`, {
                    headers: { 'Accept': 'application/json' }
                });
                if (!res.ok) return;
                const data = await res.json();

                // Update badge count
                const badge = document.getElementById('notif-badge');
                const tag = document.getElementById('notif-unread-tag');
                if (badge) {
                    if (data.unread_count > 0) {
                        badge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                        badge.classList.remove('hidden');
                        if (tag) {
                            tag.textContent = `${data.unread_count} Baru`;
                            tag.classList.remove('hidden');
                        }
                    } else {
                        badge.classList.add('hidden');
                        if (tag) tag.classList.add('hidden');
                    }
                }

                // Render recent notifications
                renderNotificationList(data.recent_notifications);

                // Check for new notifications to show toast
                if (data.new_notifications && data.new_notifications.length > 0) {
                    data.new_notifications.forEach(n => {
                        if (lastNotificationId > 0) {
                            showRealtimeToast(n);
                        }
                        if (n.id > lastNotificationId) {
                            lastNotificationId = n.id;
                        }
                    });
                } else if (data.recent_notifications && data.recent_notifications.length > 0 && lastNotificationId === 0) {
                    lastNotificationId = data.recent_notifications[0].id;
                }

                // Dispatch event for page components (like dashboard stats)
                window.dispatchEvent(new CustomEvent('sim-realtime-update', { detail: data }));
            } catch (err) {
                // Silently handle transient connection errors
            }
        }

        async function clickNotification(id, redirectUrl) {
            try {
                await fetch(`/realtime/notifications/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
            } catch (e) {}

            if (redirectUrl && redirectUrl !== '') {
                window.location.href = redirectUrl;
            } else {
                syncRealtime(false);
            }
        }

        async function markAllNotificationsAsRead() {
            try {
                await fetch('{{ route('realtime.read-all') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                syncRealtime(false);
            } catch (e) {}
        }

        // Initialize Realtime Polling Loop (Lightweight, Non-blocking)
        document.addEventListener('DOMContentLoaded', function() {
            // Initial sync on page load
            syncRealtime(false);

            // Smart heartbeat polling every 6 seconds when tab is active
            setInterval(function() {
                if (document.visibilityState === 'visible') {
                    syncRealtime(true);
                }
            }, 6000);

            // Immediate sync when user refocuses the browser tab
            window.addEventListener('focus', function() {
                syncRealtime(true);
            });

            // Speculative Prefetch for Instant Navigation (Hover / Touch)
            const prefetchedUrls = new Set();
            function prefetchPage(url) {
                if (!url || prefetchedUrls.has(url) || url.includes('#') || url.includes('logout')) return;
                prefetchedUrls.add(url);
                const prefetchTag = document.createElement('link');
                prefetchTag.rel = 'prefetch';
                prefetchTag.href = url;
                prefetchTag.as = 'document';
                document.head.appendChild(prefetchTag);
            }

            document.addEventListener('mouseover', function(e) {
                const link = e.target.closest('a');
                if (link && link.href && link.origin === window.location.origin && !link.hasAttribute('download') && link.target !== '_blank') {
                    prefetchPage(link.href);
                }
            }, { passive: true });

            document.addEventListener('touchstart', function(e) {
                const link = e.target.closest('a');
                if (link && link.href && link.origin === window.location.origin && !link.hasAttribute('download') && link.target !== '_blank') {
                    prefetchPage(link.href);
                }
            }, { passive: true });
        });
    </script>

    <!-- REALTIME FLOATING TOAST CONTAINER -->
    <div id="realtime-toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 max-w-sm w-full pointer-events-none px-4 sm:px-0"></div>
</body>
</html>
