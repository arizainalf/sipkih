<?php
namespace App\Http\Controllers\Ibu;

use App\Http\Controllers\Controller;
use App\Models\FormPeriksaKehamilan;
use App\Models\Kehamilan;
use App\Models\PeriksaKehamilan;
use App\Traits\JsonResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriksaKehamilanController extends Controller
{
    use JsonResponder;
    public function index()
    {
        return view('pages.ibu.periksa.index');
    }
    public function table(Request $request)
    {
        $kehamilans = Kehamilan::with('ibu')->where('ibu_id', auth()->user()->id)->get();
        $data       = [
            'view' => view('pages.ibu.periksa.table', compact('kehamilans'))->render(),
        ];
        return $this->successResponse($data, 'Data berhasil ditemukan.');
    }
    public function tambah(string $id)
    {
        $kehamilan = Kehamilan::with('ibu')->where('id', $id)->first();
        $forms     = FormPeriksaKehamilan::where('status', true)->get();
        return view('pages.ibu.periksa.tambah', compact('kehamilan', 'forms'));
    }

    public function getForm()
    {
        $data = FormPeriksaKehamilan::orderBy('id')
            ->where('status', true)
            ->get();

        return $this->successResponse($data, 'Data berhasil ditemukan.');
    }
    public function getFormEdit()
    {
        $data = PeriksaKehamilan::with('form_periksa_kehamilan')->orderBy('id')
            ->get()->where('status', true);

        return $this->successResponse($data, 'Data berhasil ditemukan.');
    }
    public function store(Request $request)
    {
        $request->validate([
            'kehamilan_id' => 'required|exists:kehamilans,id',
            'items'        => 'array', // boleh kosong
            'items.*'      => 'exists:form_periksa_kehamilans,id',
        ]);

        DB::beginTransaction();
        try {
            // Hapus dulu data sebelumnya
            PeriksaKehamilan::where('kehamilan_id', $request->kehamilan_id)->delete();

            // Ambil semua form pemeriksaan → untuk membuat default false
            $allForms = FormPeriksaKehamilan::pluck('id')->toArray();
            $selected = $request->input('items', []);

            $data = collect($allForms)->map(function ($formId) use ($request, $selected) {
                return [
                    'kehamilan_id'              => $request->kehamilan_id,
                    'form_periksa_kemahilan_id' => $formId,
                    'status'                    => in_array($formId, $selected), // true kalau dipilih, false kalau tidak
                    'created_at'                => now(),
                    'updated_at'                => now(),
                ];
            })->toArray();

            PeriksaKehamilan::insert($data);

            DB::commit();
            return $this->successResponse(null, 'Data berhasil disimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse(null, $th->getMessage());
        }
    }

    public function edit(string $id)
    {
        $kehamilan     = Kehamilan::with('ibu')->where('id', $id)->first();
        $selectedItems = PeriksaKehamilan::where('kehamilan_id', $id)->where('status', true)->pluck('form_periksa_kemahilan_id')->toArray();

        // dd($selectedItems);

        return view('pages.ibu.periksa.edit', [
            'kehamilan'     => $kehamilan,
            'selectedItems' => $selectedItems,
        ]);
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'items'   => 'array', // bisa kosong
            'items.*' => 'exists:form_periksa_kehamilans,id',
        ]);

        DB::beginTransaction();
        try {
            // Hapus dulu data sebelumnya
            PeriksaKehamilan::where('kehamilan_id', $id)->delete();

            // Ambil semua form ID
            $allForms = FormPeriksaKehamilan::where('status', true)->pluck('id')->toArray();
            $selected = array_map('intval', $request->input('items', [])); // pastikan tipe integer
            // dd($request->input('items'), $allForms, $selected);

            $data = collect($allForms)->map(function ($formId) use ($id, $selected) {
                return [
                    'kehamilan_id'              => $id,
                    'form_periksa_kemahilan_id' => $formId,
                    'status'                    => in_array($formId, $selected),
                    'created_at'                => now(),
                    'updated_at'                => now(),
                ];
            })->toArray();

            PeriksaKehamilan::insert($data);

            DB::commit();
            return $this->successResponse(null, 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse(null, $th->getMessage());
        }
    }

}
