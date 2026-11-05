<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanKokurikuler extends Model
{
    protected $table = 'kegiatan_kokurikuler';
    protected $guarded = ['id'];

    public function unit()
    {
        return $this->belongsTo(UnitPendidikan::class, 'unit_id');
    }

    public function pengelola()
    {
        return $this->belongsTo(User::class, 'pengelola_id');
    }
}

