<?php
namespace App\Http\Controllers;

use App\Models\Ibu;
use App\Models\User;
use App\Traits\JsonResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use JsonResponder;
    public function login(Request $request)
    {
        if ($request->method() === 'GET') {
            return view('pages.auth.login');
        }

        $request->validate([
            'role' => ['required', 'in:admin,ibu'], // sesuaikan dengan role yang ada
        ]);

        $role = $request->input('role');

        if ($role === 'admin') {
            $credentials = $request->validate([
                'email'    => ['required', 'email', 'max:32'],
                'password' => ['required', 'min:6'],
            ]);

            $user = User::where('email', $credentials['email'])->first();

            if (! $user || ! Hash::check($credentials['password'], $user->password)) {
                return $this->errorResponse(null, 'Email atau password salah.');
            }

            Auth::guard('admin')->login($user, $request->remember);

            return $this->successResponse(
                $user,
                'Login berhasil. Anda akan diarahkan ke dashboard.'
            );
        } elseif ($role === 'ibu') {
            $credentials = $request->validate([
                'nik'      => ['required', 'max:32'],
                'password' => ['required', 'min:6'], // ganti nama field ke 'password'
            ]);

            $ibu = Ibu::where('nik', $credentials['nik'])->first();

            if (! $ibu) {
                return $this->errorResponse(null, 'NIK tidak terdaftar.');
            }

            if ($ibu && $ibu->tanggal_lahir !== $credentials['password']) {
                return $this->errorResponse(null, 'Password salah.');
            }

            Auth::guard('ibu')->login($ibu, $request->remember);

            return $this->successResponse(
                $ibu,
                'Login berhasil. Anda akan diarahkan ke dashboard.'
            );
        }

        return $this->errorResponse(null, 'Role tidak valid.');
    }
    public function register()
    {
        return view('pages.auth.register');

    }
    public function registerPost(Request $request)
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

    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('ibu')->check()) {
            Auth::guard('ibu')->logout();
        }
        return $this->successResponse(null, 'Logout berhasil.');
    }
}
