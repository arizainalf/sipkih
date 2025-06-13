<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelayanan;
use App\Traits\JsonResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelayananController extends Controller
{
    use JsonResponder;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->mode == 'select') {

            $data = Pelayanan::with('kehamilan.ibu')->get();

            return $this->successResponse(
                $data,
                'Data berhasil ditemukan',
            );
        } else if ($request->ajax()) {

            $pelayanans = Pelayanan::with('kehamilan.ibu')->get();

            $data = [
                'view' => view('pages.admin.pelayanan.table', compact('pelayanans'))->render(),
            ];
            return $this->successResponse($data, 'Data berhasil ditemukan.');
        }
        return view('pages.admin.pelayanan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function detail(Request $request, string $id)
    {
        $pelayanan = Pelayanan::with('kehamilan.ibu')->where('id', $id)->first();
        return view('pages.admin.pelayanan.detail.index', compact('pelayanan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kehamilan_id'        => ['required', 'exists:kehamilans,id'],
            'trismester'          => ['required', 'string'],
            'tanggal_periksa'     => ['required', 'date'],
            'tb'                  => ['required', 'numeric'],
            'bb'                  => ['required', 'numeric'],
            'lingkar_lengan_atas' => ['required', 'numeric'],
            'detak_jantung_janin' => ['required', 'string'],
            'tinggi_rahim'        => ['required', 'numeric'],
            'konseling'           => ['required', 'string'],
            'test_hb'             => ['required', 'string'],
            'test_golongan_darah' => ['required', 'string'],
            'test_protein_urin'   => ['required', 'string'],
            'test_gula_darah'     => ['required', 'string'],
            'ppia'                => ['required', 'in:reaktif,non reaktif'],
            'tata_laksana_kasus'  => ['nullable', 'string'],
            'usg'                 => ['required', 'string'],
        ]);

        DB::beginTransaction();

        try {
            $pelayanan = Pelayanan::create($validatedData);

            DB::commit();

            return $this->successResponse(
                $pelayanan,
                'Berhasil mendaftar pelayanan',
                201
            );

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errorResponse(
                null,
                'Gagal mendaftar pelayanan. Silakan coba lagi. ' . $e->getMessage(),
                500
            );
        }
    }

/**
 * Display the specified resource.
 */
    public function show(string $id)
    {
        $pelayanan = Pelayanan::where('id', $id)->first();

        if (! $pelayanan) {
            return $this->errorResponse(null, 'Data pelayanan gagal ditemukan', 404);
        }

        return $this->successResponse($pelayanan, 'Data pelayanan berhasil ditemukan');
    }

/**
 * Update the specified resource in storage.
 */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kehamilan_id'        => ['required', 'exists:kehamilans,id'],
            'trismester'          => ['required', 'string'],
            'tanggal_periksa'     => ['required', 'date'],
            'tb'                  => ['required', 'numeric'],
            'bb'                  => ['required', 'numeric'],
            'lingkar_lengan_atas' => ['required', 'numeric'],
            'detak_jantung_janin' => ['required', 'string'],
            'tinggi_rahim'        => ['required', 'numeric'],
            'konseling'           => ['required', 'string'],
            'test_hb'             => ['required', 'string'],
            'test_golongan_darah' => ['required', 'string'],
            'test_protein_urin'   => ['required', 'string'],
            'test_gula_darah'     => ['required', 'string'],
            'ppia'                => ['required', 'in:reaktif,non reaktif'],
            'tata_laksana_kasus'  => ['nullable', 'string'],
            'usg'                 => ['required', 'string'],
        ]);

        DB::beginTransaction();

        try {
            $pelayanan = Pelayanan::findOrFail($id);
            $pelayanan->update($validatedData);

            DB::commit();

            return $this->successResponse(
                $pelayanan,
                'Data pelayanan berhasil diperbarui',
                200
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Data pelayanan tidak ditemukan',
                404
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Gagal memperbarui data pelayanan. Silakan coba lagi. ' . $e->getMessage(),
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
            $pelayanan = Pelayanan::findOrFail($id);
            $pelayanan->delete();

            DB::commit();

            return $this->successResponse(
                null,
                'Data pelayanan berhasil dihapus',
                200
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Data pelayanan tidak ditemukan',
                404
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Gagal menghapus data pelayanan. Silakan coba lagi. ' . $e->getMessage(),
                500
            );
        }
    }
}
