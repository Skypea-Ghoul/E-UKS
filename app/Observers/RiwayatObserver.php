<?php

namespace App\Observers;

use App\Models\Obat;
use App\Models\Riwayat;
use Illuminate\Support\Facades\DB;


class RiwayatObserver
{
    /**
     * Handle the Riwayat "updated" event.
     *
     * @param  \App\Models\Riwayat  $riwayat
     * @return void
     */
    public function updated(Riwayat $riwayat)
    {
        // // Ambil riwayat sebelumnya
        // $previousJumlahDipakai = $riwayat->getOriginal('jumlah_dipakai');
        // $obat = Obat::find($riwayat->obat_id);

        // // Mengembalikan jumlah obat yang sebelumnya digunakan
        // if ($obat) {
        //     $obat->increment('jumlah_obat', $previousJumlahDipakai);  // Menambah jumlah obat yang lama
        //     $obat->decrement('jumlah_obat', $riwayat->jumlah_dipakai);  // Mengurangi jumlah obat yang baru
        //     $this->updateObatStatus($obat);  // Memperbarui status obat
        // } else {
        //     throw new \Exception('Obat tidak ditemukan');
        // }
    }

    /**
     * Memperbarui status obat berdasarkan jumlahnya.
     *
     * @param  \App\Models\Obat  $obat
     * @return void
     */
    protected function updateObatStatus(Obat $obat)
    {
        if ($obat->jumlah_obat <= 0) {
            $obat->update(['status_obat' => 'Tidak Tersedia']);
        } else {
            $obat->update(['status_obat' => 'Tersedia']);
        }
    }

    /**
     * Handle the Riwayat "deleted" event.
     */
    public function deleted(Riwayat $riwayat): void
    {
        //
    }

    /**
     * Handle the Riwayat "restored" event.
     */
    public function restored(Riwayat $riwayat): void
    {
        //
    }

    /**
     * Handle the Riwayat "force deleted" event.
     */
    public function forceDeleted(Riwayat $riwayat): void
    {
        //
    }
}
