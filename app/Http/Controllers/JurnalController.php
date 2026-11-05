<?php

namespace App\Http\Controllers;

use App\Models\JurnalKerja;
use App\Models\JurnalMengajar;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\MonitoringTahfidz;
use App\Models\UnitPendidikan;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JurnalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Cek dan buat notifikasi otomatis jika ada agenda yang deadline hari ini atau telah lewat
        NotificationService::checkAndNotifyUserDeadlines($user->id);

        // Auto-seed starter agenda tasks if empty to immediately assist teachers and staff
        if (JurnalKerja::where('user_id', $user->id)->count() === 0) {
            $this->seedStarterTasksForUser($user);
        }

        // Agenda & Catatan Kerja Pengguna
        $jurnalKerjaList = JurnalKerja::where('user_id', $user->id)
            ->orderByRaw("CASE WHEN status = 'belum' THEN 1 WHEN status = 'proses' THEN 2 ELSE 3 END")
            ->orderBy('tanggal_target')
            ->get();

        $pendingKerjaCount = $jurnalKerjaList->where('status', '!=', 'selesai')->count();
        $completedKerjaCount = $jurnalKerjaList->where('status', 'selesai')->count();
        $dueTodayCount = $jurnalKerjaList->filter(fn($t) => $t->isDueToday())->count();
        $overdueCount = $jurnalKerjaList->filter(fn($t) => $t->isOverdue())->count();

        $formattedUserAgendas = $jurnalKerjaList->map(function ($t) {
            return [
                'id' => $t->id,
                'judul' => $t->judul,
                'kategori' => $t->kategori,
                'kategori_label' => $t->kategori_badge['label'] ?? ucfirst($t->kategori),
                'start' => ($t->tanggal_mulai ?? $t->tanggal_target)?->toDateString(),
                'end' => ($t->tanggal_selesai ?? $t->tanggal_target)?->toDateString(),
                'warna' => $t->warna ?: '#2563eb',
                'catatan' => $t->catatan ?? $t->catatan_refleksi ?? '',
                'prioritas' => $t->prioritas,
                'status' => $t->status,
                'is_overdue' => $t->isOverdue(),
                'is_due_today' => $t->isDueToday(),
                'is_selesai' => $t->isSelesai(),
            ];
        })->values()->toArray();

        // Jurnal Mengajar KBM di Kelas (Unit-scoped: Guru hanya melihat mandiri, Waka/Kepsek hanya melihat unitnya)
        $jurnalQuery = JurnalMengajar::with(['guru.unit', 'mataPelajaran', 'kelas'])
            ->latest('tanggal');

        if ($user->isGuru()) {
            $jurnalQuery->where('guru_id', $user->id);
        } elseif (!$user->canAccessAllUnits() && $user->unit_id) {
            $jurnalQuery->whereHas('guru', fn($q) => $q->where('unit_id', $user->unit_id));
        }

        $jurnals = $jurnalQuery->get();

        // Monitoring Setoran Tahfidz Santri (Unit-scoped)
        $tahfidzQuery = MonitoringTahfidz::with(['unit', 'penguji'])
            ->latest('tanggal_setoran');

        if (!$user->canAccessAllUnits() && $user->unit_id) {
            $tahfidzQuery->where('unit_id', $user->unit_id);
        }

        $tahfidzRecords = $tahfidzQuery->get();

        // Scoped resources for dropdowns and forms
        if (!$user->canAccessAllUnits() && $user->unit_id) {
            $mapelList = MataPelajaran::whereHas('kurikulum', fn($q) => $q->where('unit_id', $user->unit_id))->get();
            $kelasList = Kelas::whereHas('jenjang', fn($q) => $q->where('id', $user->unit?->jenjang_id))->get();
            $units = UnitPendidikan::where('id', $user->unit_id)->get();
        } else {
            $mapelList = MataPelajaran::all();
            $kelasList = Kelas::all();
            $units = UnitPendidikan::all();
        }

        // Monitoring KBM Guru Unit untuk Waka Kurikulum & Kepala Sekolah
        $guruMonitoringList = collect();
        $unitKbmStats = [
            'total_guru' => 0,
            'guru_tertib' => 0,
            'guru_perlu_pengingat' => 0,
            'total_sesi_minggu_ini' => 0,
        ];

        if (($user->isWakaKurikulum() || $user->isKepalaSekolah() || $user->isAdmin()) && $user->unit_id) {
            $unitId = $user->unit_id;
            $sevenDaysAgo = now()->subDays(7)->toDateString();

            $guruUsers = User::where('unit_id', $unitId)
                ->whereHas('peran', fn($q) => $q->where('nama_peran', 'like', '%guru%'))
                ->with(['penugasan.mataPelajaran', 'jurnalMengajar' => fn($q) => $q->latest('tanggal')])
                ->get();

            $totalGuru = $guruUsers->count();
            $tertibCount = 0;
            $pengingatCount = 0;

            $guruMonitoringList = $guruUsers->map(function ($g) use ($sevenDaysAgo, &$tertibCount, &$pengingatCount) {
                $lastJurnal = $g->jurnalMengajar->first();
                $lastDate = $lastJurnal?->tanggal ? \Carbon\Carbon::parse($lastJurnal->tanggal) : null;
                $isAktifPekanIni = $lastDate && $lastDate->gte($sevenDaysAgo);

                if ($isAktifPekanIni) {
                    $tertibCount++;
                } else {
                    $pengingatCount++;
                }

                $totalJpAssigned = $g->penugasan->sum('beban_jp');
                $totalSesiLogged = $g->jurnalMengajar->count();

                return [
                    'id' => $g->id,
                    'name' => $g->name,
                    'nip' => $g->nip ?? '-',
                    'mapel' => $g->penugasan->pluck('mataPelajaran.nama_mapel')->implode(', ') ?: 'Belum ditugaskan',
                    'beban_jp' => $totalJpAssigned,
                    'total_sesi' => $totalSesiLogged,
                    'last_kbm' => $lastDate ? $lastDate->format('d M Y') : 'Belum ada',
                    'last_materi' => $lastJurnal?->materi_diajarkan ?? '-',
                    'status' => $isAktifPekanIni ? 'Tertib KBM' : 'Perlu Pengingat',
                    'is_tertib' => $isAktifPekanIni,
                ];
            });

            $unitKbmStats = [
                'total_guru' => $totalGuru,
                'guru_tertib' => $tertibCount,
                'guru_perlu_pengingat' => $pengingatCount,
                'total_sesi_minggu_ini' => JurnalMengajar::whereHas('guru', fn($q) => $q->where('unit_id', $unitId))
                    ->where('tanggal', '>=', $sevenDaysAgo)
                    ->count(),
            ];
        }

        return view('jurnal.index', compact(
            'user',
            'jurnalKerjaList',
            'pendingKerjaCount',
            'completedKerjaCount',
            'dueTodayCount',
            'overdueCount',
            'jurnals',
            'tahfidzRecords',
            'mapelList',
            'kelasList',
            'units',
            'guruMonitoringList',
            'unitKbmStats',
            'formattedUserAgendas'
        ));
    }

    public function storeJurnalKerja(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|in:kbm,administrasi,penilaian,bimbingan,rapat,umum',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'tanggal_target' => 'nullable|date',
            'prioritas' => 'required|string|in:tinggi,sedang,rendah',
            'warna' => 'nullable|string|max:30',
            'catatan' => 'nullable|string',
            'catatan_refleksi' => 'nullable|string',
            'waktu_pengingat' => 'nullable|string|max:50',
        ]);

        $startDate = $validated['tanggal_mulai'] ?? $validated['tanggal_target'] ?? now()->toDateString();
        $endDate = $validated['tanggal_selesai'] ?? $validated['tanggal_target'] ?? $startDate;
        $targetDate = $validated['tanggal_target'] ?? $endDate;

        $task = JurnalKerja::create([
            'user_id' => $user->id,
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'tanggal_mulai' => $startDate,
            'tanggal_selesai' => $endDate,
            'tanggal_target' => $targetDate,
            'prioritas' => $validated['prioritas'],
            'status' => 'belum',
            'warna' => (!empty($validated['warna'])) ? $validated['warna'] : '#2563eb',
            'catatan' => $validated['catatan'] ?? $validated['catatan_refleksi'] ?? null,
            'catatan_refleksi' => $validated['catatan_refleksi'] ?? $validated['catatan'] ?? null,
            'waktu_pengingat' => $validated['waktu_pengingat'] ?? '08.00 WIB',
            'notif_deadline_sent' => false,
        ]);

        // Cek batas waktu langsung
        NotificationService::checkAndNotifyUserDeadlines($user->id);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Agenda di kalender berhasil dicatat.',
                'task' => $task,
            ]);
        }

        return back()->with('success', 'Agenda tugas dan catatan kerja kalender berhasil disimpan.');
    }

    public function updateJurnalKerja(Request $request, $id)
    {
        $user = Auth::user();
        $task = JurnalKerja::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|in:kbm,administrasi,penilaian,bimbingan,rapat,umum',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'tanggal_target' => 'nullable|date',
            'prioritas' => 'required|string|in:tinggi,sedang,rendah',
            'status' => 'required|string|in:belum,proses,selesai',
            'warna' => 'nullable|string|max:30',
            'catatan' => 'nullable|string',
            'catatan_refleksi' => 'nullable|string',
            'waktu_pengingat' => 'nullable|string|max:50',
        ]);

        $startDate = $validated['tanggal_mulai'] ?? $task->tanggal_mulai ?? $task->tanggal_target;
        $endDate = $validated['tanggal_selesai'] ?? $task->tanggal_selesai ?? $task->tanggal_target ?? $startDate;
        $targetDate = $validated['tanggal_target'] ?? $endDate;

        $task->update([
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'tanggal_mulai' => $startDate,
            'tanggal_selesai' => $endDate,
            'tanggal_target' => $targetDate,
            'prioritas' => $validated['prioritas'],
            'status' => $validated['status'],
            'warna' => (!empty($validated['warna'])) ? $validated['warna'] : ($task->warna ?: '#2563eb'),
            'catatan' => $validated['catatan'] ?? $validated['catatan_refleksi'] ?? $task->catatan,
            'catatan_refleksi' => $validated['catatan_refleksi'] ?? $validated['catatan'] ?? $task->catatan_refleksi,
            'waktu_pengingat' => $validated['waktu_pengingat'] ?? $task->waktu_pengingat,
            'notif_deadline_sent' => $validated['status'] === 'selesai' ? true : false,
        ]);

        NotificationService::checkAndNotifyUserDeadlines($user->id);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Agenda di kalender berhasil diperbarui.',
                'task' => $task,
            ]);
        }

        return back()->with('success', 'Agenda dan catatan kalender berhasil diperbarui.');
    }

    public function toggleJurnalKerja(Request $request, $id)
    {
        $user = Auth::user();
        $task = JurnalKerja::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $task->status = ($task->status === 'selesai') ? 'belum' : 'selesai';
        $task->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $task->status,
                'is_selesai' => $task->isSelesai(),
                'message' => $task->isSelesai() ? 'Tugas ditandai selesai! Kerja bagus.' : 'Tugas dikembalikan ke antrean aktif.',
            ]);
        }

        return back()->with('success', $task->isSelesai() ? 'Tugas kerja ditandai selesai.' : 'Tugas diaktifkan kembali.');
    }

    public function destroyJurnalKerja(Request $request, $id)
    {
        $user = Auth::user();
        $task = JurnalKerja::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $task->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Agenda berhasil dihapus dari kalender.',
            ]);
        }

        return back()->with('success', 'Agenda berhasil dihapus.');
    }

    public function getCalendarEvents(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([]);
        }

        NotificationService::checkAndNotifyUserDeadlines($user->id);

        $tasks = JurnalKerja::where('user_id', $user->id)->get();

        $events = $tasks->map(function ($t) {
            $startDate = ($t->tanggal_mulai ?? $t->tanggal_target)?->toDateString();
            $endDate = ($t->tanggal_selesai ?? $t->tanggal_target)?->toDateString();

            return [
                'id' => $t->id,
                'judul' => $t->judul,
                'kategori' => $t->kategori,
                'kategori_label' => $t->kategori_badge['label'] ?? ucfirst($t->kategori),
                'start' => $startDate,
                'end' => $endDate,
                'tanggal_mulai' => $startDate,
                'tanggal_selesai' => $endDate,
                'tanggal_target' => $t->tanggal_target?->toDateString(),
                'prioritas' => $t->prioritas,
                'status' => $t->status,
                'warna' => $t->warna ?: '#2563eb',
                'catatan' => $t->catatan ?? $t->catatan_refleksi ?? '',
                'waktu_pengingat' => $t->waktu_pengingat,
                'is_overdue' => $t->isOverdue(),
                'is_due_today' => $t->isDueToday(),
                'is_selesai' => $t->isSelesai(),
            ];
        });

        return response()->json($events);
    }

    public function triggerCheckDeadlines(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['count' => 0]);
        }

        $count = NotificationService::checkAndNotifyUserDeadlines($user->id);

        return response()->json([
            'success' => true,
            'notifications_created' => $count,
            'message' => $count > 0 ? "{$count} notifikasi batas waktu agenda telah dikirim." : 'Tidak ada agenda yang jatuh tempo baru.',
        ]);
    }

    public function storeJurnal(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'jam_ke' => 'required|string',
            'materi_diajarkan' => 'required|string',
            'catatan_kegiatan' => 'nullable|string',
            'jumlah_hadir' => 'required|integer|min:0',
            'jumlah_tidak_hadir' => 'required|integer|min:0',
        ]);

        JurnalMengajar::create(array_merge($validated, [
            'guru_id' => $user->id,
        ]));

        NotificationService::notifyKepsekAndYayasan(
            $user->unit_id,
            "Jurnal Mengajar Tercatat",
            "{$user->name} mencatat jurnal mengajar untuk materi '{$validated['materi_diajarkan']}'.",
            'jurnal_created',
            route('jurnal.index')
        );

        return back()->with('success', 'Jurnal Mengajar Harian berhasil disimpan secara digital.');
    }

    public function storeTahfidz(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'unit_id' => 'required|exists:unit_pendidikan,id',
            'nama_santri' => 'required|string',
            'kelas' => 'required|string',
            'juz' => 'required|string',
            'surat' => 'required|string',
            'ayat' => 'required|string',
            'predikat' => 'required|string',
            'catatan_mutqin' => 'nullable|string',
            'tanggal_setoran' => 'required|date',
        ]);

        if (!$user->canAccessAllUnits() && $user->unit_id) {
            $validated['unit_id'] = $user->unit_id;
        }

        MonitoringTahfidz::create(array_merge($validated, [
            'penguji_id' => $user->id,
        ]));

        NotificationService::notifyKepsekAndYayasan(
            $validated['unit_id'],
            "Setoran Tahfidz: {$validated['nama_santri']}",
            "Santri {$validated['nama_santri']} menyetorkan Juz {$validated['juz']} ({$validated['surat']}) predikat {$validated['predikat']}.",
            'tahfidz_created',
            route('jurnal.index')
        );

        return back()->with('success', 'Buku kontrol setoran tahfidz santri berhasil disimpan.');
    }

    public function remindGuruKbm(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isWakaKurikulum() && !$user->isKepalaSekolah() && !$user->isAdmin()) {
            return back()->with('error', 'Hanya Waka Kurikulum, Kepala Sekolah, atau Admin yang berhak mengirimkan pengingat KBM.');
        }

        $guru = User::findOrFail($id);
        if (!$user->canManageUnit($guru->unit_id)) {
            return back()->with('error', 'Akses Dibatasi: Anda hanya berhak mengirimkan pengingat KBM kepada dewan guru di unit sekolah Anda.');
        }
        $roleTitle = $user->isWakaKurikulum() ? 'Waka Kurikulum' : ($user->isKepalaSekolah() ? 'Kepala Sekolah' : 'Admin Sistem');

        NotificationService::send(
            $guru->id,
            "Pengingat Pengisian Jurnal KBM Harian",
            "{$roleTitle} ({$user->name}) mengingatkan untuk memperbarui catatan jurnal mengajar KBM pekan ini di portal SIM Kurikulum.",
            'kbm_reminder',
            route('jurnal.index')
        );

        return back()->with('success', "Pengingat pengisian jurnal KBM berhasil dikirimkan kepada {$guru->name}.");
    }

    protected function seedStarterTasksForUser($user): void
    {
        $today = now()->toDateString();
        $tomorrow = now()->addDay()->toDateString();
        $next3Days = now()->addDays(3)->toDateString();

        if ($user->isGuru()) {
            $starters = [
                [
                    'judul' => 'Input presensi & materi mengajar kelas pertemuan hari ini',
                    'kategori' => 'kbm',
                    'prioritas' => 'tinggi',
                    'tanggal_target' => $today,
                    'status' => 'belum',
                    'waktu_pengingat' => 'Siang (12.30 WIB)',
                    'catatan_refleksi' => 'Pastikan cek santri yang izin/sakit dan isi jurnal sebelum jam pulang sekolah.',
                ],
                [
                    'judul' => 'Koreksi lembar asesmen formatif santri & input rekap nilai',
                    'kategori' => 'penilaian',
                    'prioritas' => 'tinggi',
                    'tanggal_target' => $today,
                    'status' => 'belum',
                    'waktu_pengingat' => 'Sore (15.30 WIB)',
                    'catatan_refleksi' => 'Fokus pada soal pemahaman konsep dan hitungan santri.',
                ],
                [
                    'judul' => 'Siapkan perangkat ajar & media belajar untuk pekan depan',
                    'kategori' => 'administrasi',
                    'prioritas' => 'sedang',
                    'tanggal_target' => $tomorrow,
                    'status' => 'belum',
                    'waktu_pengingat' => 'Pagi (07.30 WIB)',
                    'catatan_refleksi' => 'Sesuaikan materi dengan sasaran TP yang telah disahkan kurikulum.',
                ],
                [
                    'judul' => 'Bimbingan remedial santri yang belum tuntas materi bab sebelumnya',
                    'kategori' => 'bimbingan',
                    'prioritas' => 'sedang',
                    'tanggal_target' => $next3Days,
                    'status' => 'belum',
                    'waktu_pengingat' => 'Siang (13.30 WIB)',
                    'catatan_refleksi' => 'Pendampingan khusus setelah sholat Ashar berjamaah di musholla.',
                ],
            ];
        } elseif ($user->isWakaKurikulum()) {
            $starters = [
                [
                    'judul' => 'Review teknis berkas usulan revisi TP & materi silabus unit',
                    'kategori' => 'administrasi',
                    'prioritas' => 'tinggi',
                    'tanggal_target' => $today,
                    'status' => 'belum',
                    'waktu_pengingat' => 'Pagi (08.30 WIB)',
                    'catatan_refleksi' => 'Periksa keterpaduan kompetensi Taksonomi Bloom C1-C6 dan kesesuaian alokasi beban JP.',
                ],
                [
                    'judul' => 'Monitoring keterisian jurnal mengajar harian KBM seluruh guru',
                    'kategori' => 'kbm',
                    'prioritas' => 'tinggi',
                    'tanggal_target' => $today,
                    'status' => 'belum',
                    'waktu_pengingat' => 'Siang (13.00 WIB)',
                    'catatan_refleksi' => 'Pastikan seluruh kelas terampu dengan baik dan tidak ada jam kosong tanpa tugas.',
                ],
                [
                    'judul' => 'Evaluasi pemenuhan standar 24 JP pekanan per guru mapel',
                    'kategori' => 'administrasi',
                    'prioritas' => 'sedang',
                    'tanggal_target' => $tomorrow,
                    'status' => 'belum',
                    'waktu_pengingat' => 'Pagi (10.00 WIB)',
                    'catatan_refleksi' => 'Koordinasi dengan TU untuk validasi distribusi jam mengajar dan rombel.',
                ],
                [
                    'judul' => 'Rapat koordinasi MGMP unit & penyelarasan modul projek P5-RA',
                    'kategori' => 'rapat',
                    'prioritas' => 'sedang',
                    'tanggal_target' => $next3Days,
                    'status' => 'belum',
                    'waktu_pengingat' => 'Siang (14.00 WIB)',
                    'catatan_refleksi' => 'Sinkronisasi dimensi Profil Rahmatan Lil Alamin dengan target kepesantrenan.',
                ],
            ];
        } elseif ($user->isKepalaSekolah()) {
            $starters = [
                [
                    'judul' => 'Supervisi ketercapaian jurnal harian guru pengampu unit',
                    'kategori' => 'administrasi',
                    'prioritas' => 'tinggi',
                    'tanggal_target' => $today,
                    'status' => 'belum',
                    'waktu_pengingat' => 'Pagi (09.00 WIB)',
                    'catatan_refleksi' => 'Pastikan guru mengisi kehadiran riil santri dan materi terverifikasi.',
                ],
                [
                    'judul' => 'Telaah berkas usulan perubahan TP dan beban JP pendidik (SLA 3 Hari)',
                    'kategori' => 'administrasi',
                    'prioritas' => 'tinggi',
                    'tanggal_target' => $tomorrow,
                    'status' => 'belum',
                    'waktu_pengingat' => 'Siang (13.00 WIB)',
                    'catatan_refleksi' => 'Evaluasi argumentasi pedagogis sesuai Taksonomi Bloom C1-C6.',
                ],
            ];
        } else {
            $starters = [
                [
                    'judul' => 'Tinjau rekapitulasi capaian TP dan muatan kepesantrenan 3 unit',
                    'kategori' => 'administrasi',
                    'prioritas' => 'sedang',
                    'tanggal_target' => $today,
                    'status' => 'belum',
                    'waktu_pengingat' => 'Pagi (08.30 WIB)',
                    'catatan_refleksi' => 'Harmonisasi kurikulum nasional dengan nilai-nilai kepesantrenan.',
                ],
            ];
        }

        foreach ($starters as $s) {
            JurnalKerja::create(array_merge($s, ['user_id' => $user->id]));
        }
    }
}
