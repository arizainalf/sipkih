<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bayi;
use App\Models\Kehamilan;
use App\Models\KesimpulanNifas;
use App\Models\KunjunganNifas;
use App\Models\Nifas;
use App\Models\Pelayanan;
use App\Models\Persalinan;
use App\Models\Ttd;
use App\Traits\JsonResponder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $kehamilan           = Kehamilan::with('ibu', 'persalinan.bayi', 'persalinan.kesimpulanNifas', 'persalinan.kunjunganNifas')->where('id', $request->id)->first();
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

            $persalinan = Persalinan::create([
                'kehamilan_id' => $ibu->id,
            ]);

            Bayi::create([
                'persalinan_id' => $persalinan->id,
            ]);

            KunjunganNifas::create([
                'persalinan_id' => $persalinan->id,
            ]);

            KesimpulanNifas::create([
                'persalinan_id' => $persalinan->id,
            ]);

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

    public function updateMenyambutPersalinan(Request $request, $id)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'ibu_id'          => 'required|exists:ibus,id',
            'anak_ke'         => 'required|integer|min:1',
            'bulan'           => 'nullable|string',
            'tahun'           => 'nullable|integer|min:2000|max:2099',
            'kendaraan'       => 'required|in:pribadi,ambulance',
            'kontrasepsi'     => 'nullable|string|max:255',
            'sumbangan_darah' => 'nullable|string|max:255',
            'dana_persalinan' => 'required|in:sendiri,jkn,jampersal',
            'bidan'           => 'nullable|string|max:255',
        ], [
            'ibu_id.required'          => 'Data ibu harus dipilih',
            'ibu_id.exists'            => 'Data ibu tidak valid',
            'anak_ke.required'         => 'Anak ke harus diisi',
            'anak_ke.integer'          => 'Anak ke harus berupa angka',
            'anak_ke.min'              => 'Anak ke minimal 1',
            'tahun.integer'            => 'Tahun harus berupa angka',
            'tahun.min'                => 'Tahun minimal 2000',
            'tahun.max'                => 'Tahun maksimal 2099',
            'kendaraan.required'       => 'Kendaraan harus dipilih',
            'kendaraan.in'             => 'Pilihan kendaraan tidak valid',
            'dana_persalinan.required' => 'Dana persalinan harus dipilih',
            'dana_persalinan.in'       => 'Pilihan dana persalinan tidak valid',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            // Temukan data kehamilan
            $kehamilan = Kehamilan::findOrFail($id);

            // Update data
            $kehamilan->update([
                'ibu_id'          => $request->ibu_id,
                'anak_ke'         => $request->anak_ke,
                'bulan'           => $request->bulan,
                'tahun'           => $request->tahun,
                'kendaraan'       => $request->kendaraan,
                'kontrasepsi'     => $request->kontrasepsi,
                'sumbangan_darah' => $request->sumbangan_darah,
                'dana_persalinan' => $request->dana_persalinan,
                'bidan'           => $request->bidan,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Data kehamilan berhasil diperbarui',
                'data'    => $kehamilan,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal memperbarui data kehamilan',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function updatePersalinan(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'kehamilan_id'          => 'required|exists:kehamilans,id',
            'tanggal_persalinan'    => 'required|date',
            'waktu_persalinan'      => 'nullable|date_format:H:i',
            'umur_kehamilan_minggu' => 'required|integer|min:20|max:45',
            'penolong_persalinan'   => 'required|in:SpOG,Dokter Umum,Bidan,Lainnya',
            'cara_persalinan'       => 'required|in:Normal,Forceps,Vakum,Sectio Caesarea,Lainnya',
            'keadaan_ibu'           => 'required|in:Sehat,Sakit,Meninggal',
            'detail_keadaan_ibu'    => 'nullable|string',
            'kb_pasca_persalinan'   => 'nullable|string',
            'keterangan_tambahan'   => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        try {
            $persalinan = Persalinan::findOrFail($id);
            $persalinan->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data persalinan berhasil diperbarui',
                'data'    => $persalinan,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data persalinan',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // BayiController.php
    public function updateBayi(Request $request, $id)
    {
        // dd($request->all());
$request->validate([
    'persalinan_id'           => 'required|exists:persalinans,id',
    'berat_lahir_gram'        => 'required|integer|min:500|max:6000',
    'panjang_badan_cm'        => 'required|numeric|min:20|max:60',
    'lingkar_kepala_cm'       => 'required|numeric|min:20|max:40',
    'jenis_kelamin'           => 'required|in:Laki-laki,Perempuan,Tidak bisa ditentukan',
    'kelainan_bawaan'         => 'nullable|string',
    'keterangan_tambahan'     => 'nullable|string',
    // Boolean fields
    'segera_menangis'         => 'nullable',
    'menangis_beberapa_saat'  => 'nullable',
    'tidak_menangis'          => 'nullable',
    'seluruh_tubuh_kemerahan' => 'nullable',
    'anggota_gerak_kebiruan'  => 'nullable',
    'seluruh_tubuh_biru'      => 'nullable',
    'meninggal'               => 'nullable',
    'imd'                     => 'nullable',
    'vitamin_k1'              => 'nullable',
    'salep_mata'              => 'nullable',
    'imunisasi_hb0'           => 'nullable',
], [
    // Pesan error dalam bahasa Indonesia
    'persalinan_id.required'           => 'ID persalinan wajib diisi.',
    'persalinan_id.exists'             => 'Persalinan yang dipilih tidak valid.',

    'berat_lahir_gram.required'        => 'Berat lahir dalam gram wajib diisi.',
    'berat_lahir_gram.integer'         => 'Berat lahir harus berupa angka.',
    'berat_lahir_gram.min'             => 'Berat lahir minimal 500 gram.',
    'berat_lahir_gram.max'             => 'Berat lahir maksimal 6000 gram.',

    'panjang_badan_cm.required'        => 'Panjang badan dalam cm wajib diisi.',
    'panjang_badan_cm.numeric'         => 'Panjang badan harus berupa angka.',
    'panjang_badan_cm.min'             => 'Panjang badan minimal 20 cm.',
    'panjang_badan_cm.max'             => 'Panjang badan maksimal 60 cm.',

    'lingkar_kepala_cm.required'       => 'Lingkar kepala dalam cm wajib diisi.',
    'lingkar_kepala_cm.numeric'        => 'Lingkar kepala harus berupa angka.',
    'lingkar_kepala_cm.min'            => 'Lingkar kepala minimal 20 cm.',
    'lingkar_kepala_cm.max'            => 'Lingkar kepala maksimal 40 cm.',

    'jenis_kelamin.required'           => 'Jenis kelamin wajib dipilih.',
    'jenis_kelamin.in'                 => 'Jenis kelamin yang dipilih tidak valid.',

    'kelainan_bawaan.string'           => 'Kolom kelainan bawaan harus berupa teks.',

    'keterangan_tambahan.string'       => 'Kolom keterangan tambahan harus berupa teks.',
]);

        try {
            $bayi = Bayi::findOrFail($id);

            // Update data utama
            $bayi->update($request->only([
                'persalinan_id', 'anak_ke', 'berat_lahir_gram',
                'panjang_badan_cm', 'lingkar_kepala_cm',
                'jenis_kelamin', 'kelainan_bawaan', 'keterangan_tambahan',
            ]));

            // Update boolean fields
            $booleanFields = [
                'segera_menangis', 'menangis_beberapa_saat', 'tidak_menangis',
                'seluruh_tubuh_kemerahan', 'anggota_gerak_kebiruan', 'seluruh_tubuh_biru',
                'meninggal', 'imd', 'vitamin_k1', 'salep_mata', 'imunisasi_hb0',
            ];

            foreach ($booleanFields as $field) {
                $bayi->{$field} = $request->has($field);
            }

            $bayi->save();

            return response()->json([
                'success' => true,
                'message' => 'Data bayi berhasil diperbarui',
                'data'    => $bayi,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data bayi',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // KunjunganNifasController.php
    public function updateKunjunganNifas(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'persalinan_id'          => 'required|exists:persalinans,id',

            // KF1 fields
            'tanggal_kunjungan_kf_1' => 'nullable|date',
            'faskes_kf_1'            => 'nullable|string|max:255',
            'masalah_kf_1'           => 'nullable|string',
            'tindakan_kf_1'          => 'nullable|string',

            // KF2 fields
            'tanggal_kunjungan_kf_2' => 'nullable|date',
            'faskes_kf_2'            => 'nullable|string|max:255',
            'masalah_kf_2'           => 'nullable|string',
            'tindakan_kf_2'          => 'nullable|string',

            // KF3 fields
            'tanggal_kunjungan_kf_3' => 'nullable|date',
            'faskes_kf_3'            => 'nullable|string|max:255',
            'masalah_kf_3'           => 'nullable|string',
            'tindakan_kf_3'          => 'nullable|string',

            // KF4 fields
            'tanggal_kunjungan_kf_4' => 'nullable|date',
            'faskes_kf_4'            => 'nullable|string|max:255',
            'masalah_kf_4'           => 'nullable|string',
            'tindakan_kf_4'          => 'nullable|string',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $kunjungan = KunjunganNifas::findOrFail($id);

            // Update data for each visit type
            $kunjungan->update([
                'persalinan_id'          => $request->persalinan_id,

                // KF1 data
                'tanggal_kunjungan_kf_1' => $request->tanggal_kunjungan_kf_1,
                'faskes_kf_1'            => $request->faskes_kf_1,
                'masalah_kf_1'           => $request->masalah_kf_1,
                'tindakan_kf_1'          => $request->tindakan_kf_1,

                // KF2 data
                'tanggal_kunjungan_kf_2' => $request->tanggal_kunjungan_kf_2,
                'faskes_kf_2'            => $request->faskes_kf_2,
                'masalah_kf_2'           => $request->masalah_kf_2,
                'tindakan_kf_2'          => $request->tindakan_kf_2,

                // KF3 data
                'tanggal_kunjungan_kf_3' => $request->tanggal_kunjungan_kf_3,
                'faskes_kf_3'            => $request->faskes_kf_3,
                'masalah_kf_3'           => $request->masalah_kf_3,
                'tindakan_kf_3'          => $request->tindakan_kf_3,

                // KF4 data
                'tanggal_kunjungan_kf_4' => $request->tanggal_kunjungan_kf_4,
                'faskes_kf_4'            => $request->faskes_kf_4,
                'masalah_kf_4'           => $request->masalah_kf_4,
                'tindakan_kf_4'          => $request->tindakan_kf_4,

            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data kunjungan nifas berhasil diperbarui',
                'data'    => $kunjungan,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data kunjungan nifas',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // KesimpulanNifasController.php
    public function updateKesimpulanNifas(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'persalinan_id'   => 'required|exists:persalinans,id',
            'keadaan_ibu'     => 'required|in:Sehat,Sakit,Meninggal',
            'keadaan_bayi'    => 'required|in:Sehat,Sakit,Meninggal',
            'kelainan_bawaan' => 'nullable|string',
            'catatan'         => 'nullable|string',
            'kesimpulan'      => 'required|string',
            // Boolean fields
            'perdarahan'      => 'nullable',
            'infeksi'         => 'nullable',
            'hipertensi'      => 'nullable',
            'komplikasi_lain' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $kesimpulan = KesimpulanNifas::findOrFail($id);

            // Update data utama
            $kesimpulan->update($request->only([
                'persalinan_id', 'keadaan_ibu', 'keadaan_bayi',
                'kelainan_bawaan', 'catatan', 'kesimpulan', 'komplikasi_lain',
            ]));

            // Update boolean fields
            $booleanFields = ['perdarahan', 'infeksi', 'hipertensi'];
            foreach ($booleanFields as $field) {
                $kesimpulan->{$field} = $request->has($field);
            }

            $kesimpulan->save();

            return response()->json([
                'success' => true,
                'message' => 'Data kesimpulan nifas berhasil diperbarui',
                'data'    => $kesimpulan,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data kesimpulan nifas',
                'error'   => $e->getMessage(),
            ], 500);
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

    public function exportPdf(Request $request, $id)
    {
        // Ambil data
        $pelayanans = Pelayanan::where('kehamilan_id', $id)
            ->orderBy('trismester')
            ->get(['trismester', 'bb', 'tinggi_rahim', 'lingkar_lengan_atas']);

        $nifas = Nifas::where('kehamilan_id', $id)->get();

        $labels = $pelayanans->pluck('trismester')->map(function ($item) {
            return 'Tri-' . $item;
        })->toArray();

        $kehamilan = Kehamilan::with('ibu', 'persalinan.bayi', 'persalinan.kesimpulanNifas', 'persalinan.kunjunganNifas')->where('id', $request->id)->first();

        // Generate chart gambar
        $chartPath = $this->generateCombinedChart(
            $pelayanans->pluck('bb')->toArray(),
            $pelayanans->pluck('tinggi_rahim')->toArray(),
            $pelayanans->pluck('lingkar_lengan_atas')->toArray(),
            $labels
        );

        $pelayanan = Pelayanan::where('kehamilan_id', $id)->get();

        // PDF
        $pdf = Pdf::loadView('pages.admin.kehamilan.detail.pdf', [
            'kehamilan'  => $kehamilan,
            'chartPath'  => $chartPath,
            'labels'     => $labels,
            'data'       => $pelayanans,
            'nifas'      => $nifas,
            'pelayanans' => $pelayanan,
        ]);

        $pdf->setPaper('legal', 'landscape');

        return $pdf->download('laporan-kehamilan.pdf');
    }

    private function generateCombinedChart($bb, $tinggiRahim, $lingkarLengan, $labels)
    {
        $width  = 800;
        $height = 400;
        $image  = imagecreatetruecolor($width, $height);

        // Warna
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $red   = imagecolorallocate($image, 255, 0, 0);
        $blue  = imagecolorallocate($image, 0, 0, 255);
        $green = imagecolorallocate($image, 0, 128, 0);

        imagefill($image, 0, 0, $white);

                                                                                // Gambar sumbu
        imageline($image, 50, $height - 50, $width - 50, $height - 50, $black); // X
        imageline($image, 50, 50, 50, $height - 50, $black);                    // Y

        // Hitung skala
        $maxValue = max(max($bb), max($tinggiRahim), max($lingkarLengan));
        $scale    = ($height - 100) / ($maxValue + 10);

        // Gambar garis untuk setiap dataset
        $this->drawDataset($image, $bb, $labels, $scale, $red, $height);
        $this->drawDataset($image, $tinggiRahim, $labels, $scale, $blue, $height);
        $this->drawDataset($image, $lingkarLengan, $labels, $scale, $green, $height);

        // Legenda
        $this->drawLegend($image, [
            ['Berat Badan (kg)', $red],
            ['Tinggi Rahim (cm)', $blue],
            ['Lingkar Lengan (cm)', $green],
        ]);

        // Label sumbu X
        foreach ($labels as $i => $label) {
            $x = 50 + ($i * 100);
            imagestring($image, 3, $x - 15, $height - 40, $label, $black);
        }

        // Simpan gambar
        $chartPath = storage_path('app/public/charts/combined_chart.png');
        if (! file_exists(dirname($chartPath))) {
            mkdir(dirname($chartPath), 0777, true);
        }
        imagepng($image, $chartPath);
        imagedestroy($image);

        return $chartPath;
    }

    private function drawDataset($image, $data, $labels, $scale, $color, $baseHeight)
    {
        $prevX = $prevY = null;
        foreach ($data as $i => $value) {
            $x = 50 + ($i * 100);
            $y = $baseHeight - 50 - ($value * $scale);

            // Titik data
            imagefilledellipse($image, $x, $y, 8, 8, $color);

            // Garis penghubung
            if ($prevX !== null) {
                imageline($image, $prevX, $prevY, $x, $y, $color);
            }

            // Label nilai
            imagestring($image, 3, $x - 10, $y - 20, $value, $color);

            $prevX = $x;
            $prevY = $y;
        }
    }

    private function drawLegend($image, $items)
    {
        $x = 600;
        $y = 50;

        foreach ($items as $i => $item) {
            list($text, $color) = $item;

            // Kotak warna
            imagefilledrectangle($image, $x, $y + ($i * 30), $x + 20, $y + 20 + ($i * 30), $color);
            imagestring($image, 4, $x + 30, $y + ($i * 30), $text, $color);
        }
    }
}
