<?php
namespace App\Http\Controllers\Ibu;

use App\Http\Controllers\Controller;
use App\Models\Ibu;
use App\Traits\JsonResponder;
use Illuminate\Http\Request;

class IbuController extends Controller
{
    use JsonResponder;
    public function profile(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('pages.ibu.profile.index');
        }

        $validated = $request->validate([
            'nik'            => 'required|string|max:20',
            'nama'           => 'required|string|max:255',
            'pembiayaan'     => 'required|in:Mandiri,KIS,KIP',
            'no_jkn'         => 'nullable|string|max:30',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'tempat_lahir'   => 'nullable|string|max:255',
            'tanggal_lahir'  => 'required|date',
            'pendidikan'     => 'required|in:sd,smp,sma,d3,s1,s2,s3',
            'pekerjaan'      => 'nullable|string|max:255',
            'alamat'         => 'required|string',
            'telepon'        => 'nullable|string|max:20',
            'suami'          => 'nullable|string|max:255',
        ]);

        try {

            $user = Ibu::findOrFail(auth()->user()->id);
            $user->update($validated);

            return $this->successResponse($user, 'Profile berhasil diperbarui.');
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Gagal memperbarui profile. Silakan coba lagi.');
        }
    }
}
