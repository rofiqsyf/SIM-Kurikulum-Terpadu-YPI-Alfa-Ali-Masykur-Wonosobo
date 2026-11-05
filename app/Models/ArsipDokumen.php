<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipDokumen extends Model
{
    use HasFactory;

    protected $table = 'arsip_dokumen';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tanggal_arsip' => 'date',
        ];
    }

    public function unit()
    {
        return $this->belongsTo(UnitPendidikan::class, 'unit_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getKategoriBadgeAttribute(): array
    {
        return match ($this->kategori) {
            'kosp' => ['label' => 'KOSP / KOM', 'class' => 'bg-blue-50 text-blue-800 border-blue-200'],
            'atp' => ['label' => 'Alur TP (ATP)', 'class' => 'bg-emerald-50 text-emerald-800 border-emerald-200'],
            'modul_ajar' => ['label' => 'Modul Ajar / RPP', 'class' => 'bg-teal-50 text-teal-800 border-teal-200'],
            'p5_ra' => ['label' => 'Modul P5-RA', 'class' => 'bg-purple-50 text-purple-800 border-purple-200'],
            'sk_pengesahan' => ['label' => 'SK Pengesahan', 'class' => 'bg-amber-50 text-amber-800 border-amber-200'],
            'instrumen_asesmen' => ['label' => 'Instrumen Asesmen', 'class' => 'bg-indigo-50 text-indigo-800 border-indigo-200'],
            default => ['label' => strtoupper($this->kategori), 'class' => 'bg-slate-50 text-slate-700 border-slate-200'],
        };
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status_verifikasi) {
            'Terverifikasi' => [
                'label' => 'Terverifikasi Lengkap',
                'class' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                'dot' => 'bg-emerald-500',
                'icon' => 'verified',
            ],
            'Perlu Dilengkapi' => [
                'label' => 'Perlu Dilengkapi',
                'class' => 'bg-rose-50 text-rose-800 border-rose-200',
                'dot' => 'bg-rose-500',
                'icon' => 'warning',
            ],
            default => [
                'label' => 'Menunggu Supervisi',
                'class' => 'bg-amber-50 text-amber-800 border-amber-200',
                'dot' => 'bg-amber-500 animate-pulse',
                'icon' => 'hourglass_empty',
            ],
        };
    }
}

