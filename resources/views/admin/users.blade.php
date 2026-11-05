@extends('layouts.app')

@section('title', 'Manajemen Pengguna & Penugasan')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6 max-w-[1600px] mx-auto">

    <!-- 2-COLUMN CANVAS (Matches Learnhru Architecture) -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">

        <!-- ======================================================== -->
        <!-- MIDDLE / MAIN COLUMN (xl:col-span-8 or 9) -->
        <!-- ======================================================== -->
        <div class="xl:col-span-8 2xl:col-span-9 space-y-6">

            <!-- TOPBAR: BREADCRUMB & STATUS BADGE -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                    <span>ADM-SYS-01</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-medium text-slate-700">Tata Kelola Pengguna</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-semibold text-brand-800">Manajemen Akun &amp; Penugasan</span>
                </div>

                <div class="flex items-center gap-2 self-end sm:self-center text-xs font-semibold text-slate-500 bg-white px-3.5 py-1.5 rounded-2xl border border-slate-100 shadow-subtle shrink-0">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Database Pendidik &amp; Staf Aktif</span>
                </div>
            </div>

            <!-- HERO OVERVIEW CARD WITH 3D ISOMETRIC ILLUSTRATION -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative">
                <div class="space-y-3 max-w-xl z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-600"></span>
                        <span>Role-Based Access Control (RBAC) &amp; Penugasan</span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 leading-tight">
                        Tata Kelola Akun &amp; Penugasan Pendidik
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Kelola akun pengguna, penempatan unit lembaga (MI, SMP, SMA), perizinan hak akses multi-peran, serta distribusi beban jam mengajar mata pelajaran secara terpusat.
                    </p>
                </div>

                <!-- 3D Isometric Server & Identity Graphic -->
                <div class="shrink-0 flex items-center justify-center md:pr-4">
                    <svg class="w-36 h-32 sm:w-44 sm:h-38 drop-shadow-sm select-none" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Bottom Server Base Plate -->
                        <path d="M40 120 L120 160 L200 120 L120 80 Z" fill="#047857" />
                        <path d="M40 120 L40 135 L120 175 L120 160 Z" fill="#064e3b" />
                        <path d="M120 160 L120 175 L200 135 L200 120 Z" fill="#059669" />
                        <path d="M44 121 L44 130 L118 168 L118 159 Z" fill="#ecfdf5" />
                        <path d="M122 159 L122 168 L196 130 L196 121 Z" fill="#d1fae5" />

                        <!-- Middle Layer: Digital Keycard / User Tile -->
                        <path d="M50 95 L120 130 L190 95 L120 60 Z" fill="#2563eb" />
                        <path d="M50 95 L50 108 L120 143 L120 130 Z" fill="#1e40af" />
                        <path d="M120 130 L120 143 L190 108 L190 95 Z" fill="#3b82f6" />
                        <path d="M54 96 L54 104 L118 137 L118 129 Z" fill="#eff6ff" />
                        <path d="M122 129 L122 137 L186 104 L186 96 Z" fill="#dbeafe" />

                        <!-- Top Floating ID Badge with Avatar Silhouette -->
                        <path d="M70 65 L130 95 L180 70 L120 40 Z" fill="#ffffff" stroke="#e2e8f0" stroke-width="1.5" />
                        <path d="M70 65 L70 70 L130 100 L130 95 Z" fill="#cbd5e1" />
                        <path d="M130 95 L130 100 L180 75 L180 70 Z" fill="#94a3b8" />
                        <!-- Avatar silhouette inside top badge -->
                        <circle cx="120" cy="58" r="4.5" fill="#059669" />
                        <path d="M112 68 C112 64 128 64 128 68 Z" fill="#047857" />
                        <line x1="95" y1="73" x2="145" y2="73" stroke="#cbd5e1" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
            </div>

            <!-- 4 METRIC TILES -->
            @php
                $totalUsers = $users->count();
                $totalGuru = $users->filter(fn($u) => $u->isGuru())->count();
                $totalWaka = $users->filter(fn($u) => $u->isWakaKurikulum())->count();
                $totalPimpinan = $users->filter(fn($u) => $u->isKepalaSekolah() || $u->isYayasan())->count();
                $totalJP = $users->sum(fn($u) => $u->penugasan->sum('beban_jp'));
            @endphp
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 text-xs">
                <!-- Total Akun -->
                <div class="p-4 rounded-3xl bg-white border border-slate-100 shadow-card space-y-1">
                    <span class="text-[11px] font-semibold text-slate-400 block uppercase tracking-wider">Total Akun Terdaftar</span>
                    <div class="flex items-baseline justify-between">
                        <span class="text-xl sm:text-2xl font-black text-slate-900">{{ $totalUsers }}</span>
                        <span class="text-[11px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">Aktif</span>
                    </div>
                    <span class="text-[11px] text-slate-500 block">Lintas 3 Unit &amp; Yayasan</span>
                </div>

                <!-- Guru Pendidik -->
                <div class="p-4 rounded-3xl bg-white border border-slate-100 shadow-card space-y-1">
                    <span class="text-[11px] font-semibold text-emerald-700 block uppercase tracking-wider">Guru Mata Pelajaran</span>
                    <div class="flex items-baseline justify-between">
                        <span class="text-xl sm:text-2xl font-black text-slate-900">{{ $totalGuru }}</span>
                        <span class="text-[11px] font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-full">Pendidik</span>
                    </div>
                    <span class="text-[11px] text-slate-500 block">Pengampu Kurikulum Merdeka</span>
                </div>

                <!-- Kepala Sekolah & Yayasan -->
                <div class="p-4 rounded-3xl bg-white border border-slate-100 shadow-card space-y-1">
                    <span class="text-[11px] font-semibold text-blue-700 block uppercase tracking-wider">Pimpinan &amp; Verifikator</span>
                    <div class="flex items-baseline justify-between">
                        <span class="text-xl sm:text-2xl font-black text-slate-900">{{ $totalPimpinan }}</span>
                        <span class="text-[11px] font-bold text-blue-800 bg-blue-50 px-2 py-0.5 rounded-full">Reviewer</span>
                    </div>
                    <span class="text-[11px] text-slate-500 block">Kepala Sekolah &amp; Yayasan</span>
                </div>

                <!-- Total Beban JP -->
                <div class="p-4 rounded-3xl bg-white border border-slate-100 shadow-card space-y-1">
                    <span class="text-[11px] font-semibold text-amber-700 block uppercase tracking-wider">Total Beban Mengajar</span>
                    <div class="flex items-baseline justify-between">
                        <span class="text-xl sm:text-2xl font-black text-slate-900">{{ $totalJP }} <span class="text-xs font-bold text-slate-500">JP</span></span>
                        <span class="text-[11px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded-full">Pekan</span>
                    </div>
                    <span class="text-[11px] text-slate-500 block">Alokasi seluruh rombel</span>
                </div>
            </div>

            <!-- SEARCH, ROLE PILL FILTERS & UNIT DROPDOWN -->
            <div class="space-y-3">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                    <!-- Live Search Bar -->
                    <div class="relative flex-1 max-w-md">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                        <input type="text" id="user-search-input" oninput="filterUserTable()" 
                               placeholder="Cari nama guru, NIP, email, atau mapel..." 
                               class="w-full pl-9 pr-8 py-2 bg-white border border-slate-200/90 rounded-2xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-brand-700 shadow-subtle transition-all">
                        <button type="button" onclick="clearUserSearch()" id="clear-search-btn" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 hidden">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                    </div>

                    <!-- Unit Selector Filter -->
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-slate-500 whitespace-nowrap hidden sm:inline">Filter Unit:</span>
                        <select id="unit-filter-select" onchange="filterUserTable()" 
                                class="bg-white border border-slate-200/90 rounded-2xl text-xs text-slate-800 px-3 py-2 font-medium focus:outline-none focus:ring-1 focus:ring-brand-700 shadow-subtle">
                            <option value="all">Semua Lembaga &amp; Yayasan</option>
                            <option value="MI Tahfidz">MI Tahfidz</option>
                            <option value="SMP Alfa">SMP Alfa Ali Masykur</option>
                            <option value="SMA Alfa">SMA Alfa Ali Masykur</option>
                            <option value="Pusat Yayasan">Pusat Yayasan</option>
                        </select>
                    </div>
                </div>

                <!-- Role Filter Tabs -->
                <div class="flex flex-wrap items-center gap-1.5 pt-1">
                    <button type="button" onclick="setRoleFilter('all')" id="role-tab-all" 
                            class="role-filter-tab px-3.5 py-1.5 rounded-full text-xs font-bold transition-all bg-brand-800 text-white shadow-subtle cursor-pointer">
                        Semua Akun ({{ $totalUsers }})
                    </button>
                    <button type="button" onclick="setRoleFilter('guru')" id="role-tab-guru" 
                            class="role-filter-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50 cursor-pointer">
                        Guru Mapel ({{ $totalGuru }})
                    </button>
                    <button type="button" onclick="setRoleFilter('waka')" id="role-tab-waka" 
                            class="role-filter-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50 cursor-pointer">
                        Waka Kurikulum ({{ $totalWaka }})
                    </button>
                    <button type="button" onclick="setRoleFilter('kepala')" id="role-tab-kepala" 
                            class="role-filter-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50 cursor-pointer">
                        Kepala Sekolah/Madrasah
                    </button>
                    <button type="button" onclick="setRoleFilter('yayasan')" id="role-tab-yayasan" 
                            class="role-filter-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50 cursor-pointer">
                        Pengurus Yayasan
                    </button>
                    <button type="button" onclick="setRoleFilter('admin')" id="role-tab-admin" 
                            class="role-filter-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50 cursor-pointer">
                        Admin Sistem
                    </button>
                    <button type="button" onclick="setRoleFilter('pembina')" id="role-tab-pembina" 
                            class="role-filter-tab px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50 cursor-pointer">
                        Pembina Ekstra
                    </button>
                </div>
            </div>

            <!-- USERS & ASSIGNMENTS TABLE CONTAINER -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
                    <div>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <span>Daftar Pendidik, Staf &amp; Akses Sistem</span>
                            <span id="rendered-count-badge" class="px-2 py-0.5 rounded-full bg-slate-200/70 text-slate-700 text-[10px] font-bold">
                                {{ $users->count() }} Pendidik
                            </span>
                        </h2>
                        <p class="text-[11px] text-slate-500 mt-0.5">
                            Status aktif, unit penempatan lembaga, dan rincian alokasi mata pelajaran terdaftar.
                        </p>
                    </div>

                    <div class="flex items-center gap-2 text-xs">
                        <button type="button" onclick="openUserModal()" 
                                class="px-3.5 py-1.5 rounded-xl bg-brand-800 hover:bg-brand-900 text-white font-semibold flex items-center gap-1.5 transition-all shadow-subtle cursor-pointer">
                            <span class="material-symbols-outlined text-sm">person_add</span>
                            <span>Tambah Akun</span>
                        </button>
                        <button type="button" onclick="openAssignModal()" 
                                class="px-3.5 py-1.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 font-semibold flex items-center gap-1.5 transition-colors cursor-pointer">
                            <span class="material-symbols-outlined text-sm text-brand-700">assignment_ind</span>
                            <span>Tetapkan Guru</span>
                        </button>
                        <button type="button" onclick="window.print()" class="text-slate-500 hover:text-slate-800 flex items-center gap-1 font-semibold px-2 py-1">
                            <span class="material-symbols-outlined text-sm">print</span>
                            <span>Cetak</span>
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs" id="users-table">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                                <th class="py-3 px-4">Pendidik &amp; Identitas</th>
                                <th class="py-3 px-4">Peran &amp; Akses</th>
                                <th class="py-3 px-4">Unit Penempatan</th>
                                <th class="py-3 px-4">Mata Pelajaran Ditugaskan</th>
                                <th class="py-3 px-4 text-center">Beban JP</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($users as $u)
                                @php
                                    $roleName = $u->peran->nama_peran ?? 'Pengguna';
                                    $unitName = $u->unit->nama_unit ?? 'Pusat Yayasan';
                                    $totalUserJP = $u->penugasan->sum('beban_jp');
                                    
                                    // Determine role category for data-filtering
                                    $roleCategory = 'lainnya';
                                    if ($u->isWakaKurikulum()) {
                                        $roleCategory = 'waka';
                                    } elseif ($u->isGuru()) {
                                        $roleCategory = 'guru';
                                    } elseif ($u->isKepalaSekolah()) {
                                        $roleCategory = 'kepala';
                                    } elseif ($u->isYayasan()) {
                                        $roleCategory = 'yayasan';
                                    } elseif ($u->isAdmin()) {
                                        $roleCategory = 'admin';
                                    } elseif ($u->isPembina()) {
                                        $roleCategory = 'pembina';
                                    }

                                    // Palette colors for avatar
                                    $avatarColors = [
                                        'guru' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                        'waka' => 'bg-teal-100 text-teal-800 border-teal-200',
                                        'kepala' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'yayasan' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'admin' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        'pembina' => 'bg-rose-100 text-rose-800 border-rose-200',
                                        'lainnya' => 'bg-slate-100 text-slate-800 border-slate-200',
                                    ];
                                    $avatarClass = $avatarColors[$roleCategory] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                                @endphp
                                <tr class="user-row hover:bg-slate-50/70 transition-colors" 
                                    data-role="{{ $roleCategory }}" 
                                    data-unit="{{ $unitName }}"
                                    data-search="{{ strtolower($u->name . ' ' . $u->email . ' ' . ($u->nip ?? '') . ' ' . $u->username . ' ' . $roleName . ' ' . $unitName . ' ' . $u->penugasan->pluck('mataPelajaran.nama_mapel')->implode(' ')) }}">
                                    
                                    <!-- Identitas Pengguna -->
                                    <td class="py-3.5 px-4 align-top">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-2xl border font-bold flex items-center justify-center shrink-0 shadow-subtle {{ $avatarClass }}">
                                                {{ strtoupper(substr($u->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <span class="font-bold text-slate-900 block leading-tight">{{ $u->name }}</span>
                                                <div class="flex items-center gap-1.5 text-[11px] text-slate-400 mt-0.5">
                                                    <span>{{ $u->email }}</span>
                                                    <span>•</span>
                                                    <span>NIP: {{ $u->nip ?? '-' }}</span>
                                                </div>
                                                <div class="text-[10px] text-slate-400 font-mono mt-0.5">
                                                    {{ '@' . $u->username }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Peran Akses -->
                                    <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold border inline-block
                                            {{ $u->isWakaKurikulum() ? 'bg-teal-50 text-teal-800 border-teal-200/70' : 
                                               ($u->isGuru() ? 'bg-emerald-50 text-emerald-800 border-emerald-200/70' : 
                                               ($u->isKepalaSekolah() ? 'bg-blue-50 text-blue-800 border-blue-200/70' : 
                                               ($u->isYayasan() ? 'bg-amber-50 text-amber-800 border-amber-200/70' : 
                                               ($u->isAdmin() ? 'bg-purple-50 text-purple-800 border-purple-200/70' : 'bg-rose-50 text-rose-800 border-rose-200/70')))) }}">
                                            {{ $roleName }}
                                        </span>
                                    </td>

                                    <!-- Unit Lembaga -->
                                    <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                        <div class="font-medium text-slate-800">
                                            {{ $unitName }}
                                        </div>
                                        @if($u->jabatan)
                                            <div class="text-[10px] text-slate-400 mt-0.5">{{ $u->jabatan }}</div>
                                        @endif
                                    </td>

                                    <!-- Mata Pelajaran Ditugaskan -->
                                    <td class="py-3.5 px-4 align-top">
                                        <div class="space-y-1.5 max-w-xs">
                                            @forelse($u->penugasan as $p)
                                                <div class="flex items-center justify-between gap-2 p-1.5 rounded-xl bg-slate-50 border border-slate-200/70 text-xs">
                                                    <span class="font-bold text-slate-900 truncate">
                                                        {{ $p->mataPelajaran->nama_mapel ?? 'Mata Pelajaran' }}
                                                    </span>
                                                    <span class="shrink-0 text-[10px] font-semibold text-brand-800 bg-brand-50 px-1.5 py-0.5 rounded-md border border-brand-200/60">
                                                        {{ $p->beban_jp }} JP • {{ $p->jumlah_rombel }} Rbl
                                                    </span>
                                                </div>
                                            @empty
                                                <div class="flex items-center gap-1.5 text-slate-400 text-[11px] italic">
                                                    <span>Belum ada penugasan</span>
                                                    @if($u->isGuru())
                                                        <button type="button" onclick="quickAssignUser({{ $u->id }}, '{{ addslashes($u->name) }}')" 
                                                                class="text-brand-800 not-italic hover:underline font-semibold text-[11px]">
                                                            Tugaskan
                                                        </button>
                                                    @endif
                                                </div>
                                            @endforelse
                                        </div>
                                    </td>

                                    <!-- Beban JP Total -->
                                    <td class="py-3.5 px-4 align-top text-center whitespace-nowrap">
                                        @if($totalUserJP > 0)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold 
                                                {{ $totalUserJP >= 24 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                                                {{ $totalUserJP }} JP
                                            </span>
                                        @else
                                            <span class="text-slate-300 text-xs">-</span>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td class="py-3.5 px-4 align-top text-center whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-800 bg-emerald-50 border border-emerald-200/60 px-2.5 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            <span>Aktif</span>
                                        </span>
                                    </td>

                                    <!-- Aksi -->
                                    <td class="py-3.5 px-4 align-top text-right whitespace-nowrap">
                                        <button type="button" onclick="quickAssignUser({{ $u->id }}, '{{ addslashes($u->name) }}')" 
                                                title="Tetapkan Mata Pelajaran"
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-brand-50 hover:text-brand-800 text-slate-600 text-xs font-semibold transition-colors">
                                            <span class="material-symbols-outlined text-sm">edit_calendar</span>
                                            <span>Tugaskan</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Empty State (Hidden by default, shown by JS filter if 0 results) -->
                <div id="users-empty-state" class="hidden p-12 text-center space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                        <span class="material-symbols-outlined text-2xl">person_search</span>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-bold text-slate-800">Tidak ada data pengguna ditemukan</h4>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto">
                            Coba sesuaikan kata kunci pencarian atau ubah filter unit/peran di atas.
                        </p>
                    </div>
                    <button type="button" onclick="resetAllFilters()" class="text-xs font-semibold text-brand-800 hover:underline">
                        Reset Filter
                    </button>
                </div>
            </div>

        </div>

        <!-- ======================================================== -->
        <!-- RIGHT PANEL COLUMN (xl:col-span-4 or 3) -->
        <!-- ======================================================== -->
        <div class="xl:col-span-4 2xl:col-span-3 space-y-6">

            <!-- WIDGET 1: MATRIKS DISTRIBUSI HAK AKSES (RBAC) -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-700 text-lg">admin_panel_settings</span>
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Struktur Peran (RBAC)</h3>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400">5 Peran</span>
                </div>

                <div class="space-y-3 text-xs">
                    @foreach($roles as $role)
                        @php
                            $count = $users->where('peran_id', $role->id)->count();
                            $pct = $totalUsers > 0 ? round(($count / $totalUsers) * 100) : 0;
                        @endphp
                        <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-slate-800">{{ $role->nama_peran }}</span>
                                <span class="text-slate-500 font-bold">{{ $count }} <span class="text-[10px] text-slate-400 font-normal">({{ $pct }}%)</span></span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-brand-600 h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70 text-[11px] text-slate-600 space-y-1">
                    <span class="font-bold text-slate-800 block">Separation of Duties (SoD):</span>
                    <p class="leading-relaxed">
                        Pendidik mengusulkan kurikulum, Kepala Sekolah memverifikasi, Pengurus Yayasan memonitor ketercapaian, dan Administrator mengelola kredensial sistem.
                    </p>
                </div>
            </div>

            <!-- WIDGET 2: STANDAR BEBAN MENGAJAR (PERMENDIKBUD & KEMENAG) -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-600 text-lg">schedule</span>
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Standar Beban Mengajar</h3>
                    </div>
                    <span class="text-[10px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200/60">Regulasi</span>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="flex items-start gap-3 p-3 rounded-2xl bg-emerald-50 border border-emerald-200/70 text-emerald-950">
                        <span class="material-symbols-outlined text-emerald-700 text-lg shrink-0 mt-0.5">verified</span>
                        <div class="space-y-0.5">
                            <span class="font-bold text-emerald-900 block">Batas Minimal: 24 JP / Pekan</span>
                            <p class="text-[11px] text-emerald-800 leading-relaxed">
                                Syarat pemenuhan beban kerja guru tetap &amp; kelayakan tunjangan profesi pendidik.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 rounded-2xl bg-blue-50 border border-blue-200/70 text-blue-950">
                        <span class="material-symbols-outlined text-blue-700 text-lg shrink-0 mt-0.5">timer</span>
                        <div class="space-y-0.5">
                            <span class="font-bold text-blue-900 block">Batas Maksimal: 40 JP / Pekan</span>
                            <p class="text-[11px] text-blue-800 leading-relaxed">
                                Menjaga efektivitas pedagogis, persiapan modul ajar, dan pendampingan santri.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-2 text-[11px] text-slate-500 border-t border-slate-100">
                    <span>Rata-rata alokasi guru aktif saat ini: </span>
                    <span class="font-bold text-slate-800">
                        {{ $totalGuru > 0 ? round($totalJP / $totalGuru, 1) : 0 }} JP/Guru
                    </span>
                </div>
            </div>

            <!-- WIDGET 3: UNIT LEMBAGA & FASE PENDIDIKAN -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-700 text-lg">domain</span>
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Unit Pendidikan</h3>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400">3 Unit</span>
                </div>

                <div class="space-y-2.5 text-xs">
                    @foreach($units as $unit)
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70 flex items-center justify-between">
                            <div>
                                <span class="font-bold text-slate-900 block">{{ $unit->nama_unit }}</span>
                                <span class="text-[10px] text-slate-500">{{ $unit->jenjang }} • {{ $unit->alamat ?? 'Wonosobo' }}</span>
                            </div>
                            <span class="text-xs font-bold text-slate-700 bg-white px-2 py-1 rounded-xl border border-slate-200 shadow-subtle">
                                {{ $users->where('unit_id', $unit->id)->count() }} Akun
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- WIDGET 4: BANTUAN ADMINISTRATOR & KEAMANAN -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-3">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="material-symbols-outlined text-slate-400 text-lg">security</span>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Keamanan &amp; SOP IT</h3>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Setiap penambahan atau mutasi mengajar langsung disinkronkan ke modul Capaian Pembelajaran, Silabus, dan Jurnal Harian.
                </p>
                <div class="pt-1">
                    <a href="{{ route('guide.index') }}" class="text-xs font-bold text-brand-800 hover:underline flex items-center gap-1">
                        <span>Lihat SOP Pengelolaan Sistem</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- ======================================================== -->
<!-- MODAL 1: TAMBAH AKUN PENGGUNA BARU -->
<!-- ======================================================== -->
<div id="user-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-floating border border-slate-200 space-y-5 animate-in fade-in zoom-in-95 duration-150">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-lg">person_add</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Tambah Akun Pengguna Baru</h3>
                    <p class="text-[11px] text-slate-500">Daftarkan akun pendidik atau pengurus yayasan</p>
                </div>
            </div>
            <button onclick="closeUserModal()" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-3.5 text-xs">
            @csrf
            
            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Nama Lengkap &amp; Gelar Pendidik</label>
                <input type="text" name="name" required placeholder="misal: Ustadzah Fatimah Azzahra, S.Pd." 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Username Login</label>
                    <input type="text" name="username" required placeholder="guru.fatimah" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">NIP / NIY (Opsional)</label>
                    <input type="text" name="nip" placeholder="19890101..." 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Email Resmi</label>
                    <input type="email" name="email" required placeholder="fatimah@alimasykur.sch.id" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Kata Sandi Awal</label>
                    <input type="password" name="password" required value="password" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Peran Sistem (RBAC)</label>
                    <select name="peran_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                        @foreach($roles as $r)
                            <option value="{{ $r->id }}">{{ $r->nama_peran }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="font-semibold text-slate-700">Unit Lembaga</label>
                    <select name="unit_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                        <option value="">Pusat Yayasan (Semua Unit)</option>
                        @foreach($units as $u)
                            <option value="{{ $u->id }}">{{ $u->nama_unit }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Jabatan / Keterangan Penugasan</label>
                <input type="text" name="jabatan" placeholder="misal: Guru Bahasa Arab SMP Alfa &amp; Pembina Tahfidz" 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeUserModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 2: TETAPKAN PENUGASAN GURU -->
<!-- ======================================================== -->
<div id="assign-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-floating border border-slate-200 space-y-5 animate-in fade-in zoom-in-95 duration-150">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-800 flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-lg">assignment_ind</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Tetapkan Penugasan Guru</h3>
                    <p class="text-[11px] text-slate-500">Alokasikan mata pelajaran, jam mengajar &amp; rombel</p>
                </div>
            </div>
            <button onclick="closeAssignModal()" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.assign.mapel') }}" class="space-y-3.5 text-xs">
            @csrf
            
            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Pilih Guru Pendidik</label>
                <select name="pengguna_id" id="assign-user-select" required 
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                    @foreach($users as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->name }} ({{ $guru->peran->nama_peran ?? 'Pendidik' }} - {{ $guru->unit->nama_unit ?? 'Pusat' }})</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-slate-700">Mata Pelajaran Ditugaskan</label>
                <select name="mapel_id" required 
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                    @foreach($mapelList as $mp)
                        <option value="{{ $mp->id }}">{{ $mp->nama_mapel }} [{{ $mp->kode_mapel }}] — {{ $mp->kurikulum->unit->nama_unit ?? 'Unit' }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <div class="flex items-center justify-between">
                        <label class="font-semibold text-slate-700">Beban Jam (JP)</label>
                        <span class="text-[10px] text-slate-400 font-medium">Standar: 24 JP</span>
                    </div>
                    <input type="number" name="beban_jp" value="24" min="1" max="48" required 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                </div>
                <div class="space-y-1">
                    <div class="flex items-center justify-between">
                        <label class="font-semibold text-slate-700">Jumlah Rombel</label>
                        <span class="text-[10px] text-slate-400 font-medium">Kelas Paralel</span>
                    </div>
                    <input type="number" name="jumlah_rombel" value="4" min="1" max="15" required 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-colors">
                </div>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeAssignModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all">
                    Tetapkan Penugasan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ======================================================== -->
<!-- INTERACTIVE SCRIPTS: FILTERING, SEARCH & MODALS -->
<!-- ======================================================== -->
<script>
    let activeRoleFilter = 'all';

    function openUserModal() {
        document.getElementById('user-modal').classList.remove('hidden');
    }
    function closeUserModal() {
        document.getElementById('user-modal').classList.add('hidden');
    }

    function openAssignModal() {
        document.getElementById('assign-modal').classList.remove('hidden');
    }
    function closeAssignModal() {
        document.getElementById('assign-modal').classList.add('hidden');
    }

    function quickAssignUser(userId, userName) {
        const select = document.getElementById('assign-user-select');
        if (select) {
            select.value = userId;
        }
        openAssignModal();
    }

    function setRoleFilter(role) {
        activeRoleFilter = role;
        
        // Update tab styles
        document.querySelectorAll('.role-filter-tab').forEach(tab => {
            tab.classList.remove('bg-brand-800', 'text-white', 'shadow-subtle');
            tab.classList.add('bg-white', 'text-slate-600', 'border', 'border-slate-100');
        });

        const activeTab = document.getElementById(`role-tab-${role}`);
        if (activeTab) {
            activeTab.classList.remove('bg-white', 'text-slate-600', 'border', 'border-slate-100');
            activeTab.classList.add('bg-brand-800', 'text-white', 'shadow-subtle');
        }

        filterUserTable();
    }

    function filterUserTable() {
        const searchInput = document.getElementById('user-search-input');
        const clearBtn = document.getElementById('clear-search-btn');
        const unitSelect = document.getElementById('unit-filter-select');
        const query = (searchInput ? searchInput.value : '').toLowerCase().trim();
        const selectedUnit = unitSelect ? unitSelect.value : 'all';

        if (clearBtn) {
            clearBtn.classList.toggle('hidden', query.length === 0);
        }

        const rows = document.querySelectorAll('.user-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const role = row.getAttribute('data-role');
            const unit = row.getAttribute('data-unit');
            const searchData = row.getAttribute('data-search') || '';

            // Check role filter
            const matchRole = (activeRoleFilter === 'all') || (role === activeRoleFilter);

            // Check unit filter
            const matchUnit = (selectedUnit === 'all') || (unit.indexOf(selectedUnit) !== -1);

            // Check search text
            const matchSearch = query.length === 0 || searchData.indexOf(query) !== -1;

            if (matchRole && matchUnit && matchSearch) {
                row.classList.remove('hidden');
                visibleCount++;
            } else {
                row.classList.add('hidden');
            }
        });

        // Update badge count
        const countBadge = document.getElementById('rendered-count-badge');
        if (countBadge) {
            countBadge.textContent = `${visibleCount} Pendidik`;
        }

        // Handle empty state
        const emptyState = document.getElementById('users-empty-state');
        if (emptyState) {
            emptyState.classList.toggle('hidden', visibleCount > 0);
        }
    }

    function clearUserSearch() {
        const searchInput = document.getElementById('user-search-input');
        if (searchInput) {
            searchInput.value = '';
        }
        filterUserTable();
    }

    function resetAllFilters() {
        clearUserSearch();
        const unitSelect = document.getElementById('unit-filter-select');
        if (unitSelect) unitSelect.value = 'all';
        setRoleFilter('all');
    }

    // Close modals on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeUserModal();
            closeAssignModal();
        }
    });
</script>
@endsection
