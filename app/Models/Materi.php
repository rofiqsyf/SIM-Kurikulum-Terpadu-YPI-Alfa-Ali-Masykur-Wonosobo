<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Materi extends Model
{
    protected $table = 'materi';
    protected $guarded = ['id'];

    public function tujuanPembelajaran()
    {
        return $this->belongsTo(TujuanPembelajaran::class, 'tp_id');
    }

    public function hasDocument(): bool
    {
        return !empty($this->file_path);
    }

    public function getDocumentUrlAttribute(): ?string
    {
        if (!$this->file_path) {
            return null;
        }

        return route('curriculum.materi.download', $this->id);
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
}
