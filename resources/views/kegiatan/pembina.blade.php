@extends('layouts.app')

@section('title', 'Workspace Pembina Ekstrakurikuler')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6 max-w-[1600px] mx-auto space-y-6">

    <!-- TOPBAR: BREADCRUMB & UNIT / EKSKUL SELECTOR -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-1.5 text-xs text-slate-500">
            <a href="{{ route('dashboard') }}" class="hover:text-brand-800 transition-colors">Dasbor</a>
            <span class="text-slate-300">/</span>
            <a href="{{ route('kegiatan.index') }}" class="hover:text-brand-800 transition-colors">Ekstrakurikuler</a>
            <span class="text-slate-300">/</span>
            <span class="font-semibold text-brand-800">Workspace Pembina</span>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <!-- Unit Selector (Khusus Admin / Yayasan) -->
            @if($user->canAccessAllUnits())
                <form method="GET" action="{{ route('pembina.index') }}" class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-2xl border border-slate-200/90 shadow-subtle shrink-0">
                    <span class="text-xs font-semibold text-slate-400">Unit:</span>
                    <select name="unit_id" onchange="this.form.submit()" class="bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer">
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
                    <span>{{ $user->unit->nama_unit ?? 'Unit Lembaga' }}</span>
                </div>
            @endif

            <!-- Cabang Ekstrakurikuler Selector -->
            @if($ekskulList->count() > 1)
                <form method="GET" action="{{ route('pembina.index') }}" class="flex items-center gap-2 bg-white px-3.5 py-1.5 rounded-2xl border border-slate-200/90 shadow-subtle shrink-0">
                    <input type="hidden" name="unit_id" value="{{ $selectedUnitId }}">
                    <span class="text-xs font-semibold text-slate-400">Cabang:</span>
                    <select name="ekskul_id" onchange="this.form.submit()" class="bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer">
                        @foreach($ekskulList as $ek)
                            <option value="{{ $ek->id }}" {{ $selectedEkskul && $selectedEkskul->id == $ek->id ? 'selected' : '' }}>
                                {{ $ek->nama_kegiatan }} ({{ $ek->anggota_count }} Santri)
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif

            <a href="{{ route('kegiatan.index', ['unit_id' => $selectedUnitId]) }}" 
               class="px-3.5 py-1.5 rounded-2xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-subtle">
                <span class="material-symbols-outlined text-sm">visibility</span>
                <span>Katalog Ekstra &amp; P5-RA</span>
            </a>
        </div>
    </div>

    @if(!$selectedEkskul)
        <!-- Empty State jika belum ada ekskul di unit ini -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-12 text-center space-y-4">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl">sports_soccer</span>
            </div>
            <h3 class="text-base font-bold text-slate-800">Belum Ada Cabang Ekstrakurikuler Terdaftar</h3>
            <p class="text-xs text-slate-500 max-w-md mx-auto">
                Silakan hubungi Administrator Unit untuk mendaftarkan cabang kegiatan ekstrakurikuler dan menetapkan pembina.
            </p>
        </div>
    @else

        <!-- HERO OVERVIEW CABANG EKSTRAKURIKULER -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-7 overflow-hidden relative">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 z-10 relative">
                <div class="space-y-3 max-w-2xl">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-800 border border-brand-200/60 inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-600 animate-pulse"></span>
                            <span>{{ $selectedEkskul->kategori }}</span>
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                            {{ $selectedEkskul->unit->nama_unit ?? 'Unit Pendidikan' }}
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
                        {{ $selectedEkskul->nama_kegiatan }}
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        {{ $selectedEkskul->deskripsi ?? 'Program pembinaan minat, bakat, disiplin fisik dan mental, serta pembentukan karakter santri unggul.' }}
                    </p>

                    <div class="flex items-center gap-4 text-xs text-slate-600 pt-1 flex-wrap">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm text-brand-700">schedule</span>
                            <span><strong>Jadwal:</strong> {{ $selectedEkskul->jadwal ?? 'Sore Hari' }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm text-brand-700">person</span>
                            <span><strong>Pembina:</strong> {{ $selectedEkskul->pembina->name ?? 'Instruktur Khusus' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Button Cluster (Rata, Seragam, & Proporsional) -->
                <div class="flex flex-col sm:flex-row lg:flex-col gap-2.5 shrink-0 w-full sm:w-auto lg:w-64">
                    <button type="button" onclick="openTambahAnggotaModal()" 
                            class="w-full px-4 py-2.5 rounded-2xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold flex items-center justify-center gap-2 shadow-subtle transition-all cursor-pointer">
                        <span class="material-symbols-outlined text-base">person_add</span>
                        <span>Tambah Anggota Santri</span>
                    </button>
                    <button type="button" onclick="openTambahJadwalModal()" 
                            class="w-full px-4 py-2.5 rounded-2xl bg-white hover:bg-slate-50 text-slate-800 border border-slate-200/90 text-xs font-semibold flex items-center justify-center gap-2 shadow-subtle transition-all cursor-pointer">
                        <span class="material-symbols-outlined text-base text-brand-700">calendar_add_on</span>
                        <span>Buat Jadwal Latihan</span>
                    </button>
                    <button type="button" onclick="printLaporanEkstra()" 
                            class="w-full px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200/60 text-xs font-semibold flex items-center justify-center gap-2 transition-colors cursor-pointer">
                        <span class="material-symbols-outlined text-base text-slate-600">print</span>
                        <span>Cetak Rekap Nilai &amp; Presensi</span>
                    </button>
                </div>
            </div>

            <!-- 4 SUMMARY METRIC CARDS -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 pt-6 mt-6 border-t border-slate-100">
                <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 space-y-1">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-[11px] font-semibold">Total Santri Terdaftar</span>
                        <span class="material-symbols-outlined text-base text-blue-600">group</span>
                    </div>
                    <div class="text-xl font-extrabold text-slate-900">{{ $totalAnggota }} <span class="text-xs font-normal text-slate-400">Santri</span></div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 space-y-1">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-[11px] font-semibold">Sesi Terlaksana</span>
                        <span class="material-symbols-outlined text-base text-emerald-600">task_alt</span>
                    </div>
                    <div class="text-xl font-extrabold text-slate-900">{{ $jadwalTerlaksana }} <span class="text-xs font-normal text-slate-400">dari {{ $totalJadwal }} Sesi</span></div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 space-y-1">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-[11px] font-semibold">Rata-Rata Kehadiran</span>
                        <span class="material-symbols-outlined text-base text-amber-600">how_to_reg</span>
                    </div>
                    <div class="text-xl font-extrabold text-slate-900">{{ $persentaseKehadiranRataRata }}% <span class="text-xs font-normal text-emerald-600 font-semibold">Tertib</span></div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 space-y-1">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-[11px] font-semibold">Predikat Sangat Baik (A)</span>
                        <span class="material-symbols-outlined text-base text-purple-600">military_tech</span>
                    </div>
                    <div class="text-xl font-extrabold text-slate-900">{{ $anggotaList->where('nilai_kualitatif', 'A')->count() }} <span class="text-xs font-normal text-slate-400">Santri</span></div>
                </div>
            </div>
        </div>

        <!-- MAIN INTERACTIVE SECTION WITH SUB-TABS -->
        <div class="space-y-4">
            
            <!-- Navigation Tabs Bar -->
            <div class="flex items-center justify-between border-b border-slate-200/80 pb-1">
                <div class="flex items-center gap-2">
                    <button type="button" onclick="switchPembinaTab('anggota')" id="tab-btn-anggota" 
                            class="pembina-tab-btn px-4 py-2 rounded-2xl text-xs font-bold transition-all bg-brand-800 text-white shadow-subtle flex items-center gap-2 cursor-pointer">
                        <span class="material-symbols-outlined text-base">group</span>
                        <span>Daftar Siswa &amp; Rekapitulasi ({{ $totalAnggota }})</span>
                    </button>
                    <button type="button" onclick="switchPembinaTab('jadwal')" id="tab-btn-jadwal" 
                            class="pembina-tab-btn px-4 py-2 rounded-2xl text-xs font-semibold transition-all bg-white text-slate-600 hover:bg-slate-50 border border-slate-200 flex items-center gap-2 cursor-pointer">
                        <span class="material-symbols-outlined text-base">calendar_month</span>
                        <span>Jadwal Latihan &amp; Presensi Sesi ({{ $totalJadwal }})</span>
                    </button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- TAB 1: DAFTAR SISWA / SANTRI PESERTA EKSTRAKURIKULER -->
            <!-- ======================================================== -->
            <div id="tab-content-anggota" class="space-y-4">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-card overflow-hidden">
                    
                    <!-- Search & Filter Controls -->
                    <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
                        <div class="relative flex-1 max-w-md">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                            <input type="text" id="anggota-search-input" oninput="filterAnggotaTable()" 
                                   placeholder="Cari nama santri, NIS, kelas, atau bakat..." 
                                   class="w-full pl-9 pr-8 py-2 bg-white border border-slate-200/90 rounded-2xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-brand-700 shadow-subtle transition-all">
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-400">Total: <strong class="text-slate-800">{{ $totalAnggota }}</strong> santri terdaftar</span>
                        </div>
                    </div>

                    <!-- Table Anggota -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs" id="table-anggota-santri">
                            <thead class="bg-slate-50/70 border-b border-slate-100 text-slate-500 font-semibold text-[11px]">
                                <tr>
                                    <th class="py-3.5 px-4 w-12 text-center">No</th>
                                    <th class="py-3.5 px-4">Nama Santri / Siswa</th>
                                    <th class="py-3.5 px-4">Kelas &amp; NIS</th>
                                    <th class="py-3.5 px-4">Kehadiran Latihan</th>
                                    <th class="py-3.5 px-4 text-center">Nilai Ekskul</th>
                                    <th class="py-3.5 px-4">Catatan Bakat &amp; Perkembangan</th>
                                    <th class="py-3.5 px-4 text-center">Status</th>
                                    <th class="py-3.5 px-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($anggotaList as $idx => $ang)
                                    @php
                                        $hadirPersen = $ang->persentase_kehadiran;
                                    @endphp
                                    <tr class="anggota-row hover:bg-slate-50/70 transition-colors"
                                        data-search="{{ strtolower($ang->nama_siswa . ' ' . $ang->nis . ' ' . $ang->kelas . ' ' . $ang->catatan_bakat) }}">
                                        
                                        <!-- No -->
                                        <td class="py-3.5 px-4 text-center font-medium text-slate-400">
                                            {{ $idx + 1 }}
                                        </td>

                                        <!-- Nama Siswa -->
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-xl font-bold flex items-center justify-center text-xs shrink-0
                                                    {{ $ang->jenis_kelamin === 'P' ? 'bg-pink-100 text-pink-700' : 'bg-brand-50 text-brand-800' }}">
                                                    {{ strtoupper(substr($ang->nama_siswa, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <span class="font-bold text-slate-900 block leading-tight">{{ $ang->nama_siswa }}</span>
                                                    <span class="text-[10px] text-slate-400">{{ $ang->jenis_kelamin === 'P' ? 'Santri Putri' : 'Santri Putra' }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Kelas & NIS -->
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <span class="font-bold text-slate-800 block">{{ $ang->kelas }}</span>
                                            <span class="text-[10px] text-slate-400 font-mono">{{ $ang->nis ? 'NIS: ' . $ang->nis : '-' }}</span>
                                        </td>

                                        <!-- Kehadiran -->
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <div class="w-16 bg-slate-100 rounded-full h-2 overflow-hidden">
                                                    <div class="bg-brand-600 h-2 rounded-full" style="width: {{ $hadirPersen }}%"></div>
                                                </div>
                                                <span class="font-bold text-[11px] {{ $hadirPersen >= 80 ? 'text-emerald-700' : ($hadirPersen >= 60 ? 'text-amber-700' : 'text-rose-700') }}">
                                                    {{ $hadirPersen }}%
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Nilai Kualitatif -->
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold
                                                {{ $ang->nilai_kualitatif === 'A' ? 'bg-purple-50 text-purple-800 border border-purple-200' : 
                                                   ($ang->nilai_kualitatif === 'B' ? 'bg-brand-50 text-brand-800 border border-brand-200' : 'bg-amber-50 text-amber-800 border border-amber-200') }}">
                                                {{ $ang->nilai_kualitatif ?? 'B' }}
                                                <span class="text-[10px] font-normal">({{ $ang->nilai_kualitatif === 'A' ? 'Sangat Baik' : ($ang->nilai_kualitatif === 'B' ? 'Baik' : 'Cukup') }})</span>
                                            </span>
                                        </td>

                                        <!-- Catatan Bakat -->
                                        <td class="py-3.5 px-4 max-w-xs">
                                            <p class="text-[11px] text-slate-600 line-clamp-2 leading-relaxed">
                                                {{ $ang->catatan_bakat ?: 'Belum ada catatan khusus minat bakat santri.' }}
                                            </p>
                                        </td>

                                        <!-- Status -->
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold
                                                {{ $ang->status_keaktifan === 'Aktif' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                                                {{ $ang->status_keaktifan }}
                                            </span>
                                        </td>

                                        <!-- Aksi -->
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <button type="button" 
                                                        onclick="openEditAnggotaModal({{ json_encode($ang) }})"
                                                        title="Edit Data Santri"
                                                        class="p-1.5 rounded-xl hover:bg-slate-100 text-slate-500 hover:text-brand-800 transition-colors">
                                                    <span class="material-symbols-outlined text-base">edit</span>
                                                </button>
                                                <form method="POST" action="{{ route('pembina.anggota.destroy', $ang->id) }}" onsubmit="return confirm('Hapus santri {{ addslashes($ang->nama_siswa) }} dari kegiatan ekstrakurikuler ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            title="Keluarkan dari Ekskul"
                                                            class="p-1.5 rounded-xl hover:bg-rose-50 text-slate-400 hover:text-rose-700 transition-colors">
                                                        <span class="material-symbols-outlined text-base">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-8 text-center text-slate-400 text-xs">
                                            Belum ada santri terdaftar pada cabang ekstrakurikuler ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- TAB 2: JADWAL SESI LATIHAN & PRESENSI PERTEMUAN -->
            <!-- ======================================================== -->
            <div id="tab-content-jadwal" class="space-y-4 hidden">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-card overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Agenda &amp; Jadwal Pertemuan Latihan</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">Catatan materi pembinaan per tanggal dan pengisian presensi santri</p>
                        </div>

                        <button type="button" onclick="openTambahJadwalModal()" 
                                class="px-3.5 py-1.5 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold flex items-center gap-1.5 shadow-subtle transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-sm">add</span>
                            <span>Tambah Pertemuan Baru</span>
                        </button>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @forelse($jadwalList as $jdw)
                            @php
                                $hadirCount = $jdw->hadir_count;
                                $presensiSudahDiisi = $jdw->presensi->count() > 0;
                            @endphp
                            <div class="p-5 sm:p-6 hover:bg-slate-50/50 transition-colors flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                <div class="space-y-2 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap text-xs">
                                        <span class="px-2.5 py-0.5 rounded-lg font-bold bg-slate-900 text-white text-[10px]">
                                            Pertemuan Ke-{{ $jdw->pertemuan_ke }}
                                        </span>
                                        <span class="font-bold text-slate-800 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm text-brand-700">event</span>
                                            <span>{{ $jdw->tanggal ? $jdw->tanggal->translatedFormat('l, d F Y') : '-' }}</span>
                                        </span>
                                        <span class="text-slate-400">•</span>
                                        <span class="text-slate-500 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">schedule</span>
                                            <span>{{ $jdw->jam_mulai }} - {{ $jdw->jam_selesai }} WIB</span>
                                        </span>
                                        <span class="text-slate-400">•</span>
                                        <span class="text-slate-500 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">location_on</span>
                                            <span>{{ $jdw->tempat }}</span>
                                        </span>
                                    </div>

                                    <h4 class="text-sm font-bold text-slate-900 leading-snug">
                                        {{ $jdw->materi_pembinaan }}
                                    </h4>

                                    @if($jdw->catatan_evaluasi)
                                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-[11px] text-slate-600">
                                            <strong>Evaluasi Pembina:</strong> {{ $jdw->catatan_evaluasi }}
                                        </div>
                                    @endif

                                    <div class="flex items-center gap-3 pt-1 text-[11px]">
                                        <span class="px-2 py-0.5 rounded-full font-bold
                                            {{ $jdw->status === 'Terlaksana' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 
                                               ($jdw->status === 'Ditunda' ? 'bg-rose-50 text-rose-800 border border-rose-200' : 'bg-amber-50 text-amber-800 border border-amber-200') }}">
                                            {{ $jdw->status }}
                                        </span>

                                        @if($presensiSudahDiisi)
                                            <span class="text-emerald-700 font-semibold flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">how_to_reg</span>
                                                <span>Presensi Terisi: <strong>{{ $hadirCount }}</strong> Hadir dari {{ $totalAnggota }} santri</span>
                                            </span>
                                        @else
                                            <span class="text-amber-700 font-semibold flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">pending_actions</span>
                                                <span>Presensi belum dicatat</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Buttons for Schedule -->
                                <div class="flex items-center gap-2 shrink-0 pt-2 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                                    <button type="button" 
                                            onclick="openPresensiModal({{ json_encode($jdw) }}, {{ json_encode($anggotaList) }}, {{ json_encode($jdw->presensi) }})"
                                            class="px-3.5 py-2 rounded-xl bg-brand-50 hover:bg-brand-100 text-brand-800 font-bold text-xs flex items-center gap-1.5 transition-colors cursor-pointer border border-brand-200/70">
                                        <span class="material-symbols-outlined text-base">how_to_reg</span>
                                        <span>{{ $presensiSudahDiisi ? 'Perbarui Absensi' : 'Isi Presensi' }}</span>
                                    </button>

                                    <button type="button" 
                                            onclick="openEditJadwalModal({{ json_encode($jdw) }})"
                                            title="Edit Sesi Jadwal"
                                            class="p-2 rounded-xl hover:bg-slate-100 text-slate-500 hover:text-slate-800 transition-colors">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                    </button>

                                    <form method="POST" action="{{ route('pembina.jadwal.destroy', $jdw->id) }}" onsubmit="return confirm('Hapus sesi jadwal pertemuan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                title="Hapus Sesi"
                                                class="p-2 rounded-xl hover:bg-rose-50 text-slate-400 hover:text-rose-700 transition-colors">
                                            <span class="material-symbols-outlined text-base">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center text-slate-400 text-xs">
                                Belum ada jadwal pertemuan yang dibuat. Klik "Buat Jadwal Latihan" untuk menjadwalkan sesi pertama.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

    @endif

</div>

<!-- ======================================================== -->
<!-- MODAL 1: TAMBAH ANGGOTA SANTRI BARU -->
<!-- ======================================================== -->
<div id="modal-tambah-anggota" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-floating border border-slate-200 space-y-5 animate-in fade-in zoom-in-95 duration-150">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-lg">person_add</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Tambah Anggota Ekstrakurikuler</h3>
                    <p class="text-[11px] text-slate-500">{{ $selectedEkskul->nama_kegiatan ?? '' }}</p>
                </div>
            </div>
            <button onclick="closeModal('modal-tambah-anggota')" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('pembina.anggota.store') }}" class="space-y-3.5 text-xs">
            @csrf
            <input type="hidden" name="ekstrakurikuler_id" value="{{ $selectedEkskul->id ?? '' }}">

            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Nama Lengkap Santri / Siswa <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_siswa" required placeholder="misal: Muhammad Bilal Al-Ghifari" 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Kelas / Rombel <span class="text-rose-500">*</span></label>
                    <input type="text" name="kelas" required placeholder="misal: 7A, 8B, atau 10 MIPA" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">NIS / NISN (Opsional)</label>
                    <input type="text" name="nis" placeholder="misal: 202407001" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                        <option value="L">Laki-Laki (Santri Putra)</option>
                        <option value="P">Perempuan (Santri Putri)</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Predikat Nilai Awal</label>
                    <select name="nilai_kualitatif" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                        <option value="A">A - Sangat Baik</option>
                        <option value="B" selected>B - Baik</option>
                        <option value="C">C - Cukup</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Catatan Bakat &amp; Minat Santri</label>
                <textarea name="catatan_bakat" rows="2" placeholder="Catatan kelebihan, fisik, potensi kejuaraan, atau instrumen yang dikuasai..." 
                          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('modal-tambah-anggota')" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all">
                    Simpan Anggota
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 2: EDIT DATA ANGGOTA SANTRI -->
<!-- ======================================================== -->
<div id="modal-edit-anggota" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-floating border border-slate-200 space-y-5 animate-in fade-in zoom-in-95 duration-150">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-800 flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-lg">manage_accounts</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Perbarui Data Santri</h3>
                    <p class="text-[11px] text-slate-500">Ubah kelas, status keaktifan, dan penilaian minat bakat</p>
                </div>
            </div>
            <button onclick="closeModal('modal-edit-anggota')" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <form id="form-edit-anggota" method="POST" action="" class="space-y-3.5 text-xs">
            @csrf
            
            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Nama Lengkap Santri / Siswa <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_siswa" id="edit-ang-nama" required 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Kelas / Rombel <span class="text-rose-500">*</span></label>
                    <input type="text" name="kelas" id="edit-ang-kelas" required 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">NIS / NISN</label>
                    <input type="text" name="nis" id="edit-ang-nis" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="edit-ang-jk" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Status Keaktifan</label>
                    <select name="status_keaktifan" id="edit-ang-status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                        <option value="Aktif">Aktif</option>
                        <option value="Kurang Aktif">Kurang Aktif</option>
                        <option value="Izin/Cuti">Izin / Cuti</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Predikat Nilai</label>
                    <select name="nilai_kualitatif" id="edit-ang-nilai" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                        <option value="A">A - Sangat Baik</option>
                        <option value="B">B - Baik</option>
                        <option value="C">C - Cukup</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Catatan Bakat &amp; Perkembangan</label>
                <textarea name="catatan_bakat" id="edit-ang-bakat" rows="2" 
                          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('modal-edit-anggota')" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 3: TAMBAH SESI JADWAL LATIHAN BARU -->
<!-- ======================================================== -->
<div id="modal-tambah-jadwal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-floating border border-slate-200 space-y-5 animate-in fade-in zoom-in-95 duration-150">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-lg">calendar_add_on</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Jadwalkan Sesi Latihan Baru</h3>
                    <p class="text-[11px] text-slate-500">{{ $selectedEkskul->nama_kegiatan ?? '' }}</p>
                </div>
            </div>
            <button onclick="closeModal('modal-tambah-jadwal')" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('pembina.jadwal.store') }}" class="space-y-3.5 text-xs">
            @csrf
            <input type="hidden" name="ekstrakurikuler_id" value="{{ $selectedEkskul->id ?? '' }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Pertemuan Ke-</label>
                    <input type="number" name="pertemuan_ke" value="{{ ($jadwalList->max('pertemuan_ke') ?? 0) + 1 }}" min="1" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Tanggal Latihan <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Jam Mulai - Selesai</label>
                    <div class="flex items-center gap-2">
                        <input type="text" name="jam_mulai" value="15:30" placeholder="15:30" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                        <span>-</span>
                        <input type="text" name="jam_selesai" value="17:00" placeholder="17:00" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Tempat / Lokasi</label>
                    <input type="text" name="tempat" placeholder="misal: Lapangan Utama / Aula" value="Lapangan Utama Ponpes" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Materi &amp; Rencana Pembinaan <span class="text-rose-500">*</span></label>
                <input type="text" name="materi_pembinaan" required placeholder="misal: Pengenalan Kuda-kuda Dasar &amp; Pola Pukulan 1-2" 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Catatan Refleksi / Kebutuhan Fasilitas</label>
                <textarea name="catatan_evaluasi" rows="2" placeholder="Catatan kesiapan peralatan, target fisik santri, dll..." 
                          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('modal-tambah-jadwal')" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all">
                    Jadwalkan Sesi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 4: EDIT JADWAL LATIHAN -->
<!-- ======================================================== -->
<div id="modal-edit-jadwal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-floating border border-slate-200 space-y-5 animate-in fade-in zoom-in-95 duration-150">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-teal-50 text-teal-800 flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-lg">edit_calendar</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Perbarui Sesi Latihan</h3>
                    <p class="text-[11px] text-slate-500">Edit tanggal, materi, atau catatan evaluasi pertemuan</p>
                </div>
            </div>
            <button onclick="closeModal('modal-edit-jadwal')" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <form id="form-edit-jadwal" method="POST" action="" class="space-y-3.5 text-xs">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Tanggal Latihan <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal" id="edit-jdw-tanggal" required 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Status Sesi</label>
                    <select name="status" id="edit-jdw-status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                        <option value="Dijadwalkan">Dijadwalkan</option>
                        <option value="Terlaksana">Terlaksana</option>
                        <option value="Ditunda">Ditunda</option>
                        <option value="Diliburkan">Diliburkan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Jam Mulai - Selesai</label>
                    <div class="flex items-center gap-2">
                        <input type="text" name="jam_mulai" id="edit-jdw-mulai" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                        <span>-</span>
                        <input type="text" name="jam_selesai" id="edit-jdw-selesai" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Tempat / Lokasi</label>
                    <input type="text" name="tempat" id="edit-jdw-tempat" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Materi &amp; Rencana Pembinaan <span class="text-rose-500">*</span></label>
                <input type="text" name="materi_pembinaan" id="edit-jdw-materi" required 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Catatan Refleksi &amp; Evaluasi Hasil Latihan</label>
                <textarea name="catatan_evaluasi" id="edit-jdw-evaluasi" rows="2" 
                          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('modal-edit-jadwal')" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 5: PRESENSI / ABSENSI SANTRI PER SESI -->
<!-- ======================================================== -->
<div id="modal-presensi-santri" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-7 shadow-floating border border-slate-200 space-y-4 animate-in fade-in zoom-in-95 duration-150 max-h-[90vh] flex flex-col">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-lg">how_to_reg</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900" id="presensi-modal-title">Presensi Kehadiran Latihan</h3>
                    <p class="text-[11px] text-slate-500" id="presensi-modal-subtitle">Centang status kehadiran santri</p>
                </div>
            </div>
            <button onclick="closeModal('modal-presensi-santri')" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <form id="form-presensi-santri" method="POST" action="" class="space-y-4 text-xs overflow-y-auto pr-1 flex-1">
            @csrf

            <!-- Fast Action: Centang Semua Hadir -->
            <div class="p-3 rounded-2xl bg-emerald-50/70 border border-emerald-200/80 flex items-center justify-between">
                <div class="flex items-center gap-2 text-emerald-800 font-semibold text-[11px]">
                    <span class="material-symbols-outlined text-base">checklist</span>
                    <span>Tandai cepat seluruh santri terdaftar:</span>
                </div>
                <button type="button" onclick="setAllPresensi('Hadir')" 
                        class="px-3 py-1 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-[10px] shadow-subtle transition-all cursor-pointer">
                    Semua Hadir
                </button>
            </div>

            <!-- Santri List Attendance Rows -->
            <div class="divide-y divide-slate-100 border border-slate-100 rounded-2xl overflow-hidden" id="presensi-santri-container">
                <!-- Injected via JavaScript -->
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100 shrink-0">
                <button type="button" onclick="closeModal('modal-presensi-santri')" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-sm">save</span>
                    <span>Simpan Presensi Sesi</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchPembinaTab(tab) {
        document.querySelectorAll('.pembina-tab-btn').forEach(b => {
            b.classList.remove('bg-brand-800', 'text-white', 'shadow-subtle');
            b.classList.add('bg-white', 'text-slate-600', 'border', 'border-slate-200');
        });

        const activeBtn = document.getElementById(`tab-btn-${tab}`);
        if (activeBtn) {
            activeBtn.classList.add('bg-brand-800', 'text-white', 'shadow-subtle');
            activeBtn.classList.remove('bg-white', 'text-slate-600', 'border', 'border-slate-200');
        }

        document.getElementById('tab-content-anggota').classList.toggle('hidden', tab !== 'anggota');
        document.getElementById('tab-content-jadwal').classList.toggle('hidden', tab !== 'jadwal');
    }

    function filterAnggotaTable() {
        const query = (document.getElementById('anggota-search-input').value || '').toLowerCase().trim();
        const rows = document.querySelectorAll('.anggota-row');
        rows.forEach(r => {
            const data = (r.getAttribute('data-search') || '').toLowerCase();
            r.style.display = data.includes(query) ? '' : 'none';
        });
    }

    function openTambahAnggotaModal() {
        document.getElementById('modal-tambah-anggota').classList.remove('hidden');
    }

    function openEditAnggotaModal(ang) {
        const form = document.getElementById('form-edit-anggota');
        form.action = `/pembina/ekstra/anggota/${ang.id}/update`;

        document.getElementById('edit-ang-nama').value = ang.nama_siswa || '';
        document.getElementById('edit-ang-kelas').value = ang.kelas || '';
        document.getElementById('edit-ang-nis').value = ang.nis || '';
        document.getElementById('edit-ang-jk').value = ang.jenis_kelamin || 'L';
        document.getElementById('edit-ang-status').value = ang.status_keaktifan || 'Aktif';
        document.getElementById('edit-ang-nilai').value = ang.nilai_kualitatif || 'B';
        document.getElementById('edit-ang-bakat').value = ang.catatan_bakat || '';

        document.getElementById('modal-edit-anggota').classList.remove('hidden');
    }

    function openTambahJadwalModal() {
        document.getElementById('modal-tambah-jadwal').classList.remove('hidden');
    }

    function openEditJadwalModal(jdw) {
        const form = document.getElementById('form-edit-jadwal');
        form.action = `/pembina/ekstra/jadwal/${jdw.id}/update`;

        const dateStr = jdw.tanggal ? jdw.tanggal.substring(0, 10) : '';
        document.getElementById('edit-jdw-tanggal').value = dateStr;
        document.getElementById('edit-jdw-status').value = jdw.status || 'Dijadwalkan';
        document.getElementById('edit-jdw-mulai').value = jdw.jam_mulai || '15:30';
        document.getElementById('edit-jdw-selesai').value = jdw.jam_selesai || '17:00';
        document.getElementById('edit-jdw-tempat').value = jdw.tempat || '';
        document.getElementById('edit-jdw-materi').value = jdw.materi_pembinaan || '';
        document.getElementById('edit-jdw-evaluasi').value = jdw.catatan_evaluasi || '';

        document.getElementById('modal-edit-jadwal').classList.remove('hidden');
    }

    function openPresensiModal(jdw, anggotaList, existingPresensi) {
        const form = document.getElementById('form-presensi-santri');
        form.action = `/pembina/ekstra/jadwal/${jdw.id}/presensi`;

        const dateStr = jdw.tanggal ? jdw.tanggal.substring(0, 10) : '';
        document.getElementById('presensi-modal-title').innerText = `Presensi Sesi Pertemuan Ke-${jdw.pertemuan_ke}`;
        document.getElementById('presensi-modal-subtitle').innerText = `${dateStr} • ${jdw.materi_pembinaan}`;

        // Map existing presensi
        const presensiMap = {};
        if (existingPresensi && Array.isArray(existingPresensi)) {
            existingPresensi.forEach(p => {
                presensiMap[p.anggota_id] = p.status_kehadiran;
            });
        }

        const container = document.getElementById('presensi-santri-container');
        container.innerHTML = '';

        if (!anggotaList || anggotaList.length === 0) {
            container.innerHTML = '<div class="p-6 text-center text-slate-400 text-xs">Belum ada santri terdaftar pada cabang ini.</div>';
        } else {
            anggotaList.forEach((ang, idx) => {
                const currentStatus = presensiMap[ang.id] || 'Hadir';
                const row = document.createElement('div');
                row.className = 'p-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 hover:bg-slate-50 transition-colors';
                row.innerHTML = `
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 text-center text-[10px] font-bold text-slate-400">${idx + 1}</span>
                        <div>
                            <span class="font-bold text-slate-900 block leading-tight">${ang.nama_siswa}</span>
                            <span class="text-[10px] text-slate-400">${ang.kelas} ${ang.nis ? '• ' + ang.nis : ''}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 shrink-0">
                        <label class="presensi-radio-label flex items-center gap-1 px-2.5 py-1 rounded-lg border text-[11px] font-semibold cursor-pointer ${currentStatus === 'Hadir' ? 'bg-emerald-50 border-emerald-300 text-emerald-800' : 'bg-white border-slate-200 text-slate-600'}">
                            <input type="radio" name="presensi[${ang.id}]" value="Hadir" ${currentStatus === 'Hadir' ? 'checked' : ''} onchange="updateRadioStyle(this)" class="accent-emerald-700">
                            <span>Hadir</span>
                        </label>
                        <label class="presensi-radio-label flex items-center gap-1 px-2.5 py-1 rounded-lg border text-[11px] font-semibold cursor-pointer ${currentStatus === 'Izin' ? 'bg-blue-50 border-blue-300 text-blue-800' : 'bg-white border-slate-200 text-slate-600'}">
                            <input type="radio" name="presensi[${ang.id}]" value="Izin" ${currentStatus === 'Izin' ? 'checked' : ''} onchange="updateRadioStyle(this)" class="accent-blue-700">
                            <span>Izin</span>
                        </label>
                        <label class="presensi-radio-label flex items-center gap-1 px-2.5 py-1 rounded-lg border text-[11px] font-semibold cursor-pointer ${currentStatus === 'Sakit' ? 'bg-amber-50 border-amber-300 text-amber-800' : 'bg-white border-slate-200 text-slate-600'}">
                            <input type="radio" name="presensi[${ang.id}]" value="Sakit" ${currentStatus === 'Sakit' ? 'checked' : ''} onchange="updateRadioStyle(this)" class="accent-amber-700">
                            <span>Sakit</span>
                        </label>
                        <label class="presensi-radio-label flex items-center gap-1 px-2.5 py-1 rounded-lg border text-[11px] font-semibold cursor-pointer ${currentStatus === 'Alpa' ? 'bg-rose-50 border-rose-300 text-rose-800' : 'bg-white border-slate-200 text-slate-600'}">
                            <input type="radio" name="presensi[${ang.id}]" value="Alpa" ${currentStatus === 'Alpa' ? 'checked' : ''} onchange="updateRadioStyle(this)" class="accent-rose-700">
                            <span>Alpa</span>
                        </label>
                    </div>
                `;
                container.appendChild(row);
            });
        }

        document.getElementById('modal-presensi-santri').classList.remove('hidden');
    }

    function setAllPresensi(status) {
        document.querySelectorAll(`input[type="radio"][value="${status}"]`).forEach(r => {
            r.checked = true;
            updateRadioStyle(r);
        });
    }

    function updateRadioStyle(radio) {
        const parentDiv = radio.closest('.flex');
        if (!parentDiv) return;
        parentDiv.querySelectorAll('label').forEach(lbl => {
            lbl.className = 'presensi-radio-label flex items-center gap-1 px-2.5 py-1 rounded-lg border text-[11px] font-semibold cursor-pointer bg-white border-slate-200 text-slate-600';
        });

        const activeLbl = radio.closest('label');
        if (radio.value === 'Hadir') {
            activeLbl.className = 'presensi-radio-label flex items-center gap-1 px-2.5 py-1 rounded-lg border text-[11px] font-semibold cursor-pointer bg-emerald-50 border-emerald-300 text-emerald-800';
        } else if (radio.value === 'Izin') {
            activeLbl.className = 'presensi-radio-label flex items-center gap-1 px-2.5 py-1 rounded-lg border text-[11px] font-semibold cursor-pointer bg-blue-50 border-blue-300 text-blue-800';
        } else if (radio.value === 'Sakit') {
            activeLbl.className = 'presensi-radio-label flex items-center gap-1 px-2.5 py-1 rounded-lg border text-[11px] font-semibold cursor-pointer bg-amber-50 border-amber-300 text-amber-800';
        } else if (radio.value === 'Alpa') {
            activeLbl.className = 'presensi-radio-label flex items-center gap-1 px-2.5 py-1 rounded-lg border text-[11px] font-semibold cursor-pointer bg-rose-50 border-rose-300 text-rose-800';
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.add('hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal('modal-tambah-anggota');
            closeModal('modal-edit-anggota');
            closeModal('modal-tambah-jadwal');
            closeModal('modal-edit-jadwal');
            closeModal('modal-presensi-santri');
        }
    });

    /**
     * Cetak Laporan Ekstrakurikuler dengan Kop Resmi
     */
    function printLaporanEkstra() {
        const headers = ['No', 'Nama Santri / Siswa', 'Kelas', 'NIS', 'Kehadiran (%)', 'Predikat Nilai', 'Catatan Bakat & Minat'];
        const rows = [];
        let counter = 1;
        document.querySelectorAll('.anggota-row').forEach(tr => {
            if (tr.style.display !== 'none') {
                const cols = tr.querySelectorAll('td');
                const nama = cols[1].querySelector('span.font-bold')?.innerText.trim() || '';
                const kelas = cols[2].querySelector('span.font-bold')?.innerText.trim() || '';
                const nis = cols[2].querySelector('span.font-mono')?.innerText.replace('NIS: ', '').trim() || '-';
                const kehadiran = cols[3].querySelector('span.font-bold')?.innerText.trim() || '';
                const nilai = cols[4].querySelector('span')?.innerText.trim() || '';
                const bakat = cols[5].querySelector('p')?.innerText.trim() || '';
                rows.push([counter++, nama, kelas, nis, kehadiran, nilai, bakat]);
            }
        });

        triggerPrintDocument({
            reportTitle: 'REKAPITULASI PEMBINAAN & NILAI EKSTRAKURIKULER',
            subtitle: 'Cabang: {{ addslashes($selectedEkskul->nama_kegiatan ?? "") }} • Pembina: {{ addslashes($selectedEkskul->pembina->name ?? "") }} • {{ addslashes($selectedEkskul->unit->nama_unit ?? "") }}',
            headers: headers,
            dataRows: rows,
            unitName: '{{ addslashes($selectedEkskul->unit->nama_unit ?? "") }}'
        });
    }
</script>
@endsection
