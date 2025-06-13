<?php
namespace App\Http\Controllers\Ibu;

use App\Http\Controllers\Controller;
use App\Models\Kehamilan;
use App\Models\Pelayanan;
use App\Traits\JsonResponder;
use Illuminate\Http\Request;

class PelayananController extends Controller
{
    use JsonResponder;

    public function table(Request $request, string $id)
    {
        if ($request->ajax()) {
            $kehamilan  = Kehamilan::with('ibu')->where('id', $id)->first();
            $pelayanans = Pelayanan::with('kehamilan')->where('kehamilan_id', $id)->get();
            $data       = [
                'view' => view('pages.ibu.kehamilan.detail.table-pelayanan', compact('pelayanans'))->render(),
            ];
            return $this->successResponse($data, 'Data berhasil ditemukan.');
        }
    }
}
