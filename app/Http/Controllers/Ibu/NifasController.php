<?php
namespace App\Http\Controllers\Ibu;

use App\Http\Controllers\Controller;
use App\Models\Kehamilan;
use App\Models\Nifas;
use App\Traits\JsonResponder;
use Illuminate\Http\Request;

class NifasController extends Controller
{
    use JsonResponder;
    public function table(Request $request, string $id)
    {
        if ($request->ajax()) {
            $kehamilan = Kehamilan::with('ibu')->where('id', $id)->first();
            $nifas     = Nifas::with('kehamilan')->get()->where('kehamilan_id', $id);
            $data      = [
                'view' => view('pages.ibu.kehamilan.detail.table-nifas', compact('nifas'))->render(),
            ];
            return $this->successResponse($data, 'Data berhasil ditemukan.');
        }
    }
}
