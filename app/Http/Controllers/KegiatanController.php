<?php

namespace App\Http\Controllers;

use App\Models\EkstrakurikulerAnggota;
use App\Models\EkstrakurikulerJadwal;
use App\Models\EkstrakurikulerPresensi;
use App\Models\KegiatanEkstrakurikuler;
use App\Models\KegiatanKokurikuler;
use App\Models\UnitPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KegiatanController extends Controller
{
    /**
     * Halaman Publik/Umum Kokurikuler (P5-RA) & Ekstrakurikuler
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->canAccessAllUnits()) {
            $units = UnitPendidikan::all();
            $selectedUnitId = $request->get('unit_id', $units->first()?->id);
        } else {
            $units = UnitPendidikan::where('id', $user->unit_id)->get();
            $selectedUnitId = $user->unit_id;
        }

        $kokurikuler = KegiatanKokurikuler::where('unit_id', $selectedUnitId)
            ->with(['pengelola', 'unit'])
            ->get();

        $ekstrakurikuler = KegiatanEkstrakurikuler::where('unit_id', $selectedUnitId)
            ->with(['pembina', 'unit'])
            ->withCount(['anggota', 'jadwal'])
            ->get();

        return view('kegiatan.index', compact('user', 'units', 'selectedUnitId', 'kokurikuler', 'ekstrakurikuler'));
    }

    /**
     * Halaman Khusus Pembina Ekstrakurikuler (Workspace Pembinaan, Daftar Siswa & Jadwal)
     */
    public function pembinaIndex(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->canAccessAllUnits()) {
            $units = UnitPendidikan::all();
            $selectedUnitId = $request->get('unit_id', $user->unit_id ?: $units->first()?->id);
        } else {
            $units = UnitPendidikan::where('id', $user->unit_id)->get();
            $selectedUnitId = $user->unit_id;
        }

        // Ambil daftar seluruh cabang ekstrakurikuler pada unit terpilih
        $ekskulList = KegiatanEkstrakurikuler::where('unit_id', $selectedUnitId)
            ->with(['pembina', 'unit'])
            ->withCount(['anggota', 'jadwal'])
            ->get();

        // Tentukan ekstrakurikuler mana yang aktif ditampilkan
        $selectedEkskulId = $request->get('ekskul_id');
        if (!$selectedEkskulId) {
            if ($user->isPembina()) {
                $myEkskul = $ekskulList->firstWhere('pembina_id', $user->id);
                $selectedEkskulId = $myEkskul ? $myEkskul->id : $ekskulList->first()?->id;
            } else {
                $selectedEkskulId = $ekskulList->first()?->id;
            }
        }

        $selectedEkskul = $selectedEkskulId 
            ? KegiatanEkstrakurikuler::with(['pembina', 'unit'])->find($selectedEkskulId) 
            : null;

        // Ambil daftar anggota santri terdaftar
        $anggotaList = $selectedEkskul 
            ? EkstrakurikulerAnggota::where('ekstrakurikuler_id', $selectedEkskul->id)
                ->with('presensi')
                ->orderBy('nama_siswa')
                ->get()
            : collect();

        // Ambil jadwal sesi pertemuan
        $jadwalList = $selectedEkskul 
            ? EkstrakurikulerJadwal::where('ekstrakurikuler_id', $selectedEkskul->id)
                ->with(['presensi.anggota'])
                ->orderBy('tanggal', 'desc')
                ->get()
            : collect();

        // Statistik
        $totalAnggota = $anggotaList->count();
        $totalJadwal = $jadwalList->count();
        $jadwalTerlaksana = $jadwalList->where('status', 'Terlaksana')->count();
        
        $persentaseKehadiranRataRata = 100;
        if ($totalAnggota > 0 && $jadwalTerlaksana > 0) {
            $totalPresensi = EkstrakurikulerPresensi::whereIn('jadwal_id', $jadwalList->pluck('id'))->count();
            $totalHadir = EkstrakurikulerPresensi::whereIn('jadwal_id', $jadwalList->pluck('id'))
                ->where('status_kehadiran', 'Hadir')
                ->count();
            $persentaseKehadiranRataRata = $totalPresensi > 0 ? (int) round(($totalHadir / $totalPresensi) * 100) : 100;
        }

        return view('kegiatan.pembina', compact(
            'user',
            'units',
            'selectedUnitId',
            'ekskulList',
            'selectedEkskul',
            'anggotaList',
            'jadwalList',
            'totalAnggota',
            'totalJadwal',
            'jadwalTerlaksana',
            'persentaseKehadiranRataRata'
        ));
    }

    /**
     * Tambah Anggota Siswa / Santri Baru
     */
    public function storeAnggota(Request $request)
    {
        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:kegiatan_ekstrakurikuler,id',
            'nama_siswa' => 'required|string|max:150',
            'kelas' => 'required|string|max:50',
        ]);

        EkstrakurikulerAnggota::create([
            'ekstrakurikuler_id' => $request->ekstrakurikuler_id,
            'nama_siswa' => $request->nama_siswa,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin ?? 'L',
            'status_keaktifan' => $request->status_keaktifan ?? 'Aktif',
            'nilai_kualitatif' => $request->nilai_kualitatif ?? 'B',
            'catatan_bakat' => $request->catatan_bakat,
        ]);

        return redirect()->back()->with('success', 'Santri/Siswa berhasil didaftarkan ke cabang ekstrakurikuler.');
    }

    /**
     * Perbarui Data Anggota Santri
     */
    public function updateAnggota(Request $request, $id)
    {
        $anggota = EkstrakurikulerAnggota::findOrFail($id);
        $request->validate([
            'nama_siswa' => 'required|string|max:150',
            'kelas' => 'required|string|max:50',
        ]);

        $anggota->update([
            'nama_siswa' => $request->nama_siswa,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin ?? $anggota->jenis_kelamin,
            'status_keaktifan' => $request->status_keaktifan ?? $anggota->status_keaktifan,
            'nilai_kualitatif' => $request->nilai_kualitatif ?? $anggota->nilai_kualitatif,
            'catatan_bakat' => $request->catatan_bakat,
        ]);

        return redirect()->back()->with('success', 'Data santri peserta ekstrakurikuler berhasil diperbarui.');
    }

    /**
     * Hapus Santri dari Anggota Ekstra
     */
    public function destroyAnggota($id)
    {
        $anggota = EkstrakurikulerAnggota::findOrFail($id);
        $anggota->delete();

        return redirect()->back()->with('success', 'Santri berhasil dihapus dari daftar anggota ekstrakurikuler.');
    }

    /**
     * Tambah Sesi Jadwal Pertemuan / Latihan
     */
    public function storeJadwal(Request $request)
    {
        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:kegiatan_ekstrakurikuler,id',
            'tanggal' => 'required|date',
            'materi_pembinaan' => 'required|string|max:255',
        ]);

        $lastPertemuan = EkstrakurikulerJadwal::where('ekstrakurikuler_id', $request->ekstrakurikuler_id)->max('pertemuan_ke') ?? 0;

        EkstrakurikulerJadwal::create([
            'ekstrakurikuler_id' => $request->ekstrakurikuler_id,
            'pertemuan_ke' => $request->pertemuan_ke ?: ($lastPertemuan + 1),
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai ?? '15:30',
            'jam_selesai' => $request->jam_selesai ?? '17:00',
            'tempat' => $request->tempat ?? 'Lapangan / Aula Ponpes',
            'materi_pembinaan' => $request->materi_pembinaan,
            'catatan_evaluasi' => $request->catatan_evaluasi,
            'status' => $request->status ?? 'Dijadwalkan',
        ]);

        return redirect()->back()->with('success', 'Sesi jadwal latihan ekstrakurikuler berhasil ditambahkan.');
    }

    /**
     * Update Jadwal Pertemuan
     */
    public function updateJadwal(Request $request, $id)
    {
        $jadwal = EkstrakurikulerJadwal::findOrFail($id);
        $request->validate([
            'tanggal' => 'required|date',
            'materi_pembinaan' => 'required|string|max:255',
        ]);

        $jadwal->update([
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai ?? $jadwal->jam_mulai,
            'jam_selesai' => $request->jam_selesai ?? $jadwal->jam_selesai,
            'tempat' => $request->tempat ?? $jadwal->tempat,
            'materi_pembinaan' => $request->materi_pembinaan,
            'catatan_evaluasi' => $request->catatan_evaluasi,
            'status' => $request->status ?? $jadwal->status,
        ]);

        return redirect()->back()->with('success', 'Data sesi latihan dan catatan evaluasi berhasil diperbarui.');
    }

    /**
     * Hapus Sesi Jadwal
     */
    public function destroyJadwal($id)
    {
        $jadwal = EkstrakurikulerJadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->back()->with('success', 'Sesi jadwal latihan berhasil dihapus.');
    }

    /**
     * Simpan Presensi Kehadiran Santri per Sesi Pertemuan
     */
    public function savePresensi(Request $request, $id)
    {
        $jadwal = EkstrakurikulerJadwal::findOrFail($id);
        $presensiData = $request->input('presensi', []);

        foreach ($presensiData as $anggotaId => $status) {
            EkstrakurikulerPresensi::updateOrCreate(
                ['jadwal_id' => $jadwal->id, 'anggota_id' => $anggotaId],
                ['status_kehadiran' => $status]
            );
        }

        // Tandai otomatis jadwal menjadi Terlaksana
        $jadwal->update(['status' => 'Terlaksana']);

        return redirect()->back()->with('success', 'Presensi kehadiran santri untuk sesi pertemuan ke-' . $jadwal->pertemuan_ke . ' berhasil disimpan.');
    }
}
