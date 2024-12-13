<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PDFController extends Controller
{
    public function downloadRiwayat($id)
    {
        // Ambil data riwayat berdasarkan ID, beserta relasi pasien dan user
        $riwayat = Riwayat::with(['pasien', 'user'])->findOrFail($id);

        // Siapkan data untuk view
        $data = ['riwayat' => $riwayat];

        // Render view menjadi HTML
        $html = view('pdf.riwayat', $data)->render();

        // Buat objek Mpdf
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        // Download PDF dengan nama file sesuai ID riwayat
        return $mpdf->Output('riwayat-' . $riwayat->id . '.pdf', 'D');
    }

    public function viewJadwalPDF(Request $request)
    {
        $jadwals = Jadwal::with('pasien')->orderBy('created_at', 'asc')->get();

        $data = [
            'jadwals' => $jadwals,
        ];

        $html = view('pdf.jadwal', $data)->render();

        $mpdf = new Mpdf();

        $mpdf->WriteHTML($html);

        $mpdf->Output('jadwal_pasien.pdf', 'D');
    }
}
