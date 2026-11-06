<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Standar Operasional Prosedur (SOP) Kurikulum - YPI Al-Futuhiyyah Ali Masykur</title>

    <!-- Favicon Logo Yayasan -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-yayasan.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-yayasan.png') }}">

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
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
                    boxShadow: {
                        'card': '0 1px 3px 0 rgba(15, 23, 42, 0.05), 0 1px 2px -1px rgba(15, 23, 42, 0.05)',
                        'subtle': '0 2px 5px 0 rgba(0, 0, 0, 0.04)',
                        'floating': '0 10px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04)',
                    }
                }
            }
        };
    </script>

    <style>
        /* Modern Scrollbar & Printing */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        @media print {
            header, footer, .no-print, #sidebar-col, #toast-container, #mobile-nav-wrapper {
                display: none !important;
            }
            .chapter-pane {
                display: block !important;
                margin-bottom: 3rem !important;
                page-break-inside: avoid;
            }
            .print-only-header {
                display: block !important;
            }
            body {
                background: white !important;
                color: black !important;
                font-size: 10pt !important;
            }
            .shadow-card, .shadow-subtle {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
            }
        }

        .print-only-header { display: none; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 font-sans min-h-screen flex flex-col justify-between selection:bg-brand-100 selection:text-brand-900 antialiased">

    <!-- ======================================================== -->
    <!-- NOTIFIKASI TOAST -->
    <!-- ======================================================== -->
    <div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <!-- ======================================================== -->
    <!-- KOP RESMI CETAK (Hanya Muncul Saat Print) -->
    <!-- ======================================================== -->
    <div class="print-only-header p-6 border-b-2 border-slate-900 mb-6">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo Yayasan" class="w-16 h-16 object-contain">
            <div>
                <h1 class="text-base font-bold uppercase tracking-tight text-slate-900">Yayasan Pendidikan Islam Al-Futuhiyyah Ali Masykur Wonosobo</h1>
                <p class="text-xs text-slate-600">Dusun Bumen, Desa Bumirejo, Kec. Mojotengah, Wonosobo, Jawa Tengah 56351 • sekretariat@alimasykur.sch.id</p>
                <p class="text-xs font-bold text-slate-800 mt-1">DOKUMEN RESMI STANDAR OPERASIONAL PROSEDUR (SOP) KURIKULUM TERPADU • SK NO. 042/YPI-AAM/VII/2024</p>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- HEADER RESMI INSTANSI -->
    <!-- ======================================================== -->
    <header class="border-b border-slate-200/80 sticky top-0 bg-white/95 backdrop-blur-md z-40 shadow-xs no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 p-1 flex items-center justify-center shadow-subtle group-hover:border-brand-500 transition-colors">
                        <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo Yayasan Ali Masykur" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold tracking-tight text-slate-900 leading-tight">SIM Kurikulum</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-brand-50 text-brand-800 border border-brand-200">SOP Resmi</span>
                        </div>
                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">YPI Al-Futuhiyyah Ali Masykur</span>
                    </div>
                </a>
            </div>

            <nav class="flex items-center gap-2.5 text-xs font-semibold">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all">
                    <span class="material-symbols-outlined text-base">home</span>
                    <span class="hidden sm:inline">Beranda</span>
                </a>
                
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-all cursor-pointer" title="Cetak Dokumen Lengkap (PDF)">
                    <span class="material-symbols-outlined text-base">print</span>
                    <span class="hidden md:inline">Cetak Dokumen</span>
                </button>

                <a href="{{ route('login') }}" 
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white shadow-subtle transition-all">
                    <span>Masuk Portal</span>
                    <span class="material-symbols-outlined text-sm">login</span>
                </a>
            </nav>
        </div>
    </header>


    <!-- ======================================================== -->
    <!-- HERO HEADER (TITLE & LEGAL CONTEXT) -->
    <!-- ======================================================== -->
    <main class="flex-1 pb-16">

        <section class="bg-white border-b border-slate-200/80 py-8 no-print">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
                
                <div class="flex flex-wrap items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-1.5 text-slate-500">
                        <a href="{{ url('/') }}" class="hover:text-brand-800 transition-colors">Beranda</a>
                        <span class="text-slate-300">/</span>
                        <span class="text-slate-700 font-medium">Tata Kelola Akademik</span>
                        <span class="text-slate-300">/</span>
                        <span class="font-bold text-brand-800">SOP-KUR-01</span>
                    </div>

                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-[11px] font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                        <span>SK Yayasan No. 042/YPI-AAM/VII/2024 • Berlaku Efektif T.A. 2024/2025 s.d. 2026/2027</span>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1.5 max-w-3xl">
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 leading-tight">
                            Standar Operasional Prosedur (SOP) Kurikulum Terpadu
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Pedoman baku tata kelola pembelajaran, perumusan Tujuan Pembelajaran (TP), modul ajar berdiferensiasi, verifikasi berjenjang oleh Waka &amp; Kepala Sekolah, jurnal KBM, dan supervisi akademik di lingkungan MI, MTs, SMP, dan SMA YPI Al-Futuhiyyah Ali Masykur Wonosobo.
                        </p>
                    </div>

                    <!-- Mode Baca Toggle Button -->
                    <div class="shrink-0 flex items-center gap-2">
                        <button type="button" id="toggle-full-mode-btn" onclick="toggleFullReadMode()" 
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-base" id="full-mode-icon">menu_book</span>
                            <span id="full-mode-label">Tampilkan Semua Bab</span>
                        </button>
                    </div>
                </div>

                <!-- 4 Highlights Stat Bar (Harmonis & Seimbang) -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 pt-2 text-xs">
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-0.5">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Dasar Hukum</span>
                        <div class="font-bold text-slate-900 leading-snug">Permendikbud &amp; KMA</div>
                        <p class="text-[11px] text-slate-500">Permendikbud 12/2024 &amp; KMA 450/2024</p>
                    </div>

                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-0.5">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Satuan Pendidikan</span>
                        <div class="font-bold text-slate-900 leading-snug">MI, MTs, SMP, SMA</div>
                        <p class="text-[11px] text-slate-500">Integrasi Pesantren Al-Futuhiyyah</p>
                    </div>

                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-0.5">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Batas SLA Usulan</span>
                        <div class="font-bold text-brand-800 leading-snug">Maksimal 3 Hari Kerja</div>
                        <p class="text-[11px] text-slate-500">Waka (2 hari) + Kepsek (1 hari)</p>
                    </div>

                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-0.5">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Siklus Pengawasan</span>
                        <div class="font-bold text-slate-900 leading-snug">Semesteran &amp; Tahunan</div>
                        <p class="text-[11px] text-slate-500">Audit Pengawas Disdikbud &amp; Kemenag</p>
                    </div>
                </div>

            </div>
        </section>


        <!-- ======================================================== -->
        <!-- 2-COLUMN DOCUMENTATION LAYOUT (PROPORSI HARMONIS & RAPI) -->
        <!-- ======================================================== -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Mobile Selector Dropdown (Hanya Tampil di Layar HP/Tablet) -->
            <div id="mobile-nav-wrapper" class="lg:hidden mb-6 no-print">
                <label for="mobile-chapter-select" class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">
                    Pilih Bab Pedoman SOP:
                </label>
                <div class="relative">
                    <select id="mobile-chapter-select" onchange="switchChapter(parseInt(this.value))" 
                            class="w-full pl-4 pr-10 py-3 bg-white border border-slate-200 rounded-2xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600 appearance-none shadow-subtle">
                        <option value="1">Bab 1 • Alur 4 Tahap Pengajuan Usulan Kurikulum</option>
                        <option value="2">Bab 2 • Standar Modul Ajar &amp; Taksonomi Bloom</option>
                        <option value="3">Bab 3 • Prosedur Jurnal KBM &amp; Agenda Digital</option>
                        <option value="4">Bab 4 • Standar Kontrol Mutu Setoran Tahfidz</option>
                        <option value="5">Bab 5 • Siklus Supervisi &amp; Matriks SLA Layanan</option>
                        <option value="6">Bab 6 • Unduhan Berkas Baku &amp; Tanya Jawab (FAQ)</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">unfold_more</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- ======================================================== -->
                <!-- SIDEBAR NAVIGASI BAB (KIRI: 4 Kolom di Desktop) -->
                <!-- ======================================================== -->
                <aside id="sidebar-col" class="hidden lg:block lg:col-span-4 sticky top-24 space-y-4 no-print">
                    
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-card p-4 space-y-3">
                        <div class="px-2 pt-1 pb-2 border-b border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Daftar Bab Pedoman</span>
                            <span class="text-[10px] font-bold text-brand-800 bg-brand-50 px-2 py-0.5 rounded-full">6 Bab Baku</span>
                        </div>

                        <!-- Menu Item Vertikal (Proporsional & Bersih) -->
                        <nav class="space-y-1 text-xs font-semibold" id="chapter-nav-list">
                            
                            <button type="button" onclick="switchChapter(1)" id="nav-btn-1" 
                                    class="nav-chapter-btn w-full flex items-center justify-between p-3 rounded-2xl bg-brand-50/80 border border-brand-200 text-brand-900 transition-all text-left cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-xl bg-brand-800 text-white flex items-center justify-center text-xs font-extrabold shrink-0">1</span>
                                    <div>
                                        <div class="font-bold text-slate-900 leading-snug">Alur 4 Tahap Usulan</div>
                                        <div class="text-[10.5px] text-slate-500 font-normal leading-tight">Mekanisme input &amp; pengesahan</div>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-sm text-brand-700">chevron_right</span>
                            </button>

                            <button type="button" onclick="switchChapter(2)" id="nav-btn-2" 
                                    class="nav-chapter-btn w-full flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 border border-transparent text-slate-700 transition-all text-left cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-xs font-extrabold shrink-0">2</span>
                                    <div>
                                        <div class="font-bold text-slate-900 leading-snug">Standar Modul &amp; Bloom</div>
                                        <div class="text-[10.5px] text-slate-500 font-normal leading-tight">6 Berkas &amp; KKO C1–C6</div>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-sm text-slate-400">chevron_right</span>
                            </button>

                            <button type="button" onclick="switchChapter(3)" id="nav-btn-3" 
                                    class="nav-chapter-btn w-full flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 border border-transparent text-slate-700 transition-all text-left cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-xs font-extrabold shrink-0">3</span>
                                    <div>
                                        <div class="font-bold text-slate-900 leading-snug">Jurnal KBM &amp; Agenda</div>
                                        <div class="text-[10.5px] text-slate-500 font-normal leading-tight">Ketentuan H+0 &amp; 6 Warna</div>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-sm text-slate-400">chevron_right</span>
                            </button>

                            <button type="button" onclick="switchChapter(4)" id="nav-btn-4" 
                                    class="nav-chapter-btn w-full flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 border border-transparent text-slate-700 transition-all text-left cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-xs font-extrabold shrink-0">4</span>
                                    <div>
                                        <div class="font-bold text-slate-900 leading-snug">Kontrol Mutu Tahfidz</div>
                                        <div class="text-[10.5px] text-slate-500 font-normal leading-tight">Target jenjang &amp; 4 predikat</div>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-sm text-slate-400">chevron_right</span>
                            </button>

                            <button type="button" onclick="switchChapter(5)" id="nav-btn-5" 
                                    class="nav-chapter-btn w-full flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 border border-transparent text-slate-700 transition-all text-left cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-xs font-extrabold shrink-0">5</span>
                                    <div>
                                        <div class="font-bold text-slate-900 leading-snug">Supervisi &amp; Matriks SLA</div>
                                        <div class="text-[10.5px] text-slate-500 font-normal leading-tight">Siklus audit &amp; wewenang peran</div>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-sm text-slate-400">chevron_right</span>
                            </button>

                            <button type="button" onclick="switchChapter(6)" id="nav-btn-6" 
                                    class="nav-chapter-btn w-full flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 border border-transparent text-slate-700 transition-all text-left cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-xs font-extrabold shrink-0">6</span>
                                    <div>
                                        <div class="font-bold text-slate-900 leading-snug">Format Berkas &amp; FAQ</div>
                                        <div class="text-[10.5px] text-slate-500 font-normal leading-tight">Unduhan template baku &amp; tanya-jawab</div>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-sm text-slate-400">chevron_right</span>
                            </button>

                        </nav>
                    </div>

                    <!-- Kartu Pintasan Akses Portal -->
                    <div class="p-4 rounded-3xl bg-slate-900 text-white space-y-3 shadow-card">
                        <div class="flex items-center gap-2 text-brand-400 text-xs font-bold">
                            <span class="material-symbols-outlined text-base">verified_user</span>
                            <span>Portal SIM Kurikulum</span>
                        </div>
                        <p class="text-[11px] text-slate-300 leading-relaxed">
                            Bagi guru dan pimpinan yang akan menyusun usulan silabus atau mengisi jurnal harian, silakan login ke portal.
                        </p>
                        <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-brand-800 hover:bg-brand-700 text-white font-bold text-xs transition-colors shadow-subtle">
                            <span>Buka Portal Pengguna</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>

                </aside>


                <!-- ======================================================== -->
                <!-- CONTENT UTAMA DOKUMEN (KANAN: 8 Kolom di Desktop) -->
                <!-- ======================================================== -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- ======================================================== -->
                    <!-- BAB 1: ALUR 4 TAHAP USULAN KURIKULUM -->
                    <!-- ======================================================== -->
                    <section id="chapter-pane-1" class="chapter-pane bg-white rounded-3xl border border-slate-200/80 shadow-card p-6 sm:p-8 space-y-6">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                            <div>
                                <span class="px-2.5 py-0.5 rounded-md font-mono text-[10px] font-bold bg-brand-50 text-brand-800 border border-brand-200">BAB 01 • PROSEDUR USULAN</span>
                                <h2 class="text-xl font-bold text-slate-900 mt-1">Alur 4 Tahap Pengajuan Usulan Kurikulum</h2>
                                <p class="text-xs text-slate-500 mt-0.5">Pedoman resmi pengusulan silabus, alokasi jam belajar (JP), dan verifikasi digital berjenjang.</p>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold self-start sm:self-center shrink-0">
                                SLA Total: Maksimal 3 Hari Kerja
                            </span>
                        </div>

                        <!-- 4 Tahap Berurutan (Vertical Clean Timeline) -->
                        <div class="space-y-4">
                            
                            <!-- Tahap 1 -->
                            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-6 h-6 rounded-lg bg-brand-800 text-white text-xs font-bold flex items-center justify-center">1</span>
                                        <h3 class="text-sm font-bold text-slate-900">Perumusan Sasaran Tujuan Pembelajaran (TP) &amp; Modul Ajar</h3>
                                    </div>
                                    <span class="text-[11px] font-semibold text-brand-800 bg-brand-50 px-2.5 py-0.5 rounded-full">Pekan 1–4 Awal Semester</span>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed pl-8">
                                    Guru pengampu menganalisis Capaian Pembelajaran (CP) nasional dari Kemendikbudristek/Kemenag. Rumuskan sasaran TP yang terukur menggunakan Kata Kerja Operasional (KKO) Taksonomi Bloom (C1 s.d. C6) serta integrasikan muatan kepesantrenan Salafiyah Ali Masykur (adab thalabul 'ilmi, dalil naqli tematik, rujukan kitab kuning).
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] pl-8 pt-1">
                                    <div class="text-slate-500"><strong>Pelaksana:</strong> Guru Mata Pelajaran Pengampu</div>
                                    <div class="text-slate-500"><strong>Keluaran:</strong> Draf Usulan TP &amp; Berkas Perangkat Ajar</div>
                                </div>
                            </div>

                            <!-- Tahap 2 -->
                            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-6 h-6 rounded-lg bg-slate-800 text-white text-xs font-bold flex items-center justify-center">2</span>
                                        <h3 class="text-sm font-bold text-slate-900">Pengajuan Digital &amp; Unggah Berkas di SIM Kurikulum</h3>
                                    </div>
                                    <span class="text-[11px] font-semibold text-slate-600 bg-slate-200/80 px-2.5 py-0.5 rounded-full">Maks. 1x24 Jam Kirim</span>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed pl-8">
                                    Pendidik masuk ke portal SIM Kurikulum pada menu Workspace Mata Pelajaran. Isi formulir digital alokasi Jam Pelajaran (JP), nomor TP, rincian materi, serta unggah dokumen perangkat ajar resmi dalam format PDF, Word (.docx), atau Excel (.xlsx) dengan ukuran berkas maksimal 10 MB per dokumen.
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] pl-8 pt-1">
                                    <div class="text-slate-500"><strong>Pelaksana:</strong> Guru Pengampu via Portal SIM</div>
                                    <div class="text-slate-500"><strong>Keluaran:</strong> Nomor Tiket Usulan (Status: Menunggu Review)</div>
                                </div>
                            </div>

                            <!-- Tahap 3 -->
                            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-6 h-6 rounded-lg bg-slate-800 text-white text-xs font-bold flex items-center justify-center">3</span>
                                        <h3 class="text-sm font-bold text-slate-900">Penelaahan Teknis Waka &amp; Pengesahan Kepala Sekolah</h3>
                                    </div>
                                    <span class="text-[11px] font-semibold text-brand-800 bg-brand-50 px-2.5 py-0.5 rounded-full">SLA: Maksimal 3 Hari Kerja</span>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed pl-8">
                                    Waka Kurikulum menelaah kelayakan pedagogis, pembagian jam mengajar, dan instrumen asesmen dalam waktu 2x24 jam kerja. Selanjutnya Kepala Sekolah menerbitkan keputusan formal: <strong>Disetujui</strong> (langsung teraktivasi) atau <strong>Perlu Revisi</strong> (disertai catatan evaluasi konstruktif untuk diperbaiki guru tanpa membuat tiket baru).
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] pl-8 pt-1">
                                    <div class="text-slate-500"><strong>Pelaksana:</strong> Waka Kurikulum &amp; Kepala Sekolah</div>
                                    <div class="text-slate-500"><strong>Keluaran:</strong> Surat Verifikasi &amp; Pembaruan Status Usulan</div>
                                </div>
                            </div>

                            <!-- Tahap 4 -->
                            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-6 h-6 rounded-lg bg-slate-800 text-white text-xs font-bold flex items-center justify-center">4</span>
                                        <h3 class="text-sm font-bold text-slate-900">Aktivasi Silabus Master &amp; Pengarsipan Portofolio Pengawas</h3>
                                    </div>
                                    <span class="text-[11px] font-semibold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full">Otomatis Seketika (Realtime)</span>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed pl-8">
                                    Materi yang telah disahkan otomatis terintegrasi ke dalam silabus aktif semester berjalan satuan, langsung dapat dipilih pada Jurnal Mengajar Harian kelas oleh guru, dan otomatis tercatat pada Portofolio Pengawasan Tahunan untuk audit pengawas Disdikbud &amp; Kemenag.
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] pl-8 pt-1">
                                    <div class="text-slate-500"><strong>Pelaksana:</strong> Sistem Informasi Kurikulum Otomatis</div>
                                    <div class="text-slate-500"><strong>Keluaran:</strong> Silabus Master Mutakhir &amp; Arsip Akreditasi</div>
                                </div>
                            </div>

                        </div>

                        <!-- 5 Kriteria Sukses Usulan Cepat Disetujui -->
                        <div class="p-5 rounded-2xl bg-white border border-slate-200 space-y-3">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-brand-700 text-base">checklist</span>
                                <span>Checklist Mandiri: 5 Kriteria Agar Usulan Kurikulum Cepat Disetujui</span>
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-slate-600">
                                <div class="flex items-start gap-2">
                                    <span class="w-4 h-4 rounded-md bg-brand-50 text-brand-700 border border-brand-200 flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">✓</span>
                                    <span><strong>Kesesuaian Fase:</strong> CP dan TP selaras dengan fase murid (A/B/C untuk MI, D untuk SMP, E/F untuk SMA).</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="w-4 h-4 rounded-md bg-brand-50 text-brand-700 border border-brand-200 flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">✓</span>
                                    <span><strong>KKO Operasional:</strong> Gunakan kata kerja Bloom terukur (hindari kata kerja abstrak seperti "mengetahui").</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="w-4 h-4 rounded-md bg-brand-50 text-brand-700 border border-brand-200 flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">✓</span>
                                    <span><strong>Muatan Kepesantrenan:</strong> Memuat adab belajar, dalil Al-Qur'an/Hadits, atau kitab kuning rujukan.</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="w-4 h-4 rounded-md bg-brand-50 text-brand-700 border border-brand-200 flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">✓</span>
                                    <span><strong>Rasio Jam Logis:</strong> Alokasi JP seimbang sesuai struktur kurikulum satuan pendidikan.</span>
                                </div>
                            </div>
                        </div>

                    </section>


                    <!-- ======================================================== -->
                    <!-- BAB 2: STANDAR MODUL & TAKSONOMI BLOOM -->
                    <!-- ======================================================== -->
                    <section id="chapter-pane-2" class="chapter-pane bg-white rounded-3xl border border-slate-200/80 shadow-card p-6 sm:p-8 space-y-6 hidden">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                            <div>
                                <span class="px-2.5 py-0.5 rounded-md font-mono text-[10px] font-bold bg-blue-50 text-blue-800 border border-blue-200">BAB 02 • STANDAR AKADEMIK</span>
                                <h2 class="text-xl font-bold text-slate-900 mt-1">Standar Modul Ajar &amp; Klasifikasi Taksonomi Bloom</h2>
                                <p class="text-xs text-slate-500 mt-0.5">6 dokumen resmi kurikulum merdeka serta klasifikasi Kata Kerja Operasional (KKO) Anderson-Krathwohl.</p>
                            </div>
                        </div>

                        <!-- 6 Dokumen Wajib Kurikulum Merdeka (Harmonis 2 Kolom) -->
                        <div class="space-y-3">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">6 Standar Dokumen Wajib Kurikulum Merdeka</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                                    <div class="flex items-center justify-between font-bold text-slate-900">
                                        <span>1. Dokumen KOSP / KOM</span>
                                        <span class="text-[10px] font-semibold text-slate-400">Tahunan</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500">Karakteristik satuan, visi-misi yayasan, profil lulusan, dan pengorganisasian pembelajaran.</p>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                                    <div class="flex items-center justify-between font-bold text-slate-900">
                                        <span>2. Matriks Alur TP (ATP)</span>
                                        <span class="text-[10px] font-semibold text-slate-400">Per Fase</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500">Rangkaian Tujuan Pembelajaran yang logis, terurut dari mudah ke kompleks per fase.</p>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                                    <div class="flex items-center justify-between font-bold text-slate-900">
                                        <span>3. Modul Ajar Berdiferensiasi</span>
                                        <span class="text-[10px] font-semibold text-slate-400">Semesteran</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500">Langkah belajar konten, proses, produk, asesmen formatif, dan LKPD kontekstual santri.</p>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                                    <div class="flex items-center justify-between font-bold text-slate-900">
                                        <span>4. Modul Projek P5-RA</span>
                                        <span class="text-[10px] font-semibold text-slate-400">Per Tema</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500">Tema kearifan lokal, kewirausahaan, dan profil pelajar berakhlak Rahmatan Lil Alamin.</p>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                                    <div class="flex items-center justify-between font-bold text-slate-900">
                                        <span>5. SK Pembagian Tugas &amp; 24 JP</span>
                                        <span class="text-[10px] font-semibold text-slate-400">Semesteran</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500">SK pembagian tugas mengajar guru memenuhi standar minimal beban 24 JP yayasan.</p>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                                    <div class="flex items-center justify-between font-bold text-slate-900">
                                        <span>6. Instrumen &amp; Rubrik Asesmen</span>
                                        <span class="text-[10px] font-semibold text-slate-400">Berkala</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500">Pedoman asesmen sumatif, kisi-kisi soal, dan Kriteria Ketercapaian TP (KKTP).</p>
                                </div>

                            </div>
                        </div>

                        <!-- Tabel Taksonomi Bloom (Rapi, Bersih, Proporsional) -->
                        <div class="space-y-3 pt-2">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Tabel Standar Taksonomi Bloom (Anderson-Krathwohl)</h3>
                            <div class="overflow-x-auto rounded-2xl border border-slate-200">
                                <table class="w-full text-left border-collapse text-xs min-w-[650px]">
                                    <thead>
                                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] uppercase tracking-wider text-slate-500 font-bold">
                                            <th class="py-3 px-4">Tingkat Kemampuan</th>
                                            <th class="py-3 px-4">Kata Kerja Operasional (KKO)</th>
                                            <th class="py-3 px-4">Contoh Mapel Umum</th>
                                            <th class="py-3 px-4">Contoh Muatan Pesantren</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-3 px-4 font-bold text-slate-900 whitespace-nowrap">
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 block w-max">C1 – C2 (LOTS)</span>
                                                <span class="text-[11px] text-slate-500 font-normal">Mengingat &amp; Memahami</span>
                                            </td>
                                            <td class="py-3 px-4">Menyebutkan, Mengidentifikasi, Menjelaskan, Mengartikan, Menghafal.</td>
                                            <td class="py-3 px-4 text-slate-600">Menyebutkan rumus luas bidang; Menjelaskan ciri makhluk hidup.</td>
                                            <td class="py-3 px-4 text-slate-600">Menghafal rukun wudhu dalam <em>Fathul Qorib</em>; Mengartikan mufradat bahasa Arab.</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-3 px-4 font-bold text-slate-900 whitespace-nowrap">
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-800 block w-max">C3 – C4 (MOTS)</span>
                                                <span class="text-[11px] text-blue-700 font-normal">Menerapkan &amp; Menganalisis</span>
                                            </td>
                                            <td class="py-3 px-4">Mengaplikasikan, Memecahkan, Menganalisis, Membandingkan, Mengkorelasikan.</td>
                                            <td class="py-3 px-4 text-slate-600">Menghitung rata-rata data statistik; Menganalisis perubahan energi fisika.</td>
                                            <td class="py-3 px-4 text-slate-600">Menghitung hisab zakat mal perniagaan; Menelaah kedudukan i'rob dalam <em>Jurumiyyah</em>.</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-3 px-4 font-bold text-slate-900 whitespace-nowrap">
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 block w-max">C5 – C6 (HOTS)</span>
                                                <span class="text-[11px] text-emerald-700 font-normal">Mengevaluasi &amp; Mencipta</span>
                                            </td>
                                            <td class="py-3 px-4">Menilai, Mengkritisi, Merancang, Mengkreasi, Menyimpulkan, Mengembangkan.</td>
                                            <td class="py-3 px-4 text-slate-600">Merancang percobaan filtrasi air sederhana; Menyusun esai argumentatif kritis.</td>
                                            <td class="py-3 px-4 text-slate-600">Merumuskan solusi masalah fiqih kontemporer santri; Membuat karya tulis bertema adab.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 3 Pilar Integrasi Pesantren -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2 text-xs">
                            <span class="font-bold text-slate-900 block">3 Pilar Integrasi Muatan Pesantren Salafiyah Ali Masykur</span>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-[11px] text-slate-600">
                                <div class="p-3 bg-white rounded-xl border border-slate-200">
                                    <strong class="text-brand-800 block mb-0.5">1. Adab Kesantrian</strong>
                                    <span>Penerapan adab ta'lim muta'allim, tawadhu' kepada guru, doa awal-akhir KBM, dan keberkahan sanad.</span>
                                </div>
                                <div class="p-3 bg-white rounded-xl border border-slate-200">
                                    <strong class="text-brand-800 block mb-0.5">2. Dalil Naqli Tematik</strong>
                                    <span>Menghubungkan konsep sains, matematika, dan sosial dengan ayat Al-Qur'an dan hadits shahih.</span>
                                </div>
                                <div class="p-3 bg-white rounded-xl border border-slate-200">
                                    <strong class="text-brand-800 block mb-0.5">3. Kitab Rujukan Salaf</strong>
                                    <span>Penguatan kajian kitab kuning (<em>Fathul Qorib, Jurumiyyah, Tuhfatul Athfal, Arbain Nawawiyah</em>).</span>
                                </div>
                            </div>
                        </div>

                    </section>


                    <!-- ======================================================== -->
                    <!-- BAB 3: JURNAL KBM & AGENDA DIGITAL -->
                    <!-- ======================================================== -->
                    <section id="chapter-pane-3" class="chapter-pane bg-white rounded-3xl border border-slate-200/80 shadow-card p-6 sm:p-8 space-y-6 hidden">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                            <div>
                                <span class="px-2.5 py-0.5 rounded-md font-mono text-[10px] font-bold bg-purple-50 text-purple-800 border border-purple-200">BAB 03 • TATA KELOLA KBM</span>
                                <h2 class="text-xl font-bold text-slate-900 mt-1">Prosedur Jurnal KBM &amp; Agenda Kerja Digital</h2>
                                <p class="text-xs text-slate-500 mt-0.5">Ketentuan pengisian kehadiran tatap muka harian dan pengelolaan kalender akademik.</p>
                            </div>
                        </div>

                        <!-- Ketentuan Jurnal KBM (H+0) & Presensi Santri -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3 text-xs">
                            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                <span class="material-symbols-outlined text-brand-800 text-base">event_available</span>
                                <span>Ketentuan Baku Jurnal Mengajar Kelas (KBM)</span>
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-slate-600 leading-relaxed">
                                <div class="p-3 bg-white rounded-xl border border-slate-200 space-y-1">
                                    <strong class="text-slate-900 block text-xs">1. Batas Waktu Pengisian (Aturan H+0)</strong>
                                    <span>Jurnal wajib diselesaikan pada hari yang sama setelah jam mengajar berakhir. Keterlambatan pengisian akan memicu notifikasi peringatan di dashboard pimpinan.</span>
                                </div>
                                <div class="p-3 bg-white rounded-xl border border-slate-200 space-y-1">
                                    <strong class="text-slate-900 block text-xs">2. Validasi Presensi Santri</strong>
                                    <span>Guru mencatat jumlah santri Hadir (H), Sakit (S), Izin (I), dan Alpa (A) secara teliti untuk sinkronisasi data presensi dengan pengurus asrama pondok.</span>
                                </div>
                                <div class="p-3 bg-white rounded-xl border border-slate-200 space-y-1">
                                    <strong class="text-slate-900 block text-xs">3. Keterkaitan dengan Sasaran TP</strong>
                                    <span>Setiap sesi pembelajaran wajib merujuk pada nomor Tujuan Pembelajaran (TP) yang tercantum di Silabus Master yang telah disahkan Kepala Sekolah.</span>
                                </div>
                                <div class="p-3 bg-white rounded-xl border border-slate-200 space-y-1">
                                    <strong class="text-slate-900 block text-xs">4. Catatan Refleksi Kelas</strong>
                                    <span>Guru mengisi catatan khusus apabila terdapat santri yang memerlukan remedial atau kendala sarana KBM untuk ditindaklanjuti wali kelas.</span>
                                </div>
                            </div>
                        </div>

                        <!-- 6 Kode Warna Murni Agenda Kalender -->
                        <div class="space-y-3 pt-2">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Standar 6 Kode Warna Agenda Kalender</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 text-xs font-semibold">
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-blue-600 shrink-0"></span>
                                    <div>
                                        <div class="text-slate-900">Biru</div>
                                        <div class="text-[10.5px] text-slate-500 font-normal">KBM Rutin Tatap Muka</div>
                                    </div>
                                </div>
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-emerald-600 shrink-0"></span>
                                    <div>
                                        <div class="text-slate-900">Hijau</div>
                                        <div class="text-[10.5px] text-slate-500 font-normal">Asesmen, PTS &amp; PAS</div>
                                    </div>
                                </div>
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-purple-600 shrink-0"></span>
                                    <div>
                                        <div class="text-slate-900">Ungu</div>
                                        <div class="text-[10.5px] text-slate-500 font-normal">Pengajian &amp; Pesantren</div>
                                    </div>
                                </div>
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-amber-600 shrink-0"></span>
                                    <div>
                                        <div class="text-slate-900">Amber</div>
                                        <div class="text-[10.5px] text-slate-500 font-normal">Rapat, Evaluasi &amp; MGMP</div>
                                    </div>
                                </div>
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-rose-600 shrink-0"></span>
                                    <div>
                                        <div class="text-slate-900">Merah</div>
                                        <div class="text-[10.5px] text-slate-500 font-normal">Tenggat Waktu / Urgen</div>
                                    </div>
                                </div>
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-teal-600 shrink-0"></span>
                                    <div>
                                        <div class="text-slate-900">Teal</div>
                                        <div class="text-[10.5px] text-slate-500 font-normal">Projek P5-RA &amp; Ekstra</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </section>


                    <!-- ======================================================== -->
                    <!-- BAB 4: STANDAR KONTROL MUTU TAHFIDZ -->
                    <!-- ======================================================== -->
                    <section id="chapter-pane-4" class="chapter-pane bg-white rounded-3xl border border-slate-200/80 shadow-card p-6 sm:p-8 space-y-6 hidden">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                            <div>
                                <span class="px-2.5 py-0.5 rounded-md font-mono text-[10px] font-bold bg-teal-50 text-teal-800 border border-teal-200">BAB 04 • KONTROL TAHFIDZ</span>
                                <h2 class="text-xl font-bold text-slate-900 mt-1">Standar Kontrol Mutu Setoran Tahfidz Al-Qur'an</h2>
                                <p class="text-xs text-slate-500 mt-0.5">Target capaian hafalan per jenjang satuan dan skala predikat kelancaran setoran santri.</p>
                            </div>
                        </div>

                        <!-- Target Jenjang (3 Satuan Pendidikan) -->
                        <div class="space-y-3">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Target Kelulusan Hafalan Berjenjang</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 text-xs">
                                
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                                    <div class="flex items-center justify-between font-bold text-slate-900">
                                        <span>MI Tahfidz Alfa</span>
                                        <span class="text-[10px] font-bold text-teal-800 bg-teal-50 px-2 py-0.5 rounded-full">Fase A, B, C</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 leading-relaxed">
                                        Fokus pada penguasaan makharijul huruf, tajwid dasar, kelancaran hafalan Juz 30 (An-Naas s.d. An-Naba'), doa harian, dan adab.
                                    </p>
                                    <div class="pt-2 border-t border-slate-200 text-brand-800 font-bold text-[11px]">
                                        Target: 1 – 2 Juz Mutqin
                                    </div>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                                    <div class="flex items-center justify-between font-bold text-slate-900">
                                        <span>SMP Alfa Ali Masykur</span>
                                        <span class="text-[10px] font-bold text-blue-800 bg-blue-50 px-2 py-0.5 rounded-full">Fase D</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 leading-relaxed">
                                        Hafalan lanjutan Juz 1 s.d. 5, tajwid matan <em>Tuhfatul Athfal</em>, fashahah, serta pembiasaan tadarus tartil santri mukim &amp; kalong.
                                    </p>
                                    <div class="pt-2 border-t border-slate-200 text-blue-800 font-bold text-[11px]">
                                        Target: 3 – 5 Juz Mutqin
                                    </div>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                                    <div class="flex items-center justify-between font-bold text-slate-900">
                                        <span>SMA Alfa Ali Masykur</span>
                                        <span class="text-[10px] font-bold text-purple-800 bg-purple-50 px-2 py-0.5 rounded-full">Fase E &amp; F</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 leading-relaxed">
                                        Volume hafalan mandiri, syahadah tahfidz, sanad tartil (khusus PPTQ Al-Futuhiyyah), dan pemahaman makna ayat ahkam.
                                    </p>
                                    <div class="pt-2 border-t border-slate-200 text-purple-800 font-bold text-[11px]">
                                        Target: 5 – 10 Juz (PPTQ: 30 Juz)
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Skala Predikat Kelancaran Setoran -->
                        <div class="space-y-3 pt-2">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Skala Predikat &amp; Tindak Lanjut Asrama</h3>
                            <div class="overflow-x-auto rounded-2xl border border-slate-200">
                                <table class="w-full text-left border-collapse text-xs min-w-[600px]">
                                    <thead>
                                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] uppercase tracking-wider text-slate-500 font-bold">
                                            <th class="py-3 px-4">Predikat Setoran</th>
                                            <th class="py-3 px-4">Rentang Skor</th>
                                            <th class="py-3 px-4">Kriteria Kelancaran &amp; Tajwid</th>
                                            <th class="py-3 px-4">Tindak Lanjut Asrama</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-3 px-4 font-bold text-emerald-800">Mumtaz</td>
                                            <td class="py-3 px-4 font-semibold">90 – 100</td>
                                            <td class="py-3 px-4">Lancar sempurna, makhraj fasih, tanpa ragu atau salah harakat.</td>
                                            <td class="py-3 px-4 text-slate-600">Lanjut ke surat/halaman berikutnya.</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-3 px-4 font-bold text-blue-800">Jayyid Jiddan</td>
                                            <td class="py-3 px-4 font-semibold">80 – 89</td>
                                            <td class="py-3 px-4">Sangat baik, terdapat maksimal 1–2 kali terhenti/ragu.</td>
                                            <td class="py-3 px-4 text-slate-600">Muraja'ah mandiri 1 kali lalu lanjut.</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-3 px-4 font-bold text-amber-800">Jayyid</td>
                                            <td class="py-3 px-4 font-semibold">70 – 79</td>
                                            <td class="py-3 px-4">Cukup lancar, terdapat kesalahan tajwid/panjang-pendek minor.</td>
                                            <td class="py-3 px-4 text-slate-600">Setor ulang ayat yang salah kepada ustadz.</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-3 px-4 font-bold text-rose-800">Maqbul</td>
                                            <td class="py-3 px-4 font-semibold">60 – 69</td>
                                            <td class="py-3 px-4">Banyak terhenti (> 3 kali) atau makhraj huruf belum tepat.</td>
                                            <td class="py-3 px-4 text-slate-600">Wajib bimbingan intensif halaqah asrama.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </section>


                    <!-- ======================================================== -->
                    <!-- BAB 5: SIKLUS SUPERVISI & MATRIKS SLA -->
                    <!-- ======================================================== -->
                    <section id="chapter-pane-5" class="chapter-pane bg-white rounded-3xl border border-slate-200/80 shadow-card p-6 sm:p-8 space-y-6 hidden">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                            <div>
                                <span class="px-2.5 py-0.5 rounded-md font-mono text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">BAB 05 • PENGAWASAN MUTU</span>
                                <h2 class="text-xl font-bold text-slate-900 mt-1">Siklus Supervisi &amp; Matriks SLA Waktu Layanan</h2>
                                <p class="text-xs text-slate-500 mt-0.5">Siklus pengawasan tahunan dan batas waktu tindak lanjut (Service Level Agreement).</p>
                            </div>
                        </div>

                        <!-- 3 Siklus Supervisi Akademik -->
                        <div class="space-y-3">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">3 Siklus Supervisi Pembelajaran</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 text-xs">
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                                    <span class="font-bold text-slate-900 block">1. Telaah Administrasi Awal</span>
                                    <p class="text-slate-500 leading-relaxed text-[11px]">
                                        Pemeriksaan kelengkapan dokumen ajar guru (CP, TP, ATP, Modul Ajar, Jadwal KBM) maksimal pekan ke-2 awal semester berjalan.
                                    </p>
                                </div>
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                                    <span class="font-bold text-slate-900 block">2. Observasi Kelas (KBM)</span>
                                    <p class="text-slate-500 leading-relaxed text-[11px]">
                                        Kepala Sekolah melakukan supervisi tatap muka langsung di kelas untuk mengamati diferensiasi ajar dan partisipasi santri.
                                    </p>
                                </div>
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                                    <span class="font-bold text-slate-900 block">3. Visitasi Pengawas Pembina</span>
                                    <p class="text-slate-500 leading-relaxed text-[11px]">
                                        Pengawas Disdikbud &amp; Kemenag memeriksa arsip digital di SIM Kurikulum secara periodik untuk akreditasi satuan pendidikan.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Matriks SLA & Tanggung Jawab -->
                        <div class="space-y-3 pt-2">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Matriks Tanggung Jawab &amp; Batas Waktu Layanan (SLA)</h3>
                            <div class="overflow-x-auto rounded-2xl border border-slate-200">
                                <table class="w-full text-left border-collapse text-xs min-w-[650px]">
                                    <thead>
                                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] uppercase tracking-wider text-slate-500 font-bold">
                                            <th class="py-3 px-4">Peran (Aktor)</th>
                                            <th class="py-3 px-4">Tanggung Jawab Utama</th>
                                            <th class="py-3 px-4">Hak Akses SIM</th>
                                            <th class="py-3 px-4 whitespace-nowrap">Batas Waktu (SLA)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-3 px-4 font-bold text-slate-900">Guru Pengampu</td>
                                            <td class="py-3 px-4">Penyusunan usulan TP, modul ajar, jurnal mengajar, dan setoran tahfidz santri.</td>
                                            <td class="py-3 px-4"><span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">Terkunci Unit &amp; Mapel</span></td>
                                            <td class="py-3 px-4 whitespace-nowrap font-medium text-slate-600">H+0 jam KBM selesai</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-3 px-4 font-bold text-slate-900">Waka Kurikulum</td>
                                            <td class="py-3 px-4">Penelaahan awal kelayakan pedagogis, pembagian jam mengajar, dan arsip dokumen.</td>
                                            <td class="py-3 px-4"><span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700">Seluruh mapel unitnya</span></td>
                                            <td class="py-3 px-4 whitespace-nowrap font-bold text-brand-800">Maks. 2x24 Jam Kerja</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-3 px-4 font-bold text-slate-900">Kepala Sekolah</td>
                                            <td class="py-3 px-4">Persetujuan final kurikulum (Disetujui/Revisi), supervisi kelas, dan validasi SK.</td>
                                            <td class="py-3 px-4"><span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800">Penuh pada unit pimpinan</span></td>
                                            <td class="py-3 px-4 whitespace-nowrap font-bold text-brand-800">Maks. 1x24 Jam Kerja</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-3 px-4 font-bold text-slate-900">Pengurus Yayasan</td>
                                            <td class="py-3 px-4">Monitoring terpadu 3 unit (MI, SMP, SMA), rasio beban 24 JP, dan muatan pesantren.</td>
                                            <td class="py-3 px-4"><span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700">Monitoring Lintas Unit</span></td>
                                            <td class="py-3 px-4 whitespace-nowrap font-medium text-slate-600">Audit Semesteran</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-3 px-4 font-bold text-slate-900">Pengawas Pembina</td>
                                            <td class="py-3 px-4">Validasi keselarasan standar nasional (Permendikbud &amp; KMA) dan audit akreditasi.</td>
                                            <td class="py-3 px-4"><span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700">Akses Portofolio Arsip</span></td>
                                            <td class="py-3 px-4 whitespace-nowrap font-medium text-slate-600">Siklus Tahunan</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-3 px-4 font-bold text-slate-900">Administrator SIM</td>
                                            <td class="py-3 px-4">Manajemen akun pengguna, reset sandi, penugasan mapel, dan respon helpdesk.</td>
                                            <td class="py-3 px-4"><span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700">Akses Penuh Sistem</span></td>
                                            <td class="py-3 px-4 whitespace-nowrap font-bold text-brand-800">&lt; 12 Jam Layanan</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </section>


                    <!-- ======================================================== -->
                    <!-- BAB 6: FORMAT BERKAS BAKU & FAQ -->
                    <!-- ======================================================== -->
                    <section id="chapter-pane-6" class="chapter-pane bg-white rounded-3xl border border-slate-200/80 shadow-card p-6 sm:p-8 space-y-6 hidden">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                            <div>
                                <span class="px-2.5 py-0.5 rounded-md font-mono text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">BAB 06 • INSTRUMEN &amp; FAQ</span>
                                <h2 class="text-xl font-bold text-slate-900 mt-1">Format Berkas Baku &amp; Tanya Jawab (FAQ)</h2>
                                <p class="text-xs text-slate-500 mt-0.5">Unduhan instrumen perangkat ajar resmi dan jawaban atas pertanyaan umum sistem.</p>
                            </div>
                        </div>

                        <!-- 3 Unduhan Dokumen Template Baku (Harmonis & Seragam) -->
                        <div class="space-y-3">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Instrumen Dokumen Baku (Siap Unduh &amp; Pratinjau)</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 text-xs">
                                
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3 flex flex-col justify-between">
                                    <div class="space-y-1">
                                        <div class="flex items-center justify-between">
                                            <strong class="text-slate-900 block">Modul Ajar (.docx)</strong>
                                            <span class="text-[10px] font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded">Word</span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 leading-relaxed">
                                            Format baku modul kurikulum merdeka berdiferensiasi dan integrasi nilai kepesantrenan.
                                        </p>
                                    </div>
                                    <div class="space-y-1.5 pt-2">
                                        <button type="button" onclick="previewTemplate('modul')" class="w-full py-1.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 font-semibold text-xs transition-colors cursor-pointer">
                                            Lihat Pratinjau
                                        </button>
                                        <button type="button" onclick="downloadTemplateFile('modul')" class="w-full py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs transition-colors cursor-pointer shadow-subtle flex items-center justify-center gap-1">
                                            <span class="material-symbols-outlined text-sm">download</span>
                                            <span>Unduh Berkas</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3 flex flex-col justify-between">
                                    <div class="space-y-1">
                                        <div class="flex items-center justify-between">
                                            <strong class="text-slate-900 block">Matriks ATP &amp; JP (.xlsx)</strong>
                                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">Excel</span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 leading-relaxed">
                                            Format matriks alur TP, distribusi beban jam pelajaran semesteran, dan KKO Bloom.
                                        </p>
                                    </div>
                                    <div class="space-y-1.5 pt-2">
                                        <button type="button" onclick="previewTemplate('atp')" class="w-full py-1.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 font-semibold text-xs transition-colors cursor-pointer">
                                            Lihat Pratinjau
                                        </button>
                                        <button type="button" onclick="downloadTemplateFile('atp')" class="w-full py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs transition-colors cursor-pointer shadow-subtle flex items-center justify-center gap-1">
                                            <span class="material-symbols-outlined text-sm">download</span>
                                            <span>Unduh Berkas</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3 flex flex-col justify-between">
                                    <div class="space-y-1">
                                        <div class="flex items-center justify-between">
                                            <strong class="text-slate-900 block">Rubrik Supervisi (.txt)</strong>
                                            <span class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded">Instrumen</span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 leading-relaxed">
                                            Instrumen telaah supervisi perangkat guru untuk Waka, Kepala Sekolah, dan Pengawas.
                                        </p>
                                    </div>
                                    <div class="space-y-1.5 pt-2">
                                        <button type="button" onclick="previewTemplate('rubrik')" class="w-full py-1.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 font-semibold text-xs transition-colors cursor-pointer">
                                            Lihat Pratinjau
                                        </button>
                                        <button type="button" onclick="downloadTemplateFile('rubrik')" class="w-full py-2 rounded-xl bg-rose-700 hover:bg-rose-800 text-white font-semibold text-xs transition-colors cursor-pointer shadow-subtle flex items-center justify-center gap-1">
                                            <span class="material-symbols-outlined text-sm">download</span>
                                            <span>Unduh Berkas</span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Tanya Jawab (FAQ) Accordion Rapi -->
                        <div class="space-y-3 pt-2">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Pertanyaan Sering Diajukan (FAQ)</h3>
                            <div class="space-y-2 text-xs">
                                
                                <details class="group p-4 rounded-2xl bg-slate-50 border border-slate-200 cursor-pointer">
                                    <summary class="font-bold text-slate-800 flex items-center justify-between">
                                        <span>Berapa batas waktu peninjauan usulan materi kurikulum oleh Kepala Sekolah?</span>
                                        <span class="material-symbols-outlined text-slate-400 group-open:rotate-180 transition-transform">expand_more</span>
                                    </summary>
                                    <p class="text-slate-600 mt-2 text-[11px] leading-relaxed">
                                        Sesuai SLA yang ditetapkan dalam SK Yayasan No. 042/YPI-AAM/VII/2024, Waka Kurikulum melakukan telaah teknis dalam waktu 2x24 jam kerja, dan Kepala Sekolah memberikan keputusan formal dalam waktu 1x24 jam kerja (total maksimal 3 hari kerja).
                                    </p>
                                </details>

                                <details class="group p-4 rounded-2xl bg-slate-50 border border-slate-200 cursor-pointer">
                                    <summary class="font-bold text-slate-800 flex items-center justify-between">
                                        <span>Bagaimana jika usulan materi kurikulum berstatus "Perlu Revisi"?</span>
                                        <span class="material-symbols-outlined text-slate-400 group-open:rotate-180 transition-transform">expand_more</span>
                                    </summary>
                                    <p class="text-slate-600 mt-2 text-[11px] leading-relaxed">
                                        Guru pengampu dapat membaca catatan perbaikan dari pimpinan pada tiket usulan, lalu mengedit data materi dan mengunggah dokumen revisi untuk diajukan kembali tanpa membuat usulan baru dari awal.
                                    </p>
                                </details>

                                <details class="group p-4 rounded-2xl bg-slate-50 border border-slate-200 cursor-pointer">
                                    <summary class="font-bold text-slate-800 flex items-center justify-between">
                                        <span>Format berkas apa saja yang diperbolehkan saat mengunggah modul ajar?</span>
                                        <span class="material-symbols-outlined text-slate-400 group-open:rotate-180 transition-transform">expand_more</span>
                                    </summary>
                                    <p class="text-slate-600 mt-2 text-[11px] leading-relaxed">
                                        Sistem mendukung berkas dokumen dalam format <strong>PDF (.pdf)</strong>, <strong>Microsoft Word (.docx)</strong>, dan <strong>Microsoft Excel (.xlsx)</strong> dengan batas ukuran maksimal 10 MB per dokumen.
                                    </p>
                                </details>

                            </div>
                        </div>

                    </section>

                </div>

            </div>

        </div>

    </main>


    <!-- ======================================================== -->
    <!-- FOOTER RESMI INSTANSI TERAFILIASI -->
    <!-- ======================================================== -->
    <footer class="bg-slate-950 text-slate-300 border-t border-slate-800 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8">
                
                <!-- Profil Yayasan (4 Kolom) -->
                <div class="lg:col-span-4 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white p-1 flex items-center justify-center shadow-md">
                            <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo Yayasan Ali Masykur" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white">YPI Al-Futuhiyyah Ali Masykur</h3>
                            <p class="text-[10px] text-brand-400 font-semibold uppercase tracking-wider">Yayasan Pendidikan Islam &amp; Pesantren</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Lembaga pendidikan Islam berakar dari rintisan dakwah <strong>KH. Masykur bin KH. Abu Hamid</strong> sejak 1951 di Bumen Bumirejo Wonosobo. Memadukan kurikulum nasional Kemendikbudristek &amp; Kemenag dengan khazanah kepesantrenan Salafiyah.
                    </p>
                    <div class="space-y-1 text-xs text-slate-400 pt-1">
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-sm text-brand-400 shrink-0 mt-0.5">location_on</span>
                            <span>Dusun Bumen, Desa Bumirejo, Mojotengah, Wonosobo, Jateng 56351 (Jl. Dieng Km. 05)</span>
                        </div>
                    </div>
                </div>

                <!-- Sekolah Formal (3 Kolom) -->
                <div class="lg:col-span-3 space-y-2.5 text-xs">
                    <h4 class="text-white font-bold uppercase tracking-wider border-b border-slate-800 pb-2">Sekolah &amp; Madrasah Formal</h4>
                    <ul class="space-y-2 text-slate-400">
                        <li>
                            <button type="button" onclick="openInstitusiModal('mi')" class="hover:text-white transition-colors text-left cursor-pointer">
                                <strong class="text-slate-200 block hover:text-brand-400">MI Tahfidz Alfa Ali Masykur</strong>
                                <span class="text-[11px] text-slate-400">Fase A, B, C • Tahfidz Juz 30 (Kemenag)</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="openInstitusiModal('mts')" class="hover:text-white transition-colors text-left cursor-pointer">
                                <strong class="text-slate-200 block hover:text-brand-400">MTs Al-Futuhiyyah Bumirejo</strong>
                                <span class="text-[11px] text-slate-400">Madrasah Berbasis Pesantren (Kemenag)</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="openInstitusiModal('smp')" class="hover:text-white transition-colors text-left cursor-pointer">
                                <strong class="text-slate-200 block hover:text-brand-400">SMP Alfa Ali Masykur</strong>
                                <span class="text-[11px] text-slate-400">Fase D • Berdiri 2014 • Sains &amp; Bahasa (Disdikbud)</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="openInstitusiModal('sma')" class="hover:text-white transition-colors text-left cursor-pointer">
                                <strong class="text-slate-200 block hover:text-brand-400">SMA Alfa Ali Masykur</strong>
                                <span class="text-[11px] text-slate-400">Fase E &amp; F • MIPA/IPS (Balai Dikmen Jateng)</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Pesantren Afiliasi (3 Kolom) -->
                <div class="lg:col-span-3 space-y-2.5 text-xs">
                    <h4 class="text-white font-bold uppercase tracking-wider border-b border-slate-800 pb-2">Pesantren Terafiliasi</h4>
                    <ul class="space-y-2 text-slate-400">
                        <li>
                            <button type="button" onclick="openInstitusiModal('alfutuhiyyah')" class="hover:text-white transition-colors text-left cursor-pointer">
                                <strong class="text-slate-200 block hover:text-brand-400">Pondok Pesantren Al-Futuhiyyah (Pusat)</strong>
                                <span class="text-[11px] text-slate-400">Dirintis 1951 • Sorogan &amp; Bandongan Kitab Kuning</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="openInstitusiModal('fatkhulmuin')" class="hover:text-white transition-colors text-left cursor-pointer">
                                <strong class="text-slate-200 block hover:text-brand-400">PP. Fatkhul Mu'in Ali Masykur</strong>
                                <span class="text-[11px] text-slate-400">Berdiri sejak 1980 • Pendalaman Fiqih Syafi'iyah</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="openInstitusiModal('tahfidz')" class="hover:text-white transition-colors text-left cursor-pointer">
                                <strong class="text-slate-200 block hover:text-brand-400">PPTQ Al-Futuhiyyah Ali Masykur</strong>
                                <span class="text-[11px] text-slate-400">Tahfidzul Qur'an 30 Juz &amp; Sanad Tartil</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="openInstitusiModal('madin')" class="hover:text-white transition-colors text-left cursor-pointer">
                                <strong class="text-slate-200 block hover:text-brand-400">MDT Al-Futuhiyyah Bumirejo</strong>
                                <span class="text-[11px] text-slate-400">Madrasah Diniyah Takmiliyah Sore</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Akses Cepat (2 Kolom) -->
                <div class="lg:col-span-2 space-y-2.5 text-xs">
                    <h4 class="text-white font-bold uppercase tracking-wider border-b border-slate-800 pb-2">Akses Cepat</h4>
                    <ul class="space-y-2 text-slate-400">
                        <li>
                            <a href="{{ route('login') }}" class="text-brand-400 font-bold hover:underline flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">login</span>
                                <span>Masuk Portal</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/') }}" class="hover:text-white transition-colors">Halaman Beranda</a>
                        </li>
                        <li>
                            <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="hover:text-white transition-colors text-left cursor-pointer">
                                Kembali ke Atas ↑
                            </button>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="border-t border-slate-800/80 bg-slate-950 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-500">
                <span>© 2024–2026 YPI Al-Futuhiyyah Ali Masykur Wonosobo. SOP Resmi Kurikulum.</span>
                <span class="inline-flex items-center gap-1.5 text-emerald-400 font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Sistem Terverifikasi Online</span>
                </span>
            </div>
        </div>
    </footer>


    <!-- ======================================================== -->
    <!-- MODAL POPUP: PROFIL INSTITUSI AFILIASI -->
    <!-- ======================================================== -->
    <div id="institusi-modal-backdrop" class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm z-50 hidden transition-opacity" onclick="closeInstitusiModal()"></div>
    <div id="institusi-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 space-y-5 shadow-2xl relative" onclick="event.stopPropagation()">
            <div class="flex items-start justify-between gap-3 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-xl" id="im-icon">mosque</span>
                    </div>
                    <div>
                        <span id="im-badge" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-brand-50 text-brand-800 border border-brand-200">Pesantren Terafiliasi</span>
                        <h3 id="im-title" class="text-base font-bold text-slate-900 mt-1">Nama Institusi</h3>
                    </div>
                </div>
                <button type="button" onclick="closeInstitusiModal()" class="p-1 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>

            <div class="space-y-3 text-xs text-slate-600 leading-relaxed">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Pengasuh / Pimpinan</span>
                    <p class="font-bold text-slate-900 text-sm" id="im-pimpinan">-</p>
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Sejarah &amp; Profil Program</span>
                    <p id="im-desc" class="text-slate-600 leading-relaxed">-</p>
                </div>
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Sinergi Kurikulum</span>
                    <p id="im-integrasi" class="text-slate-700 font-medium leading-relaxed">-</p>
                </div>
            </div>

            <div class="pt-2 flex items-center justify-end border-t border-slate-100">
                <button type="button" onclick="closeInstitusiModal()" class="px-4 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>


    <!-- ======================================================== -->
    <!-- MODAL POPUP: PRATINJAU FORMAT TEMPLATE -->
    <!-- ======================================================== -->
    <div id="preview-modal-backdrop" class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm z-50 hidden transition-opacity" onclick="closePreviewModal()"></div>
    <div id="preview-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-7 space-y-4 shadow-2xl relative max-h-[85vh] flex flex-col" onclick="event.stopPropagation()">
            <div class="flex items-start justify-between gap-3 pb-3 border-b border-slate-100 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-xl" id="pm-icon">description</span>
                    </div>
                    <div>
                        <span id="pm-badge" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-brand-50 text-brand-800 border border-brand-200">Format Resmi</span>
                        <h3 id="pm-title" class="text-base font-bold text-slate-900 mt-1">Pratinjau Format Dokumen</h3>
                    </div>
                </div>
                <button type="button" onclick="closePreviewModal()" class="p-1 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto pr-1 space-y-3 text-xs text-slate-700">
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 font-mono text-[11px] leading-relaxed whitespace-pre-wrap" id="pm-content">
                    Memuat isi format template...
                </div>
            </div>

            <div class="pt-3 flex items-center justify-between gap-2 border-t border-slate-100 shrink-0">
                <span class="text-[11px] text-slate-400">SK Yayasan No. 042/YPI-AAM/VII/2024</span>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="closePreviewModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-all cursor-pointer">
                        Tutup
                    </button>
                    <button type="button" id="pm-download-btn" onclick="" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all cursor-pointer">
                        <span class="material-symbols-outlined text-sm">download</span>
                        <span>Unduh Dokumen</span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- ======================================================== -->
    <!-- INTERACTIVE JAVASCRIPT HANDLER -->
    <!-- ======================================================== -->
    <script>
        let isFullMode = false;
        let activeChapter = 1;

        // Data Institusi Afiliasi
        const institusiData = {
            alfutuhiyyah: {
                icon: 'mosque',
                badge: 'Pondok Pesantren Pusat (Dirintis 1951)',
                title: 'Pondok Pesantren Al-Futuhiyyah Bumirejo',
                pimpinan: 'KH. Masykur bin KH. Abu Hamid (Pendiri) / KH. Ahmad Rofiq Masykur & Keluarga Besar',
                desc: 'Pondok pesantren induk di Dusun Bumen, Desa Bumirejo, Mojotengah, Wonosobo yang dirintis sejak tahun 1951. Menyelenggarakan pendidikan Islam salafiyah dengan metode sorogan dan bandongan kitab kuning, asrama santri putra dan putri, serta menjadi pusat pengajian masyarakat.',
                integrasi: 'Nilai-nilai kepesantrenan salafiyah Al-Futuhiyyah menjadi rujukan utama mata pelajaran Muatan Pesantren terpadu di SIM Kurikulum.'
            },
            fatkhulmuin: {
                icon: 'auto_stories',
                badge: 'Kajian Fiqih Salaf (Sejak 1980)',
                title: 'Pondok Pesantren Fatkhul Mu\'in Ali Masykur',
                pimpinan: 'Keluarga Besar KH. Ali Masykur & Dewan Asatidz',
                desc: 'Lembaga pesantren di Wonosobo yang didirikan sejak tahun 1980 dengan spesialisasi pengkajian kitab fiqih madzhab Syafi\'i secara mendalam, ushul fiqih, tafsir, dan tasawuf salaf.',
                integrasi: 'Silabus kajian fiqih dan hukum syariah diadopsi ke dalam Capaian Pembelajaran (CP) dan Tujuan Pembelajaran (TP) tingkat lanjut SMA dan SMP.'
            },
            tahfidz: {
                icon: 'menu_book',
                badge: 'Tahfidzul Qur\'an 30 Juz & Sanad',
                title: 'PPTQ Al-Futuhiyyah Ali Masykur (Pondok Tahfidz)',
                pimpinan: 'Ustadz Pembina Tahfidz & Dewan Penguji Al-Qur\'an',
                desc: 'Halaqah asrama khusus pembinaan hafalan Al-Qur\'an 30 Juz santri dengan sanad muttashil, tartil, fashahah, serta bimbingan setoran harian ba\'da Subuh dan ba\'da Maghrib.',
                integrasi: 'Setoran hafalan santri diinput langsung oleh guru/ustadz pembimbing melalui modul digital Jurnal & Kontrol Tahfidz di SIM Kurikulum secara realtime.'
            },
            madin: {
                icon: 'history_edu',
                badge: 'Madrasah Diniyah Takmiliyah',
                title: 'MDT Al-Futuhiyyah Bumirejo',
                pimpinan: 'Kepala MDT & Dewan Asatidz Diniyah',
                desc: 'Pendidikan diniyah komplementer sore hari bagi santri mukim dan kalong yang menitikberatkan pada fiqih ibadah praktis, tarikh Islam, nahwu shorof, dan pembiasaan adab kesantrian.',
                integrasi: 'Rekap kehadiran dan ketuntasan materi diniyah tersinkronisasi dalam catatan perkembangan karakter santri.'
            },
            mi: {
                icon: 'child_care',
                badge: 'Madrasah Ibtidaiyah Formal (Kemenag)',
                title: 'MI Tahfidz Alfa Ali Masykur',
                pimpinan: 'Kepala MI Tahfidz Alfa Ali Masykur',
                desc: 'Madrasah Ibtidaiyah formal terakreditasi Kemenag yang memadukan kurikulum merdeka dengan keunggulan tahfidz Juz 30 dan penanaman adab kesantrian sejak dini.',
                integrasi: 'Mengimplementasikan Kurikulum Merdeka Fase A, B, dan C dengan target tahfidz mutqin.'
            },
            mts: {
                icon: 'school',
                badge: 'Madrasah Tsanawiyah Formal (Kemenag)',
                title: 'MTs Al-Futuhiyyah Bumirejo Wonosobo',
                pimpinan: 'Kepala MTs Al-Futuhiyyah Bumirejo',
                desc: 'Madrasah Tsanawiyah formal berbasis pesantren di Jl. Dieng Km. 05 Bumen Bumirejo Mojotengah Wonosobo yang memadukan kurikulum Kemenag dengan muatan pesantren.',
                integrasi: 'Standar kompetensi keagamaan Kemenag disinergikan dengan silabus terpadu yayasan.'
            },
            smp: {
                icon: 'menu_book',
                badge: 'Sekolah Menengah Pertama (Disdikbud)',
                title: 'SMP Alfa Ali Masykur',
                pimpinan: 'Kepala SMP Alfa Ali Masykur',
                desc: 'Sekolah Menengah Pertama formal yang berdiri sejak 2014 di bawah Disdikbud Wonosobo. Unggul dalam program bilingual (Arab & Inggris) dan sains eksperimen.',
                integrasi: 'Modul ajar Fase D terhubung langsung dengan sistem verifikasi Waka Kurikulum.'
            },
            sma: {
                icon: 'domain',
                badge: 'Sekolah Menengah Atas (Balai Dikmen Jateng)',
                title: 'SMA Alfa Ali Masykur',
                pimpinan: 'Kepala SMA Alfa Ali Masykur',
                desc: 'Sekolah Menengah Atas unggulan berbasis pesantren yang menyiapkan santri menuju perguruan tinggi dan kemandirian riset dengan rumpun keilmuan MIPA, IPS, dan keagamaan.',
                integrasi: 'Projek penguatan profil pelajar (P5-RA) dan pemenuhan 24 JP guru tercatat di SIM Kurikulum.'
            }
        };

        // Data Template Pratinjau
        const templatePreviews = {
            modul: {
                icon: 'description',
                badge: 'Format Dokumen Word (.docx)',
                title: 'Format Baku Modul Ajar Berdiferensiasi',
                filename: 'Format_Modul_Ajar_Kurikulum_Merdeka_YPI_Ali_Masykur.doc',
                content: `FORMAT BAKU MODUL AJAR KURIKULUM MERDEKA BERDIFERENSIASI
YAYASAN PENDIDIKAN ISLAM AL-FUTUHIYYAH ALI MASYKUR WONOSOBO
SK YAYASAN NO. 042/YPI-AAM/VII/2024

I. INFORMASI UMUM
1. Nama Satuan Pendidikan  : [MI / SMP / SMA Alfa Ali Masykur]
2. Nama Guru Pengampu      : [Nama Lengkap & Gelar]
3. Mata Pelajaran          : [Nama Mata Pelajaran]
4. Fase / Kelas / Semester : [Fase ... / Kelas ... / Semester ...]
5. Alokasi Waktu           : [... JP x 40 Menit]
6. Integrasi Pesantren     : [Kitab Kuning / Dalil Naqli / Adab Santri]

II. KOMPONEN INTI
A. Capaian Pembelajaran (CP)
   [Salin Capaian Pembelajaran resmi sesuai Keputusan BSKAP/Kemenag]
B. Tujuan Pembelajaran (TP)
   1. Melalui telaah konsep, murid mampu [KKO Bloom C1-C6] [Materi Pokok].
   2. Dengan bimbingan guru, murid mampu [KKO Bloom] [Materi Pokok].
C. Pemahaman Bermakna & Pertanyaan Pemantik
   [Pertanyaan kontekstual kehidupan sehari-hari dan nilai kesantrian]
D. Kegiatan Pembelajaran Berdiferensiasi
   1. Pendahuluan (10 Menit): Doa pembuka, adab ta'lim, apersepsi.
   2. Kegiatan Inti (60 Menit):
      - Diferensiasi Konten (Teks, Audio, LKPD Bertingkat)
      - Diferensiasi Proses (Diskusi Kelompok, Bimbingan Mandiri)
      - Diferensiasi Produk (Portofolio, Presentasi, Resume)
   3. Penutup (10 Menit): Refleksi murid, doa kaffaratul majelis.

III. ASESMEN DAN LAMPIRAN
A. Asesmen Diagnostik (Awal Pembelajaran)
B. Asesmen Formatif (LKPD & Rubrik Observasi Sikap)
C. Asesmen Sumatif (Kriteria Ketercapaian TP / KKTP)
D. Bahan Bacaan Guru & Peserta Didik (Rujukan Kitab Kuning & Buku Siswa)`
            },
            atp: {
                icon: 'table_view',
                badge: 'Format Spreadsheet Excel (.xlsx)',
                title: 'Matriks Alur Tujuan Pembelajaran & Alokasi JP',
                filename: 'Matriks_Alur_Tujuan_Pembelajaran_ATP_dan_Alokasi_JP.csv',
                content: `MATRIKS ALUR TUJUAN PEMBELAJARAN (ATP) & ALOKASI JAM PELAJARAN (JP)
YPI AL-FUTUHIYYAH ALI MASYKUR WONOSOBO

Format Kolom:
No,Fase,Elemen Capaian,Kode TP,Narasi Tujuan Pembelajaran,KKO Bloom,Alokasi JP,Integrasi Pesantren,Bentuk Asesmen
1,Fase D,Bilangan,TP-01,Menghitung konsep hisab zakat perniagaan,C3,4 JP,Kitab Fathul Qorib,Formatif LKPD
2,Fase D,Aljabar,TP-02,Menganalisis pola persamaan linear,C4,4 JP,Karya Al-Khawarizmi,Sumatif Bab 1
3,Fase D,Geometri,TP-03,Mengukur besar sudut arah kiblat,C4,4 JP,Ilmu Falak Dasar,Projek Praktik`
            },
            rubrik: {
                icon: 'picture_as_pdf',
                badge: 'Instrumen Penilaian Resmi (.pdf)',
                title: 'Rubrik Telaah Supervisi Guru & Modul Ajar',
                filename: 'Rubrik_Supervisi_Akademik_Guru_Ali_Masykur.txt',
                content: `INSTRUMEN TELAAH SUPERVISI PERANGKAT AJAR GURU
YAYASAN PENDIDIKAN ISLAM AL-FUTUHIYYAH ALI MASYKUR
PETUGAS: WAKA KURIKULUM / KEPALA SEKOLAH / PENGAWAS

KOMPONEN PENILAIAN (SKALA 1 - 4):
1. Kejelasan Capaian Pembelajaran (CP) dan Alur TP
   - Kriteria: Runtut, logis, terukur, dan memenuhi target fase.
2. Keselarasan Taksonomi Bloom (KKO Operasional)
   - Kriteria: Memuat perpaduan seimbang LOTS, MOTS, dan HOTS.
3. Integrasi Muatan Lokal Kepesantrenan
   - Kriteria: Memuat nilai adab, dalil Al-Qur'an/Hadits, atau rujukan kitab salaf.
4. Rancangan Pembelajaran Berdiferensiasi
   - Kriteria: Memfasilitasi ragam kecepatan belajar santri mukim & non-mukim.
5. Kelengkapan Rubrik Asesmen & LKPD
   - Kriteria: Tersedia pedoman penskoran jelas dan instrumen refleksi.

HASIL KEPUTUSAN FORMAL SUPERVISI:
[ ] DISETUJUI TANPA REVISI (Skor 85 - 100) -> Terbit Surat Pengesahan Digital
[ ] PERLU REVISI (Skor < 85) -> Catatan Perbaikan Diberikan ke Guru Pengampu`
            }
        };

        // Ganti Bab Tampilan
        function switchChapter(chapNum) {
            activeChapter = chapNum;
            isFullMode = false;
            updateFullModeButton();

            // Sembunyikan semua bab dan tampilkan hanya yang dipilih
            for (let i = 1; i <= 6; i++) {
                const pane = document.getElementById('chapter-pane-' + i);
                const btn = document.getElementById('nav-btn-' + i);

                if (pane) {
                    if (i === chapNum) {
                        pane.classList.remove('hidden');
                    } else {
                        pane.classList.add('hidden');
                    }
                }

                if (btn) {
                    if (i === chapNum) {
                        btn.className = 'nav-chapter-btn w-full flex items-center justify-between p-3 rounded-2xl bg-brand-50/80 border border-brand-200 text-brand-900 transition-all text-left cursor-pointer';
                        const badge = btn.querySelector('span:first-child');
                        if (badge) badge.className = 'w-7 h-7 rounded-xl bg-brand-800 text-white flex items-center justify-center text-xs font-extrabold shrink-0';
                        const chevron = btn.querySelector('.material-symbols-outlined');
                        if (chevron) chevron.className = 'material-symbols-outlined text-sm text-brand-700';
                    } else {
                        btn.className = 'nav-chapter-btn w-full flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 border border-transparent text-slate-700 transition-all text-left cursor-pointer';
                        const badge = btn.querySelector('span:first-child');
                        if (badge) badge.className = 'w-7 h-7 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-xs font-extrabold shrink-0';
                        const chevron = btn.querySelector('.material-symbols-outlined');
                        if (chevron) chevron.className = 'material-symbols-outlined text-sm text-slate-400';
                    }
                }
            }

            // Update dropdown di tampilan HP/Tablet
            const select = document.getElementById('mobile-chapter-select');
            if (select) select.value = chapNum;

            // Scroll mulus ke atas konten jika berada di bawah
            const targetPane = document.getElementById('chapter-pane-' + chapNum);
            if (targetPane && window.scrollY > targetPane.offsetTop) {
                targetPane.scrollIntoView({ behavior: 'smooth' });
            }
        }

        // Toggle Tampilan Baca Penuh (Semua Bab)
        function toggleFullReadMode() {
            isFullMode = !isFullMode;
            updateFullModeButton();

            for (let i = 1; i <= 6; i++) {
                const pane = document.getElementById('chapter-pane-' + i);
                if (pane) {
                    if (isFullMode) {
                        pane.classList.remove('hidden');
                    } else {
                        if (i === activeChapter) {
                            pane.classList.remove('hidden');
                        } else {
                            pane.classList.add('hidden');
                        }
                    }
                }
            }

            if (isFullMode) {
                showToast('Menampilkan seluruh bab dalam satu lembar bacaan penuh.');
            } else {
                showToast('Kembali ke mode tampilan per bab.');
            }
        }

        function updateFullModeButton() {
            const btn = document.getElementById('toggle-full-mode-btn');
            const icon = document.getElementById('full-mode-icon');
            const label = document.getElementById('full-mode-label');

            if (isFullMode) {
                icon.textContent = 'view_agenda';
                label.textContent = 'Tampilan Per Bab';
                btn.className = 'inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-brand-50 border border-brand-200 text-brand-900 text-xs font-semibold transition-all cursor-pointer';
            } else {
                icon.textContent = 'menu_book';
                label.textContent = 'Tampilkan Semua Bab';
                btn.className = 'inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-all cursor-pointer';
            }
        }

        // Modal Profil Institusi
        function openInstitusiModal(key) {
            const data = institusiData[key];
            if (!data) return;

            document.getElementById('im-icon').textContent = data.icon;
            document.getElementById('im-badge').textContent = data.badge;
            document.getElementById('im-title').textContent = data.title;
            document.getElementById('im-pimpinan').textContent = data.pimpinan;
            document.getElementById('im-desc').textContent = data.desc;
            document.getElementById('im-integrasi').textContent = data.integrasi;

            document.getElementById('institusi-modal-backdrop').classList.remove('hidden');
            document.getElementById('institusi-modal').classList.remove('hidden');
            document.getElementById('institusi-modal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeInstitusiModal() {
            document.getElementById('institusi-modal-backdrop').classList.add('hidden');
            document.getElementById('institusi-modal').classList.add('hidden');
            document.getElementById('institusi-modal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Modal Pratinjau Template Dokumen
        function previewTemplate(type) {
            const t = templatePreviews[type];
            if (!t) return;

            document.getElementById('pm-icon').textContent = t.icon;
            document.getElementById('pm-badge').textContent = t.badge;
            document.getElementById('pm-title').textContent = t.title;
            document.getElementById('pm-content').textContent = t.content;

            const dlBtn = document.getElementById('pm-download-btn');
            dlBtn.onclick = function() {
                downloadTemplateFile(type);
            };

            document.getElementById('preview-modal-backdrop').classList.remove('hidden');
            document.getElementById('preview-modal').classList.remove('hidden');
            document.getElementById('preview-modal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closePreviewModal() {
            document.getElementById('preview-modal-backdrop').classList.add('hidden');
            document.getElementById('preview-modal').classList.add('hidden');
            document.getElementById('preview-modal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Unduh File Nyata via Blob
        function downloadTemplateFile(type) {
            const t = templatePreviews[type];
            if (!t) return;

            const blob = new Blob([t.content], { type: 'text/plain;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = t.filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);

            showToast('Berkas resmi "' + t.filename + '" berhasil diunduh.');
        }

        // Toast Notification System
        function showToast(message) {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'pointer-events-auto flex items-center gap-2.5 px-4 py-3 rounded-2xl bg-slate-900 text-white text-xs font-semibold shadow-2xl border border-slate-700 transition-all duration-300 transform translate-y-2 opacity-0';
            toast.innerHTML = `
                <span class="material-symbols-outlined text-base text-emerald-400">check_circle</span>
                <span>${message}</span>
            `;

            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
            });

            setTimeout(() => {
                toast.classList.add('opacity-0', '-translate-y-2');
                setTimeout(() => {
                    if (toast.parentNode) toast.parentNode.removeChild(toast);
                }, 300);
            }, 3500);
        }

        // Escape Key Listener
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeInstitusiModal();
                closePreviewModal();
            }
        });
    </script>
</body>
</html>