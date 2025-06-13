<?php

namespace App\Http\Controllers\Ibu;

use App\Models\Rujukan;
use Illuminate\Http\Request;
use App\Traits\JsonResponder;
use App\Http\Controllers\Controller;

class RujukanController extends Controller
{
    use JsonResponder;
    public function index()
    {
        return view('pages.ibu.rujukan.index');
    }
    public function table(Request $request)
    {
        $rujukans = Rujukan::with('ibu')->where('ibu_id', auth()->user()->id)->get();
        $data     = [
            'view' => view('pages.ibu.rujukan.table', compact('rujukans'))->render(),
        ];
        return $this->successResponse($data, 'Data berhasil ditemukan.');
    }
}
