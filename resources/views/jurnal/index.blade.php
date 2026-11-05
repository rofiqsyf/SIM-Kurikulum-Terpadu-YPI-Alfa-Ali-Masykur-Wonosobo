@extends('layouts.app')

@section('title', 'Jurnal Kerja, Mengajar & Tahfidz')

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
                    <span>Aktivitas &amp; Produktivitas</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-medium text-slate-700">Manajemen Kerja Pendidik</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-semibold text-brand-800">Jurnal &amp; Agenda Harian</span>
                </div>

                <div class="flex items-center gap-2 self-end sm:self-center text-xs font-semibold text-slate-500 bg-white px-3.5 py-1.5 rounded-2xl border border-slate-100 shadow-subtle shrink-0">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                    <span>Buku Kerja Aktif • {{ $pendingKerjaCount }} Tugas Berjalan</span>
                </div>
            </div>

            <!-- HERO OVERVIEW CARD -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative">
                <div class="space-y-3 max-w-xl z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-600"></span>
                        <span>Sistem Pendamping Pendidik &amp; Staf</span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 leading-tight">
                        Jurnal Kerja, Mengajar &amp; Kontrol Tahfidz
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Pencatatan terpadu untuk memastikan seluruh agenda mengajar, koreksi asesmen, dan administrasi kurikulum guru tertata rapi tanpa ada tugas yang kelupaan.
                    </p>

                    <!-- Smart Reminder Alert Banner -->
                    @if($dueTodayCount > 0 || $overdueCount > 0)
                        <div class="p-3.5 rounded-2xl bg-amber-50/80 border border-amber-200/80 text-xs flex items-center gap-3 text-amber-900">
                            <span class="material-symbols-outlined text-amber-700 text-xl shrink-0">notifications_active</span>
                            <div class="leading-relaxed">
                                <strong class="font-bold">Pengingat Tugas Hari Ini:</strong>
                                <span>Anda memiliki {{ $dueTodayCount }} tugas jatuh tempo hari ini @if($overdueCount > 0) dan <strong class="text-rose-700 font-bold">{{ $overdueCount }} tugas tertunda</strong>@endif. Cek daftar agenda di bawah agar pekerjaan Anda tetap terkontrol.</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- 3D Isometric Books Graphic -->
                <div class="shrink-0 flex items-center justify-center md:pr-4">
                    <svg class="w-36 h-32 sm:w-44 sm:h-38 drop-shadow-sm select-none" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M40 120 L120 160 L200 120 L120 80 Z" fill="#0d9488" />
                        <path d="M40 120 L40 135 L120 175 L120 160 Z" fill="#0f766e" />
                        <path d="M120 160 L120 175 L200 135 L200 120 Z" fill="#14b8a6" />
                        <path d="M44 121 L44 130 L118 168 L118 159 Z" fill="#f0fdfa" />
                        <path d="M122 159 L122 168 L196 130 L196 121 Z" fill="#ccfbf1" />

                        <path d="M50 95 L120 130 L190 95 L120 60 Z" fill="#3b82f6" />
                        <path d="M50 95 L50 108 L120 143 L120 130 Z" fill="#1d4ed8" />
                        <path d="M120 130 L120 143 L190 108 L190 95 Z" fill="#2563eb" />
                        <path d="M54 96 L54 104 L118 137 L118 129 Z" fill="#eff6ff" />
                        <path d="M122 129 L122 137 L186 104 L186 96 Z" fill="#dbeafe" />

                        <path d="M70 65 L130 95 L180 70 L120 40 Z" fill="#ffffff" stroke="#e2e8f0" stroke-width="1.5" />
                        <path d="M70 65 L70 70 L130 100 L130 95 Z" fill="#cbd5e1" />
                        <path d="M130 95 L130 100 L180 75 L180 70 Z" fill="#94a3b8" />
                        <circle cx="95" cy="62" r="2.5" fill="#0d9488" />
                        <line x1="103" y1="62" x2="140" y2="53" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                        <circle cx="103" cy="68" r="2.5" fill="#0d9488" />
                        <line x1="111" y1="68" x2="148" y2="59" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
            </div>

            <!-- INTERACTIVE TOOLBAR: VIEW TOGGLE & SEARCH -->
            <div class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-100 shadow-card flex flex-col md:flex-row md:items-center justify-between gap-3 text-xs">
                <!-- View Mode Pills -->
                <div class="flex items-center gap-1.5 flex-wrap">
                    <span class="text-[11px] font-semibold text-slate-400 mr-1">Tampilan:</span>
                    <button type="button" onclick="setJurnalViewMode('kerja')" id="jurnal-view-kerja" 
                            class="jurnal-view-tab px-3.5 py-1.5 rounded-full text-xs font-bold transition-all bg-brand-800 text-white shadow-subtle cursor-pointer">
                        Agenda Kerja ({{ $pendingKerjaCount }})
                    </button>
                    <button type="button" onclick="setJurnalViewMode('both')" id="jurnal-view-both" 
                            class="jurnal-view-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer">
                        Semua Tampilan
                    </button>
                    <button type="button" onclick="setJurnalViewMode('jurnal')" id="jurnal-view-jurnal" 
                            class="jurnal-view-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer">
                        Jurnal Mengajar
                    </button>
                    <button type="button" onclick="setJurnalViewMode('tahfidz')" id="jurnal-view-tahfidz" 
                            class="jurnal-view-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer">
                        Buku Tahfidz Santri
                    </button>
                    @if($user->isWakaKurikulum() || $user->isKepalaSekolah() || $user->isAdmin())
                        <button type="button" onclick="setJurnalViewMode('monitoring')" id="jurnal-view-monitoring" 
                                class="jurnal-view-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-teal-800 border border-teal-200 hover:bg-teal-50 cursor-pointer flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">supervised_user_circle</span>
                            <span>Monitoring KBM Guru ({{ $unitKbmStats['total_guru'] ?? 0 }})</span>
                        </button>
                    @endif
                </div>

                <!-- Live Search Bar -->
                <div class="relative w-full md:w-72">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base">search</span>
                    <input type="text" id="jurnal-live-search" oninput="filterAllJournalCards()"
                           placeholder="Cari agenda, santri, materi..." 
                           class="w-full pl-9 pr-3 py-1.5 bg-slate-50 border border-slate-200/80 rounded-2xl text-xs placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all">
                </div>
            </div>

            <!-- SECTION 1: BUKU KERJA & AGENDA HARIAN PENDIDIK (NEW FEATURE) -->
            <div id="kerja-section-card" class="bg-white rounded-3xl p-6 border border-slate-100 shadow-card space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-2xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-lg">checklist</span>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-900">Agenda &amp; Buku Kerja Mandiri Pendidik</h2>
                            <p class="text-[11px] text-slate-500">Daftar checklist tugas harian guru agar persiapan materi, administrasi, dan asesmen tidak kelupaan</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" onclick="openModalAgendaBaru()" 
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand-50 hover:bg-brand-100 text-brand-800 text-xs font-bold transition-all shadow-subtle cursor-pointer">
                            <span class="material-symbols-outlined text-sm">edit_calendar</span>
                            <span>Agenda Kalender</span>
                        </button>
                        <span class="text-[11px] font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                            {{ $completedKerjaCount }}/{{ $jurnalKerjaList->count() }} Selesai
                        </span>
                    </div>
                </div>

                <!-- Quick Add Task Bar -->
                <form id="quick-add-task-form" onsubmit="handleQuickAddTask(event)" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-3">
                    @csrf
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                        <div class="relative flex-1">
                            <input type="text" id="quick-task-judul" name="judul" required 
                                   placeholder="Tulis agenda baru (misal: Koreksi ulangan harian, siapkan modul ajar Bab 4...)" 
                                   class="w-full pl-3 pr-3 py-2 bg-white border border-slate-200/90 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-brand-700">
                        </div>

                        <select id="quick-task-kategori" name="kategori" class="bg-white border border-slate-200/90 rounded-xl px-2.5 py-2 text-xs font-semibold text-slate-700 focus:outline-none">
                            <option value="kbm">KBM &amp; Mengajar</option>
                            <option value="penilaian">Penilaian &amp; Koreksi</option>
                            <option value="administrasi">Silabus &amp; Modul</option>
                            <option value="bimbingan">Bimbingan Santri</option>
                            <option value="rapat">Rapat &amp; Koordinasi</option>
                            <option value="umum">Agenda Umum</option>
                        </select>

                        <select id="quick-task-prioritas" name="prioritas" class="bg-white border border-slate-200/90 rounded-xl px-2.5 py-2 text-xs font-semibold text-slate-700 focus:outline-none">
                            <option value="tinggi">Prioritas Tinggi</option>
                            <option value="sedang" selected>Prioritas Sedang</option>
                            <option value="rendah">Prioritas Rendah</option>
                        </select>

                        <button type="submit" 
                                class="px-4 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all shrink-0 cursor-pointer">
                            Simpan Agenda
                        </button>
                    </div>

                    <!-- Baris Rentang Tanggal, Warna & Catatan Singkat -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2.5 pt-1 items-center text-xs">
                        <div class="md:col-span-5 flex items-center gap-1.5 bg-white border border-slate-200/90 rounded-xl px-2.5 py-1.5">
                            <span class="text-[10px] font-bold text-slate-500 uppercase shrink-0">Rentang:</span>
                            <input type="date" id="quick-task-mulai" name="tanggal_mulai" value="{{ date('Y-m-d') }}" 
                                   title="Tanggal Mulai" class="w-full text-xs text-slate-700 focus:outline-none bg-transparent">
                            <span class="text-slate-400 text-xs">s/d</span>
                            <input type="date" id="quick-task-selesai" name="tanggal_selesai" value="{{ date('Y-m-d') }}" 
                                   title="Tanggal Selesai (Deadline)" class="w-full text-xs text-slate-700 focus:outline-none bg-transparent">
                        </div>

                        <div class="md:col-span-3 flex items-center gap-1.5 bg-white border border-slate-200/90 rounded-xl px-2.5 py-1.5 overflow-x-auto">
                            <span class="text-[10px] font-bold text-slate-500 uppercase shrink-0">Warna:</span>
                            <div class="flex items-center gap-1.5">
                                <label class="cursor-pointer" title="Biru Utama">
                                    <input type="radio" name="warna" value="#2563eb" class="sr-only peer" checked>
                                    <span class="w-4 h-4 rounded-full bg-[#2563eb] inline-block peer-checked:ring-2 peer-checked:ring-offset-1 peer-checked:ring-[#2563eb] transition-all"></span>
                                </label>
                                <label class="cursor-pointer" title="Hijau KBM">
                                    <input type="radio" name="warna" value="#059669" class="sr-only peer">
                                    <span class="w-4 h-4 rounded-full bg-[#059669] inline-block peer-checked:ring-2 peer-checked:ring-offset-1 peer-checked:ring-[#059669] transition-all"></span>
                                </label>
                                <label class="cursor-pointer" title="Ungu Bimbingan">
                                    <input type="radio" name="warna" value="#7c3aed" class="sr-only peer">
                                    <span class="w-4 h-4 rounded-full bg-[#7c3aed] inline-block peer-checked:ring-2 peer-checked:ring-offset-1 peer-checked:ring-[#7c3aed] transition-all"></span>
                                </label>
                                <label class="cursor-pointer" title="Amber Penilaian">
                                    <input type="radio" name="warna" value="#d97706" class="sr-only peer">
                                    <span class="w-4 h-4 rounded-full bg-[#d97706] inline-block peer-checked:ring-2 peer-checked:ring-offset-1 peer-checked:ring-[#d97706] transition-all"></span>
                                </label>
                                <label class="cursor-pointer" title="Merah Deadline">
                                    <input type="radio" name="warna" value="#e11d48" class="sr-only peer">
                                    <span class="w-4 h-4 rounded-full bg-[#e11d48] inline-block peer-checked:ring-2 peer-checked:ring-offset-1 peer-checked:ring-[#e11d48] transition-all"></span>
                                </label>
                                <label class="cursor-pointer" title="Teal Modul">
                                    <input type="radio" name="warna" value="#0d9488" class="sr-only peer">
                                    <span class="w-4 h-4 rounded-full bg-[#0d9488] inline-block peer-checked:ring-2 peer-checked:ring-offset-1 peer-checked:ring-[#0d9488] transition-all"></span>
                                </label>
                            </div>
                        </div>

                        <div class="md:col-span-4">
                            <input type="text" id="quick-task-catatan" name="catatan" 
                                   placeholder="Catatan agenda..." 
                                   class="w-full px-3 py-1.5 bg-white border border-slate-200/90 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-brand-700">
                        </div>
                    </div>
                </form>

                <!-- Filter Status & Category Pills -->
                <div class="flex flex-wrap items-center justify-between gap-2 pt-1 text-xs">
                    <!-- Status Filter -->
                    <div class="flex items-center gap-1.5 flex-wrap">
                        <button type="button" onclick="filterTaskStatus('all')" id="task-filter-all" 
                                class="task-status-tab px-3 py-1 rounded-full text-xs font-bold transition-all bg-slate-900 text-white cursor-pointer">
                            Semua ({{ $jurnalKerjaList->count() }})
                        </button>
                        <button type="button" onclick="filterTaskStatus('belum')" id="task-filter-belum" 
                                class="task-status-tab px-3 py-1 rounded-full text-xs font-semibold transition-all bg-slate-100 text-slate-600 hover:bg-slate-200 cursor-pointer">
                            Belum Selesai ({{ $pendingKerjaCount }})
                        </button>
                        <button type="button" onclick="filterTaskStatus('selesai')" id="task-filter-selesai" 
                                class="task-status-tab px-3 py-1 rounded-full text-xs font-semibold transition-all bg-slate-100 text-slate-600 hover:bg-slate-200 cursor-pointer">
                            Selesai ({{ $completedKerjaCount }})
                        </button>
                    </div>

                    <!-- Category Filter -->
                    <div class="flex items-center gap-1 flex-wrap text-[11px]">
                        <span class="text-slate-400 font-semibold mr-1">Kategori:</span>
                        <button type="button" onclick="filterTaskCategory('all')" id="cat-pill-all" 
                                class="task-cat-pill font-bold px-2.5 py-0.5 rounded-full bg-slate-200 text-slate-800 cursor-pointer">
                            Semua
                        </button>
                        <button type="button" onclick="filterTaskCategory('kbm')" id="cat-pill-kbm" 
                                class="task-cat-pill font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 cursor-pointer">
                            KBM
                        </button>
                        <button type="button" onclick="filterTaskCategory('penilaian')" id="cat-pill-penilaian" 
                                class="task-cat-pill font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 cursor-pointer">
                            Penilaian
                        </button>
                        <button type="button" onclick="filterTaskCategory('administrasi')" id="cat-pill-administrasi" 
                                class="task-cat-pill font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 cursor-pointer">
                            Silabus
                        </button>
                        <button type="button" onclick="filterTaskCategory('bimbingan')" id="cat-pill-bimbingan" 
                                class="task-cat-pill font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 cursor-pointer">
                            Bimbingan
                        </button>
                    </div>
                </div>

                <!-- Interactive Task List Items -->
                <div class="divide-y divide-slate-100 max-h-[460px] overflow-y-auto pr-1" id="task-list-container">
                    @forelse($jurnalKerjaList as $task)
                        @php
                            $isDone = $task->isSelesai();
                            $badge = $task->kategori_badge;
                            $isOverdue = $task->isOverdue();
                            $isDueToday = $task->isDueToday();
                        @endphp
                        <div class="task-item py-3.5 flex items-start justify-between gap-3 transition-colors hover:bg-slate-50/60 rounded-2xl px-3 border border-transparent hover:border-slate-100"
                             id="task-row-{{ $task->id }}"
                             data-id="{{ $task->id }}"
                             data-status="{{ $task->status }}"
                             data-category="{{ $task->kategori }}"
                             data-search="{{ strtolower($task->judul . ' ' . $task->kategori . ' ' . ($task->catatan ?? '') . ' ' . ($task->catatan_refleksi ?? '')) }}"
                             style="border-left: 4px solid {{ $task->warna ?: '#2563eb' }};">
                            
                            <!-- Checkbox and Task Details -->
                            <div class="flex items-start gap-3 min-w-0 flex-1">
                                <button type="button" onclick="toggleTaskStatus({{ $task->id }})" 
                                        class="task-checkbox mt-0.5 w-5 h-5 rounded-lg border flex items-center justify-center transition-all cursor-pointer shrink-0
                                        {{ $isDone ? 'bg-emerald-600 border-emerald-600 text-white' : 'border-slate-300 hover:border-brand-700 bg-white' }}">
                                    <span class="material-symbols-outlined text-sm font-bold {{ $isDone ? '' : 'hidden' }}">check</span>
                                </button>

                                <div class="space-y-1 min-w-0 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <!-- Category Badge -->
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $badge['color'] }}">
                                            {{ $badge['label'] }}
                                        </span>

                                        <!-- Priority Badge -->
                                        @if($task->prioritas === 'tinggi')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-800 border border-rose-200">
                                                Tinggi
                                            </span>
                                        @elseif($task->prioritas === 'sedang')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                                Sedang
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600">
                                                Rendah
                                            </span>
                                        @endif

                                        <!-- Date Range / Deadline Date Badge -->
                                        @if($task->tanggal_mulai && $task->tanggal_selesai && $task->tanggal_mulai->format('Y-m-d') !== $task->tanggal_selesai->format('Y-m-d'))
                                            <span class="text-[11px] font-medium flex items-center gap-1 {{ $isOverdue ? 'text-rose-700 font-bold' : ($isDueToday ? 'text-amber-800 font-bold' : 'text-slate-600') }}">
                                                <span class="material-symbols-outlined text-xs">date_range</span>
                                                <span>{{ $task->tanggal_mulai->format('d M') }} - {{ $task->tanggal_selesai->format('d M Y') }}</span>
                                                @if($isOverdue)
                                                    <span class="px-1.5 py-0.2 rounded bg-rose-100 text-rose-800 text-[9px] font-extrabold uppercase">Terlewat</span>
                                                @elseif($isDueToday)
                                                    <span class="px-1.5 py-0.2 rounded bg-amber-100 text-amber-900 text-[9px] font-extrabold uppercase">Hari Ini</span>
                                                @endif
                                            </span>
                                        @elseif($task->deadline_date)
                                            <span class="text-[11px] font-medium flex items-center gap-1 {{ $isOverdue ? 'text-rose-700 font-bold' : ($isDueToday ? 'text-amber-800 font-bold' : 'text-slate-600') }}">
                                                <span class="material-symbols-outlined text-xs">event</span>
                                                <span>{{ $task->deadline_date->format('d M Y') }}</span>
                                                @if($isOverdue)
                                                    <span class="px-1.5 py-0.2 rounded bg-rose-100 text-rose-800 text-[9px] font-extrabold uppercase">Terlewat</span>
                                                @elseif($isDueToday)
                                                    <span class="px-1.5 py-0.2 rounded bg-amber-100 text-amber-900 text-[9px] font-extrabold uppercase">Hari Ini</span>
                                                @endif
                                            </span>
                                        @endif

                                        @if($task->waktu_pengingat)
                                            <span class="text-[11px] text-slate-400 flex items-center gap-0.5">
                                                <span class="material-symbols-outlined text-xs">alarm</span>
                                                <span>{{ $task->waktu_pengingat }}</span>
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Task Title -->
                                    <h3 class="task-title text-xs sm:text-sm font-semibold transition-all leading-snug {{ $isDone ? 'line-through text-slate-400' : 'text-slate-900' }}">
                                        {{ $task->judul }}
                                    </h3>

                                    <!-- Task Note -->
                                    @if($task->catatan)
                                        <p class="text-[11px] text-slate-600 bg-slate-50 p-2 rounded-xl border border-slate-100/90 leading-relaxed">
                                            {{ $task->catatan }}
                                        </p>
                                    @elseif($task->catatan_refleksi)
                                        <p class="text-[11px] text-slate-500 bg-slate-50/90 p-2 rounded-xl border border-slate-100/90 leading-relaxed italic">
                                            "{{ $task->catatan_refleksi }}"
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Buttons: Edit & Delete -->
                            <div class="flex items-center gap-1 shrink-0">
                                <button type="button" onclick="openModalEditAgenda({{ $task->id }})" 
                                        class="p-1.5 rounded-xl text-slate-400 hover:text-brand-700 hover:bg-brand-50 transition-colors cursor-pointer" 
                                        title="Edit Agenda Kalender">
                                    <span class="material-symbols-outlined text-base">edit</span>
                                </button>
                                <button type="button" onclick="deleteTaskItem({{ $task->id }})" 
                                        class="p-1.5 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer" 
                                        title="Hapus Agenda">
                                    <span class="material-symbols-outlined text-base">delete</span>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-slate-400 text-xs">
                            Belum ada agenda kerja yang dicatat. Tulis tugas baru di atas agar hari Anda tertata!
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- SECTION 2 & 3: JURNAL MENGAJAR (LEFT) & MONITORING TAHFIDZ (RIGHT) -->
            <div id="jurnal-grid-container" class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                
                <!-- Card 1: Jurnal Mengajar -->
                <div id="jurnal-column-card" class="bg-white rounded-3xl p-6 border border-slate-100 shadow-card space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                                <span class="material-symbols-outlined text-base">history_edu</span>
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-slate-900">Jurnal Mengajar Harian</h2>
                                <p class="text-[11px] text-slate-500">{{ $jurnals->count() }} Sesi Tatap Muka Tercatat</p>
                            </div>
                        </div>
                        <button type="button" onclick="openJurnalModal()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand-50 text-brand-800 text-xs font-bold hover:bg-brand-100 transition-colors cursor-pointer">
                            <span class="material-symbols-outlined text-sm">post_add</span>
                            <span>Input Jurnal</span>
                        </button>
                    </div>

                    <div class="divide-y divide-slate-100 max-h-[520px] overflow-y-auto pr-1" id="jurnal-list-container">
                        @forelse($jurnals as $jurnal)
                            <div class="jurnal-entry-item py-3.5 space-y-2"
                                 data-search="{{ strtolower(($jurnal->mataPelajaran->nama_mapel ?? '') . ' ' . $jurnal->materi_diajarkan . ' ' . ($jurnal->guru->name ?? '') . ' ' . ($jurnal->kelas->nama_kelas ?? '')) }}">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-bold text-brand-900 bg-brand-50 border border-brand-200 px-2.5 py-0.5 rounded-full text-[10px]">
                                        {{ $jurnal->mataPelajaran->nama_mapel ?? 'Mapel' }}
                                    </span>
                                    <span class="text-slate-400 font-medium text-[11px]">
                                        {{ $jurnal->tanggal->format('d M Y') }} • Jam Ke-{{ $jurnal->jam_ke }}
                                    </span>
                                </div>

                                <h3 class="text-xs font-bold text-slate-900 leading-snug">{{ $jurnal->materi_diajarkan }}</h3>
                                
                                @if($jurnal->catatan_kegiatan)
                                    <p class="text-xs text-slate-600 bg-slate-50 p-3 rounded-2xl border border-slate-100 leading-relaxed italic">
                                        "{{ $jurnal->catatan_kegiatan }}"
                                    </p>
                                @endif

                                <div class="flex items-center justify-between text-[11px] text-slate-500 pt-0.5">
                                    <span>Guru: <strong class="text-slate-800">{{ $jurnal->guru->name ?? 'Guru Mapel' }}</strong> ({{ $jurnal->kelas->nama_kelas ?? 'Kelas' }})</span>
                                    <span class="font-semibold text-emerald-700">Hadir: {{ $jurnal->jumlah_hadir }} • Absen: {{ $jurnal->jumlah_tidak_hadir }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center text-slate-400 text-xs">
                                Belum ada catatan jurnal mengajar yang diinput.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Card 2: Monitoring Tahfidz -->
                <div id="tahfidz-column-card" class="bg-white rounded-3xl p-6 border border-slate-100 shadow-card space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-teal-50 text-teal-800 flex items-center justify-center font-bold">
                                <span class="material-symbols-outlined text-base">auto_stories</span>
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-slate-900">Buku Kontrol Tahfidz</h2>
                                <p class="text-[11px] text-slate-500">{{ $tahfidzRecords->count() }} Setoran Santri</p>
                            </div>
                        </div>
                        <button type="button" onclick="openTahfidzModal()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-teal-50 text-teal-800 text-xs font-bold hover:bg-teal-100 transition-colors cursor-pointer">
                            <span class="material-symbols-outlined text-sm">menu_book</span>
                            <span>Catat Setoran</span>
                        </button>
                    </div>

                    <!-- Predikat Filter Ribbon -->
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs">
                        <button type="button" onclick="filterTahfidzPredikat('all')" id="predikat-filter-all" 
                                class="predikat-tab px-2.5 py-1 rounded-full text-[10px] font-bold bg-teal-800 text-white shadow-subtle cursor-pointer">
                            Semua
                        </button>
                        <button type="button" onclick="filterTahfidzPredikat('Mumtaz')" id="predikat-filter-Mumtaz" 
                                class="predikat-tab px-2.5 py-1 rounded-full text-[10px] font-semibold bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer">
                            Mumtaz
                        </button>
                        <button type="button" onclick="filterTahfidzPredikat('Jayyid Jiddan')" id="predikat-filter-Jayyid Jiddan" 
                                class="predikat-tab px-2.5 py-1 rounded-full text-[10px] font-semibold bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer">
                            Jayyid Jiddan
                        </button>
                        <button type="button" onclick="filterTahfidzPredikat('Jayyid')" id="predikat-filter-Jayyid" 
                                class="predikat-tab px-2.5 py-1 rounded-full text-[10px] font-semibold bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer">
                            Jayyid
                        </button>
                    </div>

                    <div class="divide-y divide-slate-100 max-h-[460px] overflow-y-auto pr-1" id="tahfidz-list-container">
                        @forelse($tahfidzRecords as $tahfidz)
                            <div class="tahfidz-entry-item py-3.5 space-y-2"
                                 data-predikat="{{ $tahfidz->predikat }}"
                                 data-search="{{ strtolower($tahfidz->nama_santri . ' ' . $tahfidz->surat . ' ' . $tahfidz->juz . ' ' . ($tahfidz->unit->nama_unit ?? '')) }}">
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-900">{{ $tahfidz->nama_santri }}</span>
                                        <span class="text-slate-400 text-[11px]">({{ $tahfidz->kelas }})</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold
                                        {{ $tahfidz->predikat === 'Mumtaz' ? 'bg-emerald-100 text-emerald-800' : ($tahfidz->predikat === 'Jayyid Jiddan' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                                        {{ $tahfidz->predikat }}
                                    </span>
                                </div>

                                <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs">
                                    <div>
                                        <span class="font-semibold text-slate-800">{{ $tahfidz->surat }}</span>
                                        <span class="text-slate-500 text-[11px] block mt-0.5">{{ $tahfidz->ayat }} • {{ $tahfidz->juz }}</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-teal-800 bg-teal-50 px-2 py-1 rounded-lg">
                                        {{ $tahfidz->unit->kode_unit ?? 'Unit' }}
                                    </span>
                                </div>

                                @if($tahfidz->catatan_mutqin)
                                    <p class="text-xs text-slate-600 italic pl-1 leading-relaxed">
                                        "{{ $tahfidz->catatan_mutqin }}"
                                    </p>
                                @endif

                                <div class="flex items-center justify-between text-[11px] text-slate-400 pt-0.5">
                                    <span>Penguji: <strong class="text-slate-700">{{ $tahfidz->penguji->name ?? 'Ustadz Pembina' }}</strong></span>
                                    <span>{{ $tahfidz->tanggal_setoran->format('d M Y') }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center text-slate-400 text-xs">
                                Belum ada catatan setoran tahfidz santri.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- SECTION 3: MONITORING KBM & KEPATUHAN JURNAL GURU UNIT (KHUSUS WAKA KURIKULUM & KEPSEK) -->
            @if($user->isWakaKurikulum() || $user->isKepalaSekolah() || $user->isAdmin())
                <div id="monitoring-kbm-card" class="bg-white rounded-3xl p-6 border border-slate-100 shadow-card space-y-5 hidden">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-2xl bg-teal-50 text-teal-800 flex items-center justify-center font-bold">
                                <span class="material-symbols-outlined text-lg">supervised_user_circle</span>
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-slate-900">Monitoring Pelaksanaan KBM &amp; Kepatuhan Jurnal Guru</h2>
                                <p class="text-[11px] text-slate-500">Pemantauan kepatuhan pengisian jurnal mengajar harian pendidik unit {{ $user->unit->nama_unit ?? 'Unit Pendidikan' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-[11px] font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                                Evaluasi Berkala Mingguan Waka Kurikulum
                            </span>
                        </div>
                    </div>

                    <!-- 4 Quick Stat Pills -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Total Pendidik</span>
                            <span class="text-xl font-black text-slate-900 mt-0.5 block">{{ $unitKbmStats['total_guru'] ?? 0 }} Guru</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-emerald-50/80 border border-emerald-100">
                            <span class="text-[10px] uppercase font-bold text-emerald-700 block">Tertib Pekan Ini</span>
                            <span class="text-xl font-black text-emerald-700 mt-0.5 block">{{ $unitKbmStats['guru_tertib'] ?? 0 }} Guru</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-rose-50/80 border border-rose-100">
                            <span class="text-[10px] uppercase font-bold text-rose-700 block">Perlu Diingatkan</span>
                            <span class="text-xl font-black text-rose-700 mt-0.5 block">{{ $unitKbmStats['guru_perlu_pengingat'] ?? 0 }} Guru</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-teal-50/80 border border-teal-100">
                            <span class="text-[10px] uppercase font-bold text-teal-700 block">KBM 7 Hari Terakhir</span>
                            <span class="text-xl font-black text-teal-700 mt-0.5 block">{{ $unitKbmStats['total_sesi_minggu_ini'] ?? 0 }} Sesi</span>
                        </div>
                    </div>

                    <!-- Teacher Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-400 font-bold uppercase tracking-wider text-[11px]">
                                    <th class="py-3 px-4">Pendidik &amp; Identitas</th>
                                    <th class="py-3 px-4">Mata Pelajaran &amp; Beban</th>
                                    <th class="py-3 px-4 text-center">Total KBM</th>
                                    <th class="py-3 px-4">KBM Terakhir</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                    <th class="py-3 px-4 text-right">Aksi Waka</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($guruMonitoringList as $g)
                                    <tr class="hover:bg-slate-50/70 transition-colors">
                                        <td class="py-3.5 px-4 align-top">
                                            <div class="font-bold text-slate-900">{{ $g['name'] }}</div>
                                            <div class="text-[11px] text-slate-400 font-mono mt-0.5">NIP: {{ $g['nip'] }}</div>
                                        </td>
                                        <td class="py-3.5 px-4 align-top">
                                            <div class="font-semibold text-slate-800">{{ $g['mapel'] }}</div>
                                            <div class="text-[11px] text-slate-500 mt-0.5">{{ $g['beban_jp'] }} JP / Minggu</div>
                                        </td>
                                        <td class="py-3.5 px-4 align-top text-center">
                                            <span class="font-extrabold text-slate-900 text-sm">{{ $g['total_sesi'] }}</span>
                                            <span class="text-[10px] text-slate-400 block">pertemuan</span>
                                        </td>
                                        <td class="py-3.5 px-4 align-top max-w-xs">
                                            <div class="font-medium text-slate-800">{{ $g['last_kbm'] }}</div>
                                            <div class="text-[10px] text-slate-500 italic truncate" title="{{ $g['last_materi'] }}">
                                                {{ $g['last_materi'] }}
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 align-top text-center whitespace-nowrap">
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border inline-block {{ $g['is_tertib'] ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-rose-50 text-rose-800 border-rose-200' }}">
                                                {{ $g['status'] }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 align-top text-right whitespace-nowrap">
                                            @if(!$g['is_tertib'])
                                                <form method="POST" action="{{ route('jurnal.remind', $g['id']) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold text-[11px] shadow-subtle transition-all cursor-pointer"
                                                            title="Kirim notifikasi pengingat isi jurnal KBM">
                                                        <span class="material-symbols-outlined text-xs">notifications_active</span>
                                                        <span>Kirim Pengingat</span>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-[11px] text-emerald-600 font-semibold inline-flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                                    <span>Terpantau Aktif</span>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-slate-400">
                                            Belum ada data guru pengampu di unit ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>

        <!-- ======================================================== -->
        <!-- RIGHT PANEL (AGENDA PROGRESS & QUICK TIPS FOR TEACHERS) -->
        <!-- ======================================================== -->
        <div class="xl:col-span-4 2xl:col-span-3 space-y-6">

            <!-- 1. INDEKS KEMAJUAN TUGAS KERJA GURU -->
            @php
                $totalTasks = $jurnalKerjaList->count();
                $percentageDone = $totalTasks > 0 ? round(($completedKerjaCount / $totalTasks) * 100) : 0;
            @endphp
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-3">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="material-symbols-outlined text-brand-700 text-lg">donut_large</span>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Progres Agenda Kerja</h4>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center space-y-2">
                    <span class="text-3xl font-extrabold text-brand-800" id="progress-percent-label">{{ $percentageDone }}%</span>
                    <p class="text-[11px] text-slate-500" id="progress-count-label">{{ $completedKerjaCount }} dari {{ $totalTasks }} agenda terselesaikan</p>
                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                        <div id="progress-bar-fill" class="bg-brand-600 h-2 rounded-full transition-all duration-300" style="width: {{ $percentageDone }}%"></div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 text-xs pt-1">
                    <div class="p-2.5 rounded-xl bg-amber-50 text-amber-900 border border-amber-200/60">
                        <span class="text-[10px] font-bold block uppercase text-amber-700">Jatuh Tempo</span>
                        <span class="text-sm font-black">{{ $dueTodayCount }} Tugas</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-rose-50 text-rose-900 border border-rose-200/60">
                        <span class="text-[10px] font-bold block uppercase text-rose-700">Tertunda</span>
                        <span class="text-sm font-black">{{ $overdueCount }} Tugas</span>
                    </div>
                </div>
            </div>

            <!-- 2. PANDUAN KERJA & RUTINITAS GURU MAPEL -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-3">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="material-symbols-outlined text-teal-700 text-lg">lightbulb</span>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Panduan Tertata Guru</h4>
                </div>

                <div class="space-y-2 text-xs">
                    <div class="p-3 rounded-2xl bg-teal-50 border border-teal-200/60 space-y-1">
                        <span class="font-bold text-teal-900 block">Isi Jurnal Usai Mengajar</span>
                        <p class="text-[11px] text-teal-800 leading-relaxed">
                            Langsung input presensi dan materi ajar maksimal 1 jam setelah jam pelajaran usai agar catatan kehadiran tidak menumpuk.
                        </p>
                    </div>

                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                        <span class="font-bold text-slate-800 block">Jadwal Asesmen Berkala</span>
                        <p class="text-[11px] text-slate-600 leading-relaxed">
                            Beri tanda pada santri yang butuh bimbingan remedial agar evaluasi capaian TP terpenuhi sebelum evaluasi tengah semester.
                        </p>
                    </div>
                </div>
            </div>

            <!-- 3. KEHADIRAN KELAS METER -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 block">Tingkat Kehadiran Kelas</span>
                
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center space-y-2">
                    <span class="text-3xl font-extrabold text-brand-800">98.4%</span>
                    <p class="text-[11px] text-slate-500">Rata-rata presensi santri bulan ini di seluruh rombel</p>
                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-brand-600 h-2 rounded-full" style="width: 98.4%"></div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- MODAL INPUT JURNAL MENGAJAR -->
<div id="jurnal-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-floating border border-slate-200 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-700">post_add</span>
                <h3 class="text-sm font-bold text-slate-900">Input Jurnal Mengajar Harian</h3>
            </div>
            <button onclick="closeJurnalModal()" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('jurnal.store') }}" class="space-y-3 text-xs">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Mata Pelajaran</label>
                    <select name="mapel_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600">
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Kelas / Rombel</label>
                    <select name="kelas_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600">
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Tanggal Pelaksanaan</label>
                    <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600">
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Jam Ke- / Waktu</label>
                    <input type="text" name="jam_ke" value="1 - 2 (07.15 - 08.35)" required 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600">
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Materi yang Diajarkan</label>
                <input type="text" name="materi_diajarkan" required placeholder="misal: Operasi Perkalian Bilangan Bulat Negatif" 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600">
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Catatan Pelaksanaan / Refleksi Guru</label>
                <textarea name="catatan_kegiatan" rows="2" placeholder="Catatan keaktifan santri, kendala pemahaman, atau tindak lanjut..." 
                          class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Jumlah Hadir</label>
                    <input type="number" name="jumlah_hadir" value="30" min="0" required 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600">
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Jumlah Tidak Hadir</label>
                    <input type="number" name="jumlah_tidak_hadir" value="0" min="0" required 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600">
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeJurnalModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold transition-colors cursor-pointer">Simpan Jurnal</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL INPUT CATATAN TAHFIDZ -->
<div id="tahfidz-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-floating border border-slate-200 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-teal-700">menu_book</span>
                <h3 class="text-sm font-bold text-slate-900">Catat Setoran Tahfidz Santri</h3>
            </div>
            <button onclick="closeTahfidzModal()" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('tahfidz.store') }}" class="space-y-3 text-xs">
            @csrf
            
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Unit Lembaga</label>
                    <select name="unit_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600">
                        @foreach($units as $u)
                            <option value="{{ $u->id }}">{{ $u->nama_unit }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Tanggal Setoran</label>
                    <input type="date" name="tanggal_setoran" required value="{{ date('Y-m-d') }}" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Nama Lengkap Santri</label>
                    <input type="text" name="nama_santri" required placeholder="misal: Muhammad Al-Fatih" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600">
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Kelas</label>
                    <input type="text" name="kelas" required placeholder="misal: Kelas 7A" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Juz</label>
                    <input type="text" name="juz" required value="Juz 30" placeholder="Juz 30" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600">
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Nama Surat</label>
                    <input type="text" name="surat" required placeholder="An-Naba'" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600">
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Ayat</label>
                    <input type="text" name="ayat" required placeholder="Ayat 1 - 20" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600">
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Predikat Kualitas Hafalan</label>
                <select name="predikat" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600">
                    <option value="Mumtaz">Mumtaz (Sangat Baik / Mutqin)</option>
                    <option value="Jayyid Jiddan">Jayyid Jiddan (Baik Sekali)</option>
                    <option value="Jayyid">Jayyid (Cukup / Perlu Pengulangan)</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Catatan Tajwid &amp; Makhorijul Huruf</label>
                <textarea name="catatan_mutqin" rows="2" placeholder="Catatan hukum mad, ghunnah, kelancaran..." 
                          class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-600"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeTahfidzModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-teal-800 hover:bg-teal-900 text-white text-xs font-semibold transition-colors cursor-pointer">Simpan Catatan</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Initial loaded user agenda events for modal editing
    window.userAgendaEvents = {!! json_encode($formattedUserAgendas) !!};

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

        const targetDate = defaultDate || new Date().toISOString().split('T')[0];
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
                window.location.reload();
            } else {
                alert('Gagal menyimpan agenda: ' + (data.message || 'Terjadi kesalahan.'));
            }
        } catch (err) {
            form.submit();
        }
    }

    async function handleDeleteAgenda() {
        const id = document.getElementById('agenda-input-id').value;
        if (!id || !confirm('Apakah Anda yakin ingin menghapus agenda ini?')) return;

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
                window.location.reload();
            }
        } catch (err) {
            console.error(err);
        }
    }

    function openJurnalModal() {
        document.getElementById('jurnal-modal').classList.remove('hidden');
    }
    function closeJurnalModal() {
        document.getElementById('jurnal-modal').classList.add('hidden');
    }
    function openTahfidzModal() {
        document.getElementById('tahfidz-modal').classList.remove('hidden');
    }
    function closeTahfidzModal() {
        document.getElementById('tahfidz-modal').classList.add('hidden');
    }

    // ==========================================
    // AGENDA KERJA (TASK PLANNER) LOGIC
    // ==========================================
    let currentTaskStatus = 'all';
    let currentTaskCategory = 'all';

    async function handleQuickAddTask(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        try {
            const res = await fetch("{{ route('jurnal-kerja.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: formData
            });

            const data = await res.json();
            if (data.success) {
                // Reload page to re-render tasks and update progress indicators
                window.location.reload();
            }
        } catch (err) {
            form.submit();
        }
    }

    async function toggleTaskStatus(taskId) {
        const row = document.getElementById('task-row-' + taskId);
        if (!row) return;

        const checkbox = row.querySelector('.task-checkbox');
        const checkIcon = checkbox.querySelector('.material-symbols-outlined');
        const titleEl = row.querySelector('.task-title');

        try {
            const res = await fetch(`/jurnal-kerja/${taskId}/toggle`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            });

            const data = await res.json();
            if (data.success) {
                if (data.is_selesai) {
                    checkbox.className = 'task-checkbox mt-0.5 w-5 h-5 rounded-lg border flex items-center justify-center transition-all cursor-pointer shrink-0 bg-emerald-600 border-emerald-600 text-white';
                    checkIcon.classList.remove('hidden');
                    titleEl.className = 'task-title text-xs sm:text-sm font-semibold transition-all leading-snug line-through text-slate-400';
                    row.setAttribute('data-status', 'selesai');
                } else {
                    checkbox.className = 'task-checkbox mt-0.5 w-5 h-5 rounded-lg border flex items-center justify-center transition-all cursor-pointer shrink-0 border-slate-300 hover:border-brand-700 bg-white';
                    checkIcon.classList.add('hidden');
                    titleEl.className = 'task-title text-xs sm:text-sm font-semibold transition-all leading-snug text-slate-900';
                    row.setAttribute('data-status', 'belum');
                }

                // Update counts on filter tabs
                updateTaskCounts();
            }
        } catch (err) {
            console.error(err);
        }
    }

    async function deleteTaskItem(taskId) {
        if (!confirm('Hapus agenda kerja ini?')) return;

        try {
            const res = await fetch(`/jurnal-kerja/${taskId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            });

            const data = await res.json();
            if (data.success) {
                const row = document.getElementById('task-row-' + taskId);
                if (row) {
                    row.remove();
                    updateTaskCounts();
                }
            }
        } catch (err) {
            console.error(err);
        }
    }

    function updateTaskCounts() {
        const rows = document.querySelectorAll('.task-item');
        let total = rows.length;
        let done = 0;
        let pending = 0;

        rows.forEach(r => {
            if (r.getAttribute('data-status') === 'selesai') done++;
            else pending++;
        });

        const filterAll = document.getElementById('task-filter-all');
        const filterBelum = document.getElementById('task-filter-belum');
        const filterSelesai = document.getElementById('task-filter-selesai');

        if (filterAll) filterAll.textContent = `Semua (${total})`;
        if (filterBelum) filterBelum.textContent = `Belum Selesai (${pending})`;
        if (filterSelesai) filterSelesai.textContent = `Selesai (${done})`;

        const pct = total > 0 ? Math.round((done / total) * 100) : 0;
        const pctEl = document.getElementById('progress-percent-label');
        const cntEl = document.getElementById('progress-count-label');
        const barEl = document.getElementById('progress-bar-fill');

        if (pctEl) pctEl.textContent = pct + '%';
        if (cntEl) cntEl.textContent = `${done} dari ${total} agenda terselesaikan`;
        if (barEl) barEl.style.width = pct + '%';
    }

    function filterTaskStatus(status) {
        currentTaskStatus = status;

        document.querySelectorAll('.task-status-tab').forEach(b => {
            b.className = 'task-status-tab px-3 py-1 rounded-full text-xs font-semibold transition-all bg-slate-100 text-slate-600 hover:bg-slate-200 cursor-pointer';
        });

        const active = document.getElementById('task-filter-' + status);
        if (active) {
            active.className = 'task-status-tab px-3 py-1 rounded-full text-xs font-bold transition-all bg-slate-900 text-white cursor-pointer';
        }

        applyTaskFilters();
    }

    function filterTaskCategory(cat) {
        currentTaskCategory = cat;

        document.querySelectorAll('.task-cat-pill').forEach(b => {
            b.className = 'task-cat-pill font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 cursor-pointer';
        });

        const active = document.getElementById('cat-pill-' + cat);
        if (active) {
            active.className = 'task-cat-pill font-bold px-2.5 py-0.5 rounded-full bg-slate-200 text-slate-800 cursor-pointer';
        }

        applyTaskFilters();
    }

    function applyTaskFilters() {
        const query = (document.getElementById('jurnal-live-search')?.value || '').toLowerCase().trim();
        const rows = document.querySelectorAll('.task-item');

        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            const category = row.getAttribute('data-category');
            const searchData = row.getAttribute('data-search') || '';

            let matchStatus = (currentTaskStatus === 'all') || (status === currentTaskStatus);
            let matchCat = (currentTaskCategory === 'all') || (category === currentTaskCategory);
            let matchQuery = !query || searchData.includes(query);

            if (matchStatus && matchCat && matchQuery) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    }

    // ==========================================
    // VIEW MODE SWITCHER
    // ==========================================
    let activeTahfidzPredikat = 'all';

    function setJurnalViewMode(mode) {
        const cardKerja = document.getElementById('kerja-section-card');
        const grid = document.getElementById('jurnal-grid-container');
        const colJurnal = document.getElementById('jurnal-column-card');
        const colTahfidz = document.getElementById('tahfidz-column-card');
        const cardMonitoring = document.getElementById('monitoring-kbm-card');

        // Update active tab buttons
        document.querySelectorAll('.jurnal-view-tab').forEach(tab => {
            tab.className = 'jurnal-view-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer';
        });

        const activeBtn = document.getElementById(`jurnal-view-${mode}`);
        if (activeBtn) {
            activeBtn.className = 'jurnal-view-tab px-3.5 py-1.5 rounded-full text-xs font-bold transition-all bg-brand-800 text-white shadow-subtle cursor-pointer';
        }

        if (cardMonitoring) cardMonitoring.classList.add('hidden');

        if (mode === 'monitoring') {
            if (cardMonitoring) cardMonitoring.classList.remove('hidden');
            cardKerja.classList.add('hidden');
            grid.classList.add('hidden');
        } else if (mode === 'kerja') {
            cardKerja.classList.remove('hidden');
            grid.classList.add('hidden');
        } else if (mode === 'both') {
            cardKerja.classList.remove('hidden');
            grid.classList.remove('hidden');
            grid.classList.remove('grid-cols-1');
            grid.classList.add('lg:grid-cols-2');
            colJurnal.classList.remove('hidden');
            colTahfidz.classList.remove('hidden');
        } else if (mode === 'jurnal') {
            cardKerja.classList.add('hidden');
            grid.classList.remove('hidden');
            grid.classList.remove('lg:grid-cols-2');
            grid.classList.add('grid-cols-1');
            colJurnal.classList.remove('hidden');
            colTahfidz.classList.add('hidden');
        } else if (mode === 'tahfidz') {
            cardKerja.classList.add('hidden');
            grid.classList.remove('hidden');
            grid.classList.remove('lg:grid-cols-2');
            grid.classList.add('grid-cols-1');
            colJurnal.classList.add('hidden');
            colTahfidz.classList.remove('hidden');
        }
    }

    function filterTahfidzPredikat(predikat) {
        activeTahfidzPredikat = predikat;

        document.querySelectorAll('.predikat-tab').forEach(tab => {
            tab.className = 'predikat-tab px-2.5 py-1 rounded-full text-[10px] font-semibold bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 cursor-pointer';
        });

        const activeBtn = document.getElementById(`predikat-filter-${predikat}`);
        if (activeBtn) {
            activeBtn.className = 'predikat-tab px-2.5 py-1 rounded-full text-[10px] font-bold bg-teal-800 text-white shadow-subtle cursor-pointer';
        }

        filterAllJournalCards();
    }

    function filterAllJournalCards() {
        applyTaskFilters();

        const query = (document.getElementById('jurnal-live-search')?.value || '').toLowerCase().trim();

        // Filter Jurnal items
        document.querySelectorAll('.jurnal-entry-item').forEach(item => {
            const searchData = item.getAttribute('data-search') || '';
            if (!query || searchData.includes(query)) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });

        // Filter Tahfidz items
        document.querySelectorAll('.tahfidz-entry-item').forEach(item => {
            const searchData = item.getAttribute('data-search') || '';
            const predikat = item.getAttribute('data-predikat') || '';

            const matchesQuery = !query || searchData.includes(query);
            const matchesPredikat = (activeTahfidzPredikat === 'all') || (predikat === activeTahfidzPredikat);

            if (matchesQuery && matchesPredikat) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    }
</script>

    @include('partials.modal-agenda')
@endsection
