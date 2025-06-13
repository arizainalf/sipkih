<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ibu;
use App\Models\Kehamilan;
use App\Traits\JsonResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class IbuController extends Controller
{
    use JsonResponder;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->mode == 'select') {
            $data = Ibu::with('kehamilans')->get();
            return $this->successResponse(
                $data,
                'Data berhasil ditemukan',
            );
        } else if ($request->ajax()) {

            $ibus = Ibu::with('kehamilans')->get();
            $data = [
                'view' => view('pages.admin.ibu.table', compact('ibus'))->render(),
            ];
            return $this->successResponse($data, 'Data berhasil ditemukan.');
        }
        return view('pages.admin.ibu.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function detail(Request $request, string $id)
    {
        $ibu = Ibu::with('kehamilans')->where('id', $id)->first();

        if ($request->ajax()) {

            $kehamilans = Kehamilan::with('ibu')->where('ibu_id', $ibu->id)->get();

            $data = [
                'view' => view('pages.admin.ibu.detail.table', compact('kehamilans'))->render(),
            ];
            return $this->successResponse($data, 'Data berhasil ditemukan.');
        }
        return view('pages.admin.ibu.detail.index', compact('ibu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik'            => ['required', 'string', 'max:32', 'unique:ibus,nik'],
            'nama'           => ['required', 'string', 'max:100'],
            'pembiayaan'     => ['required', 'in:Mandiri,KIS,KIP'],
            'no_jkn'         => ['required', 'string', 'max:50'],
            'golongan_darah' => ['required', 'string', 'max:2', 'in:A,B,AB,O'], // tambahkan validasi golongan darah
            'tempat_lahir'   => ['required', 'string', 'max:50'],
            'tanggal_lahir'  => ['required', 'date', 'before:today'], // pastikan tanggal lahir valid
            'pendidikan'     => ['required', 'in:sd,smp,sma,d3,s1,s2,s3'],
            'pekerjaan'      => ['required', 'string', 'max:50'],
            'alamat'         => ['required', 'string', 'max:255'],
            'telepon'        => ['required', 'string', 'max:15', 'regex:/^[0-9]+$/'], // hanya angka
            'suami'          => ['required', 'string', 'max:100'],
        ]);

        DB::beginTransaction();

        try {

            $ibu = Ibu::create($validatedData);

            DB::commit();

            return $this->successResponse(
                $ibu,
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
        $ibu = Ibu::with('kehamilans')->where('id', $id)->first();
        if (! $ibu) {
            return $this->errorResponse(null, 'Data gagal ditemukan');
        }
        return $this->successResponse($ibu, 'Data berhasil ditemukan');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nik'            => ['required', 'string', 'max:32', Rule::unique('ibus', 'nik')->ignore($id)],
            'nama'           => ['required', 'string', 'max:100'],
            'pembiayaan'     => ['required', 'in:Mandiri,KIS,KIP'],
            'no_jkn'         => ['required', 'string', 'max:50'],
            'golongan_darah' => ['required', 'string', 'max:2', 'in:A,B,AB,O'],
            'tempat_lahir'   => ['required', 'string', 'max:50'],
            'tanggal_lahir'  => ['required', 'date', 'before:today'],
            'pendidikan'     => ['required', 'in:sd,smp,sma,d3,s1,s2,s3'],
            'pekerjaan'      => ['required', 'string', 'max:50'],
            'alamat'         => ['required', 'string', 'max:255'],
            'telepon'        => ['required', 'string', 'max:15', 'regex:/^[0-9]+$/'],
            'suami'          => ['required', 'string', 'max:100'],
        ]);

        DB::beginTransaction();

        try {
            $ibu = Ibu::findOrFail($id);
            $ibu->update($validatedData);

            DB::commit();

            return $this->successResponse(
                $ibu,
                'Data ibu berhasil diperbarui',
                200
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Data ibu tidak ditemukan',
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
            $ibu = Ibu::findOrFail($id);
            $ibu->delete();

            DB::commit();

            return $this->successResponse(
                null,
                'Data ibu berhasil dihapus',
                200
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Data ibu tidak ditemukan',
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
