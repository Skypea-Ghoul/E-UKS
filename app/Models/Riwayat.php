<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Riwayat extends Model
{
    protected $fillable = [
        'pasien_id',
        'user_id',
        'obat_id',
        'keluhan',
        'tindakan',
        'status_pasien',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($riwayat) {
            if ($riwayat->obat_id) {
                $obat = Obat::find($riwayat->obat_id);
                if ($obat && $obat->jumlah_obat >= $obat->jumlah_dipakai) {
                    $obat->decrement('jumlah_obat', $obat->jumlah_dipakai);
                } else {
                    throw new \Exception('Jumlah obat tidak mencukupi');
                }
            }
        });

        static::updating(function ($riwayat) {
            // Ambil nilai original dan yang baru
            $originalObatId = $riwayat->getOriginal('obat_id');
            $newObatId = $riwayat->obat_id;
            $jumlahDipakai = isset($riwayat->jumlah_dipakai) ? (int)$riwayat->jumlah_dipakai : 0;

            // Hanya lakukan pengurangan stok jika obat_id berubah dan jumlah dipakai lebih dari 0
            if ($originalObatId !== $newObatId && $newObatId) {
                $newObat = Obat::find($newObatId);

                if ($newObat && $newObat->jumlah_obat >= $jumlahDipakai) {
                    $newObat->decrement('jumlah_obat', $jumlahDipakai);
                } else {
                    throw new \Exception('Jumlah obat tidak mencukupi');
                }
            }
        });


        static::deleting(function ($riwayat) {
            // Tidak ada perubahan pada stok obat ketika riwayat dihapus
            // Cukup hapus bagian kode ini
        });
    }


    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obat::class);
    }
}
