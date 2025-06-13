<?php
namespace App\Http\Controllers\Admin;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use App\Traits\JsonResponder;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    use JsonResponder;
    public function index()
    {
        return view('pages.admin.pengaturan.index');
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_aplikasi'      => 'required|string|max:100',
            'deskripsi_aplikasi' => 'required|string|max:255',
            'logo'               => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $pengaturan = Pengaturan::firstOrCreate(['id' => 1]);

            if ($request->hasFile('logo')) {
                // Hapus logo lama jika ada
                if ($pengaturan->logo) {
                    Storage::delete($pengaturan->logo);
                }

                // Simpan logo baru
                $logoPath          = $request->file('logo')->store('pengaturan', 'public');
                $validated['logo'] = $logoPath;
            } else {
                // Pertahankan logo lama jika tidak ada upload baru
                unset($validated['logo']);
            }

            $pengaturan->update($validated);

            DB::commit();

            return $this->successResponse([
                'nama_aplikasi' => $pengaturan->nama_aplikasi,
                'logo_url'      => $pengaturan->logo ? asset('storage/' . $pengaturan->logo) : null,
            ], 'Pengaturan berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(
                ['error' => $e->getMessage()],
                'Gagal memperbarui pengaturan: ' . $e->getMessage(),
                500
            );
        }
    }
}
