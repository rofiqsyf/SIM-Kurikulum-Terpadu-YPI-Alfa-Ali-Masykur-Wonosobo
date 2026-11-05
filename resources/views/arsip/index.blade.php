@extends('layouts.app')

@section('title', 'Pusat Arsip Kurikulum & Pengawasan Tahunan')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6 max-w-[1600px] mx-auto">

    <!-- 2-COLUMN CANVAS -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">

        <!-- ======================================================== -->
        <!-- MAIN COLUMN (xl:col-span-8 or 9) -->
        <!-- ======================================================== -->
        <div class="xl:col-span-8 2xl:col-span-9 space-y-6">

            <!-- TOPBAR: BREADCRUMB & REALTIME READINESS INDICATOR -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-slate-800 transition-colors">Beranda</a>
                    <span class="text-slate-300">/</span>
                    <span class="font-medium text-slate-700">Tata Kelola Akademik</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-semibold text-brand-800">Arsip Kurikulum &amp; Pengawasan</span>
                </div>

                <div class="flex items-center gap-2 self-start sm:self-center text-xs font-semibold px-3.5 py-1.5 rounded-2xl bg-white border border-slate-200/80 shadow-subtle shrink-0">
                    <span class="w-2 h-2 rounded-full {{ $persentaseKesiapan >= 80 ? 'bg-emerald-500' : 'bg-amber-500 animate-pulse' }}"></span>
                    <span class="text-slate-600">Kesiapan Supervisi:</span>
                    <span class="font-bold {{ $persentaseKesiapan >= 80 ? 'text-emerald-700' : 'text-amber-700' }}">{{ $persentaseKesiapan }}% Siap Audit</span>
                </div>
            </div>

            <!-- HERO OVERVIEW CARD -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative">
                <div class="space-y-3 max-w-xl z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-600"></span>
                        <span>Bank Data &amp; Portofolio Pengawasan Berkala</span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 leading-tight">
                        Arsip Dokumen Kurikulum &amp; Pengawasan Tahunan
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Dokumentasi terpusat KOSP/KOM, Alur Tujuan Pembelajaran (ATP), Modul Ajar berdiferensiasi, Modul P5-RA, dan instrumen asesmen terstandarisasi untuk visitasi pengawas dinas, Kemenag, dan akreditasi BAN-PDM.
                    </p>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        @if($user->isAdmin() || $user->isWakaKurikulum() || $user->isKepalaSekolah())
                            <button type="button" onclick="openModalTambahArsip()" 
                                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all cursor-pointer">
                                <span class="material-symbols-outlined text-base">file_upload</span>
                                <span>Arsipkan Dokumen Resmi</span>
                            </button>
                        @endif

                        <button type="button" onclick="window.print()" 
                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-base">print</span>
                            <span>Cetak Portofolio Supervisi</span>
                        </button>
                    </div>
                </div>

                <!-- 3D Isometric Archive & Verification Graphic -->
                <div class="shrink-0 flex items-center justify-center md:pr-4">
                    <svg class="w-40 h-36 sm:w-48 sm:h-44 drop-shadow-sm select-none" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Bottom Base / Platform -->
                        <path d="M30 140 L120 185 L210 140 L120 95 Z" fill="#065f46" />
                        <path d="M30 140 L30 152 L120 197 L120 185 Z" fill="#064e3b" />
                        <path d="M120 185 L120 197 L210 152 L210 140 Z" fill="#047857" />
                        
                        <!-- Archive Folder Stack (Isometric) -->
                        <!-- Folder 1 (Bottom - Blue) -->
                        <path d="M45 125 L115 155 L185 125 L115 95 Z" fill="#1e3a8a" />
                        <path d="M45 125 L45 133 L115 163 L115 155 Z" fill="#172554" />
                        <path d="M115 155 L115 163 L185 133 L185 125 Z" fill="#1e40af" />
                        
                        <!-- Folder 2 (Middle - Emerald) -->
                        <path d="M50 110 L120 140 L190 110 L120 80 Z" fill="#10b981" />
                        <path d="M50 110 L50 118 L120 148 L120 140 Z" fill="#059669" />
                        <path d="M120 140 L120 148 L190 118 L190 110 Z" fill="#34d399" />
                        <path d="M55 111 L55 116 L118 144 L118 139 Z" fill="#ecfdf5" />
                        <path d="M122 139 L122 144 L185 116 L185 111 Z" fill="#d1fae5" />

                        <!-- Folder 3 (Top - Slate/White Official Document) -->
                        <path d="M60 85 L120 112 L180 85 L120 58 Z" fill="#ffffff" stroke="#e2e8f0" stroke-width="1.5" />
                        <path d="M60 85 L60 93 L120 120 L120 112 Z" fill="#cbd5e1" />
                        <path d="M120 112 L120 120 L180 93 L180 85 Z" fill="#94a3b8" />
                        
                        <!-- Document lines -->
                        <line x1="85" y1="80" x2="135" y2="70" stroke="#065f46" stroke-width="2.5" stroke-linecap="round" />
                        <line x1="90" y1="88" x2="145" y2="78" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                        <line x1="95" y1="96" x2="130" y2="90" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />

                        <!-- Verification Seal / Badge -->
                        <circle cx="155" cy="55" r="22" fill="#059669" />
                        <circle cx="155" cy="55" r="18" fill="#10b981" stroke="#34d399" stroke-width="1.5" />
                        <path d="M148 55 L153 60 L163 49" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        
                        <!-- Ribbons hanging from seal -->
                        <path d="M149 71 L145 92 L153 87 L157 91 L155 71 Z" fill="#047857" />
                        <path d="M157 71 L157 91 L162 86 L168 90 L163 71 Z" fill="#065f46" />
                    </svg>
                </div>
            </div>

            <!-- METRIC READINESS STAT TILES (4 CARDS) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Stat 1: Total Dokumen -->
                <div class="p-5 rounded-3xl bg-white border border-slate-100 shadow-subtle flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Berkas</span>
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                            <span class="material-symbols-outlined text-lg">folder</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-2xl font-black text-slate-900">{{ $totalDokumen }}</div>
                        <p class="text-[11px] text-slate-500 mt-0.5">Dokumen dalam portofolio</p>
                    </div>
                </div>

                <!-- Stat 2: Terverifikasi -->
                <div class="p-5 rounded-3xl bg-white border border-slate-100 shadow-subtle flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Terverifikasi</span>
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <span class="material-symbols-outlined text-lg">verified</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-2xl font-black text-emerald-700">{{ $totalTerverifikasi }}</div>
                        <p class="text-[11px] text-emerald-600 font-semibold mt-0.5">{{ $persentaseKesiapan }}% memenuhi standar</p>
                    </div>
                </div>

                <!-- Stat 3: Perlu Dilengkapi -->
                <div class="p-5 rounded-3xl bg-white border border-slate-100 shadow-subtle flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Perlu Dilengkapi</span>
                        <div class="w-8 h-8 rounded-xl {{ $totalPerluRevisi > 0 ? 'bg-rose-50 text-rose-700' : 'bg-slate-50 text-slate-400' }} flex items-center justify-center">
                            <span class="material-symbols-outlined text-lg">report_problem</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-2xl font-black {{ $totalPerluRevisi > 0 ? 'text-rose-700' : 'text-slate-800' }}">{{ $totalPerluRevisi }}</div>
                        <p class="text-[11px] {{ $totalPerluRevisi > 0 ? 'text-rose-600 font-semibold' : 'text-slate-500' }} mt-0.5">Catatan revisi pengawas</p>
                    </div>
                </div>

                <!-- Stat 4: Menunggu Supervisi -->
                <div class="p-5 rounded-3xl bg-white border border-slate-100 shadow-subtle flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Menunggu Review</span>
                        <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center">
                            <span class="material-symbols-outlined text-lg">schedule</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-2xl font-black text-amber-700">{{ $totalDraft }}</div>
                        <p class="text-[11px] text-slate-500 mt-0.5">Antrean validasi berkala</p>
                    </div>
                </div>
            </div>

            <!-- FILTER & SEARCH TOOLBAR -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-5 space-y-4">
                <form id="filter-arsip-form" method="GET" action="{{ route('arsip.index') }}" class="space-y-4">
                    <!-- Top Filters: Lembaga & Tahun Ajaran & Search -->
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                        <!-- Unit Dropdown -->
                        <div class="sm:col-span-4">
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Unit Lembaga</label>
                            <select name="unit_id" onchange="this.form.submit()" 
                                    class="w-full text-xs font-semibold px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600 text-slate-800">
                                <option value="all" {{ $selectedUnitId === 'all' ? 'selected' : '' }}>Seluruh Lembaga (MI, SMP, SMA)</option>
                                @foreach($units as $u)
                                    <option value="{{ $u->id }}" {{ (string)$selectedUnitId === (string)$u->id ? 'selected' : '' }}>
                                        {{ $u->nama_unit }} ({{ $u->kode_unit }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tahun Ajaran Dropdown -->
                        <div class="sm:col-span-3">
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Tahun Ajaran</label>
                            <select name="tahun" onchange="this.form.submit()" 
                                    class="w-full text-xs font-semibold px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600 text-slate-800">
                                <option value="all" {{ $selectedTahun === 'all' ? 'selected' : '' }}>Seluruh Tahun Ajaran</option>
                                @foreach($availableYears as $thn)
                                    <option value="{{ $thn }}" {{ $selectedTahun === $thn ? 'selected' : '' }}>
                                        T.A. {{ $thn }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Live Search Input -->
                        <div class="sm:col-span-5">
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Cari Dokumen</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base">search</span>
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul, kode, atau pengawas..." 
                                       class="w-full pl-9 pr-8 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600 text-slate-800 placeholder-slate-400">
                                @if(request('q'))
                                    <a href="{{ route('arsip.index', ['unit_id' => $selectedUnitId, 'tahun' => $selectedTahun, 'kategori' => $selectedKategori]) }}" 
                                       class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                        <span class="material-symbols-outlined text-sm">close</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Kategori Pills Bar -->
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 pt-1 scrollbar-none">
                        <input type="hidden" name="kategori" id="hidden-kategori-input" value="{{ $selectedKategori }}">
                        
                        @php
                            $kategoriList = [
                                'all' => 'Semua Kategori',
                                'kosp' => 'KOSP / KOM',
                                'atp' => 'Alur TP (ATP)',
                                'modul_ajar' => 'Modul Ajar',
                                'p5_ra' => 'Modul P5-RA',
                                'sk_pengesahan' => 'SK & Beban Kerja',
                                'instrumen_asesmen' => 'Instrumen Asesmen'
                            ];
                        @endphp

                        @foreach($kategoriList as $key => $label)
                            <button type="button" onclick="selectKategoriFilter('{{ $key }}')" 
                                    class="shrink-0 px-3 py-1.5 rounded-full text-xs font-semibold transition-all {{ $selectedKategori === $key ? 'bg-brand-800 text-white shadow-subtle' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </form>
            </div>

            <!-- DOCUMENTS ARCHIVE TABLE / LIST -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Daftar Dokumen Portofolio Pengawasan</h3>
                        <p class="text-[11px] text-slate-500">Menampilkan {{ $documents->count() }} dokumen arsip akademik</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-[11px] font-semibold text-slate-400">Format: Permendikbudristek 12/2024 &amp; KMA 450/2024</span>
                    </div>
                </div>

                @if($documents->isEmpty())
                    <div class="p-12 text-center space-y-3">
                        <div class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-200 text-slate-400 mx-auto flex items-center justify-center">
                            <span class="material-symbols-outlined text-2xl">folder_off</span>
                        </div>
                        <div class="space-y-1">
                            <h4 class="text-sm font-bold text-slate-800">Tidak Ada Dokumen yang Cocok</h4>
                            <p class="text-xs text-slate-500 max-w-sm mx-auto">
                                Belum ada dokumen pengawasan yang terdaftar untuk kriteria filter yang dipilih. Silakan sesuaikan filter atau tambahkan arsip dokumen baru.
                            </p>
                        </div>
                        @if($user->isAdmin() || $user->isWakaKurikulum() || $user->isKepalaSekolah())
                            <button type="button" onclick="openModalTambahArsip()" 
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all">
                                <span class="material-symbols-outlined text-base">add</span>
                                <span>Arsipkan Dokumen Sekarang</span>
                            </button>
                        @endif
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50/75 text-[11px] uppercase tracking-wider text-slate-400 font-bold">
                                    <th class="py-3 px-5">Kode &amp; Tanggal</th>
                                    <th class="py-3 px-4">Dokumen &amp; Tingkat</th>
                                    <th class="py-3 px-4">Kategori &amp; T.A.</th>
                                    <th class="py-3 px-4">Supervisi Pengawas</th>
                                    <th class="py-3 px-5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @foreach($documents as $doc)
                                    @php
                                        $kb = $doc->kategori_badge;
                                        $sb = $doc->status_badge;
                                    @endphp
                                    <tr class="hover:bg-slate-50/70 transition-colors group">
                                        <!-- Kode & Tanggal -->
                                        <td class="py-4 px-5 align-top">
                                            <div class="font-mono font-bold text-slate-800">{{ $doc->kode_dokumen }}</div>
                                            <div class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1.5">
                                                <span>{{ $doc->tanggal_arsip?->format('d M Y') ?? '-' }}</span>
                                                <span>•</span>
                                                <span class="font-medium text-slate-500">{{ $doc->file_size ?? 'PDF' }}</span>
                                            </div>
                                        </td>

                                        <!-- Judul & Lembaga & Fase -->
                                        <td class="py-4 px-4 align-top max-w-sm">
                                            <div class="font-bold text-slate-900 group-hover:text-brand-800 transition-colors leading-snug">
                                                {{ $doc->judul_dokumen }}
                                            </div>
                                            <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-semibold text-[10px] border border-slate-200/60">
                                                    {{ $doc->unit->nama_unit ?? 'Seluruh Unit' }}
                                                </span>
                                                @if($doc->tingkat_fase)
                                                    <span class="text-[11px] text-slate-500 font-medium">
                                                        {{ $doc->tingkat_fase }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Kategori & T.A. -->
                                        <td class="py-4 px-4 align-top">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold border {{ $kb['class'] }}">
                                                {{ $kb['label'] }}
                                            </span>
                                            <div class="text-[11px] text-slate-500 mt-1 font-medium">
                                                T.A. {{ $doc->tahun_ajaran }} ({{ $doc->semester }})
                                            </div>
                                        </td>

                                        <!-- Supervisi Pengawas & Catatan -->
                                        <td class="py-4 px-4 align-top max-w-xs">
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $sb['class'] }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $sb['dot'] }}"></span>
                                                <span>{{ $sb['label'] }}</span>
                                            </div>

                                            @if($doc->nama_pengawas)
                                                <div class="text-[11px] font-semibold text-slate-700 mt-1.5 flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-xs text-brand-700">person_check</span>
                                                    <span class="truncate" title="{{ $doc->nama_pengawas }}">{{ $doc->nama_pengawas }}</span>
                                                </div>
                                            @endif

                                            @if($doc->catatan_supervisi)
                                                <p class="text-[10px] text-slate-500 mt-0.5 line-clamp-2 italic" title="{{ $doc->catatan_supervisi }}">
                                                    "{{ $doc->catatan_supervisi }}"
                                                </p>
                                            @endif
                                        </td>

                                        <!-- Aksi Buttons -->
                                        <td class="py-4 px-5 align-top text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <!-- Tombol Detail / Verifikasi -->
                                                <button type="button" 
                                                        onclick="openModalDetailArsip({{ json_encode($doc) }}, '{{ $kb['label'] }}', '{{ $sb['label'] }}', '{{ $sb['class'] }}')"
                                                        class="p-1.5 rounded-xl bg-slate-100 hover:bg-brand-50 hover:text-brand-800 text-slate-600 transition-colors"
                                                        title="Detail &amp; Riwayat Supervisi">
                                                    <span class="material-symbols-outlined text-base">visibility</span>
                                                </button>

                                                <!-- Tombol Unduh / Pratinjau -->
                                                <button type="button" 
                                                        onclick="simulasiUnduhDokumen('{{ $doc->kode_dokumen }}', '{{ $doc->judul_dokumen }}')"
                                                        class="p-1.5 rounded-xl bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 text-slate-600 transition-colors"
                                                        title="Unduh Berkas Resmi (PDF)">
                                                    <span class="material-symbols-outlined text-base">download</span>
                                                </button>

                                                <!-- Tombol Hapus (Hanya Waka / Kepsek / Admin) -->
                                                @if($user->isAdmin() || $user->isWakaKurikulum() || $user->isKepalaSekolah())
                                                    <form method="POST" action="{{ route('arsip.destroy', $doc->id) }}" class="inline" 
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus arsip dokumen resmi {{ $doc->kode_dokumen }}?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="p-1.5 rounded-xl bg-slate-100 hover:bg-rose-50 hover:text-rose-700 text-slate-400 hover:text-rose-600 transition-colors"
                                                                title="Hapus Arsip">
                                                            <span class="material-symbols-outlined text-base">delete</span>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- AUDIT FOOTER NOTICE -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs text-slate-600 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-brand-700 text-lg">verified_user</span>
                    <span>Portofolio dokumen di atas diverifikasi langsung oleh Waka Kurikulum, Kepala Sekolah, dan Pengawas Pembina.</span>
                </div>
                <div class="text-[11px] font-semibold text-slate-400">
                    Siklus Audit: Semesteran &amp; Tahunan
                </div>
            </div>

        </div>


        <!-- ======================================================== -->
        <!-- RIGHT SIDEBAR (xl:col-span-4 or 3) -->
        <!-- ======================================================== -->
        <div class="xl:col-span-4 2xl:col-span-3 space-y-6">

            <!-- CHECKLIST 6 STANDAR PENGAWASAN TAHUNAN -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="space-y-0.5">
                        <h3 class="text-sm font-bold text-slate-900">Instrumen Pengawasan Tahunan</h3>
                        <p class="text-[11px] text-slate-500">6 Portofolio Wajib Kurikulum Merdeka</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-brand-50 text-brand-800">
                        Permendikbud 12/2024
                    </span>
                </div>

                @php
                    $checkKosp = $documents->where('kategori', 'kosp')->count();
                    $checkAtp = $documents->where('kategori', 'atp')->count();
                    $checkModul = $documents->where('kategori', 'modul_ajar')->count();
                    $checkP5 = $documents->where('kategori', 'p5_ra')->count();
                    $checkSk = $documents->where('kategori', 'sk_pengesahan')->count();
                    $checkAsesmen = $documents->where('kategori', 'instrumen_asesmen')->count();

                    $standards = [
                        [
                            'title' => '1. Dokumen KOSP / KOM',
                            'desc' => 'Karakteristik satuan, visi-misi, dan pengorganisasian.',
                            'count' => $checkKosp,
                            'status' => $checkKosp > 0 ? 'Lengkap' : 'Belum Ada',
                            'ok' => $checkKosp > 0,
                        ],
                        [
                            'title' => '2. Matriks Alur Tujuan (ATP)',
                            'desc' => 'Rangkaian Tujuan Pembelajaran sistematis per fase.',
                            'count' => $checkAtp,
                            'status' => $checkAtp > 0 ? 'Lengkap' : 'Belum Ada',
                            'ok' => $checkAtp > 0,
                        ],
                        [
                            'title' => '3. Modul Ajar Berdiferensiasi',
                            'desc' => 'Langkah pembelajaran & asesmen formatif tiap mapel.',
                            'count' => $checkModul,
                            'status' => $checkModul > 0 ? 'Lengkap' : 'Belum Ada',
                            'ok' => $checkModul > 0,
                        ],
                        [
                            'title' => '4. Modul Projek P5-RA',
                            'desc' => 'Tema kearifan lokal & Rahmatan Lil Alamin.',
                            'count' => $checkP5,
                            'status' => $checkP5 > 0 ? 'Lengkap' : 'Belum Ada',
                            'ok' => $checkP5 > 0,
                        ],
                        [
                            'title' => '5. SK Tim Pengembang & Tugas',
                            'desc' => 'SK TPK kurikulum dan penetapan beban mengajar guru.',
                            'count' => $checkSk,
                            'status' => $checkSk > 0 ? 'Lengkap' : 'Belum Ada',
                            'ok' => $checkSk > 0,
                        ],
                        [
                            'title' => '6. Instrumen & Rubrik Asesmen',
                            'desc' => 'Pedoman asesmen sumatif, kisi-kisi, & kriteria ketercapaian.',
                            'count' => $checkAsesmen,
                            'status' => $checkAsesmen > 0 ? 'Lengkap' : 'Belum Ada',
                            'ok' => $checkAsesmen > 0,
                        ],
                    ];
                @endphp

                <div class="space-y-3 pt-1">
                    @foreach($standards as $std)
                        <div class="p-3 rounded-2xl {{ $std['ok'] ? 'bg-emerald-50/50 border border-emerald-100' : 'bg-slate-50 border border-slate-200/60' }} flex items-start justify-between gap-3">
                            <div class="space-y-0.5">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm {{ $std['ok'] ? 'text-emerald-600' : 'text-slate-400' }}">
                                        {{ $std['ok'] ? 'check_circle' : 'radio_button_unchecked' }}
                                    </span>
                                    <span class="text-xs font-bold {{ $std['ok'] ? 'text-slate-900' : 'text-slate-600' }}">
                                        {{ $std['title'] }}
                                    </span>
                                </div>
                                <p class="text-[10px] text-slate-500 pl-5">{{ $std['desc'] }}</p>
                            </div>

                            <span class="shrink-0 text-[10px] font-bold px-2 py-0.5 rounded-full {{ $std['ok'] ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                {{ $std['ok'] ? $std['count'] . ' Berkas' : 'Perlu Diisi' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- PENGAWAS PEMBINA DIRECTORY -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900">Pengawas Pembina Resmi</h3>
                    <span class="material-symbols-outlined text-brand-700 text-lg">supervisor_account</span>
                </div>

                <div class="space-y-3">
                    <!-- Pengawas SMP -->
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-brand-800">SMP Alfa Ali Masykur</span>
                            <span class="text-[10px] font-semibold text-slate-400">Disdikbud</span>
                        </div>
                        <div class="text-xs font-bold text-slate-900">Drs. H. Suwandi, M.Pd.</div>
                        <p class="text-[11px] text-slate-500">Pengawas Sekolah Madya Disdikbud Kab. Wonosobo</p>
                    </div>

                    <!-- Pengawas MI -->
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700">MI Tahfidz Alfa</span>
                            <span class="text-[10px] font-semibold text-slate-400">Kemenag</span>
                        </div>
                        <div class="text-xs font-bold text-slate-900">Hj. Siti Marhamah, S.Ag., M.Pd.I.</div>
                        <p class="text-[11px] text-slate-500">Pengawas Madrasah Seksi Pendis Kemenag Wonosobo</p>
                    </div>

                    <!-- Pengawas SMA -->
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-blue-700">SMA Alfa Ali Masykur</span>
                            <span class="text-[10px] font-semibold text-slate-400">Balai Dikmen</span>
                        </div>
                        <div class="text-xs font-bold text-slate-900">Drs. Bambang Sudarsono, M.M.</div>
                        <p class="text-[11px] text-slate-500">Pengawas Cabang Dinas Pendidikan Wilayah IX Jateng</p>
                    </div>
                </div>
            </div>

            <!-- PANDUAN PENGAWASAN CARD -->
            <div class="p-5 rounded-3xl bg-brand-50 border border-brand-100 space-y-3">
                <div class="w-9 h-9 rounded-2xl bg-brand-800 text-white flex items-center justify-center">
                    <span class="material-symbols-outlined text-lg">fact_check</span>
                </div>

                <div class="space-y-1">
                    <h4 class="text-xs font-bold text-brand-900">Standar Visitasi Supervisi</h4>
                    <p class="text-[11px] text-brand-800 leading-relaxed">
                        Sebelum visitasi pengawas, pastikan seluruh dokumen bertanda status <strong>Terverifikasi</strong> telah divalidasi oleh Waka Kurikulum dan ditandatangani Kepala Sekolah.
                    </p>
                </div>

                <a href="{{ route('guide.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-800 hover:text-brand-900">
                    <span>Baca Pedoman Supervisi Akademik</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

        </div>

    </div>

</div>

<!-- ======================================================== -->
<!-- MODAL: TAMBAH DOKUMEN ARSIP BARU -->
<!-- ======================================================== -->
<div id="modal-tambah-arsip-backdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden transition-opacity" onclick="closeModalTambahArsip()"></div>

<div id="modal-tambah-arsip" 
     class="fixed inset-y-0 right-0 w-full sm:w-[540px] bg-white z-50 shadow-floating transform translate-x-full transition-transform duration-200 ease-in-out flex flex-col justify-between overflow-hidden">
    
    <!-- Modal Header -->
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between shrink-0 bg-slate-50/50">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                <span class="material-symbols-outlined text-xl">upload_file</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900">Arsipkan Dokumen Resmi</h3>
                <p class="text-[11px] text-slate-500">Registrasi dokumen kurikulum untuk pengawasan tahunan</p>
            </div>
        </div>
        <button type="button" onclick="closeModalTambahArsip()" class="text-slate-400 hover:text-slate-600 p-1 rounded-xl">
            <span class="material-symbols-outlined text-xl">close</span>
        </button>
    </div>

    <!-- Modal Form Body -->
    <form method="POST" action="{{ route('arsip.store') }}" class="flex-1 overflow-y-auto p-6 space-y-4 text-xs">
        @csrf

        <!-- Unit Lembaga -->
        <div>
            <label class="block font-bold text-slate-700 mb-1">Unit Lembaga Pendidikan <span class="text-rose-500">*</span></label>
            <select name="unit_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600">
                @foreach($units as $u)
                    <option value="{{ $u->id }}" {{ $user->unit_id == $u->id ? 'selected' : '' }}>
                        {{ $u->nama_unit }} ({{ $u->kode_unit }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Judul Dokumen -->
        <div>
            <label class="block font-bold text-slate-700 mb-1">Judul Dokumen Lengkap <span class="text-rose-500">*</span></label>
            <input type="text" name="judul_dokumen" required placeholder="Contoh: Modul Ajar PAI Fase D Semester Ganjil 2024/2025" 
                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600">
        </div>

        <!-- Kategori & Tingkat/Fase Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="block font-bold text-slate-700 mb-1">Kategori Dokumen <span class="text-rose-500">*</span></label>
                <select name="kategori" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600">
                    <option value="kosp">KOSP / KOM Resmi</option>
                    <option value="atp">Alur Tujuan Pembelajaran (ATP)</option>
                    <option value="modul_ajar" selected>Modul Ajar / RPP Berdiferensiasi</option>
                    <option value="p5_ra">Modul Projek P5-RA</option>
                    <option value="sk_pengesahan">SK Pengesahan / Beban Mengajar</option>
                    <option value="instrumen_asesmen">Instrumen &amp; Rubrik Asesmen</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Tingkat / Fase</label>
                <input type="text" name="tingkat_fase" placeholder="Contoh: Fase D (Kelas 7, 8, 9)" 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600">
            </div>
        </div>

        <!-- Tahun Ajaran & Semester Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="block font-bold text-slate-700 mb-1">Tahun Ajaran <span class="text-rose-500">*</span></label>
                <input type="text" name="tahun_ajaran" value="2024/2025" required 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Semester <span class="text-rose-500">*</span></label>
                <select name="semester" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600">
                    <option value="Ganjil" selected>Ganjil</option>
                    <option value="Genap">Genap</option>
                    <option value="Tahunan">Tahunan (Satu Tahun Ajaran)</option>
                </select>
            </div>
        </div>

        <!-- Tanggal Pengesahan & Ukuran Berkas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="block font-bold text-slate-700 mb-1">Tanggal Terbit / Arsip <span class="text-rose-500">*</span></label>
                <input type="date" name="tanggal_arsip" value="{{ date('Y-m-d') }}" required 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Keterangan Ukuran File</label>
                <input type="text" name="file_size" value="3.2 MB PDF" 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600">
            </div>
        </div>

        <!-- Status Verifikasi Awal -->
        <div>
            <label class="block font-bold text-slate-700 mb-1">Status Verifikasi Pengawasan <span class="text-rose-500">*</span></label>
            <select name="status_verifikasi" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600 font-semibold">
                <option value="Terverifikasi" selected>Terverifikasi Lengkap (Siap Audit Pengawas)</option>
                <option value="Menunggu Supervisi">Menunggu Supervisi (Draft / Antrean)</option>
                <option value="Perlu Dilengkapi">Perlu Dilengkapi (Ada Catatan Revisi)</option>
            </select>
        </div>

        <!-- Nama Pengawas Pembina / Validator -->
        <div>
            <label class="block font-bold text-slate-700 mb-1">Nama Pengawas Pembina / Validator</label>
            <input type="text" name="nama_pengawas" placeholder="Contoh: Drs. H. Suwandi, M.Pd. (Pengawas Disdikbud)" 
                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600">
        </div>

        <!-- Catatan Supervisi -->
        <div>
            <label class="block font-bold text-slate-700 mb-1">Catatan Hasil Supervisi / Rekomendasi</label>
            <textarea name="catatan_supervisi" rows="3" placeholder="Masukkan catatan keselarasan, temuan monev, atau rekomendasi penyempurnaan..." 
                      class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600"></textarea>
        </div>

        <!-- Submit Button Footer -->
        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
            <button type="button" onclick="closeModalTambahArsip()" 
                    class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition-all">
                Batal
            </button>
            <button type="submit" 
                    class="px-5 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white font-semibold shadow-subtle transition-all cursor-pointer">
                Simpan Dokumen Arsip
            </button>
        </div>
    </form>
</div>

<!-- ======================================================== -->
<!-- MODAL: DETAIL & PERBARUI STATUS SUPERVISI -->
<!-- ======================================================== -->
<div id="modal-detail-arsip-backdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden transition-opacity" onclick="closeModalDetailArsip()"></div>

<div id="modal-detail-arsip" 
     class="fixed inset-y-0 right-0 w-full sm:w-[540px] bg-white z-50 shadow-floating transform translate-x-full transition-transform duration-200 ease-in-out flex flex-col justify-between overflow-hidden">
    
    <!-- Header -->
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between shrink-0 bg-slate-50/50">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                <span class="material-symbols-outlined text-xl">description</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900" id="detail-judul">Detail Arsip Dokumen</h3>
                <span class="font-mono text-[10px] text-slate-500 font-semibold" id="detail-kode">DOK-XXXX</span>
            </div>
        </div>
        <button type="button" onclick="closeModalDetailArsip()" class="text-slate-400 hover:text-slate-600 p-1 rounded-xl">
            <span class="material-symbols-outlined text-xl">close</span>
        </button>
    </div>

    <!-- Content & Status Update Form -->
    <div class="flex-1 overflow-y-auto p-6 space-y-5 text-xs">
        
        <!-- Metadata Overview Card -->
        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-3">
            <div class="flex items-center justify-between">
                <span id="detail-kategori-badge" class="px-2.5 py-0.5 rounded-md text-[10px] font-bold border bg-white">Kategori</span>
                <span id="detail-status-badge" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border bg-white">Status</span>
            </div>

            <div class="grid grid-cols-2 gap-2 text-slate-600 pt-1">
                <div>
                    <span class="text-[10px] text-slate-400 uppercase font-bold block">Lembaga</span>
                    <span id="detail-unit" class="font-semibold text-slate-800">-</span>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 uppercase font-bold block">Tingkat / Fase</span>
                    <span id="detail-fase" class="font-semibold text-slate-800">-</span>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 uppercase font-bold block">Tahun Ajaran</span>
                    <span id="detail-tahun" class="font-semibold text-slate-800">-</span>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 uppercase font-bold block">Tanggal Terbit</span>
                    <span id="detail-tanggal" class="font-semibold text-slate-800">-</span>
                </div>
            </div>

            <!-- Download Button -->
            <div class="pt-2 border-t border-slate-200/60">
                <button type="button" id="detail-download-btn" 
                        class="w-full py-2 px-3 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-800 font-semibold flex items-center justify-center gap-2 shadow-subtle transition-all">
                    <span class="material-symbols-outlined text-base text-brand-700">file_download</span>
                    <span>Unduh Salinan Berkas (PDF / Dokumen)</span>
                </button>
            </div>
        </div>

        <!-- Verification / Supervision Notes Section -->
        <div class="space-y-3">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-base text-slate-600">rate_review</span>
                <h4 class="font-bold text-slate-900">Catatan &amp; Evaluasi Pengawas</h4>
            </div>

            @if($user->isAdmin() || $user->isWakaKurikulum() || $user->isKepalaSekolah() || $user->isYayasan())
                <!-- Editable Form for Authorized Roles -->
                <form id="form-update-status" method="POST" action="" class="space-y-3 p-4 rounded-2xl bg-white border border-slate-200/80 shadow-subtle">
                    @csrf

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Status Verifikasi Pengawasan</label>
                        <select name="status_verifikasi" id="detail-select-status" required 
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600 font-semibold text-slate-800">
                            <option value="Terverifikasi">Terverifikasi (Memenuhi Standar Kurikulum)</option>
                            <option value="Perlu Dilengkapi">Perlu Dilengkapi (Revisi / Dokumen Kurang)</option>
                            <option value="Menunggu Supervisi">Menunggu Supervisi (Antrean Monev)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Pengawas Pembina / Validator</label>
                        <input type="text" name="nama_pengawas" id="detail-input-pengawas" placeholder="Contoh: Drs. H. Suwandi, M.Pd." 
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Catatan Supervisi / Rekomendasi</label>
                        <textarea name="catatan_supervisi" id="detail-input-catatan" rows="4" placeholder="Tuliskan catatan hasil supervisi pengawas atau arahan penyempurnaan..." 
                                  class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-600"></textarea>
                    </div>

                    <button type="submit" 
                            class="w-full py-2.5 rounded-xl bg-brand-800 hover:bg-brand-900 text-white font-semibold shadow-subtle transition-all cursor-pointer">
                        Perbarui Catatan &amp; Status Supervisi
                    </button>
                </form>
            @else
                <!-- Read-only View for Teachers & Guests -->
                <div class="p-4 rounded-2xl bg-white border border-slate-200/80 space-y-2">
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase font-bold block">Pengawas Pembina</span>
                        <span id="detail-readonly-pengawas" class="font-bold text-slate-800">-</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase font-bold block">Catatan Supervisi</span>
                        <p id="detail-readonly-catatan" class="text-slate-600 italic bg-slate-50 p-2.5 rounded-xl border border-slate-100 mt-1">-</p>
                    </div>
                </div>
            @endif
        </div>

    </div>

    <!-- Footer -->
    <div class="px-6 py-3 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end">
        <button type="button" onclick="closeModalDetailArsip()" 
                class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold transition-all">
            Tutup
        </button>
    </div>
</div>

<!-- ======================================================== -->
<!-- JAVASCRIPT LOGIC & INTERACTIONS -->
<!-- ======================================================== -->
<script>
    function selectKategoriFilter(kat) {
        document.getElementById('hidden-kategori-input').value = kat;
        document.getElementById('filter-arsip-form').submit();
    }

    // Modal Tambah Arsip
    function openModalTambahArsip() {
        const modal = document.getElementById('modal-tambah-arsip');
        const backdrop = document.getElementById('modal-tambah-arsip-backdrop');
        backdrop.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('translate-x-full');
        }, 10);
    }

    function closeModalTambahArsip() {
        const modal = document.getElementById('modal-tambah-arsip');
        const backdrop = document.getElementById('modal-tambah-arsip-backdrop');
        modal.classList.add('translate-x-full');
        setTimeout(() => {
            backdrop.classList.add('hidden');
        }, 200);
    }

    // Modal Detail Arsip
    function openModalDetailArsip(doc, kategoriLabel, statusLabel, statusClass) {
        document.getElementById('detail-judul').textContent = doc.judul_dokumen;
        document.getElementById('detail-kode').textContent = doc.kode_dokumen;
        
        const katBadge = document.getElementById('detail-kategori-badge');
        katBadge.textContent = kategoriLabel;

        const statBadge = document.getElementById('detail-status-badge');
        statBadge.textContent = statusLabel;
        statBadge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold border ' + statusClass;

        document.getElementById('detail-unit').textContent = doc.unit ? doc.unit.nama_unit : 'Seluruh Unit';
        document.getElementById('detail-fase').textContent = doc.tingkat_fase || '-';
        document.getElementById('detail-tahun').textContent = (doc.tahun_ajaran || '') + ' (' + (doc.semester || '') + ')';
        document.getElementById('detail-tanggal').textContent = doc.tanggal_arsip ? doc.tanggal_arsip.substring(0, 10) : '-';

        // Set action form if present
        const formUpdate = document.getElementById('form-update-status');
        if (formUpdate) {
            formUpdate.action = '/arsip/' + doc.id + '/status';
            const selStatus = document.getElementById('detail-select-status');
            if (selStatus) selStatus.value = doc.status_verifikasi;
            const inPengawas = document.getElementById('detail-input-pengawas');
            if (inPengawas) inPengawas.value = doc.nama_pengawas || '';
            const inCatatan = document.getElementById('detail-input-catatan');
            if (inCatatan) inCatatan.value = doc.catatan_supervisi || '';
        } else {
            const roPengawas = document.getElementById('detail-readonly-pengawas');
            if (roPengawas) roPengawas.textContent = doc.nama_pengawas || 'Belum diisi';
            const roCatatan = document.getElementById('detail-readonly-catatan');
            if (roCatatan) roCatatan.textContent = doc.catatan_supervisi || 'Belum ada catatan supervisi pengawas.';
        }

        const dlBtn = document.getElementById('detail-download-btn');
        if (dlBtn) {
            dlBtn.onclick = function() {
                simulasiUnduhDokumen(doc.kode_dokumen, doc.judul_dokumen);
            };
        }

        const modal = document.getElementById('modal-detail-arsip');
        const backdrop = document.getElementById('modal-detail-arsip-backdrop');
        backdrop.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('translate-x-full');
        }, 10);
    }

    function closeModalDetailArsip() {
        const modal = document.getElementById('modal-detail-arsip');
        const backdrop = document.getElementById('modal-detail-arsip-backdrop');
        modal.classList.add('translate-x-full');
        setTimeout(() => {
            backdrop.classList.add('hidden');
        }, 200);
    }

    function simulasiUnduhDokumen(kode, judul) {
        alert("Mengunduh salinan berkas resmi pengawasan:\n[" + kode + "] " + judul + "\n\nFormat: PDF Portofolio Kurikulum Terverifikasi");
    }

    // Keyboard support: Escape closes modals
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModalTambahArsip();
            closeModalDetailArsip();
        }
    });
</script>

<!-- PRINT STYLESHEET -->
<style>
    @media print {
        aside, header, footer, #filter-arsip-form, .xl\:col-span-4, button, form {
            display: none !important;
        }
        .xl\:col-span-8, .2xl\:col-span-9, main, .max-w-\[1600px\] {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        body {
            background: white !important;
            color: black !important;
        }
        table {
            border: 1px solid #cbd5e1 !important;
        }
        th, td {
            border-bottom: 1px solid #e2e8f0 !important;
        }
    }
</style>
@endsection

