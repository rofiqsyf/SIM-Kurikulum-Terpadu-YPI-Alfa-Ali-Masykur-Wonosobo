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
                <a href="{{ route('guide.index') }}" class="text-slate-600 hover:text-slate-900 px-3 py-1.5 transition-colors hidden sm:inline">
                    Panduan SOP
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
                <a href="{{ route('guide.index') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs sm:text-sm font-semibold transition-colors">
                    <span>Standar Prosedur (SOP)</span>
                </a>
            </div>
        </section>

        <!-- 3 UNITS SHOWCASE -->
        <section class="bg-[#f4f6fa] border-y border-slate-100 py-12 sm:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <div class="text-center space-y-1">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Unit Lembaga Pendidikan</span>
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                        Tiga Jenjang dalam Satu Tata Kelola
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- MI -->
                    <div class="p-6 rounded-3xl bg-white border border-slate-100 shadow-card space-y-3">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-teal-50 text-teal-800 border border-teal-200">
                            Fase A, B, C
                        </span>
                        <h3 class="text-base font-bold text-slate-900">MI Tahfidz Alfa Ali Masykur</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Kurikulum Merdeka berpadu KBC Kemenag dengan target hafalan Al-Qur'an Juz 30 dan pembentukan adab dini.
                        </p>
                    </div>

                    <!-- SMP -->
                    <div class="p-6 rounded-3xl bg-white border border-slate-100 shadow-card space-y-3">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-blue-50 text-blue-800 border border-blue-200">
                            Fase D (Kls 7-9)
                        </span>
                        <h3 class="text-base font-bold text-slate-900">SMP Alfa Ali Masykur</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Penguatan literasi, numerasi, sains terpadu, Bahasa Arab, serta kitab fiqih dasar dan projek kokurikuler P5-RA.
                        </p>
                    </div>

                    <!-- SMA -->
                    <div class="p-6 rounded-3xl bg-white border border-slate-100 shadow-card space-y-3">
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

        <!-- 4 CORE CAPABILITIES -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 space-y-10">
            <div class="text-center space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kemampuan Sistem</span>
                <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                    Dirancang Berdasarkan Analisis Kebutuhan Nyata
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-xs">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-xl">account_tree</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Pohon Hierarki 3 Level</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Penyusunan Capaian Pembelajaran (CP), Tujuan Pembelajaran (TP), dan Rincian Materi secara terstruktur dan terukur.
                    </p>
                </div>

                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-xl">rate_review</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">SOP Verifikasi Transparan</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Usulan penambahan atau perubahan materi ditinjau oleh Kepala Sekolah dengan SLA 3 hari kerja dan catatan evaluasi pedagogis.
                    </p>
                </div>

                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-xl">domain</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Monitoring Terpadu Yayasan</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Pengurus Yayasan memantau pemenuhan kurikulum, rasio beban mengajar 24 JP, serta matriks integrasi muatan kepesantrenan.
                    </p>
                </div>

                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-xl">edit_calendar</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Jurnal & Kontrol Tahfidz</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Digitalisasi jurnal mengajar kelas dan buku kontrol setoran hafalan santri (solusi rekomendasi observasi lapangan).
                    </p>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="border-t border-slate-200/80 bg-white py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <span>© 2024–2026 Yayasan Pendidikan Islam Alfa Ali Masykur Wonosobo.</span>
            <div class="flex items-center gap-4">
                <span>Teknik Informatika UNSIQ</span>
                <span>•</span>
                <a href="{{ route('login') }}" class="font-semibold text-brand-800 hover:underline">Masuk Sistem →</a>
            </div>
        </div>
    </footer>

</body>
</html>
