<?php
namespace App\Http\Controllers\Ibu;

use App\Models\Ttd;
use App\Models\Kehamilan;
use App\Models\Pelayanan;
use Illuminate\Http\Request;
use App\Traits\JsonResponder;
use App\Http\Controllers\Controller;

class KehamilanController extends Controller
{
    use JsonResponder;
    public function index()
    {
        return view('pages.ibu.kehamilan.index');
    }
    public function table(Request $request)
    {
        $kehamilans = Kehamilan::with('ibu')->where('ibu_id', auth()->user()->id)->get();
        $data       = [
            'view' => view('pages.ibu.kehamilan.table', compact('kehamilans'))->render(),
        ];
        return $this->successResponse($data, 'Data berhasil ditemukan.');
    }
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
        return view('pages.ibu.kehamilan.detail.index', compact('kehamilan', 'labels', 'bb', 'tinggiRahim', 'tb', 'lingkar_lengan_atas'));
    }
    public function detailTtd(Request $request, string $id)
    {
        if ($request->ajax()) {
            $kehamilan = Kehamilan::with('ibu')->where('id', $id)->first();
            $ttds      = Ttd::with('kehamilan')->where('kehamilan_id', $id)->get();
            $data      = [
                'view' => view('pages.ibu.kehamilan.detail.table-ttd', compact('ttds'))->render(),
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
