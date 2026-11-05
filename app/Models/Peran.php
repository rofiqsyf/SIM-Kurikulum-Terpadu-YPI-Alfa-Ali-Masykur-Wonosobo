<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peran extends Model
{
    protected $table = 'peran';
    protected $guarded = ['id'];

    public function pengguna()
    {
        return $this->hasMany(User::class, 'peran_id');
    }
}

