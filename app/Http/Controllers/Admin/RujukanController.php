<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rujukan;
use App\Traits\JsonResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RujukanController extends Controller
{
    use JsonResponder;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->mode == 'select') {
            $data = Rujukan::with('ibu')->get();
            return $this->successResponse(
                $data,
                'Data berhasil ditemukan',
            );
        }
        return view('pages.admin.rujukan.index');
    }
    public function table(Request $request)
    {
        $rujukans = Rujukan::with('ibu')->get();
        $data     = [
            'view' => view('pages.admin.rujukan.table', compact('rujukans'))->render(),
        ];
        return $this->successResponse($data, 'Data berhasil ditemukan.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ibu_id'          => ['required', 'exists:ibus,id'],
            'alasan'          => ['required', 'string', 'max:100'],
            'tanggal_rujukan' => ['required', 'date'],
            'diagnosa_akhir'  => ['required', 'string', 'max:50'],
            'anjuran'         => ['required', 'string'], // tambahkan validasi golongan darah
        ]);

        DB::beginTransaction();

        try {

            $rujukan = Rujukan::create($validatedData);

            DB::commit();

            return $this->successResponse(
                $rujukan,
                'Berhasil mendaftar',
                201
            );

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errorResponse(
                null,
                'Gagal mendaftar. Silakan coba lagi. ' . $e->getMessage(),
                500// HTTP Internal Server Error
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rujukan = Rujukan::with('ibu')->where('id', $id)->first();
        if (! $rujukan) {
            return $this->errorResponse(null, 'Data gagal ditemukan');
        }
        return $this->successResponse($rujukan, 'Data berhasil ditemukan');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ibu_id'          => ['required', 'exists:ibus,id'],
            'alasan'          => ['required', 'string', 'max:100'],
            'tanggal_rujukan' => ['required', 'date'],
            'diagnosa_akhir'  => ['required', 'string', 'max:50'],
            'anjuran'         => ['required', 'string'],
        ]);

        DB::beginTransaction();

        try {
            $rujukan = Rujukan::findOrFail($id);
            $rujukan->update($validatedData);

            DB::commit();

            return $this->successResponse(
                $rujukan,
                'Data rujukan berhasil diperbarui',
                200
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Data rujukan tidak ditemukan',
                404
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Gagal memperbarui data. Silakan coba lagi. ' . $e->getMessage(),
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
            $rujukan = Rujukan::findOrFail($id);
            $rujukan->delete();

            DB::commit();

            return $this->successResponse(
                null,
                'Data rujukan berhasil dihapus',
                200
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Data rujukan tidak ditemukan',
                404
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Gagal menghapus data. Silakan coba lagi. ' . $e->getMessage(),
                500
            );
        }
    }
}
