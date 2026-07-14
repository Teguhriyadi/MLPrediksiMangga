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
        $data["users"] = User::orderBy("created_at", "DESC")->get();
        $data["roles"] = User::roleOptions();
        $data["kecamatans"] = Kecamatan::where('is_active', true)->orderBy('nama')->pluck('nama');

        return view("pages.users.index", $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "nama" => ["required", "string", "max:150"],
            "username" => ["required", "string", "max:100", "unique:users,username"],
            "email" => ["required", "email", "max:150", "unique:users,email"],
            "role" => ["required", Rule::in(array_keys(User::roleOptions()))],
            "kecamatan" => ["nullable", Rule::in(Kecamatan::where('is_active', true)->pluck('nama')->toArray())],
            "nomor_hp" => ["required", "string", "max:30"],
            "alamat" => ["nullable", "string"],
        ]);

        try {
            DB::beginTransaction();

            User::create([
                "nama" => $validated["nama"],
                "username" => $validated["username"],
                "email" => $validated["email"],
                "password" => bcrypt("password"),
                "role" => $validated["role"],
                "kecamatan" => $validated["kecamatan"] ?? null,
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
        $data["edit"] = User::findOrFail($id);
        $data["roles"] = User::roleOptions();
        $data["kecamatans"] = Kecamatan::where('is_active', true)->orderBy('nama')->pluck('nama');

        return view("pages.users.edit", $data);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "nama" => ["required", "string", "max:150"],
            "username" => ["required", "string", "max:100", Rule::unique("users", "username")->ignore($id, "id")],
            "email" => ["required", "email", "max:150", Rule::unique("users", "email")->ignore($id, "id")],
            "role" => ["required", Rule::in(array_keys(User::roleOptions()))],
            "kecamatan" => ["nullable", Rule::in(Kecamatan::where('is_active', true)->pluck('nama')->toArray())],
            "nomor_hp" => ["required", "string", "max:30"],
            "alamat" => ["nullable", "string"],
        ]);

        try {
            DB::beginTransaction();

            User::query()->findOrFail($id)->update([
                "nama" => $validated["nama"],
                "username" => $validated["username"],
                "email" => $validated["email"],
                "role" => $validated["role"],
                "kecamatan" => $validated["kecamatan"] ?? null,
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
