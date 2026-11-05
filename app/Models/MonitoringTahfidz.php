<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringTahfidz extends Model
{
    protected $table = 'monitoring_tahfidz';
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_setoran' => 'date',
    ];

    public function unit()
    {
        return $this->belongsTo(UnitPendidikan::class, 'unit_id');
    }

    public function penguji()
    {
        return $this->belongsTo(User::class, 'penguji_id');
    }
}

