@extends('layouts.app')

@section('title', 'Edit Profil & Data Diri Akun')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6 max-w-[1400px] mx-auto space-y-6">

    <!-- BREADCRUMB -->
    <div class="flex items-center gap-1.5 text-xs text-slate-500">
        <a href="{{ route('dashboard') }}" class="hover:text-slate-800 transition-colors">Beranda</a>
        <span class="text-slate-300">/</span>
        <span class="font-medium text-slate-700">Pengaturan Akun</span>
        <span class="text-slate-300">/</span>
        <span class="font-semibold text-brand-800">Data Diri &amp; Profil</span>
    </div>

    <!-- FLASH MESSAGES -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-subtle">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-base text-emerald-600">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium space-y-1 shadow-subtle">
            <div class="flex items-center gap-2 font-bold text-rose-900">
                <span class="material-symbols-outlined text-base">error</span>
                <span>Terdapat kendala pada pengisian formulir:</span>
            </div>
            <ul class="list-disc list-inside pl-5 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- HERO PROFILE HEADER CARD -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-card overflow-hidden">
        <div class="h-32 sm:h-40 bg-gradient-to-r from-brand-800 via-brand-700 to-indigo-900 relative p-6 flex items-end">
            <!-- Decorative circle -->
            <div class="absolute -right-8 -top-8 w-40 h-40 rounded-full bg-white/10 pointer-events-none"></div>
            <div class="absolute right-1/4 -bottom-10 w-28 h-28 rounded-full bg-white/5 pointer-events-none"></div>
            
            <div class="relative z-10 flex items-center justify-between w-full text-white">
                <span class="text-xs uppercase tracking-wider font-semibold text-white/80">
                    Sistem Informasi Manajemen Kurikulum Terpadu
                </span>
                <span class="px-3 py-1 rounded-full bg-white/15 backdrop-blur-md text-[11px] font-semibold border border-white/20">
                    Akun Terverifikasi
                </span>
            </div>
        </div>

        <div class="px-6 pb-6 pt-0 relative">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 -mt-14 sm:-mt-16 mb-4">
                <!-- Avatar with Initial or Custom Image -->
                <div class="flex items-end gap-4">
                    <div class="relative w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-white p-1 shadow-floating border border-slate-100 shrink-0">
                        @if($user->avatar_image)
                            <img src="{{ $user->avatar_image }}" alt="{{ $user->name }}" class="w-full h-full object-cover rounded-2xl">
                        @else
                            <div class="w-full h-full rounded-2xl bg-gradient-to-br from-brand-700 to-brand-900 text-white font-black text-3xl flex items-center justify-center shadow-inner">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <span class="absolute bottom-2 right-2 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white shadow-subtle" title="Status: Aktif"></span>
                    </div>

                    <div class="space-y-1 pb-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">{{ $user->name }}</h1>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-800 border border-brand-200">
                                {{ $user->peran->nama_peran ?? 'Pendidik' }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-2 flex-wrap">
                            <span>{{ $user->unit->nama_unit ?? 'Yayasan Pendidik Ali Masykur' }}</span>
                            <span>•</span>
                            <span class="font-mono text-slate-700 font-semibold">NIP: {{ $user->nip ?? 'Belum diisi' }}</span>
                            <span>•</span>
                            <span>{{ $user->jabatan ?? 'Tenaga Pengajar' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Fast Actions -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('helpdesk.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-all">
                        <span class="material-symbols-outlined text-base">support_agent</span>
                        <span>Bantuan IT</span>
                    </a>
                </div>
            </div>

            <!-- 4 Quick Stats Badges -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 border-t border-slate-100 text-xs">
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Beban Jam Mengajar</span>
                    <span class="text-lg font-extrabold text-brand-800 mt-0.5 block">{{ $metrics['total_jp'] }} JP / Pekan</span>
                </div>
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Jurnal KBM Terisi</span>
                    <span class="text-lg font-extrabold text-emerald-700 mt-0.5 block">{{ $metrics['jurnal_kbm'] }} Catatan</span>
                </div>
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Agenda Kerja Kalender</span>
                    <span class="text-lg font-extrabold text-slate-800 mt-0.5 block">{{ $metrics['agenda_kerja'] }} Agenda</span>
                </div>
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Usulan Kurikulum Diajukan</span>
                    <span class="text-lg font-extrabold text-indigo-700 mt-0.5 block">{{ $metrics['usulan_tp'] }} Usulan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN EDIT AREA WITH TABS -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- LEFT COLUMN: NAVIGATION TABS (lg:col-span-3) -->
        <div class="lg:col-span-3 bg-white rounded-3xl p-4 border border-slate-100 shadow-card space-y-1">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block px-3 py-2">Navigasi Pengaturan</span>

            <button type="button" onclick="switchProfileTab('data-diri')" id="tab-btn-data-diri"
                    class="profile-tab-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold transition-all bg-brand-800 text-white shadow-subtle text-left cursor-pointer">
                <span class="material-symbols-outlined text-base">person</span>
                <span>Data Diri &amp; Kontak</span>
            </button>

            <button type="button" onclick="switchProfileTab('keamanan')" id="tab-btn-keamanan"
                    class="profile-tab-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-all text-left cursor-pointer">
                <span class="material-symbols-outlined text-base">lock</span>
                <span>Keamanan &amp; Kata Sandi</span>
            </button>

            <button type="button" onclick="switchProfileTab('penugasan')" id="tab-btn-penugasan"
                    class="profile-tab-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-all text-left cursor-pointer">
                <span class="material-symbols-outlined text-base">assignment_ind</span>
                <span>Penugasan Mengajar</span>
            </button>
        </div>

        <!-- RIGHT COLUMN: TAB CONTENT (lg:col-span-9) -->
        <div class="lg:col-span-9 space-y-6">

            <!-- TAB 1: DATA DIRI & KONTAK -->
            <div id="tab-pane-data-diri" class="profile-tab-pane bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-8 space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-base font-bold text-slate-900">Perbarui Data Diri &amp; Identitas Akun</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Informasi profil ini akan tampil pada modul silabus, buku jurnal mengajar, dan surat verifikasi kurikulum.</p>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Photo Upload Section -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row items-center gap-5">
                        <div class="relative w-20 h-20 rounded-2xl bg-white p-1 border border-slate-200 shrink-0 shadow-sm overflow-hidden">
                            <img id="avatar-preview-img" 
                                 src="{{ $user->avatar_image ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=1e3a8a&color=fff' }}" 
                                 alt="Avatar Preview" class="w-full h-full object-cover rounded-xl">
                        </div>

                        <div class="space-y-2 flex-1 text-center sm:text-left">
                            <span class="text-xs font-bold text-slate-800 block">Foto Profil Pengguna</span>
                            <p class="text-[11px] text-slate-500">Mendukung format JPG, PNG, atau WebP dengan resolusi persegi (Maks. 4 MB).</p>
                            
                            <div class="flex flex-wrap items-center gap-2 justify-center sm:justify-start">
                                <label for="avatar-input" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-semibold shadow-subtle transition-all cursor-pointer">
                                    <span class="material-symbols-outlined text-sm">photo_camera</span>
                                    <span>Pilih Foto Baru</span>
                                </label>
                                <input type="file" id="avatar-input" name="avatar" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="previewAvatar(this)">

                                @if($user->avatar_url)
                                    <button type="button" onclick="confirmDeleteAvatar()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-semibold transition-all cursor-pointer">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                        <span>Hapus Foto</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Fields Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Nama Lengkap -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all font-medium">
                        </div>

                        <!-- Email -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Alamat Email Resmi <span class="text-rose-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all font-medium">
                        </div>

                        <!-- Nomor Telepon / WhatsApp -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Nomor Telepon / WhatsApp</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base">call</span>
                                <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $user->nomor_telepon) }}" 
                                       placeholder="Contoh: 0812-3456-7890" 
                                       class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all font-medium">
                            </div>
                        </div>

                        <!-- NIP / NUPTK -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">NIP / NUPTK / Kode Guru</label>
                            <input type="text" name="nip" value="{{ old('nip', $user->nip) }}" 
                                   placeholder="Contoh: 198507122010011002" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all font-medium">
                        </div>

                        <!-- Jabatan Fungsional -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Jabatan Fungsional / Spesialisasi</label>
                            <input type="text" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}" 
                                   placeholder="Contoh: Guru Matematika Fase D" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all font-medium">
                        </div>

                        <!-- Alamat Domisili -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Alamat Tempat Tinggal</label>
                            <input type="text" name="alamat" value="{{ old('alamat', $user->alamat) }}" 
                                   placeholder="Contoh: Jl. Pondok Pesantren No. 12, Kudus" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all font-medium">
                        </div>

                        <!-- Read-only Role & Unit -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-500">Peran Pengguna (Wewenang Terkunci)</label>
                            <input type="text" value="{{ $user->peran->nama_peran ?? 'Pendidik' }}" disabled
                                   class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 rounded-2xl text-xs text-slate-500 cursor-not-allowed">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-500">Unit Lembaga Terdaftar (Terkunci)</label>
                            <input type="text" value="{{ $user->unit->nama_unit ?? 'Yayasan Pendidik Ali Masykur' }}" disabled
                                   class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 rounded-2xl text-xs text-slate-500 cursor-not-allowed">
                        </div>
                    </div>

                    <!-- Bio / Catatan Pendidik -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Bio Singkat / Visi Pembelajaran</label>
                        <textarea name="bio" rows="3" placeholder="Tuliskan sekilas tentang pengalaman mengajar atau fokus pembelajaran Anda..."
                                  class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all leading-relaxed">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    <!-- Save Submit Button -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-all">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-2xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle hover:shadow-floating transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-base">save</span>
                            <span>Simpan Perubahan Data Diri</span>
                        </button>
                    </div>
                </form>

                <!-- Hidden Delete Avatar Form -->
                <form id="delete-avatar-form" action="{{ route('profile.avatar.delete') }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>

            <!-- TAB 2: KEAMANAN & KATA SANDI -->
            <div id="tab-pane-keamanan" class="profile-tab-pane hidden bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-8 space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-base font-bold text-slate-900">Perbarui Kata Sandi Akun</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Pastikan Anda menggunakan kata sandi yang aman dan tidak dibagikan kepada pihak lain.</p>
                </div>

                <form action="{{ route('profile.password') }}" method="POST" class="space-y-4 max-w-lg">
                    @csrf

                    <!-- Current Password -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Kata Sandi Saat Ini <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="password" name="current_password" id="cur-pass-input" required
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all font-medium">
                            <button type="button" onclick="togglePassVisibility('cur-pass-input')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer">
                                <span class="material-symbols-outlined text-base">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Kata Sandi Baru <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="password" name="password" id="new-pass-input" required minlength="6"
                                   placeholder="Minimal 6 karakter"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all font-medium">
                            <button type="button" onclick="togglePassVisibility('new-pass-input')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer">
                                <span class="material-symbols-outlined text-base">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="conf-pass-input" required minlength="6"
                                   placeholder="Ulangi kata sandi baru"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all font-medium">
                            <button type="button" onclick="togglePassVisibility('conf-pass-input')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer">
                                <span class="material-symbols-outlined text-base">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="pt-4 flex items-center justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-2xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle hover:shadow-floating transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-base">key</span>
                            <span>Perbarui Kata Sandi</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB 3: PENUGASAN MENGAJAR -->
            <div id="tab-pane-penugasan" class="profile-tab-pane hidden bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Daftar Penugasan Mata Pelajaran &amp; Beban Jam</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Penetapan resmi kurikulum yang diajarkan pada semester aktif.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-brand-50 text-brand-800 font-bold text-xs border border-brand-200">
                        Total Beban: {{ $metrics['total_jp'] }} JP / Pekan
                    </span>
                </div>

                @if($penugasan->count() > 0)
                    <div class="divide-y divide-slate-100 border border-slate-100 rounded-3xl overflow-hidden bg-slate-50/50">
                        @foreach($penugasan as $pg)
                            <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-white transition-colors">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-900 text-sm">{{ $pg->mataPelajaran->nama_mapel ?? 'Mata Pelajaran' }}</span>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-200/80 text-slate-700">
                                            {{ $pg->mataPelajaran->kode_mapel ?? 'KODE' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-slate-500">
                                        <span>Kelas: <strong>{{ $pg->mataPelajaran?->kelas?->first()?->nama_kelas ?? 'Reguler' }}</strong> ({{ $pg->mataPelajaran?->kelas?->first()?->fase?->nama_fase ?? 'Fase Aktif' }})</span>
                                        <span>•</span>
                                        <span>T.A. {{ $pg->tahun_ajaran }} Semester {{ ucfirst($pg->semester) }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1.5 rounded-2xl bg-brand-50 border border-brand-200 text-brand-800 font-bold text-xs">
                                        {{ $pg->beban_jp ?? 4 }} JP / Pekan
                                    </span>
                                    <a href="{{ route('curriculum.index', ['mapel_id' => $pg->mataPelajaran->id, 'view' => 'workspace']) }}" 
                                       class="px-3 py-1.5 rounded-2xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-semibold shadow-subtle transition-all flex items-center gap-1">
                                        <span>Silabus</span>
                                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center text-slate-400 space-y-2">
                        <span class="material-symbols-outlined text-4xl text-slate-300 block mb-1">school</span>
                        <p class="text-sm font-bold text-slate-700">Belum Ada Penugasan Mengajar</p>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto">Akun ini belum memiliki jadwal pengajaran tatap muka langsung di kelas.</p>
                    </div>
                @endif
            </div>

        </div>

    </div>

</div>

<script>
    function switchProfileTab(tabId) {
        document.querySelectorAll('.profile-tab-pane').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.profile-tab-btn').forEach(btn => {
            btn.classList.remove('bg-brand-800', 'text-white', 'shadow-subtle', 'font-bold');
            btn.classList.add('text-slate-600', 'font-semibold');
        });

        const activePane = document.getElementById('tab-pane-' + tabId);
        const activeBtn = document.getElementById('tab-btn-' + tabId);

        if (activePane) activePane.classList.remove('hidden');
        if (activeBtn) {
            activeBtn.classList.add('bg-brand-800', 'text-white', 'shadow-subtle', 'font-bold');
            activeBtn.classList.remove('text-slate-600', 'font-semibold');
        }
    }

    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('avatar-preview-img');
                if (previewImg) previewImg.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function confirmDeleteAvatar() {
        if (confirm('Apakah Anda yakin ingin menghapus foto profil ini?')) {
            document.getElementById('delete-avatar-form').submit();
        }
    }

    function togglePassVisibility(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    }
</script>
@endsection
