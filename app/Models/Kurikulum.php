<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    protected $table = 'kurikulum';
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'is_locked' => 'boolean',
        'locked_at' => 'datetime',
    ];

    public function unit()
    {
        return $this->belongsTo(UnitPendidikan::class, 'unit_id');
    }

    public function lockedByUser()
    {
        return $this->belongsTo(User::class, 'locked_by');
    }

    public function mataPelajaran()
    {
        return $this->hasMany(MataPelajaran::class, 'kurikulum_id');
    }
}

