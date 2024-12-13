<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obat extends Model
{

    protected $fillable = [
        'nama_obat',
        'fungsi_obat',
        'jumlah_obat',
        'status_obat',
        'kadaluarsa',
        'gambar_obat',
        'jenis_obat',
        'anjuran',
        'tipe_obat',
        'jumlah_dipakai'
    ];

    protected $appends = ['status_obat'];

    public function getStatusObatAttribute()
    {
        return $this->jumlah_obat > 0 ? 'Tersedia' : 'Tidak Tersedia';
    }
    public function riwayats()
    {
        return $this->hasMany(Riwayat::class);
    }
}
