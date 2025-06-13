<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kehamilan;
use App\Models\Nifas;
use App\Models\Pelayanan;
use App\Models\Ttd;
use App\Traits\JsonResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KehamilanController extends Controller
{
    use JsonResponder;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->mode == 'select') {
            $data = Kehamilan::with('ibu')->get();
            return $this->successResponse(
                $data,
                'Data berhasil ditemukan',
            );
        }

        return view('pages.admin.kehamilan.index');
    }
    public function table(Request $request)
    {
        $kehamilans = Kehamilan::with('ibu')->get();
        $data       = [
            'view' => view('pages.admin.kehamilan.table', compact('kehamilans'))->render(),
        ];
        return $this->successResponse($data, 'Data berhasil ditemukan.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function detail(Request $request)
    {
        $pelayanans = Pelayanan::where('kehamilan_id', $request->id)
            ->orderBy('trismester')
            ->get(['trismester', 'bb', 'tinggi_rahim', 'tb', 'lingkar_lengan_atas']);

        $labels = $pelayanans->pluck('trismester')->map(function ($item) {
            return 'Trimester ' . $item;
        });

        $bb                  = $pelayanans->pluck('bb');
        $tinggiRahim         = $pelayanans->pluck('tinggi_rahim');
        $tb                  = $pelayanans->pluck('tb');
        $lingkar_lengan_atas = $pelayanans->pluck('lingkar_lengan_atas');
        $kehamilan           = Kehamilan::with('ibu')->where('id', $request->id)->first();
        return view('pages.admin.kehamilan.detail.index', compact('kehamilan', 'labels', 'bb', 'tinggiRahim', 'tb', 'lingkar_lengan_atas'));
    }
    public function detailNifas(Request $request, string $id)
    {
        if ($request->ajax()) {
            $kehamilan = Kehamilan::with('ibu')->where('id', $id)->first();
            $nifas     = Nifas::with('kehamilan')->get()->where('kehamilan_id', $id);
            $data      = [
                'view' => view('pages.admin.kehamilan.detail.table-nifas', compact('nifas'))->render(),
            ];
            return $this->successResponse($data, 'Data berhasil ditemukan.');
        }
    }
    public function detailPelayanan(Request $request, string $id)
    {
        if ($request->ajax()) {
            $kehamilan  = Kehamilan::with('ibu')->where('id', $id)->first();
            $pelayanans = Pelayanan::with('kehamilan')->where('kehamilan_id', $id)->get();
            $data       = [
                'view' => view('pages.admin.kehamilan.detail.table-pelayanan', compact('pelayanans'))->render(),
            ];
            return $this->successResponse($data, 'Data berhasil ditemukan.');
        }
    }

    public function detailTtd(Request $request, string $id)
    {
        if ($request->ajax()) {
            $kehamilan = Kehamilan::with('ibu')->where('id', $id)->first();
            $ttds      = Ttd::with('kehamilan')->where('kehamilan_id', $id)->get();
            $data      = [
                'view' => view('pages.admin.kehamilan.detail.table-ttd', compact('ttds'))->render(),
            ];
            return $this->successResponse($data, 'Data berhasil ditemukan.');
        }
    }

    public function getTanggalEvents(Kehamilan $kehamilan)
    {
        $events = $kehamilan->ttds->map(function ($ttd) {
            return [
                'id'              => $ttd->id,
                'title'           => 'Tanggal',
                'start'           => $ttd->tanggal,
                'backgroundColor' => $ttd->status ? '#28a745' : '#6c757d',
                'borderColor'     => $ttd->status ? '#28a745' : '#6c757d',
            ];
        });

        return response()->json($events);
    }

    public function toggleTanggal(Request $request, Ttd $ttd)
    {
        $ttd->status = ! $ttd->status;
        $ttd->save();

        return response()->json([
            'status'  => $ttd->status,
            'message' => 'Status berhasil diperbarui',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ibu_id'  => ['required', 'exists:ibus,id'],
            'anak_ke' => ['required', 'integer', 'min:1'],
        ]);

        DB::beginTransaction();

        try {

            $ibu = Kehamilan::create($validatedData);

            DB::commit();

            return $this->successResponse(
                $ibu,
                'Berhasil disimpan',
                201
            );

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errorResponse(
                null,
                'Gagal meyimpan. Silakan coba lagi. ' . $e->getMessage(),
                500// HTTP Internal Server Error
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kehamilan = Kehamilan::with('ibu')->where('id', $id)->first();
        if (! $kehamilan) {
            return $this->errorResponse(null, 'Data gagal ditemukan');
        }
        return $this->successResponse($kehamilan, 'Data berhasil ditemukan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'ibu_id'  => ['required', 'exists:ibus,id'],
            'anak_ke' => ['required', 'integer', 'min:1', 'unique:kehamilans,anak_ke,' . $id . ',id'],
        ]);

        DB::beginTransaction();

        try {
            $kehamilan = Kehamilan::findOrFail($id);
            $kehamilan->update($validatedData);

            DB::commit();

            return $this->successResponse(
                $kehamilan,
                'Berhasil diperbarui',
                200
            );

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errorResponse(
                null,
                'Gagal memperbarui. Silakan coba lagi. ' . $e->getMessage(),
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
            $kehamilan = Kehamilan::findOrFail($id);
            $kehamilan->delete();

            DB::commit();

            return $this->successResponse(
                null,
                'Berhasil dihapus',
                200
            );

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errorResponse(
                null,
                'Gagal menghapus. Silakan coba lagi. ' . $e->getMessage(),
                500
            );
        }
    }

}
