<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    protected $table = 'jenjang';
    protected $guarded = ['id'];

    public function unitPendidikan()
    {
        return $this->hasMany(UnitPendidikan::class, 'jenjang_id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jenjang_id');
    }
}

