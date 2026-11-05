<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TujuanPembelajaran extends Model
{
    protected $table = 'tujuan_pembelajaran';
    protected $guarded = ['id'];

    public function capaianPembelajaran()
    {
        return $this->belongsTo(CapaianPembelajaran::class, 'cp_id');
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'tp_id');
    }
}

