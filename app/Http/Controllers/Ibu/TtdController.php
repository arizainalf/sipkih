<?php
namespace App\Http\Controllers\Ibu;

use App\Models\Ttd;
use App\Models\Kehamilan;
use Illuminate\Http\Request;
use App\Traits\JsonResponder;
use App\Http\Controllers\Controller;

class TtdController extends Controller
{
    use JsonResponder;
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
}
