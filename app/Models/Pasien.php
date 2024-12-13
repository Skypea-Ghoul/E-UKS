<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pasien extends Model
{
    protected $fillable = [
        'nis',
        'nama',
        'kelas',
        'gambar',
        'tanggal_lahir',
        'jenis_kelamin',
        'jumlah_pendaftaran'
    ];

    public function riwayats()
    {
        return $this->hasMany(Riwayat::class); // satu pasien memiliki banyak riwayat
    }
}
