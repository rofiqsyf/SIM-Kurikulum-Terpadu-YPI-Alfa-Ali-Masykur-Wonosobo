@extends('layouts.app')

@section('title', 'Panduan SOP & Pusat Bantuan')

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
                    <span>Dokumentasi Resmi</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-medium text-slate-700">SOP-KUR-01</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-semibold text-brand-800">Panduan Akademik</span>
                </div>

                <div class="flex items-center gap-2 self-end sm:self-center text-xs font-semibold text-slate-500 bg-white px-3.5 py-1.5 rounded-2xl border border-slate-100 shadow-subtle shrink-0">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                    <span>Versi SOP 2024.1 Terpadu</span>
                </div>
            </div>

            <!-- HERO OVERVIEW CARD -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative">
                <div class="space-y-3 max-w-xl z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-600"></span>
                        <span>SOP-KUR-01 • Tata Kelola Kurikulum</span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 leading-tight">
                        Pusat Panduan &amp; Bantuan Pendidik
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Standar operasional prosedur pengajuan usulan, formulasi Taksonomi Bloom (C1-C6), telaah Kepala Madrasah/Sekolah, dan pengesahan kurikulum terpadu.
                    </p>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <a href="#sop-flow" 
                           class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all">
                            <span class="material-symbols-outlined text-base">sync_alt</span>
                            <span>Alur 4 Tahap</span>
                        </a>
                        <a href="#faq-section" 
                           class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                            <span class="material-symbols-outlined text-base text-slate-500">help_outline</span>
                            <span>Tanya Jawab (FAQ)</span>
                        </a>
                    </div>
                </div>

                <!-- 3D Isometric Book Graphic -->
                <div class="shrink-0 flex items-center justify-center md:pr-4">
                    <svg class="w-36 h-32 sm:w-44 sm:h-38 drop-shadow-sm select-none" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M40 120 L120 160 L200 120 L120 80 Z" fill="#4338ca" />
                        <path d="M40 120 L40 135 L120 175 L120 160 Z" fill="#312e81" />
                        <path d="M120 160 L120 175 L200 135 L200 120 Z" fill="#3730a3" />
                        <path d="M44 121 L44 130 L118 168 L118 159 Z" fill="#eef2ff" />
                        <path d="M122 159 L122 168 L196 130 L196 121 Z" fill="#e0e7ff" />

                        <path d="M50 95 L120 130 L190 95 L120 60 Z" fill="#3b82f6" />
                        <path d="M50 95 L50 108 L120 143 L120 130 Z" fill="#1d4ed8" />
                        <path d="M120 130 L120 143 L190 108 L190 95 Z" fill="#2563eb" />
                        <path d="M54 96 L54 104 L118 137 L118 129 Z" fill="#eff6ff" />
                        <path d="M122 129 L122 137 L186 104 L186 96 Z" fill="#dbeafe" />

                        <path d="M70 65 L130 95 L180 70 L120 40 Z" fill="#ffffff" stroke="#e2e8f0" stroke-width="1.5" />
                        <path d="M70 65 L70 70 L130 100 L130 95 Z" fill="#cbd5e1" />
                        <path d="M130 95 L130 100 L180 75 L180 70 Z" fill="#94a3b8" />
                        <circle cx="95" cy="62" r="2.5" fill="#4338ca" />
                        <line x1="103" y1="62" x2="140" y2="53" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                        <circle cx="103" cy="68" r="2.5" fill="#4338ca" />
                        <line x1="111" y1="68" x2="148" y2="59" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
            </div>

            <!-- 4-STEP SOP WORKFLOW (INTERACTIVE) -->
            <div id="sop-flow" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-card space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-brand-700 text-xl">sync_alt</span>
                        <div>
                            <h2 class="text-sm font-bold text-slate-900">Alur 4 Tahap Pengajuan Usulan Kurikulum</h2>
                            <p class="text-[11px] text-slate-500">Klik setiap tahapan untuk melihat pedoman operasional dan dokumen prasyarat</p>
                        </div>
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 hidden sm:inline">SOP Baku Terpadu</span>
                </div>

                <!-- 4 Interactive Step Buttons -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Step 1 -->
                    <button type="button" onclick="selectSopStep(1)" id="sop-step-btn-1" 
                            class="sop-step-card text-left p-5 rounded-2xl bg-brand-50/60 border-2 border-brand-800 space-y-2 transition-all shadow-subtle cursor-pointer">
                        <div class="flex items-center justify-between">
                            <div class="w-8 h-8 rounded-xl bg-brand-800 text-white font-extrabold text-xs flex items-center justify-center">
                                1
                            </div>
                            <span class="material-symbols-outlined text-brand-800 text-sm">touch_app</span>
                        </div>
                        <h3 class="text-xs font-bold text-slate-900">Perumusan Sasaran TP</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Analisis CP nasional &amp; integrasi nilai kepesantrenan.
                        </p>
                    </button>

                    <!-- Step 2 -->
                    <button type="button" onclick="selectSopStep(2)" id="sop-step-btn-2" 
                            class="sop-step-card text-left p-5 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-slate-300 space-y-2 transition-all cursor-pointer">
                        <div class="flex items-center justify-between">
                            <div class="w-8 h-8 rounded-xl bg-slate-900 text-white font-extrabold text-xs flex items-center justify-center">
                                2
                            </div>
                            <span class="material-symbols-outlined text-slate-400 text-sm">touch_app</span>
                        </div>
                        <h3 class="text-xs font-bold text-slate-900">Kirim Usulan di Portal</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Input form digital, alokasi JP, dan media ajar.
                        </p>
                    </button>

                    <!-- Step 3 -->
                    <button type="button" onclick="selectSopStep(3)" id="sop-step-btn-3" 
                            class="sop-step-card text-left p-5 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-slate-300 space-y-2 transition-all cursor-pointer">
                        <div class="flex items-center justify-between">
                            <div class="w-8 h-8 rounded-xl bg-slate-900 text-white font-extrabold text-xs flex items-center justify-center">
                                3
                            </div>
                            <span class="material-symbols-outlined text-slate-400 text-sm">touch_app</span>
                        </div>
                        <h3 class="text-xs font-bold text-slate-900">Telaah Waka &amp; Pengesahan</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Validasi teknis Waka Kurikulum &amp; Kepsek (SLA 2-3 hari).
                        </p>
                    </button>

                    <!-- Step 4 -->
                    <button type="button" onclick="selectSopStep(4)" id="sop-step-btn-4" 
                            class="sop-step-card text-left p-5 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-slate-300 space-y-2 transition-all cursor-pointer">
                        <div class="flex items-center justify-between">
                            <div class="w-8 h-8 rounded-xl bg-slate-900 text-white font-extrabold text-xs flex items-center justify-center">
                                4
                            </div>
                            <span class="material-symbols-outlined text-slate-400 text-sm">touch_app</span>
                        </div>
                        <h3 class="text-xs font-bold text-slate-900">Sinkronisasi Silabus</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Pengesahan otomatis ke kurikulum master semester aktif.
                        </p>
                    </button>
                </div>

                <!-- Dynamic Step Details Card -->
                <div id="sop-step-detail" class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-3">
                    <div class="flex items-center justify-between text-xs">
                        <span id="step-detail-tag" class="px-2.5 py-0.5 rounded-full font-bold bg-brand-100 text-brand-900 text-[10px]">
                            Tahap 1 • Guru Pendidik
                        </span>
                        <span id="step-detail-sla" class="text-slate-500 font-semibold text-[11px]">
                            Durasi: Pekan 1 - 4 Awal Semester
                        </span>
                    </div>
                    <h4 id="step-detail-title" class="text-sm font-bold text-slate-900">
                        Perumusan Sasaran Tujuan Pembelajaran (TP) &amp; Materi
                    </h4>
                    <p id="step-detail-desc" class="text-xs text-slate-600 leading-relaxed">
                        Guru menganalisis Capaian Pembelajaran (CP) nasional dari Kemendikbudristek/Kemenag. Rumuskan sasaran TP yang terukur menggunakan Kata Kerja Operasional (KKO) Taksonomi Bloom (C1-C6) dan masukkan integrasi muatan lokal kepesantrenan Ali Masykur.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 text-[11px]">
                        <div class="p-3 bg-white rounded-xl border border-slate-200/70">
                            <strong class="text-slate-800 block mb-0.5">Dokumen &amp; Masukan:</strong>
                            <span id="step-detail-input" class="text-slate-500">Capaian Pembelajaran (CP), Panduan KKO Bloom, Kitab Muatan Pesantren.</span>
                        </div>
                        <div class="p-3 bg-white rounded-xl border border-slate-200/70">
                            <strong class="text-slate-800 block mb-0.5">Hasil Akhir (Output):</strong>
                            <span id="step-detail-output" class="text-slate-500">Draf TP dengan alokasi Jam Pelajaran (JP) dan media pembelajaran terencana.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PEDAGOGICAL GUIDELINES & BLOOM TAXONOMY -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-card space-y-4">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                    <span class="material-symbols-outlined text-brand-700 text-xl">psychology</span>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Panduan Taksonomi Bloom &amp; Rasional Pedagogis</h3>
                        <p class="text-xs text-slate-500">Pedoman verifikasi Kepala Sekolah dalam menilai kualitas kompetensi santri</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5 hover:border-slate-300 transition-colors">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-slate-900 block text-xs">Tingkat C1 – C2</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-200 text-slate-700">Dasar (LOTS)</span>
                        </div>
                        <span class="text-brand-800 font-semibold text-[11px] block">Mengingat &amp; Memahami</span>
                        <p class="text-slate-500 leading-relaxed mt-1">
                            Cocok untuk hafalan kaidah, definisi kosakata Arab/Inggris, dan pembacaan teks dasar di awal semester.
                        </p>
                        <div class="pt-2 text-[10px] text-slate-400">
                            <strong>KKO:</strong> Mengidentifikasi, Menyebutkan, Menjelaskan, Mengartikan.
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5 hover:border-slate-300 transition-colors">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-slate-900 block text-xs">Tingkat C3 – C4</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">Menengah (MOTS)</span>
                        </div>
                        <span class="text-brand-800 font-semibold text-[11px] block">Menerapkan &amp; Menganalisis</span>
                        <p class="text-slate-500 leading-relaxed mt-1">
                            Contoh: Menghitung zakat perniagaan kontekstual, analisis studi kasus fikih, dan operasi matematika pecahan.
                        </p>
                        <div class="pt-2 text-[10px] text-slate-400">
                            <strong>KKO:</strong> Menerapkan, Memecahkan, Menganalisis, Mengkategorikan.
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5 hover:border-slate-300 transition-colors">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-slate-900 block text-xs">Tingkat C5 – C6</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Tinggi (HOTS)</span>
                        </div>
                        <span class="text-brand-800 font-semibold text-[11px] block">Mengevaluasi &amp; Mencipta</span>
                        <p class="text-slate-500 leading-relaxed mt-1">
                            Merancang karya projek P5-RA, menyusun esai kritis, karya ilmiah santri, dan pemecahan masalah multidisiplin.
                        </p>
                        <div class="pt-2 text-[10px] text-slate-400">
                            <strong>KKO:</strong> Menilai, Mengkritisi, Merancang, Mengkreasi, Memproduksi.
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ SECTION (INTERACTIVE ACCORDION) -->
            <div id="faq-section" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-card space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-700 text-xl">help_outline</span>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Pertanyaan yang Sering Diajukan (FAQ)</h3>
                            <p class="text-xs text-slate-500">Klik pertanyaan untuk membuka penjelasan lengkap</p>
                        </div>
                    </div>

                    <div class="relative w-full sm:w-64">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base">search</span>
                        <input type="text" id="faq-search" oninput="filterFAQ(this.value)"
                               placeholder="Cari pertanyaan FAQ..." 
                               class="w-full pl-9 pr-3 py-1.5 bg-slate-50 border border-slate-200/90 rounded-xl text-xs placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-700 shadow-subtle transition-all">
                    </div>
                </div>

                <div class="space-y-2.5" id="faq-list">
                    <!-- FAQ 1 -->
                    <div class="faq-item bg-slate-50/70 border border-slate-100 rounded-2xl overflow-hidden transition-all">
                        <button type="button" onclick="toggleFaq(this)" class="faq-toggle w-full p-4 text-left flex items-center justify-between gap-3 cursor-pointer select-none">
                            <span class="text-xs font-bold text-slate-900 flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-brand-100 text-brand-800 text-[11px] font-black flex items-center justify-center shrink-0">1</span>
                                <span>Kapan batas waktu pengajuan perubahan TP dan Alokasi JP diperbolehkan?</span>
                            </span>
                            <span class="material-symbols-outlined text-slate-400 text-base transform transition-transform duration-200 rotate-180 faq-chevron">expand_more</span>
                        </button>
                        <div class="faq-content px-4 pb-4 pt-1 text-xs text-slate-600 leading-relaxed border-t border-slate-100/80">
                            Pengajuan usulan kurikulum dibuka selama 4 pekan pertama setiap awal semester. Untuk semester ganjil tahun ajaran berjalan, batas peninjauan adalah tanggal 28 Oktober 2026. Di luar jendela waktu ini, kurikulum dikunci untuk menjamin stabilitas administrasi kegiatan belajar mengajar santri.
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="faq-item bg-slate-50/70 border border-slate-100 rounded-2xl overflow-hidden transition-all">
                        <button type="button" onclick="toggleFaq(this)" class="faq-toggle w-full p-4 text-left flex items-center justify-between gap-3 cursor-pointer select-none">
                            <span class="text-xs font-bold text-slate-900 flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-brand-100 text-brand-800 text-[11px] font-black flex items-center justify-center shrink-0">2</span>
                                <span>Mengapa usulan pemadatan alokasi JP sering mendapatkan penolakan verifikator?</span>
                            </span>
                            <span class="material-symbols-outlined text-slate-400 text-base transform transition-transform duration-200 faq-chevron">expand_more</span>
                        </button>
                        <div class="faq-content px-4 pb-4 pt-1 text-xs text-slate-600 leading-relaxed border-t border-slate-100/80 hidden">
                            Pemadatan waktu (misal dari 6 JP menjadi 2 JP) berpotensi menurunkan daya serap santri terhadap kompetensi dasar. Sebagaimana pada catatan evaluasi Kepala Sekolah di TP-7.4, pemadatan wajib disertai rasional pedagogis terukur sesuai Taksonomi Bloom (C1-C6) serta lampiran modul ajar mandiri santri.
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="faq-item bg-slate-50/70 border border-slate-100 rounded-2xl overflow-hidden transition-all">
                        <button type="button" onclick="toggleFaq(this)" class="faq-toggle w-full p-4 text-left flex items-center justify-between gap-3 cursor-pointer select-none">
                            <span class="text-xs font-bold text-slate-900 flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-brand-100 text-brand-800 text-[11px] font-black flex items-center justify-center shrink-0">3</span>
                                <span>Apa yang harus saya lakukan jika usulan kurikulum saya ditolak atau perlu revisi?</span>
                            </span>
                            <span class="material-symbols-outlined text-slate-400 text-base transform transition-transform duration-200 faq-chevron">expand_more</span>
                        </button>
                        <div class="faq-content px-4 pb-4 pt-1 text-xs text-slate-600 leading-relaxed border-t border-slate-100/80 hidden">
                            Buka menu "Riwayat Usulan" atau "Pohon Mapel", lihat catatan evaluasi dari Kepala Sekolah, lalu klik tombol "Ajukan Revisi". Formulir akan terisi otomatis dan Anda dapat menyempurnakan rasional pedagogis serta alokasi JP sesuai arahan verifikator.
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="faq-item bg-slate-50/70 border border-slate-100 rounded-2xl overflow-hidden transition-all">
                        <button type="button" onclick="toggleFaq(this)" class="faq-toggle w-full p-4 text-left flex items-center justify-between gap-3 cursor-pointer select-none">
                            <span class="text-xs font-bold text-slate-900 flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-brand-100 text-brand-800 text-[11px] font-black flex items-center justify-center shrink-0">4</span>
                                <span>Bagaimana keterkaitan Jurnal Mengajar Digital dengan Capaian Pembelajaran?</span>
                            </span>
                            <span class="material-symbols-outlined text-slate-400 text-base transform transition-transform duration-200 faq-chevron">expand_more</span>
                        </button>
                        <div class="faq-content px-4 pb-4 pt-1 text-xs text-slate-600 leading-relaxed border-t border-slate-100/80 hidden">
                            Jurnal Mengajar Digital berfungsi memvalidasi implementasi riil materi ajar di kelas harian. Data presensi dan materi yang diisi menjadi acuan Kepala Sekolah dan Pengurus Yayasan dalam supervisi mutu pembelajaran serta penjaminan mutu akreditasi 3 unit.
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ======================================================== -->
        <!-- RIGHT PANEL (SOP SPECIFICATIONS & CONTACT ADMIN) -->
        <!-- ======================================================== -->
        <div class="xl:col-span-4 2xl:col-span-3 space-y-6">

            <!-- 1. SOP QUICK SPECS CARD -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 space-y-3">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="material-symbols-outlined text-brand-700 text-lg">menu_book</span>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Ringkasan SOP-KUR-01</h4>
                </div>

                <div class="space-y-2 text-xs">
                    <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <span class="text-slate-500">Nomor Regulasi:</span>
                        <span class="font-bold text-slate-800">SOP-KUR-01/YPI/2024</span>
                    </div>

                    <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <span class="text-slate-500">SLA Telaah Kepala:</span>
                        <span class="font-bold text-brand-800">Maks. 3 Hari Kerja</span>
                    </div>

                    <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <span class="text-slate-500">Cakupan Lembaga:</span>
                        <span class="font-bold text-slate-800">MI, SMP, &amp; SMA</span>
                    </div>

                    <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <span class="text-slate-500">Revisi Terbuka:</span>
                        <span class="font-bold text-emerald-700">Awal Semester</span>
                    </div>
                </div>
            </div>

            <!-- 2. KONTAK ADMINISTRATOR IT -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-card p-6 text-center space-y-3">
                <div class="w-14 h-14 rounded-full bg-brand-50 text-brand-800 mx-auto flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-2xl">support_agent</span>
                </div>
                <div>
                    <h5 class="text-xs font-bold text-slate-900">Layanan Helpdesk IT</h5>
                    <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">
                        Jika mengalami kendala hak akses akun atau perumusan silabus, hubungi tim IT Yayasan.
                    </p>
                </div>
                <a href="mailto:admin@alimasykur.sch.id?subject=Bantuan%20SOP%20SIM%20Kurikulum" 
                   class="inline-block px-5 py-2 rounded-2xl bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold shadow-subtle transition-all">
                    Hubungi Administrator
                </a>
            </div>

        </div>

    </div>

</div>

<script>
    const sopStepData = {
        1: {
            tag: 'Tahap 1 • Guru Pendidik',
            sla: 'Durasi: Pekan 1 - 4 Awal Semester',
            title: 'Perumusan Sasaran Tujuan Pembelajaran (TP) & Materi',
            desc: 'Guru menganalisis Capaian Pembelajaran (CP) nasional dari Kemendikbudristek/Kemenag. Rumuskan sasaran TP yang terukur menggunakan Kata Kerja Operasional (KKO) Taksonomi Bloom (C1-C6) dan masukkan integrasi muatan lokal kepesantrenan Ali Masykur.',
            input: 'Capaian Pembelajaran (CP), Panduan KKO Bloom, Kitab Muatan Pesantren.',
            output: 'Draf TP dengan alokasi Jam Pelajaran (JP) dan media pembelajaran terencana.'
        },
        2: {
            tag: 'Tahap 2 • Guru Pengampu',
            sla: 'Durasi: 1 - 2 Hari Proses Pengisian',
            title: 'Pengajuan Usulan Digital di SIM Kurikulum',
            desc: 'Guru membuka formulir usulan kurikulum di portal, memilih tipe perubahan (TP Baru, Revisi Materi, atau Alokasi Jam), melampirkan modul ajar, dan mengisi rasional pedagogis secara terstruktur.',
            input: 'Formulir Digital Usulan, Modul Ajar, Argumentasi Akademik.',
            output: 'Nomor Registrasi Usulan Kurikulum & Tiket Review Verifikator.'
        },
        3: {
            tag: 'Tahap 3 • Waka Kurikulum & Kepala Unit',
            sla: 'SLA: Maksimal 2–3 Hari Kerja',
            title: 'Telaah Teknis Waka & Pengesahan Kepala Sekolah',
            desc: 'Waka Kurikulum unit melakukan telaah pedagogis awal (kesesuaian taksonomi Bloom C1-C6, pemetaan alur fase, kecukupan beban JP). Usulan yang telah divalidasi Waka Kurikulum disahkan bersama Kepala Sekolah/Madrasah untuk aktif di kurikulum.',
            input: 'Draf Usulan Guru, Modul Ajar, Catatan Telaah Waka Kurikulum.',
            output: 'Status Usulan: Disetujui (Approved) atau Dikembalikan untuk Revisi dengan Catatan.'
        },
        4: {
            tag: 'Tahap 4 • Sistem SIM & Yayasan',
            sla: 'Durasi: Seketika (Realtime Synchronized)',
            title: 'Sinkronisasi Otomatis ke Silabus Master & Jurnal',
            desc: 'Usulan yang telah disetujui Kepala Sekolah otomatis disahkan masuk ke Kurikulum Master Yayasan. Pohon mata pelajaran terbarui seketika dan guru dapat langsung menggunakannya dalam Jurnal Mengajar Digital harian.',
            input: 'SK Persetujuan Kepala Unit & Validasi Kurikulum Terpadu.',
            output: 'Silabus Aktif Semester, Rencana Pembelajaran Rombel, Jurnal Terintegrasi.'
        }
    };

    function selectSopStep(stepNum) {
        // Reset card styles
        for (let i = 1; i <= 4; i++) {
            const btn = document.getElementById('sop-step-btn-' + i);
            if (btn) {
                if (i === stepNum) {
                    btn.className = 'sop-step-card text-left p-5 rounded-2xl bg-brand-50/60 border-2 border-brand-800 space-y-2 transition-all shadow-subtle cursor-pointer';
                    const icon = btn.querySelector('.material-symbols-outlined');
                    if (icon) icon.className = 'material-symbols-outlined text-brand-800 text-sm';
                    const numBadge = btn.querySelector('div > div');
                    if (numBadge) numBadge.className = 'w-8 h-8 rounded-xl bg-brand-800 text-white font-extrabold text-xs flex items-center justify-center';
                } else {
                    btn.className = 'sop-step-card text-left p-5 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-slate-300 space-y-2 transition-all cursor-pointer';
                    const icon = btn.querySelector('.material-symbols-outlined');
                    if (icon) icon.className = 'material-symbols-outlined text-slate-400 text-sm';
                    const numBadge = btn.querySelector('div > div');
                    if (numBadge) numBadge.className = 'w-8 h-8 rounded-xl bg-slate-900 text-white font-extrabold text-xs flex items-center justify-center';
                }
            }
        }

        // Update detail card content
        const data = sopStepData[stepNum];
        if (data) {
            document.getElementById('step-detail-tag').textContent = data.tag;
            document.getElementById('step-detail-sla').textContent = data.sla;
            document.getElementById('step-detail-title').textContent = data.title;
            document.getElementById('step-detail-desc').textContent = data.desc;
            document.getElementById('step-detail-input').textContent = data.input;
            document.getElementById('step-detail-output').textContent = data.output;
        }
    }

    function toggleFaq(btn) {
        const item = btn.closest('.faq-item');
        const content = item.querySelector('.faq-content');
        const chevron = item.querySelector('.faq-chevron');

        const isHidden = content.classList.contains('hidden');

        // Optional: close all other items for neat accordion
        document.querySelectorAll('.faq-item').forEach(otherItem => {
            if (otherItem !== item) {
                otherItem.querySelector('.faq-content')?.classList.add('hidden');
                otherItem.querySelector('.faq-chevron')?.classList.remove('rotate-180');
            }
        });

        if (isHidden) {
            content.classList.remove('hidden');
            chevron.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            chevron.classList.remove('rotate-180');
        }
    }

    function filterFAQ(query) {
        query = query.toLowerCase().trim();
        const items = document.querySelectorAll('.faq-item');
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            if (!query || text.includes(query)) {
                item.classList.remove('hidden');
                // If user is searching, expand matching items
                if (query) {
                    item.querySelector('.faq-content')?.classList.remove('hidden');
                    item.querySelector('.faq-chevron')?.classList.add('rotate-180');
                }
            } else {
                item.classList.add('hidden');
            }
        });
    }
</script>
@endsection
