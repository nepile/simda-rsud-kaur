<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Utils\ExportData;
use App\Http\Utils\SearchData;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PelanggaranWebController extends Controller
{
    protected $recapPelanggaran;

    public function __construct()
    {
        $this->recapPelanggaran = User::where('role', 'pegawai')->paginate(10);
    }

    public function showPelanggaran(): View
    {
        $data = [
            'title'             => 'Data Pelanggaran',
            'id_page'           => 'pelanggaran-index',
            'recapPelanggaran'  => $this->recapPelanggaran,
            'countTglPresensi'  => Presensi::select(DB::raw('COUNT(DISTINCT tanggal_presensi) as count'))
                ->first()
                ->count,
        ];

        return view('components.dash.pelanggaran.index', $data);
    }

    public function searchPelanggaran(Request $request)
    {
        $attr = [
            'model'     => new User,
            'field'     => is_numeric($request->input('query')) ? 'nip' : 'nama',
            'key'       => $request->input('query')
        ];

        $this->recapPelanggaran = SearchData::find($attr)->where('role', 'pegawai')->paginate(10);

        return $this->showRekapPresensi();
    }

    public function handleExportPdfPelanggaran()
    {
        $attr = [
            'heading'       => 'Rekap Data Presensi & Permintaan Bulanan Pegawai',
            'fileDir'       => 'pdf.rppb_pegawai',
            'data'          => User::where('role', 'pegawai')->get(),
            'countTglPresensi'  => Presensi::select(DB::raw('COUNT(DISTINCT tanggal_presensi) as count'))
                ->first()
                ->count,
        ];
        return ExportData::PDF($attr);
    }
}
