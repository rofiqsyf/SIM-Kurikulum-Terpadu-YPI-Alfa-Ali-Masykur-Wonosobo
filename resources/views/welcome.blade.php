<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SIM Kurikulum Terpadu - YPI Alfa Ali Masykur Wonosobo</title>

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
                        'card': '0 1px 3px 0 rgba(15, 23, 42, 0.05), 0 1px 2px -1px rgba(15, 23, 42, 0.05)',
                        'floating': '0 10px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04)',
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-white text-slate-800 font-sans min-h-screen flex flex-col justify-between selection:bg-brand-100 selection:text-brand-900 antialiased">

    <!-- TOP NAVIGATION -->
    <header class="border-b border-slate-100 sticky top-0 bg-white/90 backdrop-blur-md z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 p-1 flex items-center justify-center shadow-subtle">
                    <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo Yayasan Ali Masykur" class="w-full h-full object-contain">
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-bold tracking-tight text-slate-900 leading-tight">SIM Kurikulum</span>
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">YPI Alfa Ali Masykur</span>
                </div>
            </div>

            <nav class="flex items-center gap-3 text-xs font-semibold">
                <a href="{{ route('sop.public') }}" class="text-slate-600 hover:text-slate-900 px-3 py-1.5 transition-colors hidden sm:inline flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base text-brand-700">menu_book</span>
                    <span>Standar Prosedur (SOP)</span>
                </a>
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white shadow-subtle transition-all">
                    <span>Masuk Portal</span>
                    <span class="material-symbols-outlined text-sm">login</span>
                </a>
            </nav>
        </div>
    </header>

    <!-- HERO SECTION -->
    <main class="flex-1">
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 text-center space-y-6">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-50 border border-slate-200/80 text-xs font-semibold text-slate-700 shadow-subtle">
                <span class="w-2 h-2 rounded-full bg-brand-600 animate-pulse"></span>
                <span>Tahun Ajaran 2024/2025 • Kurikulum Merdeka Plus</span>
            </div>

            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 max-w-4xl mx-auto leading-tight sm:leading-tight">
                Integrasi Kurikulum Terpadu 3 Unit Pendidikan
            </h1>

            <p class="text-sm sm:text-base text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Harmonisasi Capaian Pembelajaran Nasional dengan nilai-nilai kepesantrenan untuk MI Tahfidz, SMP, dan SMA Alfa Ali Masykur Wonosobo.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-brand-800 hover:bg-brand-900 text-white text-xs sm:text-sm font-semibold shadow-subtle transition-all">
                    <span>Akses Portal SIM Kurikulum</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
                <a href="{{ route('sop.public') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs sm:text-sm font-semibold transition-colors">
                    <span class="material-symbols-outlined text-base text-brand-800">menu_book</span>
                    <span>Standar Prosedur (SOP)</span>
                </a>
            </div>
        </section>

        <!-- 3 UNITS SHOWCASE -->
        <section id="unit-pendidikan" class="bg-[#f4f6fa] border-y border-slate-100 py-12 sm:py-16 scroll-mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <div class="text-center space-y-1">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Unit Lembaga Pendidikan</span>
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                        Tiga Jenjang dalam Satu Tata Kelola
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- MI -->
                    <div id="unit-mi" class="p-6 rounded-3xl bg-white border border-slate-100 shadow-card space-y-3 hover:border-teal-300 transition-all">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-teal-50 text-teal-800 border border-teal-200">
                            Fase A, B, C
                        </span>
                        <h3 class="text-base font-bold text-slate-900">MI Tahfidz Alfa Ali Masykur</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Kurikulum Merdeka berpadu KBC Kemenag dengan target hafalan Al-Qur'an Juz 30 dan pembentukan adab dini.
                        </p>
                    </div>

                    <!-- SMP -->
                    <div id="unit-smp" class="p-6 rounded-3xl bg-white border border-slate-100 shadow-card space-y-3 hover:border-blue-300 transition-all">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-blue-50 text-blue-800 border border-blue-200">
                            Fase D (Kls 7-9)
                        </span>
                        <h3 class="text-base font-bold text-slate-900">SMP Alfa Ali Masykur</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Penguatan literasi, numerasi, sains terpadu, Bahasa Arab, serta kitab fiqih dasar dan projek kokurikuler P5-RA.
                        </p>
                    </div>

                    <!-- SMA -->
                    <div id="unit-sma" class="p-6 rounded-3xl bg-white border border-slate-100 shadow-card space-y-3 hover:border-purple-300 transition-all">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-purple-50 text-purple-800 border border-purple-200">
                            Fase E & F (Kls 10-12)
                        </span>
                        <h3 class="text-base font-bold text-slate-900">SMA Alfa Ali Masykur</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Peminatan akademik MIPA & IPS, kajian Kitab Kuning Fathul Qorib, serta bimbingan masuk perguruan tinggi dan Timur Tengah.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ======================================================== -->
    <!-- FOOTER INSTANSI: SHORTCUT SEKOLAH & PONPES TERAFILIASI -->
    <!-- ======================================================== -->
    <footer class="bg-slate-950 text-slate-300 border-t border-slate-800">
        <!-- Main Footer Links Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10">

                <!-- Kolom 1: Profil Lembaga Induk / Yayasan (lg:col-span-4) -->
                <div class="lg:col-span-4 space-y-5">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-white p-1.5 flex items-center justify-center shadow-md">
                            <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo Yayasan Ali Masykur" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-white tracking-tight leading-tight">
                                YPI Al-Futuhiyyah Ali Masykur
                            </h3>
                            <p class="text-[11px] font-semibold text-brand-400 uppercase tracking-wider">
                                Yayasan Pendidikan Islam &amp; Pesantren • Wonosobo
                            </p>
                        </div>
                    </div>

                    <p class="text-xs text-slate-400 leading-relaxed">
                        Lembaga pendidikan Islam terintegrasi yang berakar dari rintisan dakwah <strong>KH. Masykur bin KH. Abu Hamid</strong> sejak 1951 di Bumen Bumirejo. Menyinergikan kurikulum nasional Kemendikbudristek &amp; Kemenag dengan khazanah kepesantrenan Salafiyah serta tahfidzul Qur'an santri.
                    </p>

                    <!-- Alamat & Kontak Resmi Nyata -->
                    <div class="space-y-2 text-xs text-slate-400 pt-1">
                        <div class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-sm text-brand-400 shrink-0 mt-0.5">location_on</span>
                            <span>Kompleks Ponpes Al-Futuhiyyah, Dusun Bumen, Desa Bumirejo, Kec. Mojotengah, Kab. Wonosobo, Jawa Tengah 56351 (Jl. Dieng Km. 05)</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-sm text-brand-400 shrink-0">mail</span>
                            <span class="font-mono text-[11px]">sekretariat@alimasykur.sch.id</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-sm text-brand-400 shrink-0">call</span>
                            <span>(0286) 321-456 • +62 812-2550-9988</span>
                        </div>
                    </div>
                </div>

                <!-- Kolom 2: Shortcut Sekolah & Madrasah Formal Asli (lg:col-span-3) -->
                <div class="lg:col-span-3 space-y-4">
                    <div class="border-b border-slate-800 pb-2">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-white flex items-center gap-2">
                            <span class="material-symbols-outlined text-brand-400 text-base">school</span>
                            <span>Sekolah &amp; Madrasah Formal</span>
                        </h4>
                    </div>

                    <ul class="space-y-2.5 text-xs">
                        <li>
                            <a href="#unit-mi" class="group block p-2.5 rounded-xl bg-slate-900/80 hover:bg-slate-800/80 border border-slate-800/80 hover:border-teal-500/50 transition-all">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-white group-hover:text-teal-300 transition-colors">MI Tahfidz Alfa Ali Masykur</span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-teal-950 text-teal-300 border border-teal-800/60">Kemenag</span>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1">Fase A, B, C • Tahfidz Juz 30 &amp; Kurikulum Terpadu</p>
                            </a>
                        </li>

                        <li>
                            <button type="button" onclick="openInstitusiModal('mts')" 
                                    class="w-full text-left group block p-2.5 rounded-xl bg-slate-900/80 hover:bg-slate-800/80 border border-slate-800/80 hover:border-emerald-500/50 transition-all cursor-pointer">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-white group-hover:text-emerald-300 transition-colors">MTs Al-Futuhiyyah Bumirejo</span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-950 text-emerald-300 border border-emerald-800/60">Kemenag</span>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1">Madrasah Tsanawiyah Berbasis Pesantren (Jl. Dieng Km. 5)</p>
                            </button>
                        </li>

                        <li>
                            <a href="#unit-smp" class="group block p-2.5 rounded-xl bg-slate-900/80 hover:bg-slate-800/80 border border-slate-800/80 hover:border-blue-500/50 transition-all">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-white group-hover:text-blue-300 transition-colors">SMP Alfa Ali Masykur</span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-blue-950 text-blue-300 border border-blue-800/60">Disdikbud</span>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1">Fase D (Kls 7-9) • Berdiri 2014 • Bilingual &amp; Sains</p>
                            </a>
                        </li>

                        <li>
                            <a href="#unit-sma" class="group block p-2.5 rounded-xl bg-slate-900/80 hover:bg-slate-800/80 border border-slate-800/80 hover:border-purple-500/50 transition-all">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-white group-hover:text-purple-300 transition-colors">SMA Alfa Ali Masykur</span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-purple-950 text-purple-300 border border-purple-800/60">Balai Dikmen</span>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1">Fase E &amp; F • MIPA/IPS, Riset, &amp; Kitab Kuning</p>
                            </a>
                        </li>

                        <li>
                            <button type="button" onclick="openInstitusiModal('tk')" 
                                    class="w-full text-left group block p-2 rounded-xl bg-slate-900/50 hover:bg-slate-800/60 border border-slate-800/60 hover:border-amber-500/40 transition-all cursor-pointer">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-slate-300 group-hover:text-amber-300 text-[11px] transition-colors">TK Islam Al-Futuhiyyah</span>
                                    <span class="text-[9px] px-1.5 py-0.2 rounded bg-amber-950/70 text-amber-300 border border-amber-800/50">PAUD / RA</span>
                                </div>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Kolom 3: Shortcut Pondok Pesantren Asli Terafiliasi (lg:col-span-3) -->
                <div class="lg:col-span-3 space-y-4">
                    <div class="border-b border-slate-800 pb-2">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-white flex items-center gap-2">
                            <span class="material-symbols-outlined text-brand-400 text-base">mosque</span>
                            <span>Pesantren Terafiliasi</span>
                        </h4>
                    </div>

                    <ul class="space-y-2.5 text-xs">
                        <li>
                            <button type="button" onclick="openInstitusiModal('alfutuhiyyah')" 
                                    class="w-full text-left group block p-2.5 rounded-xl bg-slate-900/80 hover:bg-slate-800/80 border border-slate-800/80 hover:border-brand-500/50 transition-all cursor-pointer">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-white group-hover:text-brand-300 transition-colors">PP. Al-Futuhiyyah (Pusat)</span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-950 text-emerald-300 border border-emerald-800/60">Perintis 1951</span>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1">Dirintis KH. Masykur • Sorogan &amp; Bandongan Kitab Kuning</p>
                            </button>
                        </li>

                        <li>
                            <button type="button" onclick="openInstitusiModal('fatkhulmuin')" 
                                    class="w-full text-left group block p-2.5 rounded-xl bg-slate-900/80 hover:bg-slate-800/80 border border-slate-800/80 hover:border-brand-500/50 transition-all cursor-pointer">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-white group-hover:text-brand-300 transition-colors">PP. Fatkhul Mu'in Ali Masykur</span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-950 text-emerald-300 border border-emerald-800/60">Kajian Fiqih</span>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1">Pendalaman Fathul Qorib, Ushul Fiqih, &amp; Tasawuf Salaf</p>
                            </button>
                        </li>

                        <li>
                            <button type="button" onclick="openInstitusiModal('tahfidz')" 
                                    class="w-full text-left group block p-2.5 rounded-xl bg-slate-900/80 hover:bg-slate-800/80 border border-slate-800/80 hover:border-brand-500/50 transition-all cursor-pointer">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-white group-hover:text-brand-300 transition-colors">PPTQ Al-Futuhiyyah Ali Masykur</span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-950 text-emerald-300 border border-emerald-800/60">Tahfidz 30 Juz</span>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1">Asrama Tahfidz Al-Qur'an Santri, Sanad, &amp; Muraja'ah Harian</p>
                            </button>
                        </li>

                        <li>
                            <button type="button" onclick="openInstitusiModal('madin')" 
                                    class="w-full text-left group block p-2.5 rounded-xl bg-slate-900/80 hover:bg-slate-800/80 border border-slate-800/80 hover:border-brand-500/50 transition-all cursor-pointer">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-white group-hover:text-brand-300 transition-colors">MDT Al-Futuhiyyah Bumirejo</span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-950 text-emerald-300 border border-emerald-800/60">Madin Sore</span>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1">Madrasah Diniyah Takmiliyah: Fiqih Ibadah &amp; Nahwu Shorof</p>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Kolom 4: Tautan Cepat & Dokumen Resmi (lg:col-span-2) -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="border-b border-slate-800 pb-2">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-white flex items-center gap-2">
                            <span class="material-symbols-outlined text-brand-400 text-base">link</span>
                            <span>Akses Portal</span>
                        </h4>
                    </div>

                    <ul class="space-y-2.5 text-xs text-slate-400">
                        <li>
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 font-bold text-brand-400 hover:text-brand-300 transition-colors">
                                <span class="material-symbols-outlined text-sm">login</span>
                                <span>Masuk Portal SIM</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('sop.public') }}" class="inline-flex items-center gap-2 hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-sm">menu_book</span>
                                <span>Standar Prosedur (SOP)</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('sop.public') }}#sop-01" class="inline-flex items-center gap-2 hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-sm">sync_alt</span>
                                <span>Alur Usulan Silabus</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('sop.public') }}#sop-04" class="inline-flex items-center gap-2 hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-sm">grading</span>
                                <span>Standar Tahfidz Santri</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('sop.public') }}#sop-unduhan" class="inline-flex items-center gap-2 hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-sm">download</span>
                                <span>Unduh Format Baku</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Legal Compliance Badge -->
                    <div class="pt-3 border-t border-slate-800">
                        <div class="p-3 rounded-xl bg-slate-900 border border-slate-800 text-[11px] space-y-1">
                            <span class="font-bold text-slate-300 block">Kepatuhan Regulasi:</span>
                            <p class="text-slate-500 leading-snug">
                                Permendikbudristek No. 12/2024 &amp; KMA No. 450/2024
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Sub-Footer / Copyright Bar -->
        <div class="border-t border-slate-800/80 bg-slate-950 py-5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <span>© 2024–2026 Yayasan Pendidikan Islam Al-Futuhiyyah Ali Masykur Wonosobo.</span>
                    <span class="hidden md:inline">•</span>
                    <span class="hidden md:inline">Seluruh Hak Cipta Dilindungi.</span>
                </div>
                <div class="flex items-center gap-3">
                    <span>Teknik Informatika UNSIQ</span>
                    <span>•</span>
                    <span class="inline-flex items-center gap-1.5 text-emerald-400 font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Sistem Aktif &amp; Terenkripsi</span>
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <!-- ======================================================== -->
    <!-- MODAL POPUP: PROFIL INSTITUSI & PESANTREN TERAFILIASI -->
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
                <button type="button" onclick="closeInstitusiModal()" class="p-1 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>

            <div class="space-y-3 text-xs text-slate-600 leading-relaxed">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Pengasuh / Pimpinan</span>
                    <p class="font-bold text-slate-900 text-sm" id="im-pimpinan">KH. Ahmad Rofiq Masykur / Keluarga Besar Masykur</p>
                </div>

                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Sejarah &amp; Profil Program</span>
                    <p id="im-desc" class="text-slate-600 leading-relaxed">-</p>
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Sinergi dengan SIM Kurikulum</span>
                    <p id="im-integrasi" class="text-slate-700 font-medium leading-relaxed">-</p>
                </div>
            </div>

            <div class="pt-2 flex items-center justify-end gap-2 border-t border-slate-100">
                <a href="{{ route('sop.public') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-all">
                    Lihat SOP Kurikulum &amp; Pesantren
                </a>
                <button type="button" onclick="closeInstitusiModal()" class="px-4 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Script Handler Modal Institusi -->
    <script>
        const institusiData = {
            alfutuhiyyah: {
                icon: 'mosque',
                badge: 'Pondok Pesantren Pusat (Berdiri 1951/1973)',
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
            mts: {
                icon: 'school',
                badge: 'Madrasah Tsanawiyah Formal (Kemenag)',
                title: 'MTs Al-Futuhiyyah Bumirejo Wonosobo',
                pimpinan: 'Kepala MTs Al-Futuhiyyah Bumirejo',
                desc: 'Madrasah Tsanawiyah formal berbasis pesantren yang beralamat di Jl. Dieng Km. 05, Bumen, Bumirejo, Mojotengah, Wonosobo. Memadukan kurikulum Kementerian Agama dengan muatan kepesantrenan Al-Futuhiyyah.',
                integrasi: 'Standar kompetensi keagamaan Kemenag dan asesmen madrasah disinergikan dengan kurikulum terpadu yayasan.'
            },
            tk: {
                icon: 'child_care',
                badge: 'Pendidikan Anak Usia Dini / RA',
                title: 'TK Islam Al-Futuhiyyah Bumirejo',
                pimpinan: 'Kepala TK Islam Al-Futuhiyyah',
                desc: 'Lembaga pendidikan prasekolah di kompleks Al-Futuhiyyah yang berfokus pada penanaman adab dini, doa-doa harian, hafalan surat pendek, dan stimulasi tumbuh kembang anak berbasis nilai Islam.',
                integrasi: 'Menjadi pondasi awal tahfidz dan adab sebelum santri melanjutkan ke jenjang MI Tahfidz Alfa Ali Masykur.'
            }
        };

        function openInstitusiModal(key) {
            const data = institusiData[key];
            if (!data) return;

            document.getElementById('im-icon').textContent = data.icon || 'mosque';
            document.getElementById('im-badge').textContent = data.badge;
            document.getElementById('im-title').textContent = data.title;
            document.getElementById('im-pimpinan').textContent = data.pimpinan;
            document.getElementById('im-desc').textContent = data.desc;
            document.getElementById('im-integrasi').textContent = data.integrasi;

            const modal = document.getElementById('institusi-modal');
            const backdrop = document.getElementById('institusi-modal-backdrop');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            backdrop.classList.remove('hidden');
        }

        function closeInstitusiModal() {
            const modal = document.getElementById('institusi-modal');
            const backdrop = document.getElementById('institusi-modal-backdrop');

            modal.classList.add('hidden');
            modal.classList.remove('flex');
            backdrop.classList.add('hidden');
        }
    </script>

</body>
</html>
