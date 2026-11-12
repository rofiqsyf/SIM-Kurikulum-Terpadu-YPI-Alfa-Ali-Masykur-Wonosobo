<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsulanPerubahan extends Model
{
    protected $table = 'usulan_perubahan';
    protected $guarded = ['id'];

    protected $casts = [
        'data_usulan' => 'array',
        'tanggal_pengajuan' => 'datetime',
        'tanggal_keputusan' => 'datetime',
    ];

    public function pengusul()
    {
        return $this->belongsTo(User::class, 'pengusul_id');
    }

    public function peninjau()
    {
        return $this->belongsTo(User::class, 'peninjau_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitPendidikan::class, 'unit_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function hasDocument(): bool
    {
        return !empty($this->file_path);
    }

    public function getDocumentBadgeAttribute(): array
    {
        $type = strtolower($this->file_type ?? pathinfo($this->file_name ?? '', PATHINFO_EXTENSION));

        return match ($type) {
            'pdf' => [
                'type' => 'PDF',
                'icon' => 'picture_as_pdf',
                'color' => 'bg-rose-50 text-rose-700 border-rose-200',
                'badge' => 'bg-rose-100 text-rose-800',
            ],
            'docx', 'doc' => [
                'type' => 'Word',
                'icon' => 'description',
                'color' => 'bg-blue-50 text-blue-700 border-blue-200',
                'badge' => 'bg-blue-100 text-blue-800',
            ],
            'xlsx', 'xls', 'csv' => [
                'type' => 'Excel',
                'icon' => 'table_view',
                'color' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'badge' => 'bg-emerald-100 text-emerald-800',
            ],
            default => [
                'type' => strtoupper($type ?: 'DOC'),
                'icon' => 'attachment',
                'color' => 'bg-slate-50 text-slate-700 border-slate-200',
                'badge' => 'bg-slate-100 text-slate-800',
            ],
        };
    }

    /**
     * Rekomendasi 5: Indikator SLA Review Kepala Sekolah
     */
    public function getSlaStatusAttribute(): array
    {
        if ($this->status !== 'Menunggu Persetujuan') {
            return [
                'status' => 'completed',
                'label' => 'Selesai Ditelaah',
                'days' => 0,
                'color' => 'slate',
                'badge_class' => 'bg-slate-100 text-slate-700 border-slate-200',
            ];
        }

        $days = $this->tanggal_pengajuan ? (int) $this->tanggal_pengajuan->diffInDays(now()) : 0;

        if ($days < 3) {
            return [
                'status' => 'normal',
                'label' => $days == 0 ? 'Hari Ini (SLA Aman)' : "{$days} Hari Lalu (SLA Aman)",
                'days' => $days,
                'color' => 'emerald',
                'badge_class' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
            ];
        } elseif ($days < 7) {
            return [
                'status' => 'warning',
                'label' => "Perlu Ditelaah ({$days} Hari)",
                'days' => $days,
                'color' => 'amber',
                'badge_class' => 'bg-amber-50 text-amber-800 border-amber-300 font-semibold',
            ];
        } else {
            return [
                'status' => 'urgent',
                'label' => "Melebihi Batas SLA ({$days} Hari)",
                'days' => $days,
                'color' => 'rose',
                'badge_class' => 'bg-rose-50 text-rose-800 border-rose-300 font-bold',
            ];
        }
    }
}

