<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 't_kecamatan';
    protected $primaryKey = 'kode_kecamatan';
    protected $fillable = [
        'kode_kecamatan',
        'nama_kecamatan',
        'is_active'
    ];
    public $timestamps = true;
    protected $dates = ['deleted_at'];

}
