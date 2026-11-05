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
        'tanggal_mulai',
        'tanggal_selesai',
        'prioritas',
        'status',
        'warna',
        'catatan_refleksi',
        'catatan',
        'waktu_pengingat',
        'notif_deadline_sent',
    ];

    protected $casts = [
        'tanggal_target' => 'date',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'notif_deadline_sent' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isSelesai(): bool
    {
        return $this->status === 'selesai';
    }

    public function getDeadlineDateAttribute()
    {
        return $this->tanggal_selesai ?? $this->tanggal_target;
    }

    public function getStartDateAttribute()
    {
        return $this->tanggal_mulai ?? $this->tanggal_target;
    }

    public function isOverdue(): bool
    {
        if ($this->isSelesai()) {
            return false;
        }

        $deadline = $this->deadline_date;
        if (!$deadline) {
            return false;
        }

        return $deadline->isPast() && !$deadline->isToday();
    }

    public function isDueToday(): bool
    {
        if ($this->isSelesai()) {
            return false;
        }

        $deadline = $this->deadline_date;
        if (!$deadline) {
            return false;
        }

        return $deadline->isToday();
    }

    public function spansDate($date): bool
    {
        $target = \Carbon\Carbon::parse($date)->toDateString();
        $start = ($this->tanggal_mulai ?? $this->tanggal_target)?->toDateString();
        $end = ($this->tanggal_selesai ?? $this->tanggal_target)?->toDateString();

        if ($start && $end) {
            return $target >= $start && $target <= $end;
        } elseif ($start) {
            return $target === $start;
        } elseif ($end) {
            return $target === $end;
        }
        return false;
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

