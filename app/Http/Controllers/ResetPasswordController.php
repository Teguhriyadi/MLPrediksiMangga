<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('autentikasi.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', $this->translatePasswordStatus($status))
            : back()->withErrors(['email' => $this->translatePasswordStatus($status)]);
    }

    public function showResetForm($token)
    {
        return view('autentikasi.reset-password', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'token.required' => 'Token reset password tidak ditemukan.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'must_reset_password' => false,
                ]);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', $this->translatePasswordStatus($status))
            : back()->withErrors(['email' => [$this->translatePasswordStatus($status)]]);
    }

    private function translatePasswordStatus(string $status): string
    {
        return match ($status) {
            Password::RESET_LINK_SENT => 'Tautan reset password berhasil dikirim ke email Anda.',
            Password::PASSWORD_RESET => 'Password Anda berhasil diperbarui. Silakan login kembali.',
            Password::INVALID_TOKEN => 'Tautan reset password tidak valid atau sudah kedaluwarsa.',
            Password::INVALID_USER => 'Email tersebut belum terdaftar di sistem.',
            Password::RESET_THROTTLED => 'Permintaan reset terlalu sering. Silakan coba lagi beberapa saat.',
            default => 'Terjadi kendala saat memproses permintaan reset password.',
        };
    }
}
