<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
    protected $table = 'fase';
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'fase_id');
    }

    public function capaianPembelajaran()
    {
        return $this->hasMany(CapaianPembelajaran::class, 'fase_id');
    }
}

