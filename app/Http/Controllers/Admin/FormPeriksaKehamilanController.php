<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormPeriksaKehamilan;
use App\Traits\JsonResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormPeriksaKehamilanController extends Controller
{
    use JsonResponder;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->mode == 'select') {

            $data = FormPeriksaKehamilan::all();

            return $this->successResponse(
                $data,
                'Data berhasil ditemukan',
            );
        } else if ($request->ajax()) {

            $forms = FormPeriksaKehamilan::all();

            $data = [
                'view' => view('pages.admin.form.table', compact('forms'))->render(),
            ];
            return $this->successResponse($data, 'Data berhasil ditemukan.');
        }
        return view('pages.admin.form.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function detail(Request $request, string $id)
    {
        $form = FormPeriksaKehamilan::where('id', $id)->first();

        if ($request->ajax()) {

            $form = FormPeriksaKehamilan::all();

            $data = [
                'view' => view('pages.admin.form.detail.table', compact('form'))->render(),
            ];
            return $this->successResponse($data, 'Data berhasil ditemukan.');
        }
        return view('pages.admin.form.detail.index', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
        ]);

        DB::beginTransaction();

        try {

            $form = FormPeriksaKehamilan::create($validatedData);

            DB::commit();

            return $this->successResponse(
                $form,
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
        $form = FormPeriksaKehamilan::where('id', $id)->first();

        if (! $form) {
            return $this->errorResponse(null, 'Data gagal ditemukan');
        }

        return $this->successResponse($form, 'Data berhasil ditemukan');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
        ]);

        DB::beginTransaction();

        try {
            $form = FormPeriksaKehamilan::findOrFail($id);

            $form->update($validatedData);

            DB::commit();

            return $this->successResponse(
                $form,
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
            $form = FormPeriksaKehamilan::findOrFail($id);
            $form->delete();

            DB::commit();

            return $this->successResponse(
                null,
                'Data form berhasil dihapus',
                200
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            DB::rollBack();

            return $this->errorResponse(
                null,
                'Data form tidak ditemukan',
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
