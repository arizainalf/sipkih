<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormPeriksaKehamilan;
use App\Models\Ibu;
use App\Models\Kehamilan;
use App\Models\PeriksaKehamilan;
use App\Traits\JsonResponder;
use Illuminate\Http\Request;

class PeriksaKehamilanController extends Controller
{
    use JsonResponder;
    public function index(string $id)
    {
        $ibu = Ibu::with('kehamilans')->where('id', $id)->first();
        return view('pages.admin.periksa.index', compact('ibu'));
    }
    public function table(Request $request, string $id)
    {
        $kehamilans = Kehamilan::with('ibu')->where('ibu_id', $id)->get();
        $data       = [
            'view' => view('pages.admin.periksa.table', compact('kehamilans'))->render(),
        ];
        return $this->successResponse($data, 'Data berhasil ditemukan.');
    }
    public function getForm()
    {
        $data = FormPeriksaKehamilan::orderBy('id')->get();
        return $this->successResponse($data, 'Data berhasil ditemukan.');
    }
    public function getFormEdit()
    {
        $data = PeriksaKehamilan::with('form_periksa_kehamilan')->orderBy('id')
            ->get();

        return $this->successResponse($data, 'Data berhasil ditemukan.');
    }
    public function show(string $id)
    {
        $kehamilan     = Kehamilan::with('ibu')->where('id', $id)->first();
        $selectedItems = PeriksaKehamilan::where('kehamilan_id', $id)->pluck('form_periksa_kemahilan_id')->toArray();

        return view('pages.admin.periksa.edit', [
            'kehamilan'     => $kehamilan,
            'selectedItems' => $selectedItems,
        ]);
    }
    public function edit(string $id)
    {
        $kehamilan     = Kehamilan::with('ibu')->where('id', $id)->first();
        $selectedItems = PeriksaKehamilan::where('kehamilan_id', $id)->pluck('form_periksa_kemahilan_id')->toArray();

        return view('pages.admin.periksa.edit', [
            'kehamilan'     => $kehamilan,
            'selectedItems' => $selectedItems,
        ]);
    }
}
