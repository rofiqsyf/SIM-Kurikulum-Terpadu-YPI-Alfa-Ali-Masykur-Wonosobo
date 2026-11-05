@extends('layouts.app')

@section('title', $isAdmin ? 'Helpdesk & Konsultasi Pengguna' : 'Hubungi Administrator IT')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6 max-w-[1600px] mx-auto">

    <!-- TOPBAR / BREADCRUMB -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div class="flex items-center gap-1.5 text-xs text-slate-500">
            <a href="{{ route('dashboard') }}" class="hover:text-slate-800 transition-colors">Beranda</a>
            <span class="text-slate-300">/</span>
            <a href="{{ route('guide.index') }}" class="hover:text-slate-800 transition-colors">Pusat Bantuan</a>
            <span class="text-slate-300">/</span>
            <span class="font-semibold text-brand-800">{{ $isAdmin ? 'Helpdesk Administrator' : 'Hubungi Administrator' }}</span>
        </div>

        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-subtle">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                <span>Helpdesk Online • Jam Layanan 07:00 - 16:00 WIB</span>
            </span>
            <a href="{{ route('guide.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-2xl bg-white border border-slate-200 text-xs font-semibold text-slate-700 hover:text-brand-800 shadow-subtle transition-all">
                <span class="material-symbols-outlined text-sm">help</span>
                <span>Buka SOP &amp; FAQ</span>
            </a>
        </div>
    </div>

    @if($isAdmin)
        <!-- ===================================================================== -->
        <!-- ADMINISTRATOR WORKSPACE: SPLIT-SCREEN HELPDESK INBOX & CHAT THREAD -->
        <!-- ===================================================================== -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- LEFT COLUMN: THREAD LIST (lg:col-span-4 2xl:col-span-4) -->
            <div class="lg:col-span-4 2xl:col-span-4 bg-white rounded-3xl border border-slate-100 shadow-card p-4 sm:p-5 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Kotak Masuk Bantuan</h2>
                        <p class="text-[11px] text-slate-500">Percakapan pengguna dengan Administrator</p>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-800 border border-brand-200/80">
                        {{ $threads->count() }} Percakapan
                    </span>
                </div>

                <!-- Live Search Box -->
                <form action="{{ route('helpdesk.index') }}" method="GET" class="relative">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base">search</span>
                    <input type="text" name="q" value="{{ $searchQuery }}" 
                           placeholder="Cari nama guru, peran, pesan..." 
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-2xl text-xs placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all">
                </form>

                <!-- Filter Tabs -->
                <div class="flex items-center gap-1 p-1 bg-slate-50 rounded-2xl border border-slate-200/70 text-xs font-semibold overflow-x-auto">
                    <a href="{{ route('helpdesk.index', ['status' => 'all', 'q' => $searchQuery]) }}" 
                       class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $filterStatus === 'all' ? 'bg-white text-slate-900 shadow-subtle font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                        Semua
                    </a>
                    <a href="{{ route('helpdesk.index', ['status' => 'unread', 'q' => $searchQuery]) }}" 
                       class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap flex items-center gap-1 {{ $filterStatus === 'unread' ? 'bg-white text-slate-900 shadow-subtle font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                        <span>Belum Dibaca</span>
                        @php $totalUnread = $threads->sum('unread_for_admin'); @endphp
                        @if($totalUnread > 0)
                            <span class="w-4 h-4 rounded-full bg-rose-600 text-white text-[9px] font-bold flex items-center justify-center">{{ $totalUnread }}</span>
                        @endif
                    </a>
                    <a href="{{ route('helpdesk.index', ['status' => 'open', 'q' => $searchQuery]) }}" 
                       class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $filterStatus === 'open' ? 'bg-white text-slate-900 shadow-subtle font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                        Terbuka
                    </a>
                    <a href="{{ route('helpdesk.index', ['status' => 'resolved', 'q' => $searchQuery]) }}" 
                       class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $filterStatus === 'resolved' ? 'bg-white text-slate-900 shadow-subtle font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                        Selesai
                    </a>
                </div>

                <!-- Thread List Scrollable -->
                <div class="space-y-2 max-h-[640px] overflow-y-auto pr-1">
                    @forelse($threads as $t)
                        @php
                            $isSelected = $activeThread && $activeThread->id === $t->id;
                            $userUnit = $t->user->unit->kode_unit ?? 'YPI';
                            $userRole = $t->user->peran->nama_peran ?? 'Pengguna';
                        @endphp
                        <a href="{{ route('helpdesk.index', ['thread_id' => $t->id, 'status' => $filterStatus, 'q' => $searchQuery]) }}" 
                           class="block p-3.5 rounded-2xl border transition-all cursor-pointer {{ $isSelected ? 'bg-brand-50/70 border-brand-200 shadow-subtle' : 'bg-white hover:bg-slate-50 border-slate-100' }}">
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="w-9 h-9 rounded-2xl bg-gradient-to-br from-brand-700 to-brand-900 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                                        {{ substr($t->user->name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-xs font-bold text-slate-900 truncate">{{ $t->user->name }}</h4>
                                        <div class="flex items-center gap-1.5 text-[10px] text-slate-500">
                                            <span class="font-medium text-brand-800">{{ $userRole }}</span>
                                            <span>•</span>
                                            <span class="truncate">{{ $userUnit }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="text-[10px] text-slate-400 block">
                                        {{ $t->last_message_at ? $t->last_message_at->format('H:i') : '' }}
                                    </span>
                                    @if($t->unread_for_admin > 0)
                                        <span class="inline-block mt-1 px-1.5 py-0.5 rounded-full bg-rose-600 text-white text-[9px] font-bold">
                                            {{ $t->unread_for_admin }} baru
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <p class="text-xs text-slate-600 mt-2 truncate pl-1">
                                {{ $t->last_message_preview ?: 'Belum ada percakapan.' }}
                            </p>

                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-slate-100 text-[10px]">
                                <span class="inline-flex items-center gap-1 {{ $t->status === 'open' ? 'text-emerald-700 font-semibold' : 'text-slate-400' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $t->status === 'open' ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <span>{{ $t->status === 'open' ? 'Terbuka' : 'Selesai' }}</span>
                                </span>
                                <span class="text-slate-400">
                                    {{ $t->messages()->count() }} pesan
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center text-slate-400 text-xs">
                            <span class="material-symbols-outlined text-3xl text-slate-300 block mb-2">forum</span>
                            Tidak ada percakapan ditemukan.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- RIGHT COLUMN: ACTIVE CONVERSATION (lg:col-span-8 2xl:col-span-8) -->
            <div class="lg:col-span-8 2xl:col-span-8 bg-white rounded-3xl border border-slate-100 shadow-card flex flex-col h-[740px] overflow-hidden">
                @if($activeThread)
                    <!-- Active Thread Header -->
                    <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-brand-700 to-brand-900 text-white flex items-center justify-center font-bold text-sm shadow-subtle shrink-0">
                                {{ substr($activeThread->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-sm font-bold text-slate-900">{{ $activeThread->user->name }}</h3>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-brand-50 text-brand-800 border border-brand-200">
                                        {{ $activeThread->user->peran->nama_peran ?? 'Pengguna' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-500 mt-0.5">
                                    <span>{{ $activeThread->user->unit->nama_unit ?? 'Yayasan Pendidik' }}</span>
                                    <span>•</span>
                                    <span>{{ $activeThread->user->email ?? $activeThread->user->username }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Toggle Status Button -->
                            <form action="{{ route('helpdesk.status', $activeThread->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-2xl border text-xs font-semibold shadow-subtle transition-all cursor-pointer {{ $activeThread->isOpen() ? 'bg-emerald-50 text-emerald-800 border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200' }}">
                                    <span class="material-symbols-outlined text-base">{{ $activeThread->isOpen() ? 'check_circle' : 'refresh' }}</span>
                                    <span>{{ $activeThread->isOpen() ? 'Tandai Selesai' : 'Buka Kembali' }}</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Messages Scroll Container -->
                    <div id="chat-messages-container" class="flex-1 p-4 sm:p-6 overflow-y-auto space-y-4 bg-slate-50/30">
                        @include('helpdesk._messages_list', ['messages' => $messages, 'activeThread' => $activeThread, 'currentUser' => $currentUser])
                    </div>

                    <!-- Message Send Form with Attachment -->
                    <div class="p-3 sm:p-4 border-t border-slate-100 bg-white">
                        <form id="chat-send-form" action="{{ route('helpdesk.send', $activeThread->id) }}" method="POST" enctype="multipart/form-data" class="space-y-2.5">
                            @csrf

                            <!-- Attachment Preview Chip (hidden by default) -->
                            <div id="attachment-preview-container" class="hidden items-center justify-between p-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="material-symbols-outlined text-brand-700 text-base" id="preview-file-icon">attach_file</span>
                                    <span class="font-semibold text-slate-800 truncate" id="preview-file-name">filename.pdf</span>
                                    <span class="text-slate-400 text-[11px]" id="preview-file-size">(0 KB)</span>
                                </div>
                                <button type="button" onclick="clearAttachment()" class="text-slate-400 hover:text-rose-600 transition-colors cursor-pointer p-1">
                                    <span class="material-symbols-outlined text-base">close</span>
                                </button>
                            </div>

                            <div class="flex items-end gap-2">
                                <!-- File Upload Trigger Button -->
                                <label for="chat-file-input" 
                                       class="shrink-0 p-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-brand-800 border border-slate-200/80 transition-all cursor-pointer flex items-center justify-center" 
                                       title="Lampirkan Dokumen atau Gambar (PDF, DOCX, XLSX, PNG, JPG, ZIP max 25MB)">
                                    <span class="material-symbols-outlined text-lg">attach_file</span>
                                </label>
                                <input type="file" id="chat-file-input" name="lampiran" 
                                       accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.txt,.zip,.rar,.png,.jpg,.jpeg,.webp" 
                                       class="hidden" onchange="handleFileChosen(this)">

                                <!-- Text Message Input Area -->
                                <div class="flex-1 relative">
                                    <textarea name="pesan" id="chat-message-input" rows="1" 
                                              placeholder="Ketik balasan untuk {{ $activeThread->user->name }}..." 
                                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all resize-none max-h-32 leading-relaxed"
                                              onkeydown="handleTextareaKeydown(event)"></textarea>
                                </div>

                                <!-- Send Button -->
                                <button type="submit" id="chat-send-btn" 
                                        class="shrink-0 px-4 py-2.5 rounded-2xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all flex items-center gap-1.5 cursor-pointer">
                                    <span>Kirim</span>
                                    <span class="material-symbols-outlined text-base">send</span>
                                </button>
                            </div>
                            <div class="flex items-center justify-between text-[10px] text-slate-400 px-1">
                                <span>Format lampiran: Dokumen (PDF, Word, Excel), Gambar (PNG, JPG), ZIP (Maks. 25 MB)</span>
                                <span>Tekan Shift+Enter untuk baris baru</span>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="flex-1 flex flex-col items-center justify-center p-8 text-center text-slate-400">
                        <div class="w-16 h-16 rounded-3xl bg-slate-100 flex items-center justify-center text-slate-400 mb-3">
                            <span class="material-symbols-outlined text-3xl">chat</span>
                        </div>
                        <h4 class="text-sm font-bold text-slate-700">Pilih Percakapan</h4>
                        <p class="text-xs text-slate-500 mt-1 max-w-sm">Pilih salah satu pesan dari daftar di sebelah kiri untuk melihat riwayat percakapan dan membalas pengguna.</p>
                    </div>
                @endif
            </div>

        </div>

    @else
        <!-- ===================================================================== -->
        <!-- REGULAR USER VIEW: DIRECT CHAT WITH ADMINISTRATOR / HELPDESK -->
        <!-- ===================================================================== -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- LEFT/TOP INFO CARD: IT HELPDESK OVERVIEW (lg:col-span-4) -->
            <div class="lg:col-span-4 space-y-4">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-5">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-700 to-brand-900 text-white flex items-center justify-center font-bold text-xl shadow-subtle shrink-0">
                            <span class="material-symbols-outlined text-2xl">support_agent</span>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Helpdesk IT Administrator</h3>
                            <p class="text-[11px] text-slate-500">Tim Dukungan Teknis &amp; Kurikulum</p>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-brand-50/70 border border-brand-100 text-xs text-brand-950 space-y-1.5">
                        <div class="flex items-center gap-1.5 font-bold text-brand-900">
                            <span class="material-symbols-outlined text-sm">verified</span>
                            <span>Saluran Komunikasi Resmi</span>
                        </div>
                        <p class="text-[11px] text-slate-600 leading-relaxed">
                            Gunakan halaman ini untuk berkonsultasi mengenai perumusan silabus, kendala login/akses akun, permintaan bantuan teknis, maupun pengajuan modul pembelajaran.
                        </p>
                    </div>

                    <!-- Administrator Contact Details -->
                    <div class="space-y-3 pt-1 border-t border-slate-100 text-xs">
                        <div class="flex items-center justify-between text-slate-600">
                            <span class="text-slate-400">Status Tiket Anda:</span>
                            <span class="inline-flex items-center gap-1 font-bold {{ $activeThread->isOpen() ? 'text-emerald-700' : 'text-slate-500' }}">
                                <span class="w-2 h-2 rounded-full {{ $activeThread->isOpen() ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                <span>{{ $activeThread->isOpen() ? 'Sesi Aktif' : 'Telah Selesai' }}</span>
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span class="text-slate-400">Total Pesan:</span>
                            <span class="font-semibold text-slate-800">{{ $messages->count() }} pesan terkirim</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span class="text-slate-400">Email IT Yayasan:</span>
                            <span class="font-medium text-brand-800">admin@alimasykur.sch.id</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span class="text-slate-400">Respon Rata-rata:</span>
                            <span class="font-medium text-emerald-700">&lt; 15 Menit di Jam Kerja</span>
                        </div>
                    </div>

                    <!-- Quick Topic Suggestions -->
                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Contoh Topik Konsultasi:</span>
                        <div class="flex flex-wrap gap-1.5">
                            <button type="button" onclick="insertSuggestion('Halo Admin, mohon bantuan cek verifikasi usulan CP mapel saya.')" 
                                    class="px-2.5 py-1 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-medium transition-all text-left cursor-pointer">
                                Verifikasi Usulan CP
                            </button>
                            <button type="button" onclick="insertSuggestion('Halo Admin, saya mengalami kendala saat mengunggah modul ajar (format PDF).')" 
                                    class="px-2.5 py-1 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-medium transition-all text-left cursor-pointer">
                                Kendala Unggah Modul
                            </button>
                            <button type="button" onclick="insertSuggestion('Halo Admin, ada revisi alokasi jam tatap muka untuk kelas binaan kami.')" 
                                    class="px-2.5 py-1 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-medium transition-all text-left cursor-pointer">
                                Alokasi Jam Tatap Muka
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT/MAIN CHAT BOX: CONVERSATION WITH ADMIN (lg:col-span-8) -->
            <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-100 shadow-card flex flex-col h-[740px] overflow-hidden">
                <!-- Chat Header -->
                <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-700 to-brand-900 text-white flex items-center justify-center font-bold text-sm shadow-subtle">
                                <span class="material-symbols-outlined text-xl">admin_panel_settings</span>
                            </div>
                            <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-500 border-2 border-white"></span>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-slate-900">Administrator IT Yayasan</h3>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Resmi &amp; Terverifikasi
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-500">Siap melayani kebutuhan bimbingan dan kendala sistem Anda</p>
                        </div>
                    </div>

                    <div class="text-right">
                        <span class="text-[11px] text-slate-400">Unit Anda:</span>
                        <span class="block text-xs font-bold text-slate-800">{{ $currentUser->unit->nama_unit ?? 'Yayasan Alfa' }}</span>
                    </div>
                </div>

                <!-- Messages Timeline Container -->
                <div id="chat-messages-container" class="flex-1 p-4 sm:p-6 overflow-y-auto space-y-4 bg-slate-50/30">
                    @include('helpdesk._messages_list', ['messages' => $messages, 'activeThread' => $activeThread, 'currentUser' => $currentUser])
                </div>

                <!-- User Message Input Form with File Attachment -->
                <div class="p-3 sm:p-4 border-t border-slate-100 bg-white">
                    <form id="chat-send-form" action="{{ route('helpdesk.send', $activeThread->id) }}" method="POST" enctype="multipart/form-data" class="space-y-2.5">
                        @csrf

                        <!-- Attachment Preview Pill -->
                        <div id="attachment-preview-container" class="hidden items-center justify-between p-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs">
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="material-symbols-outlined text-brand-700 text-base" id="preview-file-icon">attach_file</span>
                                <span class="font-semibold text-slate-800 truncate" id="preview-file-name">filename.pdf</span>
                                <span class="text-slate-400 text-[11px]" id="preview-file-size">(0 KB)</span>
                            </div>
                            <button type="button" onclick="clearAttachment()" class="text-slate-400 hover:text-rose-600 transition-colors cursor-pointer p-1">
                                <span class="material-symbols-outlined text-base">close</span>
                            </button>
                        </div>

                        <div class="flex items-end gap-2">
                            <!-- Attachment Button -->
                            <label for="chat-file-input" 
                                   class="shrink-0 p-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-brand-800 border border-slate-200/80 transition-all cursor-pointer flex items-center justify-center" 
                                   title="Lampirkan Dokumen atau Gambar (PDF, DOCX, XLSX, PNG, JPG, ZIP max 25MB)">
                                <span class="material-symbols-outlined text-lg">attach_file</span>
                            </label>
                            <input type="file" id="chat-file-input" name="lampiran" 
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.txt,.zip,.rar,.png,.jpg,.jpeg,.webp" 
                                   class="hidden" onchange="handleFileChosen(this)">

                            <!-- Text Message Input -->
                            <div class="flex-1 relative">
                                <textarea name="pesan" id="chat-message-input" rows="1" 
                                          placeholder="Ketik pertanyaan atau kendala Anda di sini..." 
                                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 transition-all resize-none max-h-32 leading-relaxed"
                                          onkeydown="handleTextareaKeydown(event)"></textarea>
                            </div>

                            <!-- Send Button -->
                            <button type="submit" id="chat-send-btn" 
                                    class="shrink-0 px-4 py-2.5 rounded-2xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all flex items-center gap-1.5 cursor-pointer">
                                <span>Kirim</span>
                                <span class="material-symbols-outlined text-base">send</span>
                            </button>
                        </div>

                        <div class="flex items-center justify-between text-[10px] text-slate-400 px-1">
                            <span>Mendukung lampiran dokumen kurikulum (PDF, Word, Excel) &amp; tangkapan layar (Maks. 25 MB)</span>
                            <span>Tekan Shift+Enter untuk baris baru</span>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    @endif

</div>

<!-- IMAGE LIGHTBOX MODAL -->
<div id="image-lightbox-modal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm hidden items-center justify-center p-4" onclick="closeImageLightbox()">
    <div class="relative max-w-4xl max-h-[90vh] flex flex-col items-center" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between w-full pb-3 text-white">
            <span class="text-xs font-semibold truncate" id="lightbox-filename">Pratinjau Gambar</span>
            <div class="flex items-center gap-3">
                <a id="lightbox-download-link" href="#" target="_blank" class="text-white/80 hover:text-white text-xs flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">download</span>
                    <span>Unduh</span>
                </a>
                <button type="button" onclick="closeImageLightbox()" class="text-white/80 hover:text-white cursor-pointer">
                    <span class="material-symbols-outlined text-2xl">close</span>
                </button>
            </div>
        </div>
        <img id="lightbox-image" src="" alt="Pratinjau" class="max-w-full max-h-[80vh] rounded-2xl object-contain shadow-2xl border border-white/10">
    </div>
</div>

<script>
    // Scroll chat to bottom on page load
    const chatContainer = document.getElementById('chat-messages-container');
    if (chatContainer) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    // Auto-expand textarea
    const messageInput = document.getElementById('chat-message-input');
    if (messageInput) {
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });
    }

    function handleTextareaKeydown(event) {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            document.getElementById('chat-send-form').submit();
        }
    }

    function insertSuggestion(text) {
        if (messageInput) {
            messageInput.value = text;
            messageInput.focus();
            messageInput.style.height = 'auto';
            messageInput.style.height = Math.min(messageInput.scrollHeight, 120) + 'px';
        }
    }

    // Attachment file handling
    function handleFileChosen(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
            const sizeFormatted = sizeInMB > 1 ? sizeInMB + ' MB' : (file.size / 1024).toFixed(1) + ' KB';

            document.getElementById('preview-file-name').innerText = file.name;
            document.getElementById('preview-file-size').innerText = '(' + sizeFormatted + ')';

            // Choose icon
            const ext = file.name.split('.').pop().toLowerCase();
            const iconElem = document.getElementById('preview-file-icon');
            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                iconElem.innerText = 'image';
            } else if (ext === 'pdf') {
                iconElem.innerText = 'picture_as_pdf';
            } else if (['doc', 'docx'].includes(ext)) {
                iconElem.innerText = 'description';
            } else if (['xls', 'xlsx', 'csv'].includes(ext)) {
                iconElem.innerText = 'table_chart';
            } else {
                iconElem.innerText = 'attach_file';
            }

            document.getElementById('attachment-preview-container').classList.remove('hidden');
            document.getElementById('attachment-preview-container').classList.add('flex');
        }
    }

    function clearAttachment() {
        const input = document.getElementById('chat-file-input');
        if (input) input.value = '';
        const preview = document.getElementById('attachment-preview-container');
        if (preview) {
            preview.classList.add('hidden');
            preview.classList.remove('flex');
        }
    }

    // Image lightbox
    function openImageLightbox(url, filename) {
        const modal = document.getElementById('image-lightbox-modal');
        const img = document.getElementById('lightbox-image');
        const nameElem = document.getElementById('lightbox-filename');
        const dlLink = document.getElementById('lightbox-download-link');

        if (img) img.src = url;
        if (nameElem) nameElem.innerText = filename || 'Pratinjau Gambar';
        if (dlLink) dlLink.href = url;

        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeImageLightbox() {
        const modal = document.getElementById('image-lightbox-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // Polling for live updates every 5 seconds
    @if($activeThread)
        let lastMessageId = {{ $messages->last()?->id ?? 0 }};
        const activeThreadId = {{ $activeThread->id }};

        setInterval(function() {
            fetch(`{{ url('/bantuan/chat') }}/${activeThreadId}/poll?after_id=${lastMessageId}`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.messages && data.messages.length > 0) {
                    data.messages.forEach(msg => {
                        lastMessageId = Math.max(lastMessageId, msg.id);
                        appendLiveMessage(msg);
                    });
                    if (chatContainer) {
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                    }
                }
            })
            .catch(err => console.debug('Poll check idle'));
        }, 5000);

        function appendLiveMessage(msg) {
            const isMe = msg.is_me;
            const bubbleWrapper = document.createElement('div');
            bubbleWrapper.className = `flex ${isMe ? 'justify-end' : 'justify-start'} items-end gap-2.5`;

            let attachmentHtml = '';
            if (msg.has_file) {
                if (msg.is_image) {
                    attachmentHtml = `
                        <div class="mt-2 rounded-2xl overflow-hidden border border-white/20 max-w-xs cursor-pointer" 
                             onclick="openImageLightbox('${msg.file_url}', '${msg.file_name}')">
                            <img src="${msg.file_url}" alt="${msg.file_name}" class="w-full h-auto object-cover max-h-56 hover:opacity-90 transition-opacity">
                        </div>
                    `;
                } else {
                    attachmentHtml = `
                        <div class="mt-2.5 p-2.5 rounded-2xl ${isMe ? 'bg-white/10 border border-white/20' : 'bg-slate-50 border border-slate-200'} flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="material-symbols-outlined text-lg ${isMe ? 'text-white' : 'text-brand-700'}">${msg.file_badge.icon || 'attach_file'}</span>
                                <div class="min-w-0">
                                    <div class="text-xs font-semibold truncate ${isMe ? 'text-white' : 'text-slate-800'}">${msg.file_name}</div>
                                    <div class="text-[10px] ${isMe ? 'text-white/70' : 'text-slate-400'}">${msg.file_size}</div>
                                </div>
                            </div>
                            <a href="${msg.download_url}" class="p-1.5 rounded-xl ${isMe ? 'bg-white/20 hover:bg-white/30 text-white' : 'bg-brand-50 hover:bg-brand-100 text-brand-800'} transition-all shrink-0">
                                <span class="material-symbols-outlined text-sm">download</span>
                            </a>
                        </div>
                    `;
                }
            }

            let textHtml = msg.pesan ? `<p class="text-xs leading-relaxed whitespace-pre-wrap">${msg.pesan}</p>` : '';

            if (isMe) {
                bubbleWrapper.innerHTML = `
                    <div class="max-w-md sm:max-w-lg space-y-1 text-right">
                        <div class="inline-block p-4 rounded-3xl rounded-br-none bg-gradient-to-r from-brand-800 to-brand-900 text-white shadow-card text-left">
                            ${textHtml}
                            ${attachmentHtml}
                        </div>
                        <div class="flex items-center justify-end gap-1.5 text-[10px] text-slate-400 pr-1">
                            <span>${msg.created_at}</span>
                            <span class="material-symbols-outlined text-xs text-brand-700">done_all</span>
                        </div>
                    </div>
                `;
            } else {
                bubbleWrapper.innerHTML = `
                    <div class="w-8 h-8 rounded-2xl bg-gradient-to-br from-brand-700 to-brand-900 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                        ${msg.sender_name.charAt(0)}
                    </div>
                    <div class="max-w-md sm:max-w-lg space-y-1">
                        <span class="text-[10px] font-semibold text-slate-500 pl-1 block">${msg.sender_name}</span>
                        <div class="inline-block p-4 rounded-3xl rounded-bl-none bg-white text-slate-800 border border-slate-100 shadow-card">
                            ${textHtml}
                            ${attachmentHtml}
                        </div>
                        <div class="text-[10px] text-slate-400 pl-1">${msg.created_at}</div>
                    </div>
                `;
            }

            chatContainer.appendChild(bubbleWrapper);
        }
    @endif
</script>
@endsection

