<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class AdminChatMessage extends Model
{
    use HasFactory;

    protected $table = 'admin_chat_messages';

    protected $guarded = ['id'];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function thread(): BelongsTo
    {
        return $this->belongsTo(AdminChatThread::class, 'thread_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function hasAttachment(): bool
    {
        return !empty($this->file_path);
    }

    public function isSenderAdmin(): bool
    {
        return $this->sender?->isAdmin() ?? false;
    }

    public function isImage(): bool
    {
        $ext = strtolower($this->file_extension ?? pathinfo($this->file_name ?? '', PATHINFO_EXTENSION));
        return in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
    }

    public function isDocument(): bool
    {
        $ext = strtolower($this->file_extension ?? pathinfo($this->file_name ?? '', PATHINFO_EXTENSION));
        return in_array($ext, ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'txt', 'zip', 'rar', 'ppt', 'pptx']);
    }

    public function getFileUrlAttribute(): ?string
    {
        if (!$this->hasAttachment()) {
            return null;
        }

        return Storage::disk('public')->url($this->file_path);
    }

    public function getFileBadgeAttribute(): array
    {
        $ext = strtolower($this->file_extension ?? pathinfo($this->file_name ?? '', PATHINFO_EXTENSION));

        return match ($ext) {
            'pdf' => [
                'icon' => 'picture_as_pdf',
                'label' => 'PDF',
                'color' => 'rose',
                'badge_class' => 'bg-rose-50 text-rose-700 border-rose-200',
                'icon_class' => 'text-rose-600',
            ],
            'doc', 'docx' => [
                'icon' => 'description',
                'label' => 'DOCX',
                'color' => 'blue',
                'badge_class' => 'bg-blue-50 text-blue-700 border-blue-200',
                'icon_class' => 'text-blue-600',
            ],
            'xls', 'xlsx', 'csv' => [
                'icon' => 'table_chart',
                'label' => 'EXCEL',
                'color' => 'emerald',
                'badge_class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'icon_class' => 'text-emerald-600',
            ],
            'zip', 'rar', '7z' => [
                'icon' => 'folder_zip',
                'label' => 'ZIP',
                'color' => 'purple',
                'badge_class' => 'bg-purple-50 text-purple-700 border-purple-200',
                'icon_class' => 'text-purple-600',
            ],
            'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg' => [
                'icon' => 'image',
                'label' => 'GAMBAR',
                'color' => 'amber',
                'badge_class' => 'bg-amber-50 text-amber-700 border-amber-200',
                'icon_class' => 'text-amber-600',
            ],
            default => [
                'icon' => 'attach_file',
                'label' => strtoupper($ext ?: 'FILE'),
                'color' => 'slate',
                'badge_class' => 'bg-slate-50 text-slate-700 border-slate-200',
                'icon_class' => 'text-slate-600',
            ],
        };
    }
}

