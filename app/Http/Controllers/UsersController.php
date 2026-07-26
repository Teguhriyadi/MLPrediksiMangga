<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index()
    {
        $data["users"] = User::with('kecamatanData')->orderBy("created_at", "DESC")->get();
        $data["roles"] = User::roleOptions();
        $data["kecamatans"] = Kecamatan::where('is_active', true)->orderBy('nama')->get(['id', 'nama']);

        return view("pages.users.index", $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "nama" => ["required", "string", "max:150"],
            "username" => ["required", "string", "max:100", "unique:users,username"],
            "email" => ["required", "email", "max:150", "unique:users,email"],
            "role" => ["required", Rule::in(array_keys(User::roleOptions()))],
            "kecamatan_id" => ["nullable", "exists:kecamatans,id"],
            "nomor_hp" => ["required", "string", "max:30"],
            "alamat" => ["nullable", "string"],
        ], [
            "nama.required" => "Nama Wajib Diisi",
            "username.required" => "Username Wajib Diisi",
            "email.required" => "Email Wajib Diisi",
            "role.required" => "Role Wajib Diisi",
            "kecamatan_id.required" => "Kecamatan Wajib Diisi",
            "role.required" => "Role Wajib Diisi",
            "nomor_hp.required" => "Nomor HP Wajib Diisi",
            "nomor_hp.max" => "Nomor HP Maksimal 30 Karakter",
            "alamat.required" => "Alamat Wajib Diisi",
        ]);

        try {
            DB::beginTransaction();

            $kecamatanId = $validated["role"] === User::ROLE_UPTD
                ? ($validated["kecamatan_id"] ?? null)
                : null;

            User::create([
                "nama" => $validated["nama"],
                "username" => $validated["username"],
                "email" => $validated["email"],
                "password" => bcrypt("password"),
                "must_reset_password" => true,
                "role" => $validated["role"],
                "kecamatan_id" => $kecamatanId,
                "nomor_hp" => $validated["nomor_hp"],
                "alamat" => $validated["alamat"] ?? null,
            ]);

            DB::commit();

            return back()->with("success", "Data Berhasil di Tambahkan");
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $data["edit"] = User::with('kecamatanData')->findOrFail($id);
        $data["roles"] = User::roleOptions();
        $data["kecamatans"] = Kecamatan::where('is_active', true)->orderBy('nama')->get(['id', 'nama']);

        return view("pages.users.edit", $data);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "nama" => ["required", "string", "max:150"],
            "username" => ["required", "string", "max:100", Rule::unique("users", "username")->ignore($id, "id")],
            "email" => ["required", "email", "max:150", Rule::unique("users", "email")->ignore($id, "id")],
            "role" => ["required", Rule::in(array_keys(User::roleOptions()))],
            "kecamatan_id" => ["nullable", "exists:kecamatans,id"],
            "nomor_hp" => ["required", "string", "max:30"],
            "alamat" => ["nullable", "string"],
        ], [
            "nama.required" => "Nama Wajib Diisi",
            "username.required" => "Username Wajib Diisi",
            "email.required" => "Email Wajib Diisi",
            "role.required" => "Role Wajib Diisi",
            "kecamatan_id.required" => "Kecamatan Wajib Diisi",
            "role.required" => "Role Wajib Diisi",
            "nomor_hp.required" => "Nomor HP Wajib Diisi",
            "nomor_hp.max" => "Nomor HP Maksimal 30 Karakter",
            "alamat.required" => "Alamat Wajib Diisi",
        ]);

        try {
            DB::beginTransaction();

            $kecamatanId = $validated["role"] === User::ROLE_UPTD
                ? ($validated["kecamatan_id"] ?? null)
                : null;

            User::query()->findOrFail($id)->update([
                "nama" => $validated["nama"],
                "username" => $validated["username"],
                "email" => $validated["email"],
                "role" => $validated["role"],
                "kecamatan_id" => $kecamatanId,
                "nomor_hp" => $validated["nomor_hp"],
                "alamat" => $validated["alamat"] ?? null,
            ]);

            DB::commit();

            return back()->with("success", "Data Berhasil di Ubah");
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            User::destroy($id);

            DB::commit();

            return back()->with("success", "Data Berhasil di Hapus");
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }
}
