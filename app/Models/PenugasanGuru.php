<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenugasanGuru extends Model
{
    protected $table = 'penugasan_guru';
    protected $guarded = ['id'];

    public function guru()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }
}

