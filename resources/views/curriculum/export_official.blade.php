<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silabus Resmi - {{ $mapel->nama_mapel }} - {{ $mapel->kurikulum?->unit?->nama_unit ?? 'YPI Ali Masykur' }}</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo-yayasan.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Times+New+Roman&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; font-size: 11pt; }
            .print-page { box-shadow: none !important; margin: 0 !important; max-width: 100% !important; border: none !important; padding: 0 !important; }
            @page { size: A4 landscape; margin: 15mm; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 font-sans min-h-screen py-8 px-4 antialiased">

    <!-- FLOATING TOP BAR ACTION (NO PRINT) -->
    <div class="max-w-5xl mx-auto mb-6 flex items-center justify-between no-print bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex items-center gap-3">
            <a href="{{ route('curriculum.index', ['mapel_id' => $mapel->id]) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                <span>Kembali ke Workspace</span>
            </a>
            <div class="h-5 w-px bg-slate-200"></div>
            <span class="text-xs text-slate-500 font-medium">Dokumen Resmi Silabus & Alur Tujuan Pembelajaran (ATP)</span>
        </div>

        <div class="flex items-center gap-2">
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white font-semibold text-xs transition shadow-sm cursor-pointer">
                <span class="material-symbols-outlined text-base">print</span>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- MAIN PRINT CONTAINER -->
    <div class="print-page max-w-5xl mx-auto bg-white p-10 sm:p-12 rounded-3xl shadow-md border border-slate-200">
        
        <!-- KOP RESMI YAYASAN & SATUAN PENDIDIKAN -->
        <div class="flex items-center gap-5 pb-4 border-b-[3px] border-slate-900">
            <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo YPI Ali Masykur" class="w-20 h-20 object-contain shrink-0">
            <div class="text-center flex-1 space-y-0.5">
                <h3 class="text-sm font-bold tracking-wider text-slate-800 uppercase">YPI ALI MASYKUR</h3>
                <h1 class="text-xl font-extrabold text-slate-950 uppercase tracking-tight">{{ $mapel->kurikulum?->unit?->nama_unit ?? 'Unit Pendidikan' }}</h1>
                <p class="text-[11px] text-slate-600 font-serif italic">
                    Dusun Bumen, Desa Bumirejo, Kecamatan Mojotengah, Kabupaten Wonosobo, Jawa Tengah 56351
                </p>
                <p class="text-[10px] text-slate-500 font-mono">
                    Surat Elektronik: sekretariat@alimasykur.sch.id • Portal Akademik Terpadu
                </p>
            </div>
        </div>
        <div class="border-b border-slate-900 mt-0.5 mb-6"></div>

        <!-- JUDUL DOKUMEN -->
        <div class="text-center space-y-1 mb-6">
            <h2 class="text-base font-extrabold uppercase tracking-wide text-slate-900">
                SILABUS & ALUR TUJUAN PEMBELAJARAN (ATP)
            </h2>
            <p class="text-xs text-slate-600 font-medium">
                Tahun Ajaran {{ $mapel->kurikulum?->tahun_ajaran ?? '2024/2025' }} • Semester {{ $mapel->kurikulum?->semester ?? 'Ganjil' }}
            </p>
        </div>

        <!-- TABEL IDENTITAS MATA PELAJARAN -->
        <div class="grid grid-cols-2 gap-4 text-xs mb-6 p-4 rounded-xl bg-slate-50 border border-slate-200">
            <div class="space-y-1.5">
                <div class="flex"><span class="w-36 text-slate-500 font-medium">Mata Pelajaran:</span><span class="font-bold text-slate-900">{{ $mapel->nama_mapel }}</span></div>
                <div class="flex"><span class="w-36 text-slate-500 font-medium">Kode Mapel:</span><span class="font-mono font-bold text-slate-900">{{ $mapel->kode_mapel }}</span></div>
                <div class="flex"><span class="w-36 text-slate-500 font-medium">Satuan Pendidikan:</span><span class="font-semibold text-slate-900">{{ $mapel->kurikulum?->unit?->nama_unit }}</span></div>
            </div>
            <div class="space-y-1.5">
                <div class="flex"><span class="w-36 text-slate-500 font-medium">Fase / Kelas:</span><span class="font-semibold text-slate-900">{{ $mapel->kelas->first()?->fase?->nama_fase ?? 'Fase D' }} • Kelas {{ $mapel->kelas->pluck('nomor_kelas')->unique()->join(', ') }}</span></div>
                <div class="flex"><span class="w-36 text-slate-500 font-medium">Kurikulum Acuan:</span><span class="font-semibold text-slate-900">{{ $mapel->kurikulum?->nama_kurikulum ?? 'Kurikulum Merdeka' }}</span></div>
                <div class="flex"><span class="w-36 text-slate-500 font-medium">Guru Pengampu:</span><span class="font-semibold text-slate-900">{{ $pengampu->pluck('name')->join(', ') ?: 'Belum Ditetapkan' }}</span></div>
            </div>
        </div>

        <!-- TABEL RINCIAN SILABUS HIERARKIS (CP -> TP -> MATERI) -->
        <div class="overflow-hidden border border-slate-300 rounded-xl mb-6">
            <table class="w-full text-xs text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-800 font-bold border-b border-slate-300">
                        <th class="py-2.5 px-3 w-10 text-center border-r border-slate-300">No</th>
                        <th class="py-2.5 px-3.5 w-1/4 border-r border-slate-300">Capaian Pembelajaran (CP)</th>
                        <th class="py-2.5 px-3.5 w-1/3 border-r border-slate-300">Tujuan Pembelajaran (TP)</th>
                        <th class="py-2.5 px-3.5 border-r border-slate-300">Materi Pembelajaran & Media Ajar</th>
                        <th class="py-2.5 px-3 w-16 text-center">Beban (JP)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @php 
                        $no = 1; 
                        $totalJpSemua = 0;
                    @endphp
                    @forelse($mapel->capaianPembelajaran as $cp)
                        @php
                            $tpCount = $cp->tujuanPembelajaran->count() ?: 1;
                        @endphp
                        @foreach($cp->tujuanPembelajaran as $tpIndex => $tp)
                            <tr class="align-top hover:bg-slate-50/50">
                                @if($tpIndex === 0)
                                    <td rowspan="{{ $tpCount }}" class="py-2.5 px-3 text-center font-bold text-slate-600 border-r border-slate-200 bg-slate-50/30">
                                        {{ $no++ }}
                                    </td>
                                    <td rowspan="{{ $tpCount }}" class="py-2.5 px-3.5 border-r border-slate-200 space-y-1">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 inline-block">
                                            Elemen: {{ $cp->elemen }}
                                        </span>
                                        <p class="text-slate-800 leading-relaxed text-[11px]">{{ $cp->deskripsi_cp }}</p>
                                    </td>
                                @endif

                                <td class="py-2.5 px-3.5 border-r border-slate-200 space-y-1">
                                    <span class="font-mono font-bold text-slate-800 text-[11px]">{{ $tp->kode_tp }}</span>
                                    <p class="text-slate-800 leading-relaxed text-[11px]">{{ $tp->deskripsi_tp }}</p>
                                </td>

                                <td class="py-2.5 px-3.5 border-r border-slate-200 space-y-2">
                                    @forelse($tp->materi as $materi)
                                        @php $totalJpSemua += ($materi->beban_jp ?? 0); @endphp
                                        <div class="border-b border-slate-100 last:border-none pb-1.5 last:pb-0">
                                            <div class="font-semibold text-slate-900 text-[11px]">• {{ $materi->judul_materi }}</div>
                                            <div class="text-[10px] text-slate-500 flex items-center gap-2">
                                                <span>Media: {{ $materi->media_ajar ?? 'Modul Ajar' }}</span>
                                                <span>•</span>
                                                <span class="font-semibold text-emerald-800">{{ $materi->beban_jp ?? 0 }} JP</span>
                                            </div>
                                        </div>
                                    @empty
                                        <span class="text-slate-400 italic text-[11px]">Belum ada rincian materi.</span>
                                    @endforelse
                                </td>

                                <td class="py-2.5 px-3 text-center font-bold text-slate-900">
                                    {{ $tp->materi->sum('beban_jp') ?: ($tp->beban_jp ?? 0) }}
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 italic">
                                Belum ada data Capaian Pembelajaran pada mata pelajaran ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="bg-slate-100 font-bold border-t border-slate-300 text-slate-900">
                        <td colspan="4" class="py-2.5 px-4 text-right">TOTAL ALOKASI JAM TATAP MUKA:</td>
                        <td class="py-2.5 px-3 text-center text-emerald-900 font-extrabold">{{ $totalJpSemua }} JP</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- LEMBAR PENGESAHAN DOKUMEN RESMI -->
        <div class="mt-10 pt-4 border-t border-slate-200 text-xs">
            <div class="text-right text-slate-600 mb-6">
                Wonosobo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </div>

            <div class="grid grid-cols-3 gap-6 text-center">
                <!-- Guru Pengampu -->
                <div class="space-y-16">
                    <p class="font-medium text-slate-600">Guru Pengampu Mata Pelajaran,</p>
                    <div>
                        <p class="font-bold text-slate-900 underline">{{ $pengampu->first()?->name ?? '.....................................' }}</p>
                        <p class="text-[11px] text-slate-500 font-mono">NIP. {{ $pengampu->first()?->nip ?? '........................' }}</p>
                    </div>
                </div>

                <!-- Waka Kurikulum -->
                <div class="space-y-16">
                    <p class="font-medium text-slate-600">Mengetahui,<br>Waka Bidang Kurikulum</p>
                    <div>
                        <p class="font-bold text-slate-900 underline">{{ $mapel->kurikulum?->unit?->kepala_sekolah ? 'Tim Pengembang Kurikulum' : '.....................................' }}</p>
                        <p class="text-[11px] text-slate-500">Divisi Penjaminan Mutu Akademik</p>
                    </div>
                </div>

                <!-- Kepala Sekolah / Madrasah -->
                <div class="space-y-16">
                    <p class="font-medium text-slate-600">Mengesahkan,<br>Kepala {{ $mapel->kurikulum?->unit?->nama_unit ?? 'Sekolah' }}</p>
                    <div>
                        <p class="font-bold text-slate-900 underline">{{ $mapel->kurikulum?->unit?->kepala_sekolah ?? '.....................................' }}</p>
                        <p class="text-[11px] text-slate-500">NIP / SK Kepala Unit</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
