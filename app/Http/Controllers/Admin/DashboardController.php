<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ibu;
use App\Models\Kehamilan;
use App\Models\Nifas;
use App\Models\Pelayanan;
use App\Models\Rujukan;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ibus       = Ibu::count();
        $kehamilans = Kehamilan::count();
        $pelayanans = Pelayanan::count();
        $nifas      = Nifas::count();
        $users      = User::count();
        $rujukan    = Rujukan::count();
        return view('pages.admin.dashboard.index', compact('ibus', 'kehamilans', 'pelayanans', 'nifas', 'users', 'rujukan'));
    }

    /**
     * Export pdf
     */
    public function exportPdf(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date',
        ]);

        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $ibus       = Ibu::whereBetween('created_at', [$tanggal_mulai, $tanggal_akhir])->get();
        $kehamilans = Kehamilan::whereBetween('created_at', [$tanggal_mulai, $tanggal_akhir])->get();
        $pelayanans = Pelayanan::whereBetween('created_at', [$tanggal_mulai, $tanggal_akhir])->get();
        $nifas      = Nifas::whereBetween('created_at', [$tanggal_mulai, $tanggal_akhir])->get();
        $rujukans   = Rujukan::whereBetween('created_at', [$tanggal_mulai, $tanggal_akhir])->get();
        $users      = User::whereBetween('created_at', [$tanggal_mulai, $tanggal_akhir])->get();

        $total_ibu       = $ibus->count();
        $total_kehamilan = $kehamilans->count();
        $total_pelayanan = $pelayanans->count();
        $total_nifas     = $nifas->count();
        $total_rujukan   = $rujukans->count();
        $total_user      = $users->count();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pages.admin.dashboard.pdf', compact('tanggal_mulai', 'tanggal_akhir', 'ibus', 'kehamilans', 'pelayanans', 'nifas', 'rujukans', 'users'));
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download('laporan_' . $tanggal_mulai . '_' . $tanggal_akhir . '.pdf');
    }
}
