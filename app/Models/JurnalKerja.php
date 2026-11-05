<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalKerja extends Model
{
    use HasFactory;

    protected $table = 'jurnal_kerja';

    protected $fillable = [
        'user_id',
        'judul',
        'kategori',
        'tanggal_target',
        'prioritas',
        'status',
        'catatan_refleksi',
        'waktu_pengingat',
    ];

    protected $casts = [
        'tanggal_target' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isSelesai(): bool
    {
        return $this->status === 'selesai';
    }

    public function isOverdue(): bool
    {
        if ($this->isSelesai() || !$this->tanggal_target) {
            return false;
        }

        return $this->tanggal_target->isPast() && !$this->tanggal_target->isToday();
    }

    public function isDueToday(): bool
    {
        if ($this->isSelesai() || !$this->tanggal_target) {
            return false;
        }

        return $this->tanggal_target->isToday();
    }

    public function getKategoriBadgeAttribute(): array
    {
        return match ($this->kategori) {
            'kbm' => ['label' => 'KBM & Mengajar', 'color' => 'bg-emerald-50 text-emerald-800 border-emerald-200'],
            'administrasi' => ['label' => 'Silabus & Modul', 'color' => 'bg-blue-50 text-blue-800 border-blue-200'],
            'penilaian' => ['label' => 'Penilaian & Koreksi', 'color' => 'bg-amber-50 text-amber-800 border-amber-200'],
            'bimbingan' => ['label' => 'Bimbingan Santri', 'color' => 'bg-purple-50 text-purple-800 border-purple-200'],
            'rapat' => ['label' => 'Rapat & Koordinasi', 'color' => 'bg-rose-50 text-rose-800 border-rose-200'],
            default => ['label' => 'Agenda Kerja', 'color' => 'bg-slate-100 text-slate-700 border-slate-200'],
        };
    }
}

