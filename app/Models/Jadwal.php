<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jadwal extends Model
{
    protected $fillable = ['pasien_id', 'riwayat_id', 'kamar', 'jam_masuk', 'jam_keluar'];


    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }
    public function riwayats()
    {
        return $this->hasMany(Riwayat::class);
    }
}
