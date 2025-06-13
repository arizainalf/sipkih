<?php
namespace App\Http\Controllers\Ibu;

use App\Http\Controllers\Controller;
use App\Models\Kehamilan;
use App\Models\Nifas;
use App\Models\Pelayanan;
use App\Models\Rujukan;

class DashboardController extends Controller
{
    public function index()
    {
        $kehamilans = Kehamilan::where('ibu_id', auth()->user()->id)->count();
        $pelayanans = Pelayanan::whereHas('kehamilan', function ($query) {
            $query->where('ibu_id', auth()->user()->id);
        })->count();
        $nifas = Nifas::whereHas('kehamilan', function ($query) {
            $query->where('ibu_id', auth()->user()->id);
        })->count();
        $rujukan = Rujukan::where('ibu_id', auth()->user()->id)->count();
        return view('pages.ibu.dashboard.index', compact('kehamilans', 'pelayanans', 'nifas', 'rujukan'));
    }
}
