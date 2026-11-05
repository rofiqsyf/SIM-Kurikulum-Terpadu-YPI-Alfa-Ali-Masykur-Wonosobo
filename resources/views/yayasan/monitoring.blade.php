@extends('layouts.app')

@section('title', 'Monitoring Yayasan 3 Unit')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6 max-w-[1600px] mx-auto">

    <!-- 2-COLUMN CANVAS (Matches Reference UI Style) -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">

        <!-- ======================================================== -->
        <!-- MIDDLE / MAIN COLUMN (xl:col-span-8 or 9) -->
        <!-- ======================================================== -->
        <div class="xl:col-span-8 2xl:col-span-9 space-y-6">

            <!-- TOPBAR: BREADCRUMB & DATE ROW -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                    <span>Pengurus Yayasan</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-medium text-slate-700">Tata Kelola Lembaga</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-semibold text-brand-800">Monitoring Terpadu</span>
                </div>

                <div class="flex items-center gap-2 self-end sm:self-center text-xs font-semibold text-slate-500 bg-white px-3.5 py-1.5 rounded-2xl border border-slate-100 shadow-subtle shrink-0">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                    <span>3 Unit Lembaga Terintegrasi</span>
                </div>
            </div>

            <!-- HERO OVERVIEW CARD -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative">
                <div class="space-y-3 max-w-xl z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-600"></span>
                        <span>Portal Eksekutif Pengurus Yayasan</span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 leading-tight">
                        Monitoring Integrasi 3 Unit Pendidikan
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Harmonisasi kurikulum MI Tahfidz, SMP, dan SMA Alfa Ali Masykur. Memastikan keselarasan standar nasional dengan nilai-nilai kepesantrenan.
                    </p>

                    <div class="flex items-center gap-3 pt-2">
                        <a href="{{ route('curriculum.index') }}" 
                           class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all">
                            <span class="material-symbols-outlined text-base">schema</span>
                            <span>Eksplorasi Kurikulum Terpadu</span>
                        </a>
                    </div>
                </div>

                <!-- 3D Isometric Buildings Graphic -->
                <div class="shrink-0 flex items-center justify-center md:pr-4">
                    <svg class="w-36 h-32 sm:w-44 sm:h-38 drop-shadow-sm select-none" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M40 120 L120 160 L200 120 L120 80 Z" fill="#065f46" />
                        <path d="M40 120 L40 135 L120 175 L120 160 Z" fill="#064e3b" />
                        <path d="M120 160 L120 175 L200 135 L200 120 Z" fill="#047857" />
                        <path d="M44 121 L44 130 L118 168 L118 159 Z" fill="#ecfdf5" />
                        <path d="M122 159 L122 168 L196 130 L196 121 Z" fill="#d1fae5" />

                        <path d="M50 95 L120 130 L190 95 L120 60 Z" fill="#3b82f6" />
                        <path d="M50 95 L50 108 L120 143 L120 130 Z" fill="#1d4ed8" />
                        <path d="M120 130 L120 143 L190 108 L190 95 Z" fill="#2563eb" />
                        <path d="M54 96 L54 104 L118 137 L118 129 Z" fill="#eff6ff" />
                        <path d="M122 129 L122 137 L186 104 L186 96 Z" fill="#dbeafe" />

                        <path d="M70 65 L130 95 L180 70 L120 40 Z" fill="#ffffff" stroke="#e2e8f0" stroke-width="1.5" />
                        <path d="M70 65 L70 70 L130 100 L130 95 Z" fill="#cbd5e1" />
                        <path d="M130 95 L130 100 L180 75 L180 70 Z" fill="#94a3b8" />
                        <circle cx="95" cy="62" r="2.5" fill="#065f46" />
                        <line x1="103" y1="62" x2="140" y2="53" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                        <circle cx="103" cy="68" r="2.5" fill="#065f46" />
                        <line x1="111" y1="68" x2="148" y2="59" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
            </div>

            <!-- 3 UNIT INSTITUTION CARDS -->
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Perkembangan Kurikulum per Lembaga</h2>
                        <p class="text-[11px] text-slate-500">Evaluasi capaian TP, silabus, dan rasio guru per unit</p>
                    </div>

                    <!-- Interactive Unit Filter Tabs -->
                    <div class="flex items-center gap-1.5 flex-wrap">
                        <button type="button" onclick="filterMonitoringUnit('all')" id="unit-tab-all" 
                                class="unit-filter-tab px-3 py-1.5 rounded-full text-xs font-bold transition-all bg-brand-800 text-white shadow-subtle">
                            Semua Lembaga
                        </button>
                        <button type="button" onclick="filterMonitoringUnit('MI-ALFA')" id="unit-tab-MI-ALFA" 
                                class="unit-filter-tab px-3 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50">
                            MI Tahfidz
                        </button>
                        <button type="button" onclick="filterMonitoringUnit('SMP-ALFA')" id="unit-tab-SMP-ALFA" 
                                class="unit-filter-tab px-3 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50">
                            SMP Alfa
                        </button>
                        <button type="button" onclick="filterMonitoringUnit('SMA-ALFA')" id="unit-tab-SMA-ALFA" 
                                class="unit-filter-tab px-3 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50">
                            SMA Alfa
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5" id="monitoring-unit-grid">
                    @foreach($unitStats as $stat)
                        @php $unit = $stat['unit']; @endphp
                        <div class="unit-stat-card bg-white rounded-3xl p-6 border border-slate-100 shadow-card flex flex-col justify-between gap-5 hover:border-slate-300 transition-colors"
                             data-unit-code="{{ $unit->kode_unit }}">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                        {{ $unit->kode_unit === 'MI-ALFA' ? 'bg-teal-50 text-teal-800 border border-teal-200' : ($unit->kode_unit === 'SMP-ALFA' ? 'bg-blue-50 text-blue-800 border border-blue-200' : 'bg-purple-50 text-purple-800 border border-purple-200') }}">
                                        {{ $unit->jenjang->nama_jenjang ?? 'Jenjang' }}
                                    </span>
                                    <span class="text-[11px] font-medium text-slate-400">Merdeka</span>
                                </div>

                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">{{ $unit->nama_unit }}</h3>
                                    <span class="text-[11px] text-slate-500 block mt-0.5">
                                        Kepala: <strong class="text-slate-800">{{ $unit->kepala_sekolah ?? 'Kepala Sekolah' }}</strong>
                                    </span>
                                </div>

                                <!-- Metrics Grid -->
                                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100 text-xs">
                                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100/80">
                                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Mata Pelajaran</span>
                                        <span class="text-base font-extrabold text-slate-900 mt-0.5 block">{{ $stat['mapel_count'] }}</span>
                                    </div>
                                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100/80">
                                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Sasaran TP</span>
                                        <span class="text-base font-extrabold text-brand-800 mt-0.5 block">{{ $stat['tp_count'] }}</span>
                                    </div>
                                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100/80">
                                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Elemen CP</span>
                                        <span class="text-base font-extrabold text-slate-900 mt-0.5 block">{{ $stat['cp_count'] }}</span>
                                    </div>
                                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100/80">
                                        <span class="text-slate-400 text-[10px] uppercase font-bold block">Disahkan</span>
                                        <span class="text-base font-extrabold text-emerald-700 mt-0.5 block">{{ $stat['usulan_approved'] }}</span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('curriculum.index', ['unit_id' => $unit->id]) }}" 
                               class="w-full py-2 px-3 rounded-2xl bg-slate-100 hover:bg-brand-800 hover:text-white text-slate-800 text-xs font-semibold transition-all text-center flex items-center justify-center gap-1.5">
                                <span>Eksplorasi Kurikulum Unit</span>
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- MATRIKS INTEGRASI MUATAN KEPESANTRENAN -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-card space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-brand-700 text-xl">auto_stories</span>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Matriks Integrasi Muatan Kepesantrenan</h3>
                            <p class="text-xs text-slate-500">Sinergi kurikulum Kemendikbudristek/Kemenag dengan kultur Pesantren Ali Masykur</p>
                        </div>
                    </div>
                    <span class="text-[11px] font-bold text-brand-800 bg-brand-50 px-2.5 py-1 rounded-full border border-brand-200/60 hidden sm:inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">verified</span>
                        <span>Standar Kurikulum Yayasan</span>
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs" id="pesantren-grid">
                    <!-- MI -->
                    <div class="pesantren-card p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-3 flex flex-col justify-between hover:border-slate-300 transition-colors" data-unit-code="MI-ALFA">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 font-bold text-slate-900">
                                    <span class="material-symbols-outlined text-teal-700 text-base">school</span>
                                    <h4>MI Tahfidz Alfa</h4>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-teal-100 text-teal-800">Fase A–C</span>
                            </div>
                            <ul class="text-slate-600 space-y-1.5 list-disc pl-4 leading-relaxed text-[11px]">
                                <li>Kurikulum Merdeka + KBC (Kurikulum Berbasis Cinta) Kemenag.</li>
                                <li>Program Unggulan Tahfidz Al-Qur'an Juz 30 &amp; Juz 1 secara mutqin.</li>
                                <li>Penanaman adab dan akhlakul karimah sejak dini (Fase A–C).</li>
                            </ul>
                        </div>
                        <button type="button" onclick="openPesantrenModal('MI-ALFA')" 
                                class="mt-3 w-full py-2 px-3 rounded-xl bg-white hover:bg-teal-50 text-teal-800 font-semibold text-xs border border-slate-200 transition-colors flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                            <span>Rincian Kurikulum MI</span>
                        </button>
                    </div>

                    <!-- SMP -->
                    <div class="pesantren-card p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-3 flex flex-col justify-between hover:border-slate-300 transition-colors" data-unit-code="SMP-ALFA">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 font-bold text-slate-900">
                                    <span class="material-symbols-outlined text-blue-700 text-base">school</span>
                                    <h4>SMP Alfa Ali Masykur</h4>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">Fase D</span>
                            </div>
                            <ul class="text-slate-600 space-y-1.5 list-disc pl-4 leading-relaxed text-[11px]">
                                <li>Kurikulum Merdeka Fase D dengan penguatan sains dan literasi.</li>
                                <li>Muatan Lokal Pesantren: Bahasa Arab terapan &amp; Mabadi'ul Fiqhiyyah.</li>
                                <li>Kokurikuler P5-RA bertema Kearifan Lokal dan Kebhinekaan Santri.</li>
                            </ul>
                        </div>
                        <button type="button" onclick="openPesantrenModal('SMP-ALFA')" 
                                class="mt-3 w-full py-2 px-3 rounded-xl bg-white hover:bg-blue-50 text-blue-800 font-semibold text-xs border border-slate-200 transition-colors flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                            <span>Rincian Kurikulum SMP</span>
                        </button>
                    </div>

                    <!-- SMA -->
                    <div class="pesantren-card p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-3 flex flex-col justify-between hover:border-slate-300 transition-colors" data-unit-code="SMA-ALFA">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 font-bold text-slate-900">
                                    <span class="material-symbols-outlined text-purple-700 text-base">school</span>
                                    <h4>SMA Alfa Ali Masykur</h4>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800">Fase E–F</span>
                            </div>
                            <ul class="text-slate-600 space-y-1.5 list-disc pl-4 leading-relaxed text-[11px]">
                                <li>Kurikulum Merdeka Fase E &amp; F (Peminatan MIPA dan IPS Terpadu).</li>
                                <li>Kajian Kitab Kuning Fathul Qorib dan Ta'lim Muta'allim.</li>
                                <li>Program kepemimpinan santri dan bimbingan masuk perguruan tinggi / Timur Tengah.</li>
                            </ul>
                        </div>
                        <button type="button" onclick="openPesantrenModal('SMA-ALFA')" 
                                class="mt-3 w-full py-2 px-3 rounded-xl bg-white hover:bg-purple-50 text-purple-800 font-semibold text-xs border border-slate-200 transition-colors flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                            <span>Rincian Kurikulum SMA</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- ======================================================== -->
        <!-- RIGHT PANEL (INDEKS KETERCAPAIAN & PETA JENJANG) -->
        <!-- ======================================================== -->
        <div class="xl:col-span-4 2xl:col-span-3 space-y-6">

            <!-- 1. INDEKS KETERCAPAIAN YAYASAN -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-3">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="material-symbols-outlined text-brand-700 text-lg">assessment</span>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Indeks Ketercapaian TP</h4>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center space-y-2">
                    <span class="text-3xl font-extrabold text-brand-800">100%</span>
                    <p class="text-[11px] text-slate-500">Seluruh TP di 3 unit telah tervalidasi dan diterapkan di silabus</p>
                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-brand-600 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
            </div>

            <!-- 2. PETA JENJANG & FASE -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 block">Peta Fase Pendidikan</span>
                
                <div class="space-y-2 text-xs">
                    <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-800 block">Fase A - C</span>
                            <span class="text-[11px] text-slate-500">Kelas 1 - 6 (MI Tahfidz)</span>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full bg-teal-100 font-bold text-[10px] text-teal-800">MI</span>
                    </div>

                    <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-800 block">Fase D</span>
                            <span class="text-[11px] text-slate-500">Kelas 7 - 9 (SMP Alfa)</span>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full bg-blue-100 font-bold text-[10px] text-blue-800">SMP</span>
                    </div>

                    <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-800 block">Fase E - F</span>
                            <span class="text-[11px] text-slate-500">Kelas 10 - 12 (SMA Alfa)</span>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full bg-purple-100 font-bold text-[10px] text-purple-800">SMA</span>
                    </div>
                </div>
            </div>

            <!-- 3. AGENDA DEWAN YAYASAN -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 text-center space-y-2">
                <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-800 mx-auto flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-2xl">event_upcoming</span>
                </div>
                <h5 class="text-xs font-bold text-slate-800">Rapat Triwulan Yayasan</h5>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Sinkronisasi kurikulum triwulanan bersama Majelis Pimpinan Yayasan dijadwalkan pada 10 November 2026.
                </p>
            </div>

        </div>

    </div>

    <!-- MODAL RINCIAN INTEGRASI KEPESANTRENAN -->
    <div id="pesantren-modal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-7 shadow-floating border border-slate-100 space-y-5 animate-in fade-in zoom-in-95 duration-200">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div id="modal-unit-icon" class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-800 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-xl">school</span>
                    </div>
                    <div>
                        <h3 id="modal-unit-title" class="text-sm font-bold text-slate-900">Rincian Muatan Kepesantrenan</h3>
                        <span id="modal-unit-subtitle" class="text-xs text-slate-500">Integrasi Kurikulum &amp; Standar Mutu Yayasan</span>
                    </div>
                </div>
                <button type="button" onclick="closePesantrenModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-base">close</span>
                </button>
            </div>

            <div id="modal-unit-content" class="space-y-4 text-xs">
                <!-- Injected via JavaScript -->
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[11px] text-slate-400">SK Majelis Kurikulum Pesantren No. 04/SK-KUR/2024</span>
                <button type="button" onclick="closePesantrenModal()" 
                        class="px-5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    const pesantrenData = {
        'MI-ALFA': {
            title: 'MI Tahfidz Alfa Ali Masykur',
            subtitle: 'Jenjang Dasar • Fase A - C (Kelas 1 - 6)',
            iconColor: 'bg-teal-50 text-teal-800',
            highlights: [
                { label: 'Target Utama Tahfidz', desc: 'Hafal Juz 30 dan Juz 1 secara mutqin dengan standar tajwid makhraj yang fasih.' },
                { label: 'Metode Pengajaran', desc: 'Kombinasi metode Talaqqi harian, Muraja\'ah berpasangan, dan Tasmi\' berkala setiap akhir triwulan.' },
                { label: 'Kitab & Muatan Lokal', desc: 'Mabadi\'ul Fiqhiyyah Juz 1, Al-Adab fil Islam, serta Hafalan Doa Harian dan Hadits Arbain pilihan.' },
                { label: 'Pembiasaan Karakter', desc: 'Sholat Dhuha berjamaah, Sholat Dzuhur berjamaah, dan pembiasaan adab makan-minum santri.' }
            ]
        },
        'SMP-ALFA': {
            title: 'SMP Alfa Ali Masykur Wonosobo',
            subtitle: 'Jenjang Menengah Pertama • Fase D (Kelas 7 - 9)',
            iconColor: 'bg-blue-50 text-blue-800',
            highlights: [
                { label: 'Kurikulum Penguat', desc: 'Harmonisasi Kurikulum Merdeka Fase D dengan penguatan literasi sains dan adab pesantren.' },
                { label: 'Kajian Kitab Kuning', desc: 'Mabadi\'ul Fiqhiyyah Juz 2-3, Safinatun Najah, Aqidatul Awam, dan Matan Al-Ajurumiyyah (Nahwu).' },
                { label: 'Bahasa Arab Terapan', desc: 'Muhadatsah Yaumiyyah (percakapan harian santri), penguasaan mufrodat tematik, dan insya\'.' },
                { label: 'Kokurikuler P5-RA', desc: 'Projek Bertema Kearifan Lokal: Ekologi Pesantren dan Budaya Moderasi Beragama Santri.' }
            ]
        },
        'SMA-ALFA': {
            title: 'SMA Alfa Ali Masykur Wonosobo',
            subtitle: 'Jenjang Menengah Atas • Fase E - F (Kelas 10 - 12)',
            iconColor: 'bg-purple-50 text-purple-800',
            highlights: [
                { label: 'Peminatan Akademik', desc: 'Kurikulum Merdeka Fase E & F: Peminatan Terpadu MIPA, Soshum, dan Keagamaan Islam.' },
                { label: 'Kajian Kitab Kuning Lanjutan', desc: 'Fathul Qorib Al-Mujib (Fiqih Madzhab Syafi\'i), Ta\'lim Muta\'allim (Etika Belajar), dan Ushul Fiqh Al-Waraqat.' },
                { label: 'Kepemimpinan & Dakwah', desc: 'Pelatihan Khutbah Jumat, Bahtsul Masail santri, pembekalan karya tulis ilmiah santri, dan TOAFL.' },
                { label: 'Bimbingan Lanjutan', desc: 'Persiapan seleksi Perguruan Tinggi Negeri (SNBP/SNBT) dan beasiswa universitas Timur Tengah (Al-Azhar Kairo, dll).' }
            ]
        }
    };

    function filterMonitoringUnit(unitCode) {
        // Update active tab buttons
        const tabs = document.querySelectorAll('.unit-filter-tab');
        tabs.forEach(tab => {
            tab.className = 'unit-filter-tab px-3 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer';
        });

        const activeTab = document.getElementById('unit-tab-' + unitCode);
        if (activeTab) {
            activeTab.className = 'unit-filter-tab px-3 py-1.5 rounded-full text-xs font-bold transition-all bg-brand-800 text-white shadow-subtle cursor-pointer';
        }

        // Filter unit stat cards
        const cards = document.querySelectorAll('.unit-stat-card');
        const grid = document.getElementById('monitoring-unit-grid');
        
        cards.forEach(card => {
            const cardUnit = card.getAttribute('data-unit-code');
            if (unitCode === 'all' || cardUnit === unitCode) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });

        if (unitCode === 'all') {
            grid.className = 'grid grid-cols-1 md:grid-cols-3 gap-5';
        } else {
            grid.className = 'grid grid-cols-1 md:grid-cols-1 gap-5 max-w-2xl';
        }

        // Sync with Matriks Integrasi Kepesantrenan cards
        const pesantrenCards = document.querySelectorAll('.pesantren-card');
        pesantrenCards.forEach(pCard => {
            const pUnit = pCard.getAttribute('data-unit-code');
            if (unitCode === 'all' || pUnit === unitCode) {
                pCard.style.display = 'flex';
            } else {
                pCard.style.display = 'none';
            }
        });
    }

    function openPesantrenModal(unitCode) {
        const data = pesantrenData[unitCode];
        if (!data) return;

        document.getElementById('modal-unit-title').textContent = data.title;
        document.getElementById('modal-unit-subtitle').textContent = data.subtitle;
        document.getElementById('modal-unit-icon').className = 'w-10 h-10 rounded-2xl flex items-center justify-center font-bold ' + data.iconColor;

        let html = '';
        data.highlights.forEach(item => {
            html += `
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="font-bold text-slate-900 block text-xs mb-1">${item.label}</span>
                    <p class="text-[11px] text-slate-600 leading-relaxed">${item.desc}</p>
                </div>
            `;
        });

        document.getElementById('modal-unit-content').innerHTML = html;
        document.getElementById('pesantren-modal').classList.remove('hidden');
    }

    function closePesantrenModal() {
        document.getElementById('pesantren-modal').classList.add('hidden');
    }

    // Close on backdrop click or ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePesantrenModal();
    });
    document.getElementById('pesantren-modal')?.addEventListener('click', function(e) {
        if (e.target === this) closePesantrenModal();
    });
</script>
@endsection
