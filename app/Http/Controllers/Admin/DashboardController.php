<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ibu;
use App\Models\Kehamilan;
use App\Models\Nifas;
use App\Models\Pelayanan;
use App\Models\Rujukan;
use App\Models\User;

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
}
