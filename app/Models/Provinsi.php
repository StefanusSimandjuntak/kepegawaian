<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 't_provinsi';
    protected $primaryKey = 'kode_provinsi';
    protected $fillable = [
        'kode_provinsi',
        'nama_provinsi',
        'is_active'
    ];
    public $timestamps = true;
    protected $dates = ['deleted_at'];

}
