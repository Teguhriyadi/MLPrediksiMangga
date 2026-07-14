<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ env('APP_NAME') }} - Atur Ulang Password
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('templating/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background: radial-gradient(circle at top left, rgba(56, 189, 248, 0.32), transparent 32%),
                radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.26), transparent 28%),
                linear-gradient(135deg, #0f172a 0%, #1d4ed8 100%);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-page {
            min-height: 100vh;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 900px;
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.28);
            backdrop-filter: blur(14px);
        }

        .login-showcase {
            position: relative;
            padding: 3rem;
            color: #fff;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.32), rgba(15, 23, 42, 0.1));
        }

        .login-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1.4rem;
        }

        .login-showcase h1 {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .login-showcase p {
            color: rgba(255, 255, 255, 0.86);
            font-size: 0.95rem;
            line-height: 1.75;
            margin-bottom: 2rem;
        }

        .btn-outline-secondary.btn-login {
            background: transparent;
            border: 2px solid #64748b;
            color: #64748b;
        }

        .btn-outline-secondary.btn-login:hover {
            background: #64748b;
            color: #fff;
        }

        .login-panel {
            background: rgba(255, 255, 255, 0.96);
            padding: 3rem 2.5rem;
            display: flex;
            align-items: center;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }

        .login-brand {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            font-size: 1rem;
            box-shadow: 0 14px 28px rgba(37, 99, 235, 0.24);
            margin-bottom: 1rem;
        }

        .login-title {
            font-size: 1.55rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.55rem;
        }

        .login-subtitle {
            color: #64748b;
            margin-bottom: 1.8rem;
            line-height: 1.7;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.45rem;
        }

        .form-control {
            min-height: 50px;
            border-radius: 14px;
            border: 1px solid #dbe4f0;
            padding: 0.8rem 1rem;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 0.18rem rgba(37, 99, 235, 0.12);
        }

        .btn-login {
            min-height: 50px;
            border-radius: 14px;
            font-weight: 600;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
        }

        .login-footer-note {
            color: #94a3b8;
            font-size: 0.86rem;
            margin-top: 1.4rem;
            text-align: center;
        }

        .alert {
            border: none;
            border-radius: 14px;
            font-size: 0.92rem;
        }

        @media (max-width: 991.98px) {
            .login-wrapper {
                grid-template-columns: 1fr;
            }
            .login-showcase {
                padding: 2rem;
            }
            .login-panel {
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 575.98px) {
            .login-page {
                padding: 0.9rem;
            }
            .login-wrapper {
                border-radius: 22px;
            }
        }
    </style>
</head>

<body>
    <div class="login-page">
        <div class="login-wrapper">
            <div class="login-showcase">
                <span class="login-badge">
                    <i class="fas fa-key"></i>
                    Atur Password Baru
                </span>
                <h1>Atur Ulang Password Akun Anda</h1>
                <p>
                    Masukkan email akun dan password baru Anda untuk menyelesaikan proses reset. Pastikan password Anda kuat dan mudah diingat.
                </p>
            </div>

            <div class="login-panel">
                <div class="login-card">
                    <div class="login-brand">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h2 class="login-title">Atur Password Baru</h2>
                    <p class="login-subtitle">
                        Masukkan email akun dan password baru Anda untuk menyelesaikan proses reset.
                    </p>

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Masukkan email akun" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password Baru</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password baru" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Konfirmasi password baru" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-login">
                                <i class="fas fa-check me-1"></i>
                                Atur Ulang Password
                            </button>
                            <a href="{{ url('/login') }}" class="btn btn-outline-secondary btn-login">
                                <i class="fas fa-arrow-left me-1"></i>
                                Kembali ke Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
