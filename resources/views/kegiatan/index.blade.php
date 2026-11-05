@extends('layouts.app')

@section('title', 'Kokurikuler & Ekstrakurikuler')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6 max-w-[1600px] mx-auto">

    <!-- 2-COLUMN CANVAS (Matches Reference UI Style) -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">

        <!-- ======================================================== -->
        <!-- MIDDLE / MAIN COLUMN (xl:col-span-8 or 9) -->
        <!-- ======================================================== -->
        <div class="xl:col-span-8 2xl:col-span-9 space-y-6">

            <!-- TOPBAR: BREADCRUMB & UNIT FILTER ROW -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                    <span>Pengembangan Karakter Santri</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-medium text-slate-700">P5-RA &amp; Bakat Minat</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-semibold text-brand-800">Kegiatan Santri</span>
                </div>

                <!-- Unit Selector or Locked Scope -->
                @if($user->canAccessAllUnits())
                    <form method="GET" action="{{ route('kegiatan.index') }}" 
                          class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-2xl border border-slate-100 shadow-subtle shrink-0">
                        <span class="text-xs font-semibold text-slate-400">Unit:</span>
                        <select name="unit_id" onchange="this.form.submit()" 
                                class="bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer">
                            @foreach($units as $u)
                                <option value="{{ $u->id }}" {{ $selectedUnitId == $u->id ? 'selected' : '' }}>
                                    {{ $u->nama_unit }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                @else
                    <div class="flex items-center gap-2 bg-slate-100 px-3.5 py-1.5 rounded-2xl border border-slate-200/80 shrink-0 text-xs font-bold text-slate-800">
                        <span class="material-symbols-outlined text-sm text-brand-700">lock</span>
                        <span>{{ $user->unit->nama_unit ?? 'Unit Anda' }}</span>
                    </div>
                @endif
            </div>

            <!-- HERO OVERVIEW CARD -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative">
                <div class="space-y-3 max-w-xl z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-600"></span>
                        <span>Kurikulum Merdeka • Profil P5-RA</span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 leading-tight">
                        Kokurikuler (P5-RA) &amp; Ekstrakurikuler
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Harmonisasi dimensi Profil Pelajar Pancasila dan Rahmatan Lil Alamin dengan pengembangan bakat kepemimpinan, seni Islami, dan olahraga santri.
                    </p>

                    <div class="flex items-center gap-3 pt-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand-50 text-brand-800 font-bold text-xs border border-brand-200/60">
                            <span class="material-symbols-outlined text-base">verified</span>
                            <span>{{ $kokurikuler->count() }} Projek Terverifikasi</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs">
                            <span class="material-symbols-outlined text-base">sports_soccer</span>
                            <span>{{ $ekstrakurikuler->count() }} Cabang Pilihan</span>
                        </span>
                    </div>
                </div>

                <!-- 3D Isometric Trophy Graphic -->
                <div class="shrink-0 flex items-center justify-center md:pr-4">
                    <svg class="w-36 h-32 sm:w-44 sm:h-38 drop-shadow-sm select-none" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M40 120 L120 160 L200 120 L120 80 Z" fill="#6366f1" />
                        <path d="M40 120 L40 135 L120 175 L120 160 Z" fill="#4338ca" />
                        <path d="M120 160 L120 175 L200 135 L200 120 Z" fill="#4f46e5" />
                        <path d="M44 121 L44 130 L118 168 L118 159 Z" fill="#e0e7ff" />
                        <path d="M122 159 L122 168 L196 130 L196 121 Z" fill="#c7d2fe" />

                        <path d="M50 95 L120 130 L190 95 L120 60 Z" fill="#f59e0b" />
                        <path d="M50 95 L50 108 L120 143 L120 130 Z" fill="#d97706" />
                        <path d="M120 130 L120 143 L190 108 L190 95 Z" fill="#b45309" />
                        <path d="M54 96 L54 104 L118 137 L118 129 Z" fill="#fef3c7" />
                        <path d="M122 129 L122 137 L186 104 L186 96 Z" fill="#fde68a" />

                        <path d="M70 65 L130 95 L180 70 L120 40 Z" fill="#ffffff" stroke="#e2e8f0" stroke-width="1.5" />
                        <path d="M70 65 L70 70 L130 100 L130 95 Z" fill="#cbd5e1" />
                        <path d="M130 95 L130 100 L180 75 L180 70 Z" fill="#94a3b8" />
                        <circle cx="95" cy="62" r="2.5" fill="#f59e0b" />
                        <line x1="103" y1="62" x2="140" y2="53" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
            </div>

            <!-- INTERACTIVE FILTER TOOLBAR -->
            <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-card space-y-3.5">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                    <!-- Live Search Input -->
                    <div class="relative flex-1 max-w-md">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                        <input type="text" id="kegiatan-search-input" oninput="filterKegiatanLive()" 
                               placeholder="Cari kegiatan, tema, koordinator, atau jadwal..." 
                               class="w-full pl-9 pr-8 py-2 bg-slate-50 border border-slate-200/90 rounded-2xl text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 shadow-subtle transition-all">
                        <button type="button" onclick="clearKegiatanSearch()" id="clear-kegiatan-search" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 hidden">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                    </div>

                    <!-- Category Switcher Tabs -->
                    <div class="flex items-center gap-1.5 flex-wrap">
                        <button type="button" onclick="setKegiatanTab('all')" id="tab-kegiatan-all" 
                                class="kegiatan-nav-tab px-3.5 py-1.5 rounded-full text-xs font-bold transition-all bg-brand-800 text-white shadow-subtle cursor-pointer">
                            Semua ({{ $kokurikuler->count() + $ekstrakurikuler->count() }})
                        </button>
                        <button type="button" onclick="setKegiatanTab('kokurikuler')" id="tab-kegiatan-kokurikuler" 
                                class="kegiatan-nav-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer">
                            P5-RA ({{ $kokurikuler->count() }})
                        </button>
                        <button type="button" onclick="setKegiatanTab('ekstrakurikuler')" id="tab-kegiatan-ekstrakurikuler" 
                                class="kegiatan-nav-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer">
                            Ekstrakurikuler ({{ $ekstrakurikuler->count() }})
                        </button>
                    </div>
                </div>

                <!-- Sub-category filter pills for Ekstrakurikuler (Visible when all or extra is active) -->
                <div id="extra-sub-filter" class="flex flex-wrap items-center gap-1.5 pt-2 border-t border-slate-100 text-xs">
                    <span class="text-[11px] font-semibold text-slate-400 mr-1">Kategori Ekstra:</span>
                    <button type="button" onclick="filterExtraCategory('all')" id="extra-cat-all" 
                            class="extra-cat-pill px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-900 text-white transition-all">
                        Semua Kategori
                    </button>
                    <button type="button" onclick="filterExtraCategory('Keagamaan')" id="extra-cat-Keagamaan" 
                            class="extra-cat-pill px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">
                        Keagamaan
                    </button>
                    <button type="button" onclick="filterExtraCategory('Olahraga')" id="extra-cat-Olahraga" 
                            class="extra-cat-pill px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">
                        Olahraga
                    </button>
                    <button type="button" onclick="filterExtraCategory('Seni Islami')" id="extra-cat-Seni Islami" 
                            class="extra-cat-pill px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">
                        Seni Islami
                    </button>
                    <button type="button" onclick="filterExtraCategory('Kepanduan')" id="extra-cat-Kepanduan" 
                            class="extra-cat-pill px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">
                        Kepanduan
                    </button>
                </div>
            </div>

            <!-- SECTION 1: PROJEK KOKURIKULER (P5-RA) -->
            <div id="section-kokurikuler" class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-700 text-lg">diversity_3</span>
                        <h2 class="text-sm font-bold text-slate-900">Projek Penguatan Profil Pelajar (P5-RA)</h2>
                    </div>
                    <span class="text-xs text-slate-400 font-medium">T.A 2024/2025</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="kokurikuler-grid">
                    @forelse($kokurikuler as $k)
                        <div class="kegiatan-card bg-white rounded-3xl p-5 border border-slate-100 shadow-card flex flex-col justify-between gap-3 hover:border-slate-300 transition-colors cursor-pointer group"
                             data-type="kokurikuler"
                             data-title="{{ $k->nama_kegiatan }}"
                             data-subtitle="Tema: {{ $k->tema ?? 'Kearifan Lokal' }} • {{ $k->alokasi_waktu }}"
                             data-badge="P5-RA"
                             data-badge-color="bg-brand-50 text-brand-900 border border-brand-200"
                             data-leader="{{ $k->pengelola->name ?? 'Tim P5 Unit' }}"
                             data-schedule="{{ $k->alokasi_waktu }}"
                             data-desc="{{ $k->deskripsi }}"
                             data-search="{{ strtolower($k->nama_kegiatan . ' ' . $k->tema . ' ' . $k->deskripsi . ' ' . ($k->pengelola->name ?? '')) }}"
                             onclick="showKegiatanModal(this)">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="px-2.5 py-0.5 rounded-full font-bold bg-brand-50 text-brand-900 border border-brand-200 text-[10px]">
                                        Tema: {{ $k->tema ?? 'Kearifan Lokal' }}
                                    </span>
                                    <span class="text-slate-400 font-semibold text-[11px]">{{ $k->alokasi_waktu }}</span>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900 group-hover:text-brand-800 transition-colors leading-snug">{{ $k->nama_kegiatan }}</h3>
                                <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $k->deskripsi }}</p>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-slate-100 text-xs">
                                <span class="text-slate-500">
                                    Koordinator: <strong class="text-slate-800">{{ $k->pengelola->name ?? 'Tim P5 Unit' }}</strong>
                                </span>
                                <span class="text-brand-700 font-semibold flex items-center gap-1 text-[11px] group-hover:translate-x-0.5 transition-transform">
                                    <span>Detail</span>
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 py-8 text-center text-slate-400 text-xs bg-white rounded-3xl border border-slate-100">
                            Belum ada data kegiatan kokurikuler pada unit ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- SECTION 2: CABANG EKSTRAKURIKULER SANTRI -->
            <div id="section-ekstrakurikuler" class="space-y-3 pt-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-slate-700 text-lg">sports_soccer</span>
                        <h2 class="text-sm font-bold text-slate-900">Cabang Kegiatan Ekstrakurikuler</h2>
                    </div>
                    <span class="text-xs text-slate-500 font-semibold">Total: {{ $ekstrakurikuler->count() }} Cabang</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4" id="ekstrakurikuler-grid">
                    @forelse($ekstrakurikuler as $e)
                        <div class="kegiatan-card bg-white rounded-3xl p-5 border border-slate-100 shadow-card flex flex-col justify-between gap-3 hover:border-slate-300 transition-colors cursor-pointer group"
                             data-type="ekstrakurikuler"
                             data-category="{{ $e->kategori }}"
                             data-title="{{ $e->nama_kegiatan }}"
                             data-subtitle="Kategori: {{ $e->kategori }} • {{ $e->jadwal ?? 'Mingguan' }}"
                             data-badge="{{ $e->kategori }}"
                             data-badge-color="bg-slate-100 text-slate-700"
                             data-leader="{{ $e->pembina->name ?? 'Instruktur Khusus' }}"
                             data-schedule="{{ $e->jadwal ?? 'Jadwal Mingguan' }}"
                             data-desc="{{ $e->deskripsi }}"
                             data-search="{{ strtolower($e->nama_kegiatan . ' ' . $e->kategori . ' ' . $e->deskripsi . ' ' . ($e->pembina->name ?? '') . ' ' . ($e->jadwal ?? '')) }}"
                             onclick="showKegiatanModal(this)">
                            <div class="space-y-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 inline-block">
                                    {{ $e->kategori }}
                                </span>
                                <h3 class="text-xs font-bold text-slate-900 group-hover:text-brand-800 transition-colors">{{ $e->nama_kegiatan }}</h3>
                                <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $e->deskripsi }}</p>
                            </div>

                            <div class="pt-3 border-t border-slate-100 space-y-1 text-xs">
                                <div class="flex items-center gap-1.5 text-slate-600 font-medium">
                                    <span class="material-symbols-outlined text-sm text-brand-700">schedule</span>
                                    <span>{{ $e->jadwal ?? 'Jadwal Mingguan' }}</span>
                                </div>
                                <div class="flex items-center justify-between text-slate-500 text-[11px]">
                                    <span>Pembina: <strong class="text-slate-800">{{ $e->pembina->name ?? 'Instruktur' }}</strong></span>
                                    <span class="material-symbols-outlined text-sm text-slate-400 group-hover:text-brand-800 group-hover:translate-x-0.5 transition-all">arrow_forward</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 py-8 text-center text-slate-400 text-xs bg-white rounded-3xl border border-slate-100">
                            Belum ada data ekstrakurikuler pada unit ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Empty Search Results Placeholder -->
            <div id="no-kegiatan-found" class="bg-white rounded-3xl p-8 border border-slate-100 text-center space-y-3 hidden">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">search_off</span>
                </div>
                <h4 class="text-xs font-bold text-slate-800">Tidak ada kegiatan yang cocok</h4>
                <p class="text-[11px] text-slate-500">Coba ubah kata kunci pencarian atau ganti filter kategori di atas.</p>
                <button type="button" onclick="clearKegiatanSearch()" class="px-4 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold">
                    Reset Pencarian
                </button>
            </div>

        </div>

        <!-- ======================================================== -->
        <!-- RIGHT PANEL (P5-RA DIMENSI & JADWAL PEKANAN) -->
        <!-- ======================================================== -->
        <div class="xl:col-span-4 2xl:col-span-3 space-y-6">

            <!-- 1. DIMENSI PROFIL PELAJAR PANCASILA & RA -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-3">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="material-symbols-outlined text-brand-700 text-lg">star</span>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Dimensi P5 &amp; Rahmatan Lil Alamin</h4>
                </div>

                <div class="space-y-2 text-xs">
                    <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-brand-100 text-brand-800 font-bold text-xs flex items-center justify-center shrink-0">1</span>
                        <div>
                            <span class="font-bold text-slate-800 block">Berkeadaban (Ta'addub)</span>
                            <span class="text-[11px] text-slate-500">Adab terhadap guru, orang tua, &amp; masyarakat.</span>
                        </div>
                    </div>

                    <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-brand-100 text-brand-800 font-bold text-xs flex items-center justify-center shrink-0">2</span>
                        <div>
                            <span class="font-bold text-slate-800 block">Keteladanan (Qudwah)</span>
                            <span class="text-[11px] text-slate-500">Integritas moral dan suri teladan santri.</span>
                        </div>
                    </div>

                    <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-brand-100 text-brand-800 font-bold text-xs flex items-center justify-center shrink-0">3</span>
                        <div>
                            <span class="font-bold text-slate-800 block">Kewarganegaraan &amp; Kebangsaan</span>
                            <span class="text-[11px] text-slate-500">Hubbul wathan minal iman (cinta tanah air).</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. JADWAL LATIHAN EKSTRAKURIKULER -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 block">Waktu Latihan Pekanan</span>
                
                <div class="space-y-2 text-xs">
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-800 block">Jumat Sore</span>
                            <span class="text-[11px] text-slate-500">Pramuka &amp; Kepanduan Santri</span>
                        </div>
                        <span class="px-2 py-0.5 rounded bg-brand-100 font-bold text-[11px] text-brand-900">14.30 WIB</span>
                    </div>

                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-800 block">Sabtu Pagi</span>
                            <span class="text-[11px] text-slate-500">Khadrah, Tilawah, &amp; Kaligrafi</span>
                        </div>
                        <span class="px-2 py-0.5 rounded bg-slate-200 font-bold text-[11px] text-slate-700">08.00 WIB</span>
                    </div>

                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-800 block">Ahad Pagi</span>
                            <span class="text-[11px] text-slate-500">Pencak Silat Pagar Nusa &amp; Futsal</span>
                        </div>
                        <span class="px-2 py-0.5 rounded bg-slate-200 font-bold text-[11px] text-slate-700">06.30 WIB</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- MODAL RINCIAN KEGIATAN SANTRI -->
    <div id="kegiatan-modal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-floating border border-slate-100 space-y-5 animate-in fade-in zoom-in-95 duration-200">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div id="km-icon-box" class="w-10 h-10 rounded-2xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                        <span id="km-icon" class="material-symbols-outlined text-xl">diversity_3</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 id="km-title" class="text-sm font-bold text-slate-900">Nama Kegiatan</h3>
                            <span id="km-badge" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-brand-50 text-brand-900 border border-brand-200">P5-RA</span>
                        </div>
                        <span id="km-subtitle" class="text-xs text-slate-500">Tema Kegiatan &amp; Jadwal</span>
                    </div>
                </div>
                <button type="button" onclick="closeKegiatanModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-base">close</span>
                </button>
            </div>

            <div class="space-y-3.5 text-xs">
                <!-- Deskripsi -->
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Deskripsi &amp; Capaian</span>
                    <p id="km-desc" class="text-slate-700 leading-relaxed">Deskripsi kegiatan santri.</p>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Waktu / Durasi</span>
                        <div class="flex items-center gap-1.5 mt-1 text-slate-800 font-semibold">
                            <span class="material-symbols-outlined text-sm text-brand-700">schedule</span>
                            <span id="km-schedule">Jadwal</span>
                        </div>
                    </div>

                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Pembina / Koordinator</span>
                        <div class="flex items-center gap-1.5 mt-1 text-slate-800 font-semibold">
                            <span class="material-symbols-outlined text-sm text-brand-700">person</span>
                            <span id="km-leader">Nama Pembina</span>
                        </div>
                    </div>
                </div>

                <!-- Status Validasi -->
                <div class="p-3 rounded-2xl bg-emerald-50/70 border border-emerald-100 flex items-center justify-between text-[11px]">
                    <span class="text-emerald-800 font-medium">Status Program Kurikulum:</span>
                    <span class="font-bold text-emerald-800 flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">verified</span>
                        <span>Aktif &amp; Terverifikasi Yayasan</span>
                    </span>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end">
                <button type="button" onclick="closeKegiatanModal()" 
                        class="px-5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    let currentTab = 'all';
    let currentExtraCat = 'all';

    function setKegiatanTab(tab) {
        currentTab = tab;

        // Update tabs styling
        document.querySelectorAll('.kegiatan-nav-tab').forEach(b => {
            b.className = 'kegiatan-nav-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer';
        });

        const active = document.getElementById('tab-kegiatan-' + tab);
        if (active) {
            active.className = 'kegiatan-nav-tab px-3.5 py-1.5 rounded-full text-xs font-bold transition-all bg-brand-800 text-white shadow-subtle cursor-pointer';
        }

        // Sub filter visibility
        const subFilter = document.getElementById('extra-sub-filter');
        if (tab === 'kokurikuler') {
            subFilter.style.display = 'none';
        } else {
            subFilter.style.display = 'flex';
        }

        filterKegiatanLive();
    }

    function filterExtraCategory(cat) {
        currentExtraCat = cat;

        document.querySelectorAll('.extra-cat-pill').forEach(b => {
            b.className = 'extra-cat-pill px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all cursor-pointer';
        });

        const active = document.getElementById('extra-cat-' + cat);
        if (active) {
            active.className = 'extra-cat-pill px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-900 text-white transition-all cursor-pointer';
        }

        filterKegiatanLive();
    }

    function filterKegiatanLive() {
        const query = (document.getElementById('kegiatan-search-input')?.value || '').toLowerCase().trim();
        const clearBtn = document.getElementById('clear-kegiatan-search');
        if (clearBtn) {
            clearBtn.classList.toggle('hidden', query.length === 0);
        }

        const secKoku = document.getElementById('section-kokurikuler');
        const secExtra = document.getElementById('section-ekstrakurikuler');
        const cards = document.querySelectorAll('.kegiatan-card');
        let visibleCount = 0;
        let visibleKoku = 0;
        let visibleExtra = 0;

        cards.forEach(card => {
            const type = card.getAttribute('data-type');
            const cat = card.getAttribute('data-category') || '';
            const searchData = card.getAttribute('data-search') || '';

            // Check Tab condition
            let matchTab = (currentTab === 'all') || (currentTab === type);

            // Check Extra category condition
            let matchCat = true;
            if (type === 'ekstrakurikuler' && currentExtraCat !== 'all') {
                matchCat = (cat === currentExtraCat);
            }

            // Check Query condition
            let matchQuery = !query || searchData.includes(query);

            if (matchTab && matchCat && matchQuery) {
                card.style.display = 'flex';
                visibleCount++;
                if (type === 'kokurikuler') visibleKoku++;
                if (type === 'ekstrakurikuler') visibleExtra++;
            } else {
                card.style.display = 'none';
            }
        });

        // Hide or show sections depending on results
        if (secKoku) secKoku.style.display = (visibleKoku > 0 && currentTab !== 'ekstrakurikuler') ? 'block' : 'none';
        if (secExtra) secExtra.style.display = (visibleExtra > 0 && currentTab !== 'kokurikuler') ? 'block' : 'none';

        const noFound = document.getElementById('no-kegiatan-found');
        if (noFound) {
            noFound.classList.toggle('hidden', visibleCount > 0);
        }
    }

    function clearKegiatanSearch() {
        const inp = document.getElementById('kegiatan-search-input');
        if (inp) {
            inp.value = '';
            filterKegiatanLive();
            inp.focus();
        }
    }

    function showKegiatanModal(el) {
        const title = el.getAttribute('data-title');
        const subtitle = el.getAttribute('data-subtitle');
        const badge = el.getAttribute('data-badge');
        const badgeColor = el.getAttribute('data-badge-color');
        const leader = el.getAttribute('data-leader');
        const schedule = el.getAttribute('data-schedule');
        const desc = el.getAttribute('data-desc');
        const type = el.getAttribute('data-type');

        document.getElementById('km-title').textContent = title;
        document.getElementById('km-subtitle').textContent = subtitle;
        document.getElementById('km-badge').textContent = badge;
        document.getElementById('km-badge').className = 'px-2 py-0.5 rounded-full text-[10px] font-bold ' + badgeColor;
        document.getElementById('km-leader').textContent = leader;
        document.getElementById('km-schedule').textContent = schedule;
        document.getElementById('km-desc').textContent = desc;

        const icon = document.getElementById('km-icon');
        const iconBox = document.getElementById('km-icon-box');
        if (type === 'kokurikuler') {
            icon.textContent = 'diversity_3';
            iconBox.className = 'w-10 h-10 rounded-2xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold';
        } else {
            icon.textContent = 'sports_soccer';
            iconBox.className = 'w-10 h-10 rounded-2xl bg-amber-50 text-amber-800 flex items-center justify-center font-bold';
        }

        document.getElementById('kegiatan-modal').classList.remove('hidden');
    }

    function closeKegiatanModal() {
        document.getElementById('kegiatan-modal').classList.add('hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeKegiatanModal();
    });
    document.getElementById('kegiatan-modal')?.addEventListener('click', function(e) {
        if (e.target === this) closeKegiatanModal();
    });
</script>
@endsection
