<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ env('APP_NAME') }} - Lupa Password
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

        .login-feature {
            display: flex;
            align-items: flex-start;
            gap: 0.9rem;
            margin-bottom: 1.1rem;
        }

        .login-feature-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.14);
            color: #fde68a;
            flex-shrink: 0;
        }

        .login-feature-title {
            font-weight: 700;
            margin-bottom: 0.2rem;
            color: #fff;
        }

        .login-feature-text {
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.92rem;
            line-height: 1.6;
            margin: 0;
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
                    Reset Password
                </span>
                <h1>Lupa Password Akun Anda?</h1>
                <p>
                    Tenang, Anda dapat mereset password dengan mudah. Masukkan alamat email yang terdaftar, dan kami akan
                    mengirimkan tautan reset password ke email Anda.
                </p>
                <div class="login-feature">
                    <div class="login-feature-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <div class="login-feature-title">Kirim ke Email</div>
                        <p class="login-feature-text">Tautan reset password dikirim langsung ke email Anda.</p>
                    </div>
                </div>
            </div>

            <div class="login-panel">
                <div class="login-card">
                    <div class="login-brand">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h2 class="login-title">Lupa Password</h2>
                    <p class="login-subtitle">
                        Masukkan alamat email yang terdaftar untuk menerima tautan pengaturan ulang password.
                    </p>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Masukkan email Anda" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-login">
                                <i class="fas fa-paper-plane me-1"></i>
                                Kirim Tautan Reset
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
