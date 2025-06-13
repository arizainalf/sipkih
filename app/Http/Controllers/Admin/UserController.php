<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\JsonResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use JsonResponder;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->mode == 'select') {
            $data = User::all();
            return $this->successResponse(
                $data,
                'Data berhasil ditemukan',
            );
        }
        return view('pages.admin.user.index');
    }
    public function table(Request $request)
    {
        $users = User::all();
        $data  = [
            'view' => view('pages.admin.user.table', compact('users'))->render(),
        ];
        return $this->successResponse($data, 'Data berhasil ditemukan.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'max:32'],
        ]);

        DB::beginTransaction();

        try {

            $validatedData['password'] = Hash::make($validatedData['password']);

            $user = User::create($validatedData);

            DB::commit();

            return $this->successResponse(
                $user,
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
        $user = User::where('id', $id)->first();
        if (! $user) {
            return $this->errorResponse(null, 'Data gagal ditemukan');
        }
        return $this->successResponse($user, 'Data berhasil ditemukan');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama'  => ['required', 'string', 'max:100'],
            'email' => ['required', 'email'],
        ]);

        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $user->update($validatedData);

            DB::commit();

            return $this->successResponse(
                $user,
                'Data user berhasil diperbarui',
                200
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Data user tidak ditemukan',
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
            $user = User::findOrFail($id);
            $user->delete();

            DB::commit();

            return $this->successResponse(
                null,
                'Data user berhasil dihapus',
                200
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse(
                null,
                'Data user tidak ditemukan',
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
    public function profile(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('pages.admin.profile.index');
        }

        $validated = $request->validate([
            'nama'  => 'required',
            'email' => 'required|email',
        ]);

        try {

            $user = User::findOrFail(auth()->user()->id);
            $user->update($validated);

            return $this->successResponse($user, 'Profile berhasil diperbarui.');
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Gagal memperbarui profile. Silakan coba lagi.');
        }
    }
    public function updatePassword(Request $request)
    {

        $validated = $request->validate([
            'password'                 => 'required',
            'password_baru'            => 'required',
            'konfirmasi_password_baru' => 'required',
        ]);

        try {
            $user = auth()->user();

            if (! Hash::check($validated['password'], $user->password)) {
                return $this->errorResponse(null, 'Password saat ini salah.');
            }

            if ($validated['password_baru'] !== $validated['konfirmasi_password_baru']) {
                return $this->errorResponse(null, 'Konfirmasi password harus sama dengan password baru.');
            }

            $user->update([
                'password' => bcrypt($validated['password_baru']),
            ]);

            return $this->successResponse($user, 'Password berhasil diperbarui.');
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Gagal memperbarui password. Silakan coba lagi.');
        }
    }
}
