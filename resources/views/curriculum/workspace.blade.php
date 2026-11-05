@extends('layouts.app')

@section('title', $viewMode === 'katalog' ? 'Katalog Mata Pelajaran & Silabus' : 'Silabus ' . ($selectedMapel->nama_mapel ?? 'Mata Pelajaran'))

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6 max-w-[1600px] mx-auto">

    <!-- 2-COLUMN CANVAS (Matches Reference UI Style) -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">

        <!-- ======================================================== -->
        <!-- MIDDLE / MAIN WORKSPACE AREA (xl:col-span-8 or 9) -->
        <!-- ======================================================== -->
        <div class="xl:col-span-8 2xl:col-span-9 space-y-6">

            <!-- TOPBAR: BREADCRUMB, DATE ROW & VIEW SWITCHER -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-slate-800 transition-colors">Beranda</a>
                    <span class="text-slate-300">/</span>
                    <span class="font-medium text-slate-700">Kurikulum Merdeka</span>
                    <span class="text-slate-300">/</span>
                    @if($viewMode === 'katalog')
                        <span class="font-semibold text-brand-800">Katalog Kartu Mapel</span>
                    @else
                        <a href="{{ route('curriculum.index', ['view' => 'katalog']) }}" class="hover:text-slate-800 transition-colors">Katalog Mapel</a>
                        <span class="text-slate-300">/</span>
                        <span class="font-semibold text-brand-800">{{ $selectedMapel->nama_mapel ?? 'Mata Pelajaran' }}</span>
                    @endif
                </div>

                <!-- View Mode Switcher Pills -->
                <div class="flex items-center gap-1 p-1 bg-white border border-slate-200/80 rounded-2xl shadow-subtle text-xs font-semibold self-start sm:self-center">
                    <a href="{{ route('curriculum.index', ['view' => 'katalog', 'unit_id' => $currentUnit->id]) }}" 
                       class="px-3.5 py-1.5 rounded-xl transition-all flex items-center gap-1.5 {{ $viewMode === 'katalog' ? 'bg-brand-800 text-white font-bold shadow-subtle' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        <span class="material-symbols-outlined text-sm">grid_view</span>
                        <span>Katalog Kartu Mapel</span>
                    </a>
                    <a href="{{ route('curriculum.index', ['view' => 'workspace', 'mapel_id' => $selectedMapel->id, 'unit_id' => $currentUnit->id]) }}" 
                       class="px-3.5 py-1.5 rounded-xl transition-all flex items-center gap-1.5 {{ $viewMode === 'workspace' ? 'bg-brand-800 text-white font-bold shadow-subtle' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        <span class="material-symbols-outlined text-sm">account_tree</span>
                        <span>Ruang Kerja Silabus</span>
                    </a>
                </div>
            </div>

            @if($viewMode === 'katalog')
                <!-- ======================================================== -->
                <!-- KATALOG VIEW: GRID DERETAN SHAPE MAPEL KONSISTEN -->
                <!-- ======================================================== -->

                <!-- HERO OVERVIEW CARD KATALOG -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative">
                    <div class="space-y-3.5 max-w-xl z-10">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-600 animate-pulse"></span>
                            <span>Direktori Lengkap • 3 Unit Pendidikan Terpadu</span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 leading-tight">
                            Katalog Mata Pelajaran &amp; Silabus
                        </h1>

                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Daftar seluruh mata pelajaran aktif tingkat MI Tahfidz, SMP, dan SMA Alfa Ali Masykur. Klik salah satu kartu mata pelajaran untuk mengeksplorasi hierarki CP, TP, dan modul materi.
                        </p>

                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <a href="{{ route('curriculum.index', ['mapel_id' => $selectedMapel->id, 'view' => 'workspace']) }}" 
                               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all">
                                <span>Buka Silabus {{ $selectedMapel->nama_mapel }}</span>
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                            <button type="button" onclick="window.print()" 
                                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-all cursor-pointer">
                                <span class="material-symbols-outlined text-base">print</span>
                                <span>Cetak Daftar Mapel</span>
                            </button>
                        </div>
                    </div>

                    <!-- 3D Isometric Book Graphic -->
                    <div class="shrink-0 flex items-center justify-center md:pr-4">
                        <svg class="w-36 h-32 sm:w-44 sm:h-38 drop-shadow-sm select-none" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M40 120 L120 160 L200 120 L120 80 Z" fill="#047857" />
                            <path d="M40 120 L40 135 L120 175 L120 160 Z" fill="#064e3b" />
                            <path d="M120 160 L120 175 L200 135 L200 120 Z" fill="#059669" />
                            <path d="M44 121 L44 130 L118 168 L118 159 Z" fill="#f8fafc" />
                            <path d="M122 159 L122 168 L196 130 L196 121 Z" fill="#e2e8f0" />

                            <path d="M50 95 L120 130 L190 95 L120 60 Z" fill="#3b82f6" />
                            <path d="M50 95 L50 108 L120 143 L120 130 Z" fill="#1d4ed8" />
                            <path d="M120 130 L120 143 L190 108 L190 95 Z" fill="#2563eb" />
                            <path d="M54 96 L54 104 L118 137 L118 129 Z" fill="#eff6ff" />
                            <path d="M122 129 L122 137 L186 104 L186 96 Z" fill="#dbeafe" />

                            <path d="M70 65 L130 95 L180 70 L120 40 Z" fill="#ffffff" stroke="#e2e8f0" stroke-width="1.5" />
                            <path d="M70 65 L70 70 L130 100 L130 95 Z" fill="#cbd5e1" />
                            <path d="M130 95 L130 100 L180 75 L180 70 Z" fill="#94a3b8" />
                            <circle cx="95" cy="62" r="2.5" fill="#047857" />
                            <line x1="103" y1="62" x2="140" y2="53" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                            <circle cx="103" cy="68" r="2.5" fill="#047857" />
                            <line x1="111" y1="68" x2="148" y2="59" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                </div>

                <!-- 4 METRICS TILES -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 text-xs">
                    <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-card flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Total Mata Pelajaran</span>
                            <span class="text-xl sm:text-2xl font-bold text-slate-900 mt-1 block">{{ $allCatalogMapel->count() }} Mapel</span>
                        </div>
                        <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-lg">auto_stories</span>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-card flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Total Sasaran TP</span>
                            <span class="text-xl sm:text-2xl font-bold text-emerald-700 mt-1 block">{{ $allCatalogMapel->sum('tujuan_pembelajaran_count') }} Sasaran</span>
                        </div>
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-lg">verified</span>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-card flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Unit Otoritas</span>
                            <span class="text-xl sm:text-2xl font-bold text-slate-900 mt-1 block">
                                {{ $user->canAccessAllUnits() ? '3 Lembaga' : ($currentUnit->kode_unit ?? 'Unit Anda') }}
                            </span>
                        </div>
                        <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-lg">{{ $user->canAccessAllUnits() ? 'domain' : 'verified_user' }}</span>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-card flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Muatan Pesantren</span>
                            <span class="text-xl sm:text-2xl font-bold text-purple-700 mt-1 block">{{ $allCatalogMapel->where('kategori', 'Muatan Pesantren')->count() }} Khas</span>
                        </div>
                        <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-lg">mosque</span>
                        </div>
                    </div>
                </div>

                <!-- FILTER & SEARCH TOOLBAR -->
                <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-card space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <!-- Unit Filter Pills or Locked Scope Badge -->
                        @if($user->canAccessAllUnits())
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mr-1">Lembaga:</span>
                                <button type="button" onclick="filterKatalogUnit('all')" id="katalog-tab-all" 
                                        class="katalog-unit-tab px-3.5 py-1.5 rounded-full text-xs font-bold transition-all bg-brand-800 text-white shadow-subtle cursor-pointer">
                                    Semua ({{ $allCatalogMapel->count() }})
                                </button>
                                <button type="button" onclick="filterKatalogUnit('MI-ALFA')" id="katalog-tab-MI-ALFA" 
                                        class="katalog-unit-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                    MI Tahfidz ({{ $allCatalogMapel->where('kurikulum.unit.kode_unit', 'MI-ALFA')->count() }})
                                </button>
                                <button type="button" onclick="filterKatalogUnit('SMP-ALFA')" id="katalog-tab-SMP-ALFA" 
                                        class="katalog-unit-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                    SMP Alfa ({{ $allCatalogMapel->where('kurikulum.unit.kode_unit', 'SMP-ALFA')->count() }})
                                </button>
                                <button type="button" onclick="filterKatalogUnit('SMA-ALFA')" id="katalog-tab-SMA-ALFA" 
                                        class="katalog-unit-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                    SMA Alfa ({{ $allCatalogMapel->where('kurikulum.unit.kode_unit', 'SMA-ALFA')->count() }})
                                </button>
                            </div>
                        @else
                            <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-2xl bg-brand-50 border border-brand-200/80 text-brand-900 text-xs font-bold shadow-subtle">
                                <span class="material-symbols-outlined text-base text-brand-700">lock</span>
                                <span>Lingkup Otoritas: <strong>{{ $currentUnit->nama_unit }}</strong> (Terkunci Sesuai Wewenang)</span>
                            </div>
                        @endif

                        <!-- Instant Live Search Bar -->
                        <div class="relative w-full sm:w-72">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base">search</span>
                            <input type="text" id="katalog-search-input" oninput="filterKatalogSearch(this.value)" 
                                   placeholder="Cari nama mapel, kode, atau guru..." 
                                   class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-2xl text-xs placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all">
                        </div>
                    </div>
                </div>

                <!-- DAFTAR DERETAN SHAPE MAPEL (GRID) -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900">Deretan Mata Pelajaran Terdaftar</h2>
                            <p class="text-[11px] text-slate-500">Klik kartu untuk membuka ruang kerja hierarki capaian pembelajaran dan silabus</p>
                        </div>
                        <span class="text-xs font-semibold text-slate-400" id="katalog-count-label">Menampilkan {{ $allCatalogMapel->count() }} kartu</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="katalog-cards-grid">
                        @php
                            $gradientPalettes = [
                                ['from' => 'from-[#3252a4]', 'to' => 'to-[#1b3472]', 'text_sub' => 'text-blue-200', 'badge_bg' => 'bg-blue-400/30'],
                                ['from' => 'from-[#495796]', 'to' => 'to-[#2b3564]', 'text_sub' => 'text-indigo-200', 'badge_bg' => 'bg-indigo-400/30'],
                                ['from' => 'from-[#7c3f6a]', 'to' => 'to-[#522345]', 'text_sub' => 'text-pink-200', 'badge_bg' => 'bg-pink-400/30'],
                                ['from' => 'from-[#0f766e]', 'to' => 'to-[#115e59]', 'text_sub' => 'text-teal-200', 'badge_bg' => 'bg-teal-400/30'],
                                ['from' => 'from-[#0369a1]', 'to' => 'to-[#075985]', 'text_sub' => 'text-sky-200', 'badge_bg' => 'bg-sky-400/30'],
                                ['from' => 'from-[#4338ca]', 'to' => 'to-[#3730a3]', 'text_sub' => 'text-indigo-200', 'badge_bg' => 'bg-indigo-400/30'],
                                ['from' => 'from-[#065f46]', 'to' => 'to-[#064e3b]', 'text_sub' => 'text-emerald-200', 'badge_bg' => 'bg-emerald-400/30'],
                                ['from' => 'from-[#6b21a8]', 'to' => 'to-[#581c87]', 'text_sub' => 'text-purple-200', 'badge_bg' => 'bg-purple-400/30'],
                            ];
                        @endphp

                        @foreach($allCatalogMapel as $idx => $mp)
                            @php
                                $palette = $gradientPalettes[$idx % count($gradientPalettes)];
                                $teacher = $mp->penugasanGuru->first()?->user;
                                $tpCount = $mp->tujuan_pembelajaran_count ?? $mp->tujuanPembelajaran->count();
                                $unitKode = $mp->kurikulum->unit->kode_unit ?? 'YPI';
                                $unitNama = $mp->kurikulum->unit->nama_unit ?? 'Unit Pendidikan';
                            @endphp
                            <a href="{{ route('curriculum.index', ['mapel_id' => $mp->id, 'view' => 'workspace']) }}" 
                               class="mapel-card-item rounded-3xl p-5 text-white shadow-card bg-gradient-to-br {{ $palette['from'] }} {{ $palette['to'] }} flex flex-col justify-between min-h-[185px] relative overflow-hidden group hover:-translate-y-1 hover:shadow-floating transition-all duration-200 cursor-pointer"
                               data-unit="{{ $unitKode }}"
                               data-search="{{ strtolower($mp->nama_mapel . ' ' . $mp->kode_mapel . ' ' . $unitNama . ' ' . ($teacher->name ?? '') . ' ' . $mp->kategori) }}">
                                
                                <div class="space-y-1.5 z-10">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold uppercase tracking-wider {{ $palette['text_sub'] }} truncate max-w-[190px]" title="{{ $unitNama }}">
                                            {{ $unitNama }} • {{ $mp->kode_mapel }}
                                        </span>
                                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-full {{ $palette['badge_bg'] }} text-white/90">
                                            {{ $mp->kategori ?? 'Intrakurikuler' }}
                                        </span>
                                    </div>
                                    
                                    <h3 class="text-sm font-bold text-white group-hover:text-amber-200 transition-colors line-clamp-2 leading-snug">
                                        {{ $mp->nama_mapel }}
                                    </h3>
                                </div>

                                <div class="space-y-3 pt-4 z-10">
                                    <!-- Avatar Stack -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center -space-x-1.5">
                                            <div class="w-6 h-6 rounded-full bg-white/20 border border-white/40 flex items-center justify-center text-[10px] font-bold text-white shadow-sm" title="{{ $teacher->name ?? 'Guru Mapel' }}">
                                                {{ substr($teacher->name ?? 'G', 0, 1) }}
                                            </div>
                                            <div class="w-6 h-6 rounded-full bg-white/10 border border-white/30 flex items-center justify-center text-[9px] font-bold text-white/80" title="Kepala Sekolah">
                                                KS
                                            </div>
                                            <div class="w-6 h-6 rounded-full bg-white/10 border border-white/30 flex items-center justify-center text-[9px] font-bold text-white/80" title="Waka Kurikulum">
                                                +3
                                            </div>
                                        </div>

                                        <span class="text-[11px] font-medium text-white/80 group-hover:text-white flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                            <span>Buka Silabus</span>
                                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-[11px] border-t border-white/15 pt-2">
                                        <span class="flex items-center gap-1 {{ $palette['text_sub'] }}">
                                            <span class="material-symbols-outlined text-sm">description</span>
                                            <span>{{ $tpCount }} Sasaran TP</span>
                                        </span>
                                        <span class="truncate max-w-[130px] text-right text-white font-medium" title="{{ $teacher->name ?? 'Dewan Guru' }}">
                                            {{ $teacher->name ?? 'Dewan Guru' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Decorative background circle -->
                                <div class="absolute -right-6 -bottom-6 w-24 h-24 rounded-full bg-white/5 pointer-events-none group-hover:scale-125 transition-transform duration-300"></div>
                            </a>
                        @endforeach
                    </div>
                </div>

            @else
                <!-- ======================================================== -->
                <!-- WORKSPACE VIEW: HIERARKI SILABUS CP -> TP -> MATERI -->
                <!-- ======================================================== -->

                <!-- BACK TO KATALOG BUTTON BANNER -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('curriculum.index', ['view' => 'katalog', 'unit_id' => $currentUnit->id]) }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white hover:bg-slate-50 border border-slate-200/80 text-xs font-semibold text-slate-700 shadow-subtle hover:text-brand-800 transition-all cursor-pointer">
                        <span class="material-symbols-outlined text-base text-brand-700">arrow_back</span>
                        <span>Kembali ke Katalog Kartu Mapel</span>
                    </a>

                    <div class="flex items-center gap-2 text-xs">
                        <span class="text-slate-400 font-medium">Mapel Aktif:</span>
                        <span class="px-3 py-1 rounded-xl bg-brand-50 text-brand-800 font-bold border border-brand-200/60 shadow-subtle">
                            {{ $selectedMapel->nama_mapel }}
                        </span>
                    </div>
                </div>

                <!-- HERO OVERVIEW CARD WORKSPACE -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative">
                    <div class="space-y-3.5 max-w-xl z-10">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-600"></span>
                            <span>{{ $selectedMapel->kategori ?? 'INTRAKURIKULER' }} • {{ $selectedMapel->kode_mapel ?? 'MP' }}</span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 leading-tight">
                            Silabus: {{ $selectedMapel->nama_mapel ?? 'Mata Pelajaran' }}
                        </h1>

                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Skema hierarki Kurikulum Merdeka: <strong>Capaian Pembelajaran (CP)</strong> ➔ <strong>Alur Tujuan Pembelajaran (ATP) &amp; Sasaran TP</strong> ➔ <strong>Modul &amp; Rincian Materi Ajar</strong>.
                        </p>

                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <button type="button" onclick="openGlobalProposalModal('TP', 'Perumusan TP Baru: {{ $selectedMapel->nama_mapel }}', null, null, '{{ $selectedMapel->id }}')" 
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all cursor-pointer">
                                <span class="material-symbols-outlined text-base">add_circle</span>
                                <span>Ajukan Usulan TP / Materi</span>
                            </button>

                            <button type="button" onclick="window.print()" 
                                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-all cursor-pointer">
                                <span class="material-symbols-outlined text-base">print</span>
                                <span>Cetak Silabus Resmi</span>
                            </button>
                        </div>
                    </div>

                    <!-- 3D Isometric Book Graphic -->
                    <div class="shrink-0 flex items-center justify-center md:pr-4">
                        <svg class="w-36 h-32 sm:w-44 sm:h-38 drop-shadow-sm select-none" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M40 120 L120 160 L200 120 L120 80 Z" fill="#047857" />
                            <path d="M40 120 L40 135 L120 175 L120 160 Z" fill="#064e3b" />
                            <path d="M120 160 L120 175 L200 135 L200 120 Z" fill="#059669" />
                            <path d="M44 121 L44 130 L118 168 L118 159 Z" fill="#f8fafc" />
                            <path d="M122 159 L122 168 L196 130 L196 121 Z" fill="#e2e8f0" />

                            <path d="M50 95 L120 130 L190 95 L120 60 Z" fill="#3b82f6" />
                            <path d="M50 95 L50 108 L120 143 L120 130 Z" fill="#1d4ed8" />
                            <path d="M120 130 L120 143 L190 108 L190 95 Z" fill="#2563eb" />
                            <path d="M54 96 L54 104 L118 137 L118 129 Z" fill="#eff6ff" />
                            <path d="M122 129 L122 137 L186 104 L186 96 Z" fill="#dbeafe" />

                            <path d="M70 65 L130 95 L180 70 L120 40 Z" fill="#ffffff" stroke="#e2e8f0" stroke-width="1.5" />
                            <path d="M70 65 L70 70 L130 100 L130 95 Z" fill="#cbd5e1" />
                            <path d="M130 95 L130 100 L180 75 L180 70 Z" fill="#94a3b8" />
                            <circle cx="95" cy="62" r="2.5" fill="#047857" />
                            <line x1="103" y1="62" x2="140" y2="53" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                            <circle cx="103" cy="68" r="2.5" fill="#047857" />
                            <line x1="111" y1="68" x2="148" y2="59" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                </div>

                <!-- 4 COMPACT METRICS TILES -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 text-xs">
                    <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-card flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Total Elemen CP</span>
                            <span class="text-xl sm:text-2xl font-bold text-slate-900 mt-1 block">{{ $totalCP }} Elemen</span>
                        </div>
                        <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-lg">schema</span>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-card flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Sasaran TP Aktif</span>
                            <span class="text-xl sm:text-2xl font-bold text-emerald-700 mt-1 block">{{ $totalTP }} Sasaran</span>
                        </div>
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-lg">verified</span>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-card flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Materi &amp; Sub-Materi</span>
                            <span class="text-xl sm:text-2xl font-bold text-slate-900 mt-1 block">{{ $totalMateri }} Rincian</span>
                        </div>
                        <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-lg">schedule</span>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-card flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Usulan Menunggu</span>
                            <span class="text-xl sm:text-2xl font-bold text-amber-700 mt-1 block">{{ $usulanMenunggu }} Berkas</span>
                        </div>
                        <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-lg">pending_actions</span>
                        </div>
                    </div>
                </div>

                <!-- FILTER & ACCORDION TOOLBAR -->
                <div class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-100 shadow-card space-y-3.5 text-xs">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">
                        <form method="GET" action="{{ route('curriculum.index') }}" class="flex flex-wrap items-center gap-3">
                            <input type="hidden" name="view" value="workspace">

                            <!-- Mapel Selector -->
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 font-semibold">Mapel:</span>
                                <select name="mapel_id" onchange="this.form.submit()" 
                                        class="bg-slate-50 border border-slate-200/80 rounded-xl px-3 py-1.5 text-slate-900 font-bold focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700">
                                    @foreach($availableMapel as $mp)
                                        <option value="{{ $mp->id }}" {{ $selectedMapel && $selectedMapel->id === $mp->id ? 'selected' : '' }}>
                                            {{ $mp->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Unit Selector -->
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 font-semibold">Unit:</span>
                                <select name="unit_id" onchange="this.form.submit()" 
                                        class="bg-slate-50 border border-slate-200/80 rounded-xl px-3 py-1.5 text-slate-900 font-bold focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700">
                                    @foreach(\App\Models\UnitPendidikan::all() as $u)
                                        <option value="{{ $u->id }}" {{ $currentUnit && $currentUnit->id === $u->id ? 'selected' : '' }}>
                                            {{ $u->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        <!-- Client Filter Field & Tree Toggle Buttons -->
                        <div class="flex items-center gap-2 w-full lg:w-auto">
                            <div class="relative flex-1 sm:w-64">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base">filter_list</span>
                                <input type="text" id="hierarchy-filter" onkeyup="filterTree(this.value)"
                                       placeholder="Saring capaian atau materi..." 
                                       class="w-full pl-9 pr-3 py-1.5 bg-slate-50 border border-slate-200/80 rounded-xl text-xs placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700">
                            </div>

                            <!-- Expand / Collapse All -->
                            <div class="flex items-center gap-1 shrink-0">
                                <button type="button" onclick="toggleAllTrees(true)" 
                                        class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors flex items-center gap-1" 
                                        title="Buka Semua Ranting Silabus">
                                    <span class="material-symbols-outlined text-base">unfold_more</span>
                                </button>
                                <button type="button" onclick="toggleAllTrees(false)" 
                                        class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors flex items-center gap-1" 
                                        title="Tutup Semua Ranting">
                                    <span class="material-symbols-outlined text-base">unfold_less</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Row: Filter TP Status Tabs -->
                    <div class="flex items-center gap-1.5 border-t border-slate-100 pt-3 flex-wrap">
                        <span class="text-slate-400 font-semibold text-[11px] mr-1">Status Pengesahan TP:</span>
                        <button type="button" onclick="filterTpStatus('all')" id="tp-filter-all" 
                                class="tp-status-tab px-3 py-1 rounded-full text-xs font-bold transition-all bg-brand-800 text-white shadow-subtle cursor-pointer">
                            Semua TP
                        </button>
                        <button type="button" onclick="filterTpStatus('Disetujui')" id="tp-filter-Disetujui" 
                                class="tp-status-tab px-3 py-1 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer">
                            Disetujui (Aktif)
                        </button>
                        <button type="button" onclick="filterTpStatus('Draft')" id="tp-filter-Draft" 
                                class="tp-status-tab px-3 py-1 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer">
                            Draf Usulan
                        </button>
                        <button type="button" onclick="filterTpStatus('Perlu Revisi')" id="tp-filter-Perlu Revisi" 
                                class="tp-status-tab px-3 py-1 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer">
                            Perlu Revisi
                        </button>
                    </div>
                </div>

                <!-- CP ACCORDION TREE CONTAINER -->
                <div class="space-y-4" id="cp-tree-container">
                    @forelse($capaianList as $cpIndex => $cp)
                        <div class="cp-card bg-white rounded-3xl border border-slate-200/80 shadow-card overflow-hidden transition-all" 
                             id="cp-card-{{ $cp->id }}"
                             data-title="{{ strtolower($cp->elemen . ' ' . $cp->deskripsi_cp . ' ' . $cp->kode_cp) }}">
                            
                            <!-- CP Header (Level 1: Capaian Pembelajaran) -->
                            <div class="p-5 sm:p-6 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between gap-4 cursor-pointer hover:bg-slate-100/70 transition-colors select-none"
                                 onclick="toggleCp('{{ $cp->id }}')">
                                <div class="flex items-start sm:items-center gap-3.5 min-w-0">
                                    <div class="w-10 h-10 rounded-2xl bg-brand-50 border border-brand-200 text-brand-800 flex items-center justify-center font-bold text-xs shrink-0 shadow-subtle">
                                        CP {{ $loop->iteration }}
                                    </div>

                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="font-extrabold text-slate-900 text-sm tracking-tight">
                                                Elemen: {{ $cp->elemen ?? 'Umum' }}
                                            </span>
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-200 text-slate-700">
                                                {{ $cp->kode_cp }}
                                            </span>
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-brand-50 text-brand-800 border border-brand-200/60">
                                                {{ $cp->fase->nama_fase ?? 'Fase D' }}
                                            </span>
                                        </div>

                                        <p class="text-xs text-slate-500 mt-1 line-clamp-1 leading-relaxed">
                                            {{ $cp->deskripsi_cp }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 shrink-0">
                                    <div class="hidden sm:flex items-center gap-2 text-right">
                                        <div class="text-[11px] font-semibold text-slate-400">Alokasi Beban</div>
                                        <div class="text-xs font-bold text-slate-800 bg-white px-2.5 py-1 rounded-xl border border-slate-200 shadow-subtle">
                                            {{ $cp->total_beban_jp }} JP
                                        </div>
                                    </div>

                                    <button type="button" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center shadow-subtle transition-transform duration-200" id="cp-toggle-btn-{{ $cp->id }}">
                                        <span class="material-symbols-outlined text-lg" id="cp-toggle-icon-{{ $cp->id }}">expand_less</span>
                                    </button>
                                </div>
                            </div>

                            <!-- CP Body: Tree of TP & Materi -->
                            <div class="cp-body p-5 sm:p-6 space-y-4" id="cp-body-{{ $cp->id }}">
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-xs text-slate-700 leading-relaxed">
                                    <strong class="font-semibold text-slate-900 block mb-1">Capaian Akhir Fase:</strong>
                                    {{ $cp->deskripsi_cp }}
                                </div>

                                <!-- TP List (Level 2: Tujuan Pembelajaran) -->
                                <div class="space-y-3 pt-2">
                                    <div class="flex items-center justify-between text-xs pb-1">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-slate-800 uppercase tracking-wider text-[11px]">Rangkaian Alur Tujuan Pembelajaran (ATP)</span>
                                            <span class="text-slate-400 font-semibold text-[11px]">({{ $cp->tujuanPembelajaran->count() }} Sasaran)</span>
                                        </div>

                                        <button type="button" onclick="openGlobalProposalModal('TP', 'Tambah TP pada Elemen {{ $cp->elemen }}', null, '{{ $cp->id }}', '{{ $selectedMapel->id }}')" 
                                                class="text-[11px] font-semibold text-brand-800 hover:underline flex items-center gap-1 cursor-pointer">
                                            <span class="material-symbols-outlined text-sm">add_circle</span>
                                            <span>Tambah TP ke CP Ini</span>
                                        </button>
                                    </div>

                                    <div class="space-y-3">
                                        @forelse($cp->tujuanPembelajaran as $tp)
                                            <div class="tp-card rounded-2xl border border-slate-200/90 p-4 bg-white shadow-subtle space-y-3 transition-colors hover:border-slate-300"
                                                 id="tp-card-{{ $tp->id }}"
                                                 data-title="{{ strtolower($tp->kode_tp . ' ' . $tp->deskripsi_tp) }}"
                                                 data-status="{{ $tp->status_pengesahan }}">
                                                
                                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                                                    <div class="space-y-1.5 flex-1 min-w-0">
                                                        <div class="flex items-center gap-2 flex-wrap">
                                                            <span class="font-mono font-bold text-xs text-brand-800 bg-brand-50 px-2.5 py-0.5 rounded-lg border border-brand-200/60">
                                                                {{ $tp->kode_tp }}
                                                            </span>

                                                            <!-- Status Tag -->
                                                            @if($tp->status_pengesahan === 'Disetujui')
                                                                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-emerald-800 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-full whitespace-nowrap leading-none">
                                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                                                    <span>Disetujui</span>
                                                                </span>
                                                            @elseif($tp->status_pengesahan === 'Perlu Revisi')
                                                                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-rose-800 bg-rose-50 border border-rose-200 px-2.5 py-0.5 rounded-full whitespace-nowrap leading-none">
                                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 shrink-0"></span>
                                                                    <span>Perlu Revisi</span>
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-amber-800 bg-amber-50 border border-amber-200 px-2.5 py-0.5 rounded-full whitespace-nowrap leading-none">
                                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0"></span>
                                                                    <span>Draf Usulan</span>
                                                                </span>
                                                            @endif

                                                            <span class="text-[11px] text-slate-400 font-medium">
                                                                {{ $tp->periode ?? 'Semester Ganjil' }}
                                                            </span>
                                                        </div>

                                                        <p class="text-xs font-semibold text-slate-800 leading-relaxed">
                                                            {{ $tp->deskripsi_tp }}
                                                        </p>
                                                    </div>

                                                    <div class="flex items-center gap-3 shrink-0 self-end sm:self-start">
                                                        <span class="text-xs font-bold text-slate-700 bg-slate-50 px-2.5 py-1 rounded-xl border border-slate-200">
                                                            {{ $tp->beban_jp }} JP
                                                        </span>

                                                        <button type="button" 
                                                                onclick="openGlobalProposalModal('TP', 'Revisi Sasaran: {{ $tp->kode_tp }}', '{{ $tp->id }}', '{{ $cp->id }}', '{{ $selectedMapel->id }}')" 
                                                                class="p-1.5 rounded-xl bg-slate-100 hover:bg-brand-50 hover:text-brand-800 text-slate-600 transition-colors"
                                                                title="Ajukan Usulan Perubahan TP Ini">
                                                            <span class="material-symbols-outlined text-base">edit</span>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Materi Silabus List (Level 3: Materi & Modul Ajar) -->
                                                <div class="border-t border-slate-100 pt-3 space-y-2">
                                                    <div class="flex items-center justify-between text-[11px]">
                                                        <span class="font-bold text-slate-400 uppercase tracking-wider">Materi &amp; Sub-Materi (Silabus Pembelajaran)</span>
                                                        <button type="button" 
                                                                onclick="openGlobalProposalModal('Materi', 'Tambah Materi Baru pada {{ $tp->kode_tp }}', null, '{{ $tp->id }}', '{{ $selectedMapel->id }}')" 
                                                                class="font-semibold text-brand-800 hover:underline flex items-center gap-1 cursor-pointer">
                                                            <span class="material-symbols-outlined text-xs">add</span>
                                                            <span>Tambah Materi</span>
                                                        </button>
                                                    </div>

                                                    <div class="space-y-2">
                                                        @forelse($tp->materi as $materi)
                                                            <div class="p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100/90 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs hover:bg-slate-100/60 transition-colors"
                                                                 id="materi-item-{{ $materi->id }}">
                                                                <div class="flex items-start gap-2.5 min-w-0 flex-1">
                                                                    <div class="w-7 h-7 rounded-xl bg-brand-50 text-brand-800 flex items-center justify-center shrink-0 mt-0.5 font-bold">
                                                                        <span class="material-symbols-outlined text-base">menu_book</span>
                                                                    </div>
                                                                    
                                                                    <div class="min-w-0 flex-1 space-y-1.5">
                                                                        <div class="flex items-center gap-2 flex-wrap">
                                                                            <span class="font-bold text-slate-800 text-xs sm:text-[13px] leading-snug" title="{{ $materi->judul_materi }}">
                                                                                {{ $materi->kode_materi ? '['.$materi->kode_materi.'] ' : '' }}{{ $materi->judul_materi }}
                                                                            </span>
                                                                            <span class="text-[10px] font-semibold text-slate-500 bg-white px-2 py-0.5 rounded-md border border-slate-200">
                                                                                {{ $materi->beban_jp }} JP
                                                                            </span>
                                                                        </div>

                                                                        @if($materi->media_ajar)
                                                                            <p class="text-[11px] text-slate-400 truncate max-w-md">
                                                                                Media: {{ $materi->media_ajar }}
                                                                            </p>
                                                                        @endif

                                                                        <!-- Attached Document / Upload Trigger Widget -->
                                                                        <div class="pt-1" id="materi-doc-box-{{ $materi->id }}">
                                                                            @if($materi->hasDocument())
                                                                                @php $badge = $materi->document_badge; @endphp
                                                                                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border {{ $badge['color'] }} bg-white shadow-2xs group">
                                                                                    <span class="material-symbols-outlined text-base shrink-0">{{ $badge['icon'] }}</span>
                                                                                    <div class="flex flex-col text-left min-w-0">
                                                                                        <a href="{{ route('curriculum.materi.download', $materi->id) }}" 
                                                                                           class="font-bold hover:underline truncate max-w-[170px] sm:max-w-xs text-xs text-slate-800" 
                                                                                           title="{{ $materi->file_name }}">
                                                                                            {{ $materi->file_name }}
                                                                                        </a>
                                                                                        <span class="text-[10px] text-slate-400 font-medium">
                                                                                            {{ $badge['type'] }} • {{ $materi->file_size }}
                                                                                        </span>
                                                                                    </div>
                                                                                    <div class="flex items-center gap-1 border-l border-slate-200 pl-2 ml-1">
                                                                                        <a href="{{ route('curriculum.materi.download', $materi->id) }}" 
                                                                                           class="p-1 rounded-lg hover:bg-slate-100 text-slate-600 transition-colors" 
                                                                                           title="Unduh Berkas Dokumen">
                                                                                            <span class="material-symbols-outlined text-sm">download</span>
                                                                                        </a>
                                                                                        <button type="button" 
                                                                                                onclick="openUploadMateriModal({{ $materi->id }}, '{{ addslashes($materi->judul_materi) }}', '{{ addslashes($selectedMapel->nama_mapel) }}', '{{ $tp->kode_tp }}')" 
                                                                                                class="p-1 rounded-lg hover:bg-slate-100 text-slate-600 transition-colors cursor-pointer" 
                                                                                                title="Ganti Berkas Dokumen">
                                                                                            <span class="material-symbols-outlined text-sm">change_circle</span>
                                                                                        </button>
                                                                                        <button type="button" 
                                                                                                onclick="deleteMateriDoc({{ $materi->id }})" 
                                                                                                class="p-1 rounded-lg hover:bg-rose-50 text-rose-500 transition-colors cursor-pointer" 
                                                                                                title="Hapus Dokumen">
                                                                                            <span class="material-symbols-outlined text-sm">close</span>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <button type="button" 
                                                                                        onclick="openUploadMateriModal({{ $materi->id }}, '{{ addslashes($materi->judul_materi) }}', '{{ addslashes($selectedMapel->nama_mapel) }}', '{{ $tp->kode_tp }}')" 
                                                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white hover:bg-brand-50 border border-slate-200 hover:border-brand-300 text-slate-600 hover:text-brand-800 text-[11px] font-semibold transition-all shadow-2xs cursor-pointer">
                                                                                    <span class="material-symbols-outlined text-sm text-brand-700">upload_file</span>
                                                                                    <span>Unggah Modul / Dokumen (PDF, Word, Excel)</span>
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="flex items-center gap-1 shrink-0 self-end sm:self-center">
                                                                    <button type="button" 
                                                                            onclick="openGlobalProposalModal('Materi', 'Revisi Materi: {{ $materi->judul_materi }}', '{{ $materi->id }}', '{{ $tp->id }}', '{{ $selectedMapel->id }}')" 
                                                                            class="p-1.5 rounded-xl hover:bg-slate-200 text-slate-400 hover:text-slate-700 transition-colors cursor-pointer"
                                                                            title="Ajukan Revisi Materi">
                                                                        <span class="material-symbols-outlined text-sm">edit</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="p-2.5 text-center text-slate-400 text-xs italic bg-slate-50/50 rounded-xl border border-dashed border-slate-200">
                                                                Belum ada materi terdaftar pada sasaran TP ini.
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="p-4 text-center text-slate-400 text-xs bg-white rounded-2xl border border-dashed border-slate-200">
                                                Belum ada Sasaran Tujuan Pembelajaran (TP) pada Capaian Pembelajaran ini.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white p-12 text-center rounded-3xl border border-slate-200/80 shadow-card">
                            <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">menu_book</span>
                            <p class="text-sm font-semibold text-slate-700">Belum ada data Capaian Pembelajaran</p>
                            <p class="text-xs text-slate-500 mt-1">Gunakan tombol "Ajukan Usulan" untuk merumuskan CP atau TP baru untuk mata pelajaran ini.</p>
                        </div>
                    @endforelse
                </div>
            @endif

        </div>

        <!-- ======================================================== -->
        <!-- RIGHT PANEL (MATA PELAJARAN SPECS & GUIDELINES) -->
        <!-- ======================================================== -->
        <div class="xl:col-span-4 2xl:col-span-3 space-y-6">

            @if($viewMode === 'katalog')
                @if($user->canAccessAllUnits())
                    <!-- 1. RINGKASAN DISTRIBUSI MAPEL 3 UNIT (PENGURUS YAYASAN & ADMIN) -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-4">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-brand-700 text-lg">domain</span>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Distribusi Mapel Lembaga</h4>
                            </div>
                        </div>

                        <div class="space-y-2.5 text-xs">
                            <div class="p-3 rounded-2xl bg-blue-50/70 border border-blue-100 flex items-center justify-between">
                                <div>
                                    <span class="font-bold text-blue-950 block">MI Tahfidz Alfa</span>
                                    <span class="text-[11px] text-blue-700">Fase A, B, C (Kelas 1-6)</span>
                                </div>
                                <span class="text-xs font-black px-2.5 py-1 rounded-full bg-blue-200 text-blue-900">
                                    {{ $allCatalogMapel->where('kurikulum.unit.kode_unit', 'MI-ALFA')->count() }} Mapel
                                </span>
                            </div>

                            <div class="p-3 rounded-2xl bg-emerald-50/70 border border-emerald-100 flex items-center justify-between">
                                <div>
                                    <span class="font-bold text-emerald-950 block">SMP Alfa Ali Masykur</span>
                                    <span class="text-[11px] text-emerald-700">Fase D (Kelas 7, 8, 9)</span>
                                </div>
                                <span class="text-xs font-black px-2.5 py-1 rounded-full bg-emerald-200 text-emerald-900">
                                    {{ $allCatalogMapel->where('kurikulum.unit.kode_unit', 'SMP-ALFA')->count() }} Mapel
                                </span>
                            </div>

                            <div class="p-3 rounded-2xl bg-purple-50/70 border border-purple-100 flex items-center justify-between">
                                <div>
                                    <span class="font-bold text-purple-950 block">SMA Alfa Ali Masykur</span>
                                    <span class="text-[11px] text-purple-700">Fase E &amp; F (Kelas 10-12)</span>
                                </div>
                                <span class="text-xs font-black px-2.5 py-1 rounded-full bg-purple-200 text-purple-900">
                                    {{ $allCatalogMapel->where('kurikulum.unit.kode_unit', 'SMA-ALFA')->count() }} Mapel
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- 1. RINGKASAN OTORITAS UNIT PENDIDIKAN (SCOPED USER) -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-4">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-brand-700 text-lg">verified_user</span>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Otoritas Unit Anda</h4>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-brand-100 text-brand-800">{{ $currentUnit->kode_unit }}</span>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70 space-y-1.5">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Satuan Pendidikan</span>
                                <span class="font-bold text-slate-900 text-sm block leading-snug">{{ $currentUnit->nama_unit }}</span>
                                <span class="text-[11px] text-slate-500 block">Kepala Sekolah: {{ $currentUnit->kepala_sekolah ?? '-' }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 text-center">
                                <div class="p-2.5 rounded-2xl bg-brand-50/60 border border-brand-100">
                                    <span class="text-[10px] font-bold text-brand-700 block uppercase">Mapel Unit</span>
                                    <span class="text-base font-extrabold text-brand-900">{{ $allCatalogMapel->count() }} Mapel</span>
                                </div>
                                <div class="p-2.5 rounded-2xl bg-emerald-50/60 border border-emerald-100">
                                    <span class="text-[10px] font-bold text-emerald-700 block uppercase">Total TP</span>
                                    <span class="text-base font-extrabold text-emerald-900">{{ $allCatalogMapel->sum('tujuan_pembelajaran_count') }} TP</span>
                                </div>
                            </div>

                            <p class="text-[11px] text-slate-400 leading-relaxed italic">
                                Sesuai regulasi tata kelola YPI Alfa Ali Masykur, ruang kerja Anda terisolasi secara aman pada unit pendidikan ini.
                            </p>
                        </div>
                    </div>
                @endif

                <!-- 2. PANDUAN STRUKTUR SILABUS -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-3">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <span class="material-symbols-outlined text-brand-700 text-lg">schema</span>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Struktur Kurikulum Merdeka</h4>
                    </div>
                    <div class="space-y-2 text-xs text-slate-600 leading-relaxed">
                        <p>
                            Pilih salah satu kartu mata pelajaran di samping untuk melihat rincian <strong>Capaian Pembelajaran (CP)</strong>, merumuskan <strong>Tujuan Pembelajaran (TP)</strong>, serta modul materi ajar.
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('guide.index') }}" class="text-xs font-bold text-brand-800 hover:underline flex items-center gap-1">
                                <span>Baca Panduan SOP Formulasi TP</span>
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>

            @else
                <!-- 1. MAPEL PROFILE CARD -->
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-card p-6 text-center space-y-3">
                    <div class="w-16 h-16 rounded-full bg-brand-50 border border-brand-200 flex items-center justify-center text-brand-800 mx-auto shadow-subtle">
                        <span class="material-symbols-outlined text-3xl">auto_stories</span>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-slate-900">{{ $selectedMapel->nama_mapel }}</h3>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">
                            {{ $currentUnit->nama_unit ?? 'Unit Pendidikan' }} • Kode: {{ $selectedMapel->kode_mapel }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-2 pt-2 text-center">
                        <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Kategori</span>
                            <span class="text-xs font-bold text-slate-800">{{ $selectedMapel->kategori ?? 'Intrakurikuler' }}</span>
                        </div>
                        <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Beban JP</span>
                            <span class="text-xs font-bold text-brand-800">4 JP / Pekan</span>
                        </div>
                    </div>
                </div>

                <!-- 2. TAKSONOMI BLOOM GUIDELINES WIDGET (INTERACTIVE KKO BUILDER) -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-3.5">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-brand-700 text-lg">psychology</span>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Taksonomi Bloom (KKO)</h4>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">Klik KKO</span>
                    </div>

                    <div class="space-y-2.5 text-xs">
                        <!-- C1-C2 -->
                        <div class="p-3 rounded-2xl bg-blue-50/60 border border-blue-100 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-0.5 rounded-lg bg-blue-100 text-blue-800 font-bold text-[10px]">C1 - C2</span>
                                <span class="font-bold text-slate-800">Mengingat &amp; Memahami</span>
                            </div>
                            <div class="flex flex-wrap gap-1.5 pt-0.5">
                                <button type="button" onclick="copyKko('Menyebutkan (C1)')" class="kko-pill px-2 py-0.5 rounded-lg bg-white border border-blue-200 text-blue-900 text-[10px] font-medium hover:bg-blue-600 hover:text-white transition-colors" title="Klik untuk menyalin">Menyebutkan</button>
                                <button type="button" onclick="copyKko('Menghafal (C1)')" class="kko-pill px-2 py-0.5 rounded-lg bg-white border border-blue-200 text-blue-900 text-[10px] font-medium hover:bg-blue-600 hover:text-white transition-colors" title="Klik untuk menyalin">Menghafal</button>
                                <button type="button" onclick="copyKko('Menjelaskan (C2)')" class="kko-pill px-2 py-0.5 rounded-lg bg-white border border-blue-200 text-blue-900 text-[10px] font-medium hover:bg-blue-600 hover:text-white transition-colors" title="Klik untuk menyalin">Menjelaskan</button>
                                <button type="button" onclick="copyKko('Mengidentifikasi (C2)')" class="kko-pill px-2 py-0.5 rounded-lg bg-white border border-blue-200 text-blue-900 text-[10px] font-medium hover:bg-blue-600 hover:text-white transition-colors" title="Klik untuk menyalin">Mengidentifikasi</button>
                            </div>
                        </div>

                        <!-- C3-C4 -->
                        <div class="p-3 rounded-2xl bg-emerald-50/60 border border-emerald-100 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-0.5 rounded-lg bg-emerald-100 text-emerald-800 font-bold text-[10px]">C3 - C4</span>
                                <span class="font-bold text-slate-800">Menerapkan &amp; Menganalisis</span>
                            </div>
                            <div class="flex flex-wrap gap-1.5 pt-0.5">
                                <button type="button" onclick="copyKko('Menerapkan (C3)')" class="kko-pill px-2 py-0.5 rounded-lg bg-white border border-emerald-200 text-emerald-900 text-[10px] font-medium hover:bg-emerald-600 hover:text-white transition-colors" title="Klik untuk menyalin">Menerapkan</button>
                                <button type="button" onclick="copyKko('Menghitung (C3)')" class="kko-pill px-2 py-0.5 rounded-lg bg-white border border-emerald-200 text-emerald-900 text-[10px] font-medium hover:bg-emerald-600 hover:text-white transition-colors" title="Klik untuk menyalin">Menghitung</button>
                                <button type="button" onclick="copyKko('Menganalisis (C4)')" class="kko-pill px-2 py-0.5 rounded-lg bg-white border border-emerald-200 text-emerald-900 text-[10px] font-medium hover:bg-emerald-600 hover:text-white transition-colors" title="Klik untuk menyalin">Menganalisis</button>
                                <button type="button" onclick="copyKko('Menguraikan (C4)')" class="kko-pill px-2 py-0.5 rounded-lg bg-white border border-emerald-200 text-emerald-900 text-[10px] font-medium hover:bg-emerald-600 hover:text-white transition-colors" title="Klik untuk menyalin">Menguraikan</button>
                            </div>
                        </div>

                        <!-- C5-C6 -->
                        <div class="p-3 rounded-2xl bg-purple-50/60 border border-purple-100 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-0.5 rounded-lg bg-purple-100 text-purple-800 font-bold text-[10px]">C5 - C6</span>
                                <span class="font-bold text-slate-800">Mengevaluasi &amp; Mencipta</span>
                            </div>
                            <div class="flex flex-wrap gap-1.5 pt-0.5">
                                <button type="button" onclick="copyKko('Mengevaluasi (C5)')" class="kko-pill px-2 py-0.5 rounded-lg bg-white border border-purple-200 text-purple-900 text-[10px] font-medium hover:bg-purple-600 hover:text-white transition-colors" title="Klik untuk menyalin">Mengevaluasi</button>
                                <button type="button" onclick="copyKko('Memvalidasi (C5)')" class="kko-pill px-2 py-0.5 rounded-lg bg-white border border-purple-200 text-purple-900 text-[10px] font-medium hover:bg-purple-600 hover:text-white transition-colors" title="Klik untuk menyalin">Memvalidasi</button>
                                <button type="button" onclick="copyKko('Mendesain (C6)')" class="kko-pill px-2 py-0.5 rounded-lg bg-white border border-purple-200 text-purple-900 text-[10px] font-medium hover:bg-purple-600 hover:text-white transition-colors" title="Klik untuk menyalin">Mendesain</button>
                                <button type="button" onclick="copyKko('Merumuskan (C6)')" class="kko-pill px-2 py-0.5 rounded-lg bg-white border border-purple-200 text-purple-900 text-[10px] font-medium hover:bg-purple-600 hover:text-white transition-colors" title="Klik untuk menyalin">Merumuskan</button>
                            </div>
                        </div>
                    </div>

                    <div id="kko-copy-notice" class="hidden text-[10px] text-emerald-800 bg-emerald-50 border border-emerald-200 p-2 rounded-xl text-center font-medium"></div>
                </div>

                <!-- 3. KURIKULUM YAYASAN SYNC CARD -->
                <div class="p-5 rounded-3xl bg-slate-50 border border-slate-100 space-y-2.5 text-xs text-slate-600">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-700 text-lg">sync_saved_locally</span>
                        <h4 class="font-bold text-slate-900">Sinkronisasi Kurikulum</h4>
                    </div>
                    <p class="leading-relaxed text-[11px]">
                        Seluruh capaian dan tujuan pembelajaran mata pelajaran ini telah tersinkronisasi dengan master kurikulum Yayasan Pendidikan Islam Alfa Ali Masykur.
                    </p>
                </div>
            @endif

        </div>

    </div>

</div>

<!-- JAVASCRIPT LOGIC & INTERACTIONS -->
<script>
    let activeTpFilter = 'all';
    let activeKatalogUnit = 'all';

    // Katalog Filtering by Unit
    function filterKatalogUnit(unitCode) {
        activeKatalogUnit = unitCode;

        // Update tabs styling
        document.querySelectorAll('.katalog-unit-tab').forEach(tab => {
            tab.className = 'katalog-unit-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer';
        });

        const activeTab = document.getElementById(`katalog-tab-${unitCode}`);
        if (activeTab) {
            activeTab.className = 'katalog-unit-tab px-3.5 py-1.5 rounded-full text-xs font-bold transition-all bg-brand-800 text-white shadow-subtle cursor-pointer';
        }

        const query = (document.getElementById('katalog-search-input')?.value || '').toLowerCase().trim();
        applyKatalogFilters(activeKatalogUnit, query);
    }

    // Katalog Filtering by Search Input
    function filterKatalogSearch(query) {
        query = query.toLowerCase().trim();
        applyKatalogFilters(activeKatalogUnit, query);
    }

    function applyKatalogFilters(unitCode, query) {
        const cards = document.querySelectorAll('.mapel-card-item');
        let visibleCount = 0;

        cards.forEach(card => {
            const cardUnit = card.getAttribute('data-unit') || '';
            const searchData = card.getAttribute('data-search') || '';

            const matchUnit = (unitCode === 'all') || (cardUnit === unitCode);
            const matchQuery = !query || searchData.includes(query);

            if (matchUnit && matchQuery) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        const label = document.getElementById('katalog-count-label');
        if (label) {
            label.textContent = `Menampilkan ${visibleCount} kartu`;
        }
    }

    // Workspace Accordion Logic
    function toggleCp(cpId) {
        const body = document.getElementById(`cp-body-${cpId}`);
        const icon = document.getElementById(`cp-toggle-icon-${cpId}`);
        if (!body) return;

        const isHidden = body.classList.contains('hidden');
        if (isHidden) {
            body.classList.remove('hidden');
            if (icon) icon.textContent = 'expand_less';
        } else {
            body.classList.add('hidden');
            if (icon) icon.textContent = 'expand_more';
        }
    }

    function toggleAllTrees(expand) {
        document.querySelectorAll('.cp-body').forEach(body => {
            if (expand) {
                body.classList.remove('hidden');
            } else {
                body.classList.add('hidden');
            }
        });
        document.querySelectorAll('[id^="cp-toggle-icon-"]').forEach(icon => {
            icon.textContent = expand ? 'expand_less' : 'expand_more';
        });
    }

    function filterTpStatus(status) {
        activeTpFilter = status;

        document.querySelectorAll('.tp-status-tab').forEach(tab => {
            tab.classList.remove('bg-brand-800', 'text-white', 'shadow-subtle');
            tab.classList.add('bg-white', 'text-slate-600', 'border', 'border-slate-200');
        });

        const activeTab = document.getElementById(`tp-filter-${status}`);
        if (activeTab) {
            activeTab.classList.remove('bg-white', 'text-slate-600', 'border', 'border-slate-200');
            activeTab.classList.add('bg-brand-800', 'text-white', 'shadow-subtle');
        }

        const query = (document.getElementById('hierarchy-filter')?.value || '').toLowerCase().trim();
        filterTree(query);
    }

    function filterTree(query) {
        query = query.toLowerCase().trim();
        const cpCards = document.querySelectorAll('.cp-card');
        
        cpCards.forEach(card => {
            const cpTitle = card.getAttribute('data-title') || '';
            const tpCards = card.querySelectorAll('.tp-card');
            let hasVisibleTp = false;

            tpCards.forEach(tp => {
                const tpTitle = tp.getAttribute('data-title') || '';
                const tpStatus = tp.getAttribute('data-status') || '';

                const matchesQuery = !query || tpTitle.includes(query) || cpTitle.includes(query);
                const matchesStatus = (activeTpFilter === 'all') || (tpStatus === activeTpFilter);

                if (matchesQuery && matchesStatus) {
                    tp.classList.remove('hidden');
                    hasVisibleTp = true;
                } else {
                    tp.classList.add('hidden');
                }
            });

            if (!query && activeTpFilter === 'all') {
                card.classList.remove('hidden');
            } else if (hasVisibleTp || (matchesQuery && !query)) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    function copyKko(kkoText) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(kkoText);
        }
        const notice = document.getElementById('kko-copy-notice');
        if (notice) {
            notice.textContent = `Tersalin ke clipboard: "${kkoText}"`;
            notice.classList.remove('hidden');
            setTimeout(() => notice.classList.add('hidden'), 2500);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const q = urlParams.get('q');
        if (q) {
            const filterInput = document.getElementById('hierarchy-filter');
            if (filterInput) {
                filterInput.value = q;
                filterTree(q);
            }
        }
    });

    // ==========================================
    // UPLOAD DOKUMEN MODUL MATERI (DRAG & DROP)
    // ==========================================
    let currentUploadMateriId = null;

    function openUploadMateriModal(materiId, judulMateri, mapelNama, kodeTp) {
        currentUploadMateriId = materiId;
        const modal = document.getElementById('modal-upload-materi');
        const backdrop = document.getElementById('upload-materi-backdrop');
        const form = document.getElementById('upload-materi-form');
        if (!modal || !backdrop || !form) return;

        form.reset();
        clearMateriSelectedFile();

        document.getElementById('upload-materi-id').value = materiId;
        document.getElementById('upload-modal-target-materi').textContent = judulMateri || 'Materi Pembelajaran';
        document.getElementById('upload-modal-target-tp').textContent = 'Sasaran ' + (kodeTp || 'TP');
        if (mapelNama) {
            document.getElementById('upload-modal-target-mapel').textContent = mapelNama;
        }

        backdrop.classList.remove('hidden');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeUploadMateriModal() {
        const modal = document.getElementById('modal-upload-materi');
        const backdrop = document.getElementById('upload-materi-backdrop');
        if (modal && backdrop) {
            modal.classList.add('hidden');
            backdrop.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    function handleMateriFileSelected(files) {
        if (!files || files.length === 0) return;
        const file = files[0];

        // Format validation
        const allowedExtensions = ['pdf', 'docx', 'xlsx', 'doc', 'xls'];
        const ext = file.name.split('.').pop().toLowerCase();
        if (!allowedExtensions.includes(ext)) {
            alert('Format berkas "' + ext.toUpperCase() + '" tidak didukung! Format yang diperbolehkan hanya PDF (.pdf), Word (.docx, .doc), dan Excel (.xlsx, .xls).');
            clearMateriSelectedFile();
            return;
        }

        // Size validation (Max 20MB)
        if (file.size > 20 * 1024 * 1024) {
            alert('Ukuran berkas melebihi batas 20 MB! Ukuran berkas Anda: ' + (file.size / (1024 * 1024)).toFixed(1) + ' MB.');
            clearMateriSelectedFile();
            return;
        }

        // Render preview card
        const placeholder = document.getElementById('materi-dropzone-placeholder');
        const previewCard = document.getElementById('materi-file-preview-card');
        const fileNameEl = document.getElementById('preview-file-name');
        const fileMetaEl = document.getElementById('preview-file-meta');
        const iconBox = document.getElementById('preview-file-icon-box');
        const icon = document.getElementById('preview-file-icon');

        const sizeFormatted = file.size >= 1048576 
            ? (file.size / 1048576).toFixed(1) + ' MB' 
            : (file.size / 1024).toFixed(1) + ' KB';

        let badgeType = ext.toUpperCase();
        let iconName = 'description';
        let iconBg = 'bg-blue-50 text-blue-700';

        if (ext === 'pdf') {
            badgeType = 'Dokumen PDF';
            iconName = 'picture_as_pdf';
            iconBg = 'bg-rose-50 text-rose-700';
        } else if (['xlsx', 'xls'].includes(ext)) {
            badgeType = 'Lembar Kerja Excel';
            iconName = 'table_view';
            iconBg = 'bg-emerald-50 text-emerald-700';
        } else if (['docx', 'doc'].includes(ext)) {
            badgeType = 'Dokumen Word';
            iconName = 'description';
            iconBg = 'bg-blue-50 text-blue-700';
        }

        fileNameEl.textContent = file.name;
        fileMetaEl.textContent = `${badgeType} • ${sizeFormatted}`;
        icon.textContent = iconName;
        iconBox.className = `w-9 h-9 rounded-xl flex items-center justify-center shrink-0 font-bold ${iconBg}`;

        placeholder.classList.add('hidden');
        previewCard.classList.remove('hidden');
    }

    function clearMateriSelectedFile() {
        const fileInput = document.getElementById('materi-dropzone-file-input');
        if (fileInput) fileInput.value = '';
        const placeholder = document.getElementById('materi-dropzone-placeholder');
        const previewCard = document.getElementById('materi-file-preview-card');
        if (placeholder && previewCard) {
            placeholder.classList.remove('hidden');
            previewCard.classList.add('hidden');
        }
    }

    // Drag and Drop Events on #materi-dropzone
    document.addEventListener('DOMContentLoaded', function() {
        const dropzone = document.getElementById('materi-dropzone');
        if (!dropzone) return;

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('border-brand-600', 'bg-brand-50/50', 'scale-[1.01]');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('border-brand-600', 'bg-brand-50/50', 'scale-[1.01]');
            }, false);
        });

        dropzone.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files && files.length > 0) {
                const fileInput = document.getElementById('materi-dropzone-file-input');
                fileInput.files = files;
                handleMateriFileSelected(files);
            }
        }, false);
    });

    async function handleUploadMateriSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const fileInput = document.getElementById('materi-dropzone-file-input');
        if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
            alert('Silakan pilih berkas dokumen terlebih dahulu sebelum mengunggah.');
            return;
        }

        const materiId = document.getElementById('upload-materi-id').value;
        const formData = new FormData(form);
        const submitBtn = document.getElementById('btn-submit-upload-materi');
        const progressBox = document.getElementById('upload-progress-box');
        const progressBar = document.getElementById('upload-progress-bar');
        const progressPercent = document.getElementById('upload-progress-percent');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">progress_activity</span><span>Mengunggah...</span>';
        progressBox.classList.remove('hidden');
        progressBar.style.width = '45%';
        progressPercent.textContent = '45%';

        try {
            const res = await fetch(`/kurikulum/materi/${materiId}/upload-dokumen`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            progressBar.style.width = '100%';
            progressPercent.textContent = '100%';

            const data = await res.json();
            if (data.success) {
                closeUploadMateriModal();
                window.location.reload();
            } else {
                alert('Gagal mengunggah dokumen: ' + (data.message || 'Terjadi kesalahan.'));
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<span class="material-symbols-outlined text-sm">upload</span><span>Unggah Dokumen</span>';
                progressBox.classList.add('hidden');
            }
        } catch (err) {
            form.action = `/kurikulum/materi/${materiId}/upload-dokumen`;
            form.submit();
        }
    }

    async function deleteMateriDoc(materiId) {
        if (!confirm('Apakah Anda yakin ingin menghapus dokumen lampiran ini dari materi pembelajaran?')) return;

        try {
            const res = await fetch(`/kurikulum/materi/${materiId}/delete-dokumen`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();
            if (data.success) {
                window.location.reload();
            } else {
                alert('Gagal menghapus dokumen: ' + (data.message || 'Terjadi kesalahan.'));
            }
        } catch (err) {
            console.error(err);
        }
    }
</script>

<!-- MODAL UPLOAD DOKUMEN MODUL MATERI (DRAG & DROP) -->
<div id="upload-materi-backdrop" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden transition-opacity" onclick="closeUploadMateriModal()"></div>
<div id="modal-upload-materi" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-floating border border-slate-100 space-y-5 animate-in fade-in zoom-in-95 duration-200">
        
        <!-- Header -->
        <div class="flex items-start justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold shadow-2xs">
                    <span class="material-symbols-outlined text-xl">upload_file</span>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900">Unggah Modul / Dokumen Materi</h3>
                    <p class="text-[11px] text-slate-500 mt-0.5" id="upload-materi-subtitle">
                        Lampirkan dokumen modul ajar dalam format PDF, Word, atau Excel
                    </p>
                </div>
            </div>
            <button type="button" onclick="closeUploadMateriModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <!-- Target Info Pill -->
        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1 text-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] uppercase font-bold text-slate-400" id="upload-modal-target-tp">Sasaran TP</span>
                <span class="text-[10px] font-bold text-brand-800 bg-brand-50 px-2 py-0.5 rounded-md" id="upload-modal-target-mapel">{{ $selectedMapel->nama_mapel ?? 'Mata Pelajaran' }}</span>
            </div>
            <div class="font-bold text-slate-900 text-xs sm:text-[13px] truncate" id="upload-modal-target-materi">
                Materi Pokok
            </div>
        </div>

        <!-- Form with Drag and Drop Zone -->
        <form id="upload-materi-form" onsubmit="handleUploadMateriSubmit(event)" class="space-y-4 text-xs">
            @csrf
            <input type="hidden" id="upload-materi-id" name="materi_id" value="">

            <!-- Drag & Drop Zone -->
            <div class="space-y-2">
                <label class="block font-bold text-slate-700">Berkas Dokumen <span class="text-rose-500">*</span></label>
                
                <div id="materi-dropzone" 
                     class="border-2 border-dashed border-slate-300 hover:border-brand-600 bg-slate-50/70 hover:bg-brand-50/30 rounded-3xl p-6 sm:p-7 text-center cursor-pointer transition-all duration-200 flex flex-col items-center justify-center gap-2.5"
                     onclick="document.getElementById('materi-dropzone-file-input').click()">
                    
                    <input type="file" id="materi-dropzone-file-input" name="dokumen" 
                           accept=".pdf,.docx,.xlsx,.doc,.xls" 
                           class="hidden" 
                           onchange="handleMateriFileSelected(this.files)">

                    <!-- State 1: Dropzone Idle / Placeholder -->
                    <div id="materi-dropzone-placeholder" class="space-y-2 select-none">
                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 text-brand-700 flex items-center justify-center mx-auto shadow-2xs">
                            <span class="material-symbols-outlined text-2xl">cloud_upload</span>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-xs sm:text-sm">
                                Tarik &amp; Letakkan berkas ke sini
                            </p>
                            <p class="text-[11px] text-slate-400 mt-0.5">
                                atau <span class="text-brand-700 font-bold underline">klik untuk mencari di komputer</span>
                            </p>
                        </div>
                    </div>

                    <!-- State 2: Selected File Preview -->
                    <div id="materi-file-preview-card" class="hidden w-full p-3 rounded-2xl bg-white border border-slate-200/90 shadow-2xs flex items-center justify-between gap-3 text-left">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 font-bold" id="preview-file-icon-box">
                                <span class="material-symbols-outlined text-lg" id="preview-file-icon">description</span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-slate-900 text-xs truncate" id="preview-file-name">file.pdf</p>
                                <p class="text-[10px] text-slate-400 mt-0.5" id="preview-file-meta">PDF • 2.4 MB</p>
                            </div>
                        </div>
                        <button type="button" onclick="event.stopPropagation(); clearMateriSelectedFile();" 
                                class="p-1.5 rounded-xl hover:bg-slate-100 text-slate-400 hover:text-rose-600 transition-colors" 
                                title="Batal Pilih File">
                            <span class="material-symbols-outlined text-base">close</span>
                        </button>
                    </div>

                    <!-- Allowed Formats Tag Pills -->
                    <div class="flex items-center justify-center gap-1.5 pt-1 text-[10px] font-bold text-slate-400 flex-wrap">
                        <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200/60">PDF (.pdf)</span>
                        <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200/60">Word (.docx)</span>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/60">Excel (.xlsx)</span>
                        <span class="text-slate-400 font-normal">Maks. 20 MB</span>
                    </div>
                </div>
            </div>

            <!-- Catatan / Deskripsi Lampiran (Opsional) -->
            <div class="space-y-1">
                <label class="block font-bold text-slate-700">Keterangan / Catatan Versi (Opsional)</label>
                <input type="text" name="keterangan" id="upload-materi-keterangan" 
                       placeholder="misal: Modul Ajar Kurikulum Merdeka Pertemuan 1 - 3 Revisi 2026" 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 text-xs text-slate-800">
            </div>

            <!-- Upload Progress Indicator (Hidden by default) -->
            <div id="upload-progress-box" class="hidden space-y-1.5 p-3 rounded-2xl bg-brand-50 border border-brand-200/70">
                <div class="flex items-center justify-between text-[11px] text-brand-900 font-semibold">
                    <span class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm animate-spin">progress_activity</span>
                        <span>Mengunggah dokumen ke server...</span>
                    </span>
                    <span id="upload-progress-percent">0%</span>
                </div>
                <div class="w-full bg-brand-200 rounded-full h-1.5 overflow-hidden">
                    <div id="upload-progress-bar" class="bg-brand-700 h-1.5 rounded-full transition-all duration-200" style="width: 0%"></div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeUploadMateriModal()" 
                        class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100 text-xs font-semibold transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" id="btn-submit-upload-materi" 
                        class="px-5 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-bold shadow-subtle transition-all cursor-pointer flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-sm">upload</span>
                    <span>Unggah Dokumen</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
