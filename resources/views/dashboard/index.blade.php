@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6 max-w-[1600px] mx-auto">

    <!-- 2-COLUMN DESKTOP CANVAS (Matches Learnhru Reference Architecture) -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">
        
        <!-- ======================================================== -->
        <!-- MIDDLE / MAIN COLUMN (xl:col-span-8 or 9) -->
        <!-- ======================================================== -->
        <div class="xl:col-span-8 2xl:col-span-9 space-y-6">

            <!-- WELCOME HERO BANNER (With 3D Isometric Book Illustration) -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative">
                <div class="space-y-3.5 max-w-xl z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-600 animate-pulse"></span>
                        <span>{{ $user->unit->nama_unit ?? 'Yayasan Alfa Ali Masykur' }}</span>
                        <span>•</span>
                        <span>T.A 2024/2025</span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 leading-tight">
                        Selamat Datang Kembali, {{ $user->name }}!
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Kelola Capaian Pembelajaran, perumusan Tujuan Pembelajaran (TP), dan pantau usulan silabus lintas unit pendidikan secara terpadu dan transparan.
                    </p>

                    <div class="pt-2">
                        <a href="{{ route('curriculum.index') }}" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all">
                            <span>Eksplorasi Silabus Terpadu</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>

                <!-- 3D Isometric Books Graphic (Faithful to Reference Image) -->
                <div class="shrink-0 flex items-center justify-center md:pr-4">
                    <svg class="w-40 h-36 sm:w-52 sm:h-44 drop-shadow-sm select-none" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Bottom Book (Navy / Deep Blue) -->
                        <path d="M40 120 L120 160 L200 120 L120 80 Z" fill="#3b82f6" />
                        <path d="M40 120 L40 135 L120 175 L120 160 Z" fill="#1d4ed8" />
                        <path d="M120 160 L120 175 L200 135 L200 120 Z" fill="#2563eb" />
                        <path d="M44 121 L44 130 L118 168 L118 159 Z" fill="#f8fafc" />
                        <path d="M122 159 L122 168 L196 130 L196 121 Z" fill="#e2e8f0" />

                        <!-- Middle Book (Rose / Pink) -->
                        <path d="M50 95 L120 130 L190 95 L120 60 Z" fill="#fb7185" />
                        <path d="M50 95 L50 108 L120 143 L120 130 Z" fill="#e11d48" />
                        <path d="M120 130 L120 143 L190 108 L190 95 Z" fill="#f43f5e" />
                        <path d="M54 96 L54 104 L118 137 L118 129 Z" fill="#fff1f2" />
                        <path d="M122 129 L122 137 L186 104 L186 96 Z" fill="#ffe4e6" />

                        <!-- Top Document / Tablet Page -->
                        <path d="M70 65 L130 95 L180 70 L120 40 Z" fill="#ffffff" stroke="#e2e8f0" stroke-width="1.5" />
                        <path d="M70 65 L70 70 L130 100 L130 95 Z" fill="#cbd5e1" />
                        <path d="M130 95 L130 100 L180 75 L180 70 Z" fill="#94a3b8" />
                        
                        <!-- Page Checklist Dots & Lines -->
                        <circle cx="95" cy="62" r="2.5" fill="#3b82f6" />
                        <line x1="103" y1="62" x2="140" y2="53" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                        <circle cx="103" cy="68" r="2.5" fill="#3b82f6" />
                        <line x1="111" y1="68" x2="148" y2="59" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                        <circle cx="111" cy="74" r="2.5" fill="#3b82f6" />
                        <line x1="119" y1="74" x2="156" y2="65" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
            </div>

            <!-- KHUSUS KEPALA SEKOLAH & WAKA KURIKULUM: ALERT USULAN MENUNGGU VERIFIKASI (IF ANY) -->
            @if(($user->isKepalaSekolah() || $user->isWakaKurikulum()) && count($pendingReviews) > 0)
                <div id="kepsek-pending-card" class="bg-amber-50/80 border border-amber-200 rounded-3xl p-5 shadow-card space-y-3">
                    <div class="flex items-center justify-between pb-2 border-b border-amber-200/70">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-600 animate-pulse"></span>
                            <h2 class="text-xs font-bold uppercase tracking-wider text-amber-950">
                                {{ $user->isWakaKurikulum() ? 'Usulan Guru Menunggu Telaah Teknis & Validasi' : 'Usulan Pendidik Menunggu Pengesahan' }} ({{ count($pendingReviews) }})
                            </h2>
                        </div>
                        <a href="{{ route('usulan.index') }}" class="text-xs font-semibold text-amber-900 hover:underline">
                            Lihat Semua →
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-1">
                        @foreach($pendingReviews as $pr)
                            <div class="p-4 rounded-2xl bg-white border border-amber-200/80 shadow-subtle flex flex-col justify-between gap-3">
                                <div>
                                    <div class="flex items-center justify-between text-xs mb-1">
                                        <span class="font-bold text-slate-800">{{ $pr->nomor_usulan }}</span>
                                        <span class="text-[11px] text-slate-400">{{ $pr->tanggal_pengajuan->diffForHumans() }}</span>
                                    </div>
                                    <h3 class="text-xs font-bold text-slate-900 line-clamp-1">{{ $pr->judul_usulan }}</h3>
                                    <div class="text-[11px] text-slate-500 mt-1">
                                        Pengusul: <span class="font-semibold text-slate-700">{{ $pr->pengusul->name }}</span> ({{ $pr->mataPelajaran->nama_mapel }})
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
                                    <form method="POST" action="{{ route('usulan.review', $pr->id) }}" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="keputusan" value="setujui">
                                        <button type="submit" 
                                                class="w-full py-2 px-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold transition-colors flex items-center justify-center gap-1 shadow-subtle">
                                            <span class="material-symbols-outlined text-sm">check</span>
                                            <span>Setujui</span>
                                        </button>
                                    </form>

                                    <button type="button" onclick="openRejectModal('{{ $pr->id }}', '{{ $pr->nomor_usulan }}', '{{ addslashes($pr->judul_usulan) }}')"
                                            class="py-2 px-3 rounded-xl bg-white border border-slate-200 text-rose-700 hover:bg-rose-50 text-xs font-semibold transition-colors">
                                        Tolak / Revisi
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- KHUSUS WAKA KURIKULUM & KEPSEK: PORTOFOLIO SUPERVISI & STATUS KBM UNIT -->
            @if(($user->isWakaKurikulum() || $user->isKepalaSekolah()) && $unit)
                <div class="p-5 rounded-3xl bg-white border border-slate-100 shadow-card flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-800 flex items-center justify-center font-bold shrink-0">
                            <span class="material-symbols-outlined text-2xl">verified</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Status Kelengkapan Arsip Dokumen Unit</h3>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $persentaseArsip >= 80 ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $persentaseArsip }}% Lengkap
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                                <strong>{{ $terverifikasiArsipUnit }}</strong> dari <strong>{{ $totalArsipUnit }}</strong> dokumen kurikulum telah terverifikasi lengkap. Terdapat <strong>{{ $totalGuruUnit }} guru mapel</strong> terdata di unit {{ $unit->nama_unit }}.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0 self-stretch md:self-auto justify-end">
                        <a href="{{ route('arsip.index', ['unit_id' => $unit->id]) }}" 
                           class="px-4 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all">
                            Buka Bank Arsip Dokumen →
                        </a>
                    </div>
                </div>
            @endif

            <!-- "CLASSES" SECTION: 3 FEATURED MATA PELAJARAN CARDS (Matches Reference Style Exactly) -->
            <div class="space-y-3.5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Mata Pelajaran &amp; Silabus</h2>
                        <p class="text-[11px] text-slate-500">Pilih mata pelajaran untuk melihat atau memperbarui alur capaian pembelajaran</p>
                    </div>
                    <a href="{{ route('curriculum.index', ['view' => 'katalog']) }}" class="text-xs font-semibold text-brand-800 hover:underline transition-colors flex items-center gap-1">
                        <span>Lihat Semua</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @php
                        $gradientPalettes = [
                            ['from' => 'from-[#3252a4]', 'to' => 'to-[#1b3472]', 'text_sub' => 'text-blue-200', 'badge_bg' => 'bg-blue-400/30'],
                            ['from' => 'from-[#495796]', 'to' => 'to-[#2b3564]', 'text_sub' => 'text-indigo-200', 'badge_bg' => 'bg-indigo-400/30'],
                            ['from' => 'from-[#7c3f6a]', 'to' => 'to-[#522345]', 'text_sub' => 'text-pink-200', 'badge_bg' => 'bg-pink-400/30'],
                        ];
                    @endphp

                    @forelse($mapelList->take(3) as $idx => $mp)
                        @php
                            $palette = $gradientPalettes[$idx % 3];
                            $teacher = $mp->penugasanGuru->first()?->user;
                            $tpCount = $mp->tujuan_pembelajaran_count ?? 12;
                        @endphp
                        <a href="{{ route('curriculum.index', ['mapel_id' => $mp->id, 'view' => 'workspace']) }}" 
                           class="rounded-3xl p-5 text-white shadow-card bg-gradient-to-br {{ $palette['from'] }} {{ $palette['to'] }} flex flex-col justify-between min-h-[175px] relative overflow-hidden group hover:-translate-y-1 hover:shadow-floating transition-all duration-200 cursor-pointer">
                            
                            <div class="space-y-1 z-10">
                                <span class="text-[10px] font-bold uppercase tracking-wider {{ $palette['text_sub'] }} block">
                                    {{ $mp->kurikulum->unit->nama_unit ?? 'Unit Pendidikan' }} • {{ $mp->kode_mapel }}
                                </span>
                                <h3 class="text-sm font-bold text-white group-hover:text-amber-200 transition-colors line-clamp-1">
                                    {{ $mp->nama_mapel }}
                                </h3>
                            </div>

                            <div class="space-y-3 pt-4 z-10">
                                <!-- Avatar Stack -->
                                <div class="flex items-center -space-x-1.5">
                                    <div class="w-6 h-6 rounded-full bg-white/20 border border-white/40 flex items-center justify-center text-[10px] font-bold text-white">
                                        {{ substr($teacher->name ?? 'G', 0, 1) }}
                                    </div>
                                    <div class="w-6 h-6 rounded-full bg-white/10 border border-white/30 flex items-center justify-center text-[10px] font-bold text-white/80">
                                        KS
                                    </div>
                                    <div class="w-6 h-6 rounded-full bg-white/10 border border-white/30 flex items-center justify-center text-[9px] font-bold text-white/80">
                                        +3
                                    </div>
                                </div>

                                <div class="flex items-center justify-between text-[11px] border-t border-white/15 pt-2">
                                    <span class="flex items-center gap-1 {{ $palette['text_sub'] }}">
                                        <span class="material-symbols-outlined text-sm">description</span>
                                        <span>{{ $tpCount }} Sasaran TP</span>
                                    </span>
                                    <span class="truncate max-w-[120px] text-right text-white font-medium">
                                        {{ $teacher->name ?? 'Dewan Guru' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Decorative background circle -->
                            <div class="absolute -right-6 -bottom-6 w-24 h-24 rounded-full bg-white/5 pointer-events-none"></div>
                        </a>
                    @empty
                        <div class="col-span-3 p-6 rounded-3xl bg-white text-center text-xs text-slate-400 border border-slate-100">
                            Belum ada mata pelajaran terdaftar.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- "LESSONS" SECTION: TABLE USULAN KURIKULUM (Matches Reference Style Exactly) -->
            <div class="space-y-3.5 pt-1">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Usulan Kurikulum &amp; Silabus Terkini</h2>
                        <p class="text-[11px] text-slate-500">Status verifikasi capaian pembelajaran dan perumusan materi</p>
                    </div>
                    <a href="{{ route('usulan.index') }}" class="text-xs font-semibold text-brand-800 hover:underline transition-colors">
                        Lihat Semua &gt;
                    </a>
                </div>

                <!-- Modern Clean Table Surface -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50/70 border-b border-slate-100 text-slate-500 font-semibold text-[11px]">
                                <tr>
                                    <th class="py-3.5 px-5">Kode Usulan</th>
                                    <th class="py-3.5 px-4">Mata Pelajaran</th>
                                    <th class="py-3.5 px-4">Pengusul</th>
                                    <th class="py-3.5 px-4">Tanggal</th>
                                    <th class="py-3.5 px-4">Rincian TP</th>
                                    <th class="py-3.5 px-5 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100" id="recent-proposals-table">
                                @forelse($recentUsulan as $usulan)
                                    <tr class="hover:bg-slate-50/60 transition-colors">
                                        <td class="py-4 px-5 font-bold text-slate-900">
                                            {{ $usulan->nomor_usulan }}
                                        </td>
                                        <td class="py-4 px-4 text-slate-700 font-medium truncate max-w-[150px]">
                                            {{ $usulan->mataPelajaran->nama_mapel ?? '-' }}
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-brand-50 border border-brand-200 text-brand-800 flex items-center justify-center font-bold text-[10px] shrink-0">
                                                    {{ substr($usulan->pengusul->name ?? 'G', 0, 1) }}
                                                </div>
                                                <span class="text-slate-800 font-medium truncate max-w-[120px]">
                                                    {{ $usulan->pengusul->name ?? '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-slate-500 text-[11px]">
                                            {{ $usulan->tanggal_pengajuan ? $usulan->tanggal_pengajuan->format('d.m.Y') : '-' }}
                                        </td>
                                        <td class="py-4 px-4">
                                            <a href="{{ route('usulan.index') }}" class="text-brand-800 hover:underline font-semibold text-[11px] truncate block max-w-[180px]">
                                                {{ $usulan->judul_usulan }}
                                            </a>
                                        </td>
                                        <td class="py-4 px-5 text-right">
                                            @if($usulan->status === 'Disetujui')
                                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                                    Disetujui
                                                </span>
                                            @elseif($usulan->status === 'Ditolak')
                                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-800 border border-rose-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                                                    Perlu Revisi
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                    Menunggu
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-slate-400 text-xs">
                                            Belum ada usulan kurikulum yang diajukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- ======================================================== -->
        <!-- RIGHT PANEL (DEDICATED PROFILE, CALENDAR, & REMINDERS) -->
        <!-- Matches Right Column of Reference Image Exactly -->
        <!-- ======================================================== -->
        <div class="xl:col-span-4 2xl:col-span-3 bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-6">

            <!-- 1. USER PROFILE CARD (Centered Avatar, Name, Role, Pill Button) -->
            <div class="text-center space-y-3 pt-2">
                <div class="relative w-20 h-20 mx-auto">
                    <div class="w-20 h-20 rounded-full bg-slate-100 border-2 border-brand-200 flex items-center justify-center font-extrabold text-2xl text-brand-800 shadow-subtle overflow-hidden">
                        @if($user->avatar_url)
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            {{ substr($user->name, 0, 1) }}
                        @endif
                    </div>
                    <span class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white"></span>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-slate-900 leading-snug">{{ $user->name }}</h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">
                        {{ $user->peran->nama_peran ?? 'Pendidik' }} • {{ $user->unit->kode_unit ?? 'YPI' }}
                    </p>
                </div>

                <div class="pt-1">
                    <button type="button" onclick="openUserProfileModal()" 
                            class="inline-flex items-center gap-1.5 px-5 py-2 rounded-full bg-slate-50 hover:bg-slate-100 border border-slate-200/80 text-slate-700 text-xs font-semibold shadow-subtle hover:shadow transition-all cursor-pointer">
                        <span class="material-symbols-outlined text-sm text-brand-700">badge</span>
                        <span>Profil Akun</span>
                    </button>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- 2. MINI ACADEMIC CALENDAR WIDGET (Interactive Month Navigation & Day Selection) -->
            <div class="space-y-3 bg-white p-4 rounded-3xl border border-slate-100 shadow-card">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <div class="flex items-center gap-1.5">
                        <button type="button" onclick="changeDashboardMonth(-1)" class="text-slate-400 hover:text-slate-700 p-1 rounded-xl hover:bg-slate-100 transition-colors" title="Bulan Sebelumnya">
                            <span class="material-symbols-outlined text-sm">chevron_left</span>
                        </button>
                        <span class="text-xs font-bold text-slate-900" id="cal-month-label">
                            {{ now()->locale('id')->translatedFormat('F Y') }}
                        </span>
                        <button type="button" onclick="changeDashboardMonth(1)" class="text-slate-400 hover:text-slate-700 p-1 rounded-xl hover:bg-slate-100 transition-colors" title="Bulan Berikutnya">
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                        </button>
                    </div>

                    <button type="button" onclick="openModalAgendaBaru()" class="text-[11px] font-bold text-brand-800 hover:text-brand-900 bg-brand-50 hover:bg-brand-100 px-2.5 py-1 rounded-full transition-colors flex items-center gap-1 cursor-pointer">
                        <span class="material-symbols-outlined text-xs">add_circle</span>
                        <span>Agenda</span>
                    </button>
                </div>

                <!-- Calendar Days Header -->
                <div class="grid grid-cols-7 text-center text-[10px] font-semibold text-slate-400">
                    <span>Sen</span>
                    <span>Sel</span>
                    <span>Rab</span>
                    <span>Kam</span>
                    <span>Jum</span>
                    <span>Sab</span>
                    <span>Min</span>
                </div>

                <!-- Calendar Dates Grid (Generated by JS) -->
                <div id="cal-dates-grid" class="grid grid-cols-7 gap-y-1.5 text-center text-xs">
                    <!-- Populated dynamically by renderDashboardCalendar() -->
                </div>

                <!-- Interactive Date Detail Container -->
                <div id="cal-selected-notice" class="hidden p-3 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs space-y-2.5 animate-in fade-in">
                    <div class="flex items-center justify-between border-b border-slate-200/60 pb-1.5">
                        <span id="cal-selected-header" class="font-bold text-slate-900 text-xs flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm text-brand-700">event</span>
                            <span id="cal-selected-text"></span>
                        </span>
                        <button type="button" onclick="this.closest('#cal-selected-notice').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                            <span class="material-symbols-outlined text-xs">close</span>
                        </button>
                    </div>

                    <div id="cal-agenda-list" class="space-y-2 max-h-48 overflow-y-auto">
                        <!-- Populated by JS -->
                    </div>

                    <div class="pt-1">
                        <button type="button" onclick="openModalAgendaBaru(currentSelectedDateStr)" class="w-full py-1.5 text-center text-[11px] font-bold text-brand-800 bg-white border border-brand-200 rounded-xl hover:bg-brand-50 transition-colors flex items-center justify-center gap-1 cursor-pointer">
                            <span class="material-symbols-outlined text-xs">add</span>
                            <span>Tambah Agenda di Tanggal Ini</span>
                        </button>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- 3. REMINDERS / AGENDA KERJA PENDIDIK (Matching Learnhru Reminders Style) -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-900 block">Pengingat &amp; Agenda Kerja</span>
                    <a href="{{ route('jurnal.index') }}" class="text-[11px] font-semibold text-brand-800 hover:underline">
                        Kelola
                    </a>
                </div>

                <div class="space-y-2">
                    @forelse($userAgendaTasks as $agenda)
                        <div class="flex items-start gap-2.5 p-2.5 rounded-2xl hover:bg-slate-50 transition-colors border border-slate-100/60 bg-white">
                            <div class="w-7 h-7 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-sm">notifications</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-xs font-semibold text-slate-900 leading-snug truncate">{{ $agenda->judul }}</h4>
                                <div class="flex items-center gap-1.5 text-[10px] text-slate-500 mt-0.5">
                                    <span class="font-bold text-brand-800">{{ $agenda->kategori_badge['label'] }}</span>
                                    <span>•</span>
                                    <span>{{ $agenda->tanggal_target ? $agenda->tanggal_target->format('d M') : 'Hari ini' }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        @forelse($recentUsulan->take(3) as $notifItem)
                            <a href="{{ route('usulan.index') }}" class="flex items-center gap-2.5 p-2.5 rounded-2xl hover:bg-slate-50 transition-colors block border border-slate-100/60">
                                <div class="w-7 h-7 rounded-lg bg-brand-50 text-brand-800 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-sm">notifications</span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-xs font-semibold text-slate-900 truncate">{{ $notifItem->judul_usulan }}</h4>
                                    <span class="text-[10px] text-slate-400 block">{{ $notifItem->status }} • {{ $notifItem->tanggal_pengajuan->format('d M Y') }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="flex items-center gap-2.5 p-2.5 rounded-2xl bg-slate-50 border border-slate-100/60">
                                <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-xs font-semibold text-slate-900 truncate">Semua agenda tuntas</h4>
                                    <span class="text-[10px] text-slate-400 block">Pekerjaan Anda tertata rapi</span>
                                </div>
                            </div>
                        @endforelse
                    @endforelse
                </div>

                <div class="pt-1">
                    <a href="{{ route('jurnal.index') }}" 
                       class="w-full py-2.5 px-3.5 rounded-2xl bg-slate-50 hover:bg-slate-100 border border-slate-200/80 text-slate-700 font-semibold text-xs transition-all shadow-subtle hover:shadow flex items-center justify-center gap-1.5 cursor-pointer">
                        <span class="material-symbols-outlined text-sm text-brand-700">checklist</span>
                        <span>Buka Buku Kerja &amp; Refleksi</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- MODAL PENOLAKAN / REVISI KHUSUS KEPALA SEKOLAH -->
<div id="reject-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-floating border border-slate-200 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2 text-rose-700">
                <span class="material-symbols-outlined">feedback</span>
                <h3 class="text-sm font-bold text-slate-900">Catatan Evaluasi / Permintaan Revisi</h3>
            </div>
            <button onclick="closeRejectModal()" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <form id="reject-form" method="POST" action="" class="space-y-3">
            @csrf
            <input type="hidden" name="keputusan" value="tolak">
            
            <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                <span class="text-slate-400 block" id="reject-target-code">Nomor Usulan</span>
                <span class="font-bold text-slate-800" id="reject-target-title">Judul Usulan</span>
            </div>

            <div class="space-y-1">
                <label class="text-xs font-semibold text-slate-700">Rekomendasi Perbaikan untuk Guru</label>
                <textarea name="alasan_penolakan" required rows="4" 
                          placeholder="Jelaskan alasan evaluasi dan arahan perbaikan untuk pendidik..."
                          class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-rose-500 focus:border-rose-500 leading-relaxed"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeRejectModal()" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-rose-700 hover:bg-rose-800 text-white text-xs font-semibold transition-colors">
                    Kirim Catatan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(proposalId, proposalCode, proposalTitle) {
        const modal = document.getElementById('reject-modal');
        const form = document.getElementById('reject-form');
        document.getElementById('reject-target-code').textContent = proposalCode;
        document.getElementById('reject-target-title').textContent = proposalTitle || '';
        form.action = `/usulan/${proposalId}/review`;
        modal.classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('reject-modal').classList.add('hidden');
    }

    // ==========================================
    // INTERACTIVE DASHBOARD CALENDAR & AGENDA
    // ==========================================
    const monthNamesId = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    let currentCalDate = new Date();
    let currentSelectedDay = currentCalDate.getDate();
    let currentSelectedDateStr = formatDateKey(currentCalDate.getFullYear(), currentCalDate.getMonth() + 1, currentSelectedDay);

    // Initial loaded user agenda events
    window.userAgendaEvents = {!! json_encode($formattedUserAgendas) !!};

    function formatDateKey(year, month, day) {
        const m = String(month).padStart(2, '0');
        const d = String(day).padStart(2, '0');
        return `${year}-${m}-${d}`;
    }

    function renderDashboardCalendar(date) {
        const grid = document.getElementById('cal-dates-grid');
        const label = document.getElementById('cal-month-label');
        if (!grid || !label) return;

        const year = date.getFullYear();
        const month = date.getMonth();

        label.textContent = `${monthNamesId[month]} ${year}`;

        // Get first day of month (0 = Sun, 1 = Mon ... 6 = Sat)
        let firstDay = new Date(year, month, 1).getDay();
        firstDay = firstDay === 0 ? 7 : firstDay;

        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const prevMonthDays = new Date(year, month, 0).getDate();

        const today = new Date();
        const todayStr = formatDateKey(today.getFullYear(), today.getMonth() + 1, today.getDate());

        let html = '';

        // Padding from previous month
        for (let i = 1; i < firstDay; i++) {
            const prevDayNum = prevMonthDays - (firstDay - 1) + i;
            html += `<span class="py-1 text-slate-300 text-[11px]">${prevDayNum}</span>`;
        }

        // Current month days
        for (let d = 1; d <= daysInMonth; d++) {
            const dateStr = formatDateKey(year, month + 1, d);
            const isToday = (dateStr === todayStr);
            const isSelected = (d === currentSelectedDay);

            // Find agendas active on this date (start <= dateStr <= end)
            const activeAgendas = window.userAgendaEvents.filter(ev => {
                const s = ev.start || ev.end;
                const e = ev.end || ev.start;
                return s && e && (dateStr >= s && dateStr <= e);
            });

            const hasAgendas = activeAgendas.length > 0;

            // Generate colored indicator dots (up to 3)
            let dotsHtml = '';
            if (hasAgendas) {
                dotsHtml = '<div class="flex items-center justify-center gap-0.5 mt-0.5">';
                activeAgendas.slice(0, 3).forEach(ag => {
                    dotsHtml += `<span class="w-1.5 h-1.5 rounded-full shrink-0 shadow-xs" style="background-color: ${ag.warna};" title="${ag.judul}"></span>`;
                });
                dotsHtml += '</div>';
            }

            if (isToday) {
                html += `
                    <div class="py-0.5 flex flex-col items-center justify-center cursor-pointer group" onclick="selectCalendarDate(${d}, ${month}, ${year})">
                        <span class="w-6 h-6 rounded-full bg-rose-500 text-white font-bold flex items-center justify-center shadow-subtle text-xs hover:scale-110 transition-transform">
                            ${d}
                        </span>
                        ${dotsHtml}
                    </div>`;
            } else if (isSelected) {
                html += `
                    <div class="py-0.5 flex flex-col items-center justify-center cursor-pointer group" onclick="selectCalendarDate(${d}, ${month}, ${year})">
                        <span class="w-6 h-6 rounded-full bg-brand-800 text-white font-bold flex items-center justify-center shadow-subtle text-xs">
                            ${d}
                        </span>
                        ${dotsHtml}
                    </div>`;
            } else {
                html += `
                    <div class="py-0.5 flex flex-col items-center justify-center rounded-xl cursor-pointer hover:bg-slate-50 transition-colors group" 
                         onclick="selectCalendarDate(${d}, ${month}, ${year})">
                        <span class="w-6 h-6 flex items-center justify-center text-slate-700 font-semibold group-hover:text-brand-800 text-xs">
                            ${d}
                        </span>
                        ${dotsHtml}
                    </div>`;
            }
        }

        // Fill remaining cells
        const totalCells = (firstDay - 1) + daysInMonth;
        let remaining = 35 - totalCells;
        if (remaining < 0) remaining = 42 - totalCells;

        for (let n = 1; n <= remaining; n++) {
            html += `<span class="py-1 text-slate-300 text-[11px]">${n}</span>`;
        }

        grid.innerHTML = html;
    }

    function changeDashboardMonth(step) {
        currentCalDate.setMonth(currentCalDate.getMonth() + step);
        currentSelectedDay = 1;
        currentSelectedDateStr = formatDateKey(currentCalDate.getFullYear(), currentCalDate.getMonth() + 1, 1);
        renderDashboardCalendar(currentCalDate);
    }

    function selectCalendarDate(day, month, year) {
        currentSelectedDay = day;
        currentSelectedDateStr = formatDateKey(year, month + 1, day);
        renderDashboardCalendar(currentCalDate);

        const notice = document.getElementById('cal-selected-notice');
        const text = document.getElementById('cal-selected-text');
        const listContainer = document.getElementById('cal-agenda-list');
        if (!notice || !text || !listContainer) return;

        text.textContent = `${day} ${monthNamesId[month]} ${year}`;

        // Find agendas on this day
        const activeAgendas = window.userAgendaEvents.filter(ev => {
            const s = ev.start || ev.end;
            const e = ev.end || ev.start;
            return s && e && (currentSelectedDateStr >= s && currentSelectedDateStr <= e);
        });

        if (activeAgendas.length === 0) {
            listContainer.innerHTML = `
                <div class="p-2.5 text-center text-slate-400 text-[11px] bg-white rounded-xl border border-slate-100">
                    Belum ada agenda di tanggal ini.
                </div>`;
        } else {
            let itemsHtml = '';
            activeAgendas.forEach(ag => {
                const dateSpan = (ag.start && ag.end && ag.start !== ag.end) 
                    ? `${ag.start} s/d ${ag.end}`
                    : (ag.start || ag.end);

                itemsHtml += `
                    <div class="p-2.5 rounded-xl bg-white border border-slate-100 shadow-xs space-y-1.5" style="border-left: 3.5px solid ${ag.warna};">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded text-white" style="background-color: ${ag.warna};">
                                        ${ag.kategori_label}
                                    </span>
                                    ${ag.is_due_today ? '<span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-amber-100 text-amber-900">Deadline Hari Ini</span>' : ''}
                                    ${ag.is_overdue ? '<span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-rose-100 text-rose-800">Terlewat</span>' : ''}
                                    ${ag.is_selesai ? '<span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800">Selesai</span>' : ''}
                                </div>
                                <h5 class="text-xs font-bold text-slate-900 mt-1 leading-snug">${ag.judul}</h5>
                            </div>
                            <button type="button" onclick="openModalEditAgenda(${ag.id})" class="p-1 text-slate-400 hover:text-brand-800 hover:bg-slate-50 rounded-lg transition-colors cursor-pointer" title="Edit Agenda">
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </button>
                        </div>
                        <div class="text-[10px] text-slate-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">date_range</span>
                            <span>${dateSpan}</span>
                        </div>
                        ${ag.catatan ? `<p class="text-[11px] text-slate-600 bg-slate-50 p-1.5 rounded-lg italic">"${ag.catatan}"</p>` : ''}
                    </div>`;
            });
            listContainer.innerHTML = itemsHtml;
        }

        notice.classList.remove('hidden');
    }

    // ==========================================
    // AGENDA MODAL & EDIT ACTIONS
    // ==========================================
    function openModalAgendaBaru(defaultDate) {
        const modal = document.getElementById('modal-agenda');
        const backdrop = document.getElementById('modal-agenda-backdrop');
        const form = document.getElementById('agenda-calendar-form');
        if (!modal || !backdrop || !form) return;

        form.reset();
        document.getElementById('agenda-input-id').value = '';
        document.getElementById('agenda-modal-title').textContent = 'Tambah Agenda Kalender';
        document.getElementById('agenda-btn-delete').classList.add('hidden');
        document.getElementById('agenda-btn-submit').textContent = 'Simpan Agenda';

        const targetDate = defaultDate || currentSelectedDateStr || new Date().toISOString().split('T')[0];
        document.getElementById('agenda-input-mulai').value = targetDate;
        document.getElementById('agenda-input-selesai').value = targetDate;

        backdrop.classList.remove('hidden');
        setTimeout(() => modal.classList.remove('translate-x-full'), 10);
    }

    function openModalEditAgenda(id) {
        const ev = window.userAgendaEvents.find(e => e.id == id);
        if (!ev) return;

        const modal = document.getElementById('modal-agenda');
        const backdrop = document.getElementById('modal-agenda-backdrop');
        const form = document.getElementById('agenda-calendar-form');
        if (!modal || !backdrop || !form) return;

        document.getElementById('agenda-input-id').value = ev.id;
        document.getElementById('agenda-modal-title').textContent = 'Edit Agenda Kalender';
        document.getElementById('agenda-input-judul').value = ev.judul;
        document.getElementById('agenda-input-kategori').value = ev.kategori;
        document.getElementById('agenda-input-prioritas').value = ev.prioritas;
        document.getElementById('agenda-input-status').value = ev.status;
        document.getElementById('agenda-input-mulai').value = ev.start || '';
        document.getElementById('agenda-input-selesai').value = ev.end || '';
        document.getElementById('agenda-input-catatan').value = ev.catatan || '';

        // Select color radio
        const colorRadio = form.querySelector(`input[name="warna"][value="${ev.warna}"]`);
        if (colorRadio) {
            colorRadio.checked = true;
        }

        document.getElementById('agenda-btn-delete').classList.remove('hidden');
        document.getElementById('agenda-btn-submit').textContent = 'Simpan Perubahan';

        backdrop.classList.remove('hidden');
        setTimeout(() => modal.classList.remove('translate-x-full'), 10);
    }

    function closeModalAgenda() {
        const modal = document.getElementById('modal-agenda');
        const backdrop = document.getElementById('modal-agenda-backdrop');
        if (modal && backdrop) {
            modal.classList.add('translate-x-full');
            setTimeout(() => backdrop.classList.add('hidden'), 200);
        }
    }

    async function handleSaveAgenda(e) {
        e.preventDefault();
        const form = e.target;
        const id = document.getElementById('agenda-input-id').value;
        const formData = new FormData(form);

        const url = id ? `/jurnal-kerja/${id}/update` : '/jurnal-kerja/store';

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await res.json();
            if (data.success) {
                closeModalAgenda();
                // Refresh calendar events
                await refreshCalendarEvents();
                // If realtime active, trigger sync
                if (typeof syncRealtime === 'function') syncRealtime(true);
            } else {
                alert('Gagal menyimpan agenda: ' + (data.message || 'Terjadi kesalahan.'));
            }
        } catch (err) {
            form.submit();
        }
    }

    async function handleDeleteAgenda() {
        const id = document.getElementById('agenda-input-id').value;
        if (!id || !confirm('Apakah Anda yakin ingin menghapus agenda ini dari kalender?')) return;

        try {
            const res = await fetch(`/jurnal-kerja/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();
            if (data.success) {
                closeModalAgenda();
                await refreshCalendarEvents();
            }
        } catch (e) {
            location.reload();
        }
    }

    async function refreshCalendarEvents() {
        try {
            const res = await fetch('/jurnal-kerja/events', { credentials: 'same-origin' });
            const events = await res.json();
            window.userAgendaEvents = events;
            renderDashboardCalendar(currentCalDate);
            selectCalendarDate(currentSelectedDay, currentCalDate.getMonth(), currentCalDate.getFullYear());
        } catch (e) {}
    }

    document.addEventListener('DOMContentLoaded', function() {
        renderDashboardCalendar(currentCalDate);
    });
</script>

    @include('partials.modal-agenda')
@endsection
