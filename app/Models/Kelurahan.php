<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 't_kelurahan';
    protected $primaryKey = 'kode_kelurahan';
    protected $fillable = [
        'kode_kelurahan',
        'nama_kelurahan',
        'is_active'
    ];
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'kode_kecamatan');
    }

}
