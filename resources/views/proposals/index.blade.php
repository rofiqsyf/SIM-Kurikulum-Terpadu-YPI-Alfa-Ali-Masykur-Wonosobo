@extends('layouts.app')

@section('title', 'Riwayat Usulan Kurikulum')

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
                    <span>SOP-KUR-01</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-medium text-slate-700">Tata Kelola Kurikulum</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-semibold text-brand-800">Pelacakan Usulan</span>
                </div>

                <div class="flex items-center gap-2 self-end sm:self-center text-xs font-semibold text-slate-500 bg-white px-3.5 py-1.5 rounded-2xl border border-slate-100 shadow-subtle shrink-0">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    <span>Siklus Penelaahan Kepala Sekolah</span>
                </div>
            </div>

            <!-- HERO OVERVIEW CARD -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative">
                <div class="space-y-3.5 max-w-xl z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-600"></span>
                        <span>Verifikasi Akademik &amp; Silabus</span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 leading-tight">
                        Riwayat &amp; Pelacakan Usulan
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Transparansi pengajuan revisi Capaian Pembelajaran, perumusan TP, dan penyesuaian alokasi beban jam pelajaran dari seluruh pendidik.
                    </p>

                    <div class="pt-2">
                        <button type="button" onclick="window.print()" 
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-base">print</span>
                            <span>Cetak Rekap Usulan</span>
                        </button>
                    </div>
                </div>

                <!-- 3D Isometric Books Graphic -->
                <div class="shrink-0 flex items-center justify-center md:pr-4">
                    <svg class="w-36 h-32 sm:w-44 sm:h-38 drop-shadow-sm select-none" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M40 120 L120 160 L200 120 L120 80 Z" fill="#d97706" />
                        <path d="M40 120 L40 135 L120 175 L120 160 Z" fill="#b45309" />
                        <path d="M120 160 L120 175 L200 135 L200 120 Z" fill="#f59e0b" />
                        <path d="M44 121 L44 130 L118 168 L118 159 Z" fill="#fffbeb" />
                        <path d="M122 159 L122 168 L196 130 L196 121 Z" fill="#fef3c7" />

                        <path d="M50 95 L120 130 L190 95 L120 60 Z" fill="#3b82f6" />
                        <path d="M50 95 L50 108 L120 143 L120 130 Z" fill="#1d4ed8" />
                        <path d="M120 130 L120 143 L190 108 L190 95 Z" fill="#2563eb" />
                        <path d="M54 96 L54 104 L118 137 L118 129 Z" fill="#eff6ff" />
                        <path d="M122 129 L122 137 L186 104 L186 96 Z" fill="#dbeafe" />

                        <path d="M70 65 L130 95 L180 70 L120 40 Z" fill="#ffffff" stroke="#e2e8f0" stroke-width="1.5" />
                        <path d="M70 65 L70 70 L130 100 L130 95 Z" fill="#cbd5e1" />
                        <path d="M130 95 L130 100 L180 75 L180 70 Z" fill="#94a3b8" />
                        <circle cx="95" cy="62" r="2.5" fill="#d97706" />
                        <line x1="103" y1="62" x2="140" y2="53" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                        <circle cx="103" cy="68" r="2.5" fill="#d97706" />
                        <line x1="111" y1="68" x2="148" y2="59" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
            </div>

            <!-- 4 METRIC TILES -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 text-xs">
                <a href="{{ route('usulan.index') }}" 
                   class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-card flex items-center justify-between hover:border-slate-300 transition-colors">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Total Pengajuan</span>
                        <span class="text-xl sm:text-2xl font-bold text-slate-900 mt-1 block">{{ $totalPengajuan }}</span>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-lg">folder_open</span>
                    </div>
                </a>

                <a href="{{ route('usulan.index', ['status' => 'menunggu']) }}" 
                   class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-card flex items-center justify-between hover:border-slate-300 transition-colors">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Menunggu Review</span>
                        <span class="text-xl sm:text-2xl font-bold text-amber-700 mt-1 block">{{ $menungguCount }}</span>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-lg">pending_actions</span>
                    </div>
                </a>

                <a href="{{ route('usulan.index', ['status' => 'disetujui']) }}" 
                   class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-card flex items-center justify-between hover:border-slate-300 transition-colors">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Disetujui</span>
                        <span class="text-xl sm:text-2xl font-bold text-emerald-700 mt-1 block">{{ $disetujuiCount }}</span>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-lg">verified</span>
                    </div>
                </a>

                <a href="{{ route('usulan.index', ['status' => 'ditolak']) }}" 
                   class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-card flex items-center justify-between hover:border-slate-300 transition-colors">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Perlu Revisi</span>
                        <span class="text-xl sm:text-2xl font-bold text-rose-700 mt-1 block">{{ $ditolakCount }}</span>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-lg">feedback</span>
                    </div>
                </a>
            </div>

            <!-- FILTER RIBBON (Pill card) -->
            <div class="bg-white rounded-3xl p-4 border border-slate-100 shadow-card flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                <!-- Status Tabs -->
                <div class="flex items-center gap-1 overflow-x-auto pb-1 sm:pb-0">
                    <a href="{{ route('usulan.index') }}" 
                       class="px-3.5 py-1.5 rounded-full font-bold transition-colors {{ !request('status') || request('status') === 'all' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                        Semua ({{ $totalPengajuan }})
                    </a>
                    <a href="{{ route('usulan.index', ['status' => 'menunggu']) }}" 
                       class="px-3.5 py-1.5 rounded-full font-bold transition-colors {{ request('status') === 'menunggu' ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'text-slate-600 hover:bg-slate-100' }}">
                        Menunggu ({{ $menungguCount }})
                    </a>
                    <a href="{{ route('usulan.index', ['status' => 'disetujui']) }}" 
                       class="px-3.5 py-1.5 rounded-full font-bold transition-colors {{ request('status') === 'disetujui' ? 'bg-emerald-100 text-emerald-900 border border-emerald-300' : 'text-slate-600 hover:bg-slate-100' }}">
                        Disetujui ({{ $disetujuiCount }})
                    </a>
                    <a href="{{ route('usulan.index', ['status' => 'ditolak']) }}" 
                       class="px-3.5 py-1.5 rounded-full font-bold transition-colors {{ request('status') === 'ditolak' ? 'bg-rose-100 text-rose-900 border border-rose-300' : 'text-slate-600 hover:bg-slate-100' }}">
                        Revisi ({{ $ditolakCount }})
                    </a>
                </div>

                <!-- Search form with live search & Action button -->
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <div class="relative flex-1 sm:w-64">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base">search</span>
                        <input type="text" id="live-proposal-search" oninput="filterProposalsLive()"
                               placeholder="Cari kode, judul, atau pengusul..." 
                               class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200/80 rounded-2xl text-xs placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all">
                    </div>
                    <button type="button" onclick="openGlobalProposalModal()" 
                            class="px-3.5 py-2 rounded-2xl bg-brand-800 hover:bg-brand-900 text-white font-semibold transition-all shadow-subtle shrink-0 flex items-center gap-1 cursor-pointer">
                        <span class="material-symbols-outlined text-sm">edit_document</span>
                        <span>Buat Usulan</span>
                    </button>
                </div>
            </div>

            <!-- PROPOSALS TABLE (Matching Reference Lessons Table Style) -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/70 border-b border-slate-100 text-slate-500 font-semibold text-[11px]">
                            <tr>
                                <th class="py-3.5 px-5">Kode Usulan</th>
                                <th class="py-3.5 px-4">Mata Pelajaran</th>
                                <th class="py-3.5 px-4">Pengusul</th>
                                <th class="py-3.5 px-4">Tanggal</th>
                                <th class="py-3.5 px-4">Objek &amp; Sasaran</th>
                                <th class="py-3.5 px-4 text-center">Status</th>
                                <th class="py-3.5 px-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($proposals as $prop)
                                <tr class="proposal-row hover:bg-slate-50/70 transition-colors cursor-pointer" 
                                    onclick="showProposalDetail({{ json_encode($prop) }})"
                                    data-search="{{ strtolower($prop->nomor_usulan . ' ' . ($prop->mataPelajaran->nama_mapel ?? '') . ' ' . ($prop->pengusul->name ?? '') . ' ' . $prop->judul_usulan . ' ' . $prop->status) }}">
                                    <td class="py-3.5 px-5 font-bold text-slate-900">
                                        {{ $prop->nomor_usulan }}
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-700 font-medium truncate max-w-[150px]">
                                        {{ $prop->mataPelajaran->nama_mapel ?? '-' }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-brand-50 border border-brand-200 text-brand-800 flex items-center justify-center font-bold text-[10px] shrink-0">
                                                {{ substr($prop->pengusul->name ?? 'G', 0, 1) }}
                                            </div>
                                            <span class="text-slate-800 font-medium truncate max-w-[120px]">
                                                {{ $prop->pengusul->name ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-500 text-[11px]">
                                        {{ $prop->tanggal_pengajuan ? $prop->tanggal_pengajuan->format('d.m.Y') : '-' }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="max-w-[200px]">
                                            <span class="text-[10px] font-bold text-slate-400 block uppercase">{{ $prop->jenis_usulan }} {{ $prop->objek_data }}</span>
                                            <span class="font-semibold text-slate-900 truncate block">{{ $prop->judul_usulan }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                        @if($prop->status === 'Disetujui')
                                            <span class="inline-flex items-center justify-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 whitespace-nowrap leading-none min-w-[96px]">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 shrink-0"></span>
                                                <span>Disetujui</span>
                                            </span>
                                        @elseif($prop->status === 'Ditolak')
                                            <span class="inline-flex items-center justify-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-800 border border-rose-200 whitespace-nowrap leading-none min-w-[96px]">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-600 shrink-0"></span>
                                                <span>Perlu Revisi</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200 whitespace-nowrap leading-none min-w-[96px]">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse shrink-0"></span>
                                                <span>Menunggu</span>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-5 text-right">
                                        <button type="button" onclick="showProposalDetail({{ json_encode($prop) }})" 
                                                class="px-3 py-1 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-semibold transition-colors">
                                            Rincian
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-slate-400">
                                        <span class="material-symbols-outlined text-3xl mb-1 block">search_off</span>
                                        Tidak ada data usulan kurikulum yang cocok dengan filter.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($proposals, 'hasPages') && $proposals->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $proposals->links() }}
                    </div>
                @endif
            </div>

        </div>

        <!-- ======================================================== -->
        <!-- RIGHT PANEL (SLA & ALUR VERIFIKASI) -->
        <!-- ======================================================== -->
        <div class="xl:col-span-4 2xl:col-span-3 space-y-6">

            <!-- 1. SLA VERIFIKASI CARD -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-3">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="material-symbols-outlined text-brand-700 text-lg">timer</span>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">SLA Penelaahan Usulan</h4>
                </div>

                <div class="space-y-2.5 text-xs">
                    <div class="p-3 rounded-2xl bg-brand-50 border border-brand-200/70 space-y-1">
                        <span class="font-bold text-brand-900 block">Maksimal 3 Hari Kerja</span>
                        <p class="text-[11px] text-brand-800 leading-relaxed">
                            Kepala Sekolah / Madrasah wajib memberikan keputusan (setuju atau tolak dengan catatan) dalam 3 hari kerja setelah usulan diajukan.
                        </p>
                    </div>

                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                        <span class="font-bold text-slate-800 block">Kewajiban Catatan Pedagogis</span>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Setiap penolakan wajib disertai arahan perbaikan terukur berdasarkan taksonomi Bloom dan integrasi nilai pesantren.
                        </p>
                    </div>
                </div>
            </div>

            <!-- 2. ALUR PENGAJUAN RINGKAS -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 block">Alur Kerja Standar</span>
                
                <div class="space-y-2 text-xs">
                    <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="w-6 h-6 rounded-full bg-brand-800 text-white font-bold text-xs flex items-center justify-center shrink-0">1</span>
                        <span class="text-slate-700 font-medium">Guru Input Usulan TP / Materi</span>
                    </div>
                    <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="w-6 h-6 rounded-full bg-brand-800 text-white font-bold text-xs flex items-center justify-center shrink-0">2</span>
                        <span class="text-slate-700 font-medium">Waka Kurikulum Telaah Teknis &amp; Validasi</span>
                    </div>
                    <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="w-6 h-6 rounded-full bg-brand-800 text-white font-bold text-xs flex items-center justify-center shrink-0">3</span>
                        <span class="text-slate-700 font-medium">Kepala Sekolah Memberi Pengesahan</span>
                    </div>
                    <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="w-6 h-6 rounded-full bg-brand-800 text-white font-bold text-xs flex items-center justify-center shrink-0">4</span>
                        <span class="text-slate-700 font-medium">Sinkronisasi Instan ke Master Silabus</span>
                    </div>
                </div>
            </div>

            <!-- 3. BANTUAN OPERASIONAL -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 text-center space-y-2">
                <div class="w-12 h-12 rounded-full bg-brand-50 text-brand-800 mx-auto flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-2xl">help_outline</span>
                </div>
                <h5 class="text-xs font-bold text-slate-800">Ada Pertanyaan Alur?</h5>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Pelajari tata cara penyusunan instrumen usulan silabus pada dokumen panduan.
                </p>
                <a href="{{ route('guide.index') }}" class="inline-block pt-1 text-xs font-semibold text-brand-800 hover:underline">
                    Buka Panduan SOP →
                </a>
            </div>

        </div>

    </div>

</div>

<!-- MODAL DETAIL & REVIEW USULAN -->
<div id="proposal-detail-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 shadow-floating border border-slate-200 space-y-4 max-h-[90vh] flex flex-col justify-between overflow-hidden">
        
        <!-- Header -->
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-lg">description</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900" id="detail-modal-title">Detail Usulan Kurikulum</h3>
                    <p class="text-[11px] text-slate-500" id="detail-modal-subtitle">Informasi pengajuan dan catatan penelaahan</p>
                </div>
            </div>
            <button onclick="closeProposalDetailModal()" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto space-y-4 text-xs pr-1" id="detail-modal-body">
            <!-- Dynamic Injection via JavaScript -->
        </div>

        <!-- Footer Actions -->
        <div class="pt-4 border-t border-slate-100 flex items-center justify-between shrink-0" id="detail-modal-footer">
            <button type="button" onclick="closeProposalDetailModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold">
                Tutup
            </button>
            <div id="detail-modal-actions" class="flex items-center gap-2"></div>
        </div>

    </div>
</div>

<script>
    function showProposalDetail(prop) {
        const modal = document.getElementById('proposal-detail-modal');
        const title = document.getElementById('detail-modal-title');
        const subtitle = document.getElementById('detail-modal-subtitle');
        const body = document.getElementById('detail-modal-body');
        const actions = document.getElementById('detail-modal-actions');

        title.textContent = prop.nomor_usulan + ': ' + prop.judul_usulan;
        subtitle.textContent = (prop.mata_pelajaran ? prop.mata_pelajaran.nama_mapel : 'Mapel') + ' • ' + (prop.unit ? prop.unit.nama_unit : 'Unit');

        let statusHtml = '';
        if (prop.status === 'Disetujui') {
            statusHtml = `<span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 font-bold text-[11px]">✓ Disetujui & Diterapkan</span>`;
        } else if (prop.status === 'Ditolak') {
            statusHtml = `<span class="px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-800 border border-rose-200 font-bold text-[11px]">✕ Perlu Revisi / Ditolak</span>`;
        } else {
            statusHtml = `<span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200 font-bold text-[11px]">⏳ Menunggu Peninjauan</span>`;
        }

        let feedbackHtml = '';
        if (prop.status === 'Ditolak' && prop.alasan_penolakan) {
            feedbackHtml = `
                <div class="p-3.5 rounded-2xl bg-rose-50/70 border border-rose-200 space-y-1">
                    <span class="font-bold text-rose-800 flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">feedback</span> Catatan Evaluasi Kepala Sekolah:
                    </span>
                    <p class="text-rose-900 leading-relaxed italic pl-3 border-l-2 border-rose-400">
                        "${prop.alasan_penolakan}"
                    </p>
                    <span class="text-[10px] text-rose-600 block pt-1">
                        Ditinjau oleh: ${prop.peninjau ? prop.peninjau.name : 'Kepala Sekolah'}
                    </span>
                </div>
            `;
        } else if (prop.status === 'Disetujui') {
            feedbackHtml = `
                <div class="p-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between">
                    <span class="flex items-center gap-1.5 font-semibold">
                        <span class="material-symbols-outlined text-base">verified</span>
                        Telah disahkan dan disinkronkan ke Master Silabus
                    </span>
                    <span class="text-[11px] text-emerald-700">Oleh: ${prop.peninjau ? prop.peninjau.name : 'Kepala Unit'}</span>
                </div>
            `;
        }

        body.innerHTML = `
            <div class="grid grid-cols-2 gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                <div>
                    <span class="text-slate-400 text-[11px] block">Jenis & Objek Usulan:</span>
                    <span class="font-bold text-slate-800">${prop.jenis_usulan} ${prop.objek_data}</span>
                </div>
                <div>
                    <span class="text-slate-400 text-[11px] block">Status Verifikasi:</span>
                    <div>${statusHtml}</div>
                </div>
                <div>
                    <span class="text-slate-400 text-[11px] block">Diajukan Oleh:</span>
                    <span class="font-semibold text-slate-800">${prop.pengusul ? prop.pengusul.name : '-'}</span>
                </div>
                <div>
                    <span class="text-slate-400 text-[11px] block">Waktu Pengajuan:</span>
                    <span class="text-slate-700">${prop.tanggal_pengajuan}</span>
                </div>
            </div>

            <div class="space-y-1">
                <span class="font-bold text-slate-800 block">Rasional Pedagogis (Sesuai SOP-KUR-01):</span>
                <p class="text-slate-600 bg-slate-50 p-3.5 rounded-2xl border border-slate-100 leading-relaxed">
                    ${prop.alasan_pengajuan}
                </p>
            </div>

            ${feedbackHtml}
        `;

        // Action buttons based on status & current user role
        actions.innerHTML = '';
        @if(auth()->user()->canReviewProposals())
            if (prop.status === 'Menunggu Persetujuan') {
                actions.innerHTML = `
                    <form method="POST" action="/usulan/${prop.id}/review" class="inline">
                        @csrf
                        <input type="hidden" name="keputusan" value="setujui">
                        <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold shadow-subtle transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">check</span>
                            <span>Setujui Usulan</span>
                        </button>
                    </form>
                    <button type="button" onclick="closeProposalDetailModal(); openRejectModal('${prop.id}', '${prop.nomor_usulan}', '${prop.judul_usulan}')" 
                            class="px-4 py-2 rounded-xl bg-rose-700 hover:bg-rose-800 text-white text-xs font-semibold transition-colors">
                        Tolak / Minta Revisi
                    </button>
                `;
            }
        @endif

        if (prop.status === 'Ditolak') {
            actions.innerHTML += `
                <button type="button" onclick="closeProposalDetailModal(); openGlobalProposalModal('${prop.objek_data}', 'Revisi Ulang: ' + '${prop.judul_usulan}', '${prop.data_id}', null, '${prop.mapel_id}')"
                        class="px-4 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">edit_note</span>
                    <span>Ajukan Revisi Ulang</span>
                </button>
            `;
        }

        modal.classList.remove('hidden');
    }

    function closeProposalDetailModal() {
        document.getElementById('proposal-detail-modal').classList.add('hidden');
    }

    function filterProposalsLive() {
        const query = (document.getElementById('live-proposal-search')?.value || '').toLowerCase().trim();
        document.querySelectorAll('.proposal-row').forEach(row => {
            const text = row.getAttribute('data-search') || '';
            if (!query || text.includes(query)) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    }
</script>
@endsection
