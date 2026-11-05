<!-- MODAL EDIT / TAMBAH AGENDA KALENDER (SHARED) -->
<div id="modal-agenda-backdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden transition-opacity" onclick="closeModalAgenda()"></div>
<div id="modal-agenda" class="fixed inset-y-0 right-0 w-full sm:w-[500px] bg-white z-50 shadow-floating transform translate-x-full transition-transform duration-200 ease-in-out flex flex-col justify-between overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between shrink-0 bg-slate-50/50">
        <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-2xl bg-brand-50 text-brand-800 flex items-center justify-center font-bold">
                <span class="material-symbols-outlined text-xl">event_note</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900" id="agenda-modal-title">Kelola Agenda Kalender</h3>
                <p class="text-[11px] text-slate-500">Rentang tanggal, warna penanda, dan catatan agenda</p>
            </div>
        </div>
        <button type="button" onclick="closeModalAgenda()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
            <span class="material-symbols-outlined text-xl">close</span>
        </button>
    </div>

    <!-- Form Body -->
    <form id="agenda-calendar-form" onsubmit="handleSaveAgenda(event)" class="flex-1 overflow-y-auto p-6 space-y-4 text-xs">
        @csrf
        <input type="hidden" id="agenda-input-id" name="id" value="">

        <!-- Judul Agenda -->
        <div>
            <label class="block font-bold text-slate-700 mb-1">Judul Agenda <span class="text-rose-500">*</span></label>
            <input type="text" id="agenda-input-judul" name="judul" required placeholder="Contoh: Koreksi Asesmen Sumatif, Rapat Koordinasi Kurikulum..."
                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 text-xs text-slate-800">
        </div>

        <!-- Kategori & Prioritas -->
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block font-bold text-slate-700 mb-1">Kategori</label>
                <select id="agenda-input-kategori" name="kategori" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 text-xs font-semibold text-slate-700">
                    <option value="kbm">KBM &amp; Mengajar</option>
                    <option value="administrasi">Silabus &amp; Modul</option>
                    <option value="penilaian">Penilaian &amp; Koreksi</option>
                    <option value="bimbingan">Bimbingan Santri</option>
                    <option value="rapat">Rapat &amp; Koordinasi</option>
                    <option value="umum">Agenda Umum</option>
                </select>
            </div>
            <div>
                <label class="block font-bold text-slate-700 mb-1">Prioritas</label>
                <select id="agenda-input-prioritas" name="prioritas" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 text-xs font-semibold text-slate-700">
                    <option value="tinggi">Prioritas Tinggi</option>
                    <option value="sedang" selected>Prioritas Sedang</option>
                    <option value="rendah">Prioritas Rendah</option>
                </select>
            </div>
        </div>

        <!-- Rentang Tanggal: Tanggal Mulai s.d. Tanggal Selesai -->
        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70 space-y-2.5">
            <span class="text-[11px] font-bold text-slate-700 uppercase tracking-wider block">Rentang Tanggal Pelaksanaan</span>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-semibold text-slate-500 mb-1">Mulai Dari</label>
                    <input type="date" id="agenda-input-mulai" name="tanggal_mulai" required
                           class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-brand-700 text-xs text-slate-800">
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-slate-500 mb-1">Sampai Dengan (Deadline)</label>
                    <input type="date" id="agenda-input-selesai" name="tanggal_selesai" required
                           class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-brand-700 text-xs text-slate-800">
                </div>
            </div>
            <div class="flex items-center gap-1.5 text-[10px] text-amber-800 bg-amber-50/80 p-2 rounded-xl border border-amber-200/60">
                <span class="material-symbols-outlined text-xs shrink-0 text-amber-700">notifications_active</span>
                <span>Sistem otomatis mengirimkan notifikasi saat agenda mencapai batas waktu (deadline).</span>
            </div>
        </div>

        <!-- Pilihan Warna Penanda Kalender -->
        <div>
            <label class="block font-bold text-slate-700 mb-1.5">Pilihan Warna Penanda di Kalender</label>
            <div class="flex items-center gap-2.5 flex-wrap" id="agenda-color-palette">
                <label class="cursor-pointer flex items-center gap-1.5 p-1 rounded-xl hover:bg-slate-50 transition-colors" title="Biru">
                    <input type="radio" name="warna" value="#2563eb" class="sr-only peer" checked>
                    <span class="w-6 h-6 rounded-full bg-[#2563eb] inline-flex items-center justify-center text-white peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-[#2563eb] transition-all shadow-subtle">
                        <span class="material-symbols-outlined text-[10px] opacity-0 peer-checked:opacity-100">check</span>
                    </span>
                    <span class="text-[11px] text-slate-600 font-medium">Biru</span>
                </label>

                <label class="cursor-pointer flex items-center gap-1.5 p-1 rounded-xl hover:bg-slate-50 transition-colors" title="Hijau">
                    <input type="radio" name="warna" value="#059669" class="sr-only peer">
                    <span class="w-6 h-6 rounded-full bg-[#059669] inline-flex items-center justify-center text-white peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-[#059669] transition-all shadow-subtle">
                        <span class="material-symbols-outlined text-[10px] opacity-0 peer-checked:opacity-100">check</span>
                    </span>
                    <span class="text-[11px] text-slate-600 font-medium">Hijau</span>
                </label>

                <label class="cursor-pointer flex items-center gap-1.5 p-1 rounded-xl hover:bg-slate-50 transition-colors" title="Ungu">
                    <input type="radio" name="warna" value="#7c3aed" class="sr-only peer">
                    <span class="w-6 h-6 rounded-full bg-[#7c3aed] inline-flex items-center justify-center text-white peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-[#7c3aed] transition-all shadow-subtle">
                        <span class="material-symbols-outlined text-[10px] opacity-0 peer-checked:opacity-100">check</span>
                    </span>
                    <span class="text-[11px] text-slate-600 font-medium">Ungu</span>
                </label>

                <label class="cursor-pointer flex items-center gap-1.5 p-1 rounded-xl hover:bg-slate-50 transition-colors" title="Amber">
                    <input type="radio" name="warna" value="#d97706" class="sr-only peer">
                    <span class="w-6 h-6 rounded-full bg-[#d97706] inline-flex items-center justify-center text-white peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-[#d97706] transition-all shadow-subtle">
                        <span class="material-symbols-outlined text-[10px] opacity-0 peer-checked:opacity-100">check</span>
                    </span>
                    <span class="text-[11px] text-slate-600 font-medium">Amber</span>
                </label>

                <label class="cursor-pointer flex items-center gap-1.5 p-1 rounded-xl hover:bg-slate-50 transition-colors" title="Merah">
                    <input type="radio" name="warna" value="#e11d48" class="sr-only peer">
                    <span class="w-6 h-6 rounded-full bg-[#e11d48] inline-flex items-center justify-center text-white peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-[#e11d48] transition-all shadow-subtle">
                        <span class="material-symbols-outlined text-[10px] opacity-0 peer-checked:opacity-100">check</span>
                    </span>
                    <span class="text-[11px] text-slate-600 font-medium">Merah</span>
                </label>

                <label class="cursor-pointer flex items-center gap-1.5 p-1 rounded-xl hover:bg-slate-50 transition-colors" title="Teal">
                    <input type="radio" name="warna" value="#0d9488" class="sr-only peer">
                    <span class="w-6 h-6 rounded-full bg-[#0d9488] inline-flex items-center justify-center text-white peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-[#0d9488] transition-all shadow-subtle">
                        <span class="material-symbols-outlined text-[10px] opacity-0 peer-checked:opacity-100">check</span>
                    </span>
                    <span class="text-[11px] text-slate-600 font-medium">Teal</span>
                </label>
            </div>
        </div>

        <!-- Catatan Detail -->
        <div>
            <label class="block font-bold text-slate-700 mb-1">Catatan &amp; Detail Persiapan</label>
            <textarea id="agenda-input-catatan" name="catatan" rows="3" placeholder="Tuliskan catatan penting, persiapan perangkat, materi atau instruksi..."
                      class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 text-xs placeholder-slate-400"></textarea>
        </div>

        <!-- Status Pelaksanaan -->
        <div id="agenda-status-container">
            <label class="block font-bold text-slate-700 mb-1">Status Pelaksanaan</label>
            <select id="agenda-input-status" name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 text-xs font-semibold text-slate-700">
                <option value="belum">Belum Dikerjakan</option>
                <option value="proses">Sedang Berjalan</option>
                <option value="selesai">Selesai / Tuntas</option>
            </select>
        </div>

        <!-- Footer Buttons -->
        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
            <button type="button" id="agenda-btn-delete" onclick="handleDeleteAgenda()" class="hidden px-3.5 py-2 rounded-xl text-rose-600 hover:bg-rose-50 text-xs font-bold transition-colors cursor-pointer">
                Hapus Agenda
            </button>
            <div class="flex items-center gap-2 ml-auto">
                <button type="button" onclick="closeModalAgenda()" class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100 text-xs font-semibold transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" id="agenda-btn-submit" class="px-5 py-2 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-bold shadow-subtle transition-all cursor-pointer">
                    Simpan Agenda
                </button>
            </div>
        </div>
    </form>
</div>

