<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status_aktif' => 'boolean',
        ];
    }

    public function peran()
    {
        return $this->belongsTo(Peran::class, 'peran_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitPendidikan::class, 'unit_id');
    }

    public function penugasan()
    {
        return $this->hasMany(PenugasanGuru::class, 'pengguna_id');
    }

    public function mataPelajaran()
    {
        return $this->hasManyThrough(
            MataPelajaran::class,
            PenugasanGuru::class,
            'pengguna_id',
            'id',
            'id',
            'mapel_id'
        );
    }

    public function usulanDiajukan()
    {
        return $this->hasMany(UsulanPerubahan::class, 'pengusul_id');
    }

    public function usulanDitinjau()
    {
        return $this->hasMany(UsulanPerubahan::class, 'peninjau_id');
    }

    public function jurnalMengajar()
    {
        return $this->hasMany(JurnalMengajar::class, 'guru_id');
    }

    public function jurnalKerja()
    {
        return $this->hasMany(JurnalKerja::class, 'user_id')->latest('tanggal_target');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'user_id')->latest();
    }

    public function adminChatThread()
    {
        return $this->hasOne(AdminChatThread::class, 'user_id');
    }

    public function unreadAdminChatCount(): int
    {
        if ($this->isAdmin()) {
            return (int) AdminChatThread::sum('unread_for_admin');
        }

        return (int) ($this->adminChatThread?->unread_for_user ?? 0);
    }

    public function getAvatarImageAttribute(): ?string
    {
        if (!$this->avatar_url) {
            return null;
        }

        if (str_starts_with($this->avatar_url, 'http://') || str_starts_with($this->avatar_url, 'https://')) {
            return $this->avatar_url;
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->url($this->avatar_url);
    }

    // Role helper methods
    public function isGuru(): bool
    {
        return str_contains(strtolower($this->peran?->nama_peran ?? ''), 'guru');
    }

    public function isKepalaSekolah(): bool
    {
        return str_contains(strtolower($this->peran?->nama_peran ?? ''), 'kepala');
    }

    public function isWakaKurikulum(): bool
    {
        return str_contains(strtolower($this->peran?->nama_peran ?? ''), 'waka');
    }

    public function canReviewProposals(): bool
    {
        return $this->isKepalaSekolah() || $this->isWakaKurikulum() || $this->isAdmin();
    }

    public function isYayasan(): bool
    {
        return str_contains(strtolower($this->peran?->nama_peran ?? ''), 'yayasan');
    }

    public function isAdmin(): bool
    {
        return str_contains(strtolower($this->peran?->nama_peran ?? ''), 'admin');
    }

    public function isPembina(): bool
    {
        return str_contains(strtolower($this->peran?->nama_peran ?? ''), 'pembina');
    }

    public function canAccessAllUnits(): bool
    {
        return $this->isAdmin() || $this->isYayasan();
    }

    public function canManageUnit($unitId): bool
    {
        if ($this->canAccessAllUnits()) {
            return true;
        }

        if (!$this->unit_id || !$unitId) {
            return false;
        }

        return (int) $this->unit_id === (int) $unitId;
    }
}
