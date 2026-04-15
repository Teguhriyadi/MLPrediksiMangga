<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index()
    {
        $data["users"] = User::orderBy("created_at", "DESC")->get();

        return view("pages.users.index", $data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            User::create([
                "nama" => $request["nama"],
                "username" => $request["username"],
                "email" => $request["email"],
                "password" => bcrypt("password"),
                "nomor_hp" => $request["nomor_hp"],
                "alamat" => $request["alamat"]
            ]);

            DB::commit();

            return back()->with("success", "Data Berhasil di Tambahkan");
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data["edit"] = User::where("id", $id)->first();

        return view("pages.users.edit", $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            User::where("id", $id)->update([
                "nama" => $request["nama"],
                "username" => $request["username"],
                "email" => $request["email"],
                "nomor_hp" => $request["nomor_hp"],
                "alamat" => $request["alamat"]
            ]);

            DB::commit();

            return back()->with("success", "Data Berhasil di Ubah");
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            User::where("id", $id)->delete();

            DB::commit();

            return back()->with("success", "Data Berhasil di Hapus");
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }
}
