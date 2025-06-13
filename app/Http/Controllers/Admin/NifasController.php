<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nifas;
use App\Traits\JsonResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NifasController extends Controller
{
    use JsonResponder;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->mode == 'select') {

            $data = Nifas::with('kehamilan.ibu')->get();

            return $this->successResponse(
                $data,
                'Data berhasil ditemukan',
            );
        } else if ($request->ajax()) {

            $nifas = Nifas::with('kehamilan.ibu')->get();

            $data = [
                'view' => view('pages.admin.nifas.table', compact('nifas'))->render(),
            ];
            return $this->successResponse($data, 'Data berhasil ditemukan.');
        }
        return view('pages.admin.nifas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function detail(Request $request, string $id)
    {
        $nifas = Nifas::with('kehamilan.ibu')->where('id', $id)->first();
        return view('pages.admin.nifas.detail.index', compact('nifas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kehamilan_id'        => ['required', 'exists:kehamilans,id'],
            'periksa_asi'         => ['boolean'],
            'periksa_perdarahan'  => ['boolean'],
            'periksa_jalan_lahir' => ['boolean'],
            'vitamin_a'           => ['nullable', 'string'],
            'kb_pasca_kelahiran'  => ['nullable', 'in:suntik,pil'],
            'konseling'           => ['boolean'],
            'tata_laksana_kasus'  => ['boolean'],
        ]);

        DB::beginTransaction();

        try {
            // Set default values for boolean fields if not provided
            $defaultValues = [
                'periksa_asi'         => false,
                'periksa_perdarahan'  => false,
                'periksa_jalan_lahir' => false,
                'konseling'           => false,
                'tata_laksana_kasus'  => false,
            ];

            $nifasData = array_merge($defaultValues, $validatedData);
            $nifas     = Nifas::create($nifasData);

            DB::commit();

            return $this->successResponse(
                $nifas,
                'Data nifas berhasil disimpan',
                201
            );

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errorResponse(
                null,
                'Gagal menyimpan data nifas. Silakan coba lagi. ' . $e->getMessage(),
                500
            );
        }
    }

/**
 * Display the specified resource.
 */
    public function show(string $id)
    {
        $nifas = Nifas::with('kehamilan')->find($id);

        if (! $nifas) {
            return $this->errorResponse(null, 'Data nifas tidak ditemukan', 404);
        }

        return $this->successResponse($nifas, 'Data nifas berhasil ditemukan');
    }

/**
 * Update the specified resource in storage.
 */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kehamilan_id'        => ['sometimes', 'exists:kehamilans,id'],
            'periksa_asi'         => ['boolean'],
            'periksa_perdarahan'  => ['boolean'],
            'periksa_jalan_lahir' => ['boolean'],
            'vitamin_a'           => ['nullable', 'string'],
            'kb_pasca_kelahiran'  => ['nullable', 'in:suntik,pil'],
            'konseling'           => ['boolean'],
            'tata_laksana_kasus'  => ['boolean'],
        ]);

        DB::beginTransaction();

        try {
            $nifas = Nifas::findOrFail($id);
            $nifas->update($validatedData);

            DB::commit();

            return $this->successResponse(
                $nifas,
                'Data nifas berhasil diperbarui',
                200
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Data nifas tidak ditemukan',
                404
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Gagal memperbarui data nifas. Silakan coba lagi. ' . $e->getMessage(),
                500
            );
        }
    }

/**
 * Remove the specified resource from storage.
 */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $nifas = Nifas::findOrFail($id);
            $nifas->delete();

            DB::commit();

            return $this->successResponse(
                null,
                'Data nifas berhasil dihapus',
                200
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Data nifas tidak ditemukan',
                404
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Gagal menghapus data nifas. Silakan coba lagi. ' . $e->getMessage(),
                500
            );
        }
    }
}
