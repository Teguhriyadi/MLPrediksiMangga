<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ env('APP_NAME') }} - Login
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('templating/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background:
                radial-gradient(circle at top left, rgba(56, 189, 248, 0.32), transparent 32%),
                radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.26), transparent 28%),
                linear-gradient(135deg, #0f172a 0%, #172554 45%, #1d4ed8 100%);
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
            max-width: 1120px;
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
            color: #ffffff;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.32), rgba(15, 23, 42, 0.1));
        }

        .login-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.55rem 0.95rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1.4rem;
        }

        .login-showcase h1 {
            font-size: 2.3rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .login-showcase p {
            color: rgba(255, 255, 255, 0.82);
            font-size: 1rem;
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
        }

        .login-feature-text {
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.92rem;
            line-height: 1.6;
            margin: 0;
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
            width: 58px;
            height: 58px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            font-size: 1.2rem;
            box-shadow: 0 14px 28px rgba(37, 99, 235, 0.24);
            margin-bottom: 1rem;
        }

        .login-title {
            font-size: 1.65rem;
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
            min-height: 52px;
            border-radius: 16px;
            border: 1px solid #dbe4f0;
            padding: 0.85rem 1rem;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 0.18rem rgba(37, 99, 235, 0.12);
        }

        .btn-login {
            min-height: 52px;
            border-radius: 16px;
            font-weight: 600;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
        }

        .btn-reset {
            min-height: 52px;
            border-radius: 16px;
            font-weight: 600;
        }

        .login-footer-note {
            color: #94a3b8;
            font-size: 0.88rem;
            margin-top: 1.4rem;
            text-align: center;
        }

        .alert {
            border: none;
            border-radius: 16px;
            font-size: 0.94rem;
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

            .login-showcase {
                padding: 1.5rem;
            }

            .login-showcase h1 {
                font-size: 1.7rem;
            }

            .login-panel {
                padding: 1.5rem 1.15rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-page">
        <div class="login-wrapper">
            <div class="login-showcase">
                <span class="login-badge">
                    <i class="fas fa-chart-line"></i>
                    Sistem Prediksi Produktivitas Mangga
                </span>

                <h1>Masuk ke Dashboard Perkebunan Mangga</h1>
                <p>
                    Kelola data produksi, varietas, laporan, dan hasil prediksi SARIMA dalam satu sistem.
                </p>

                <div class="login-feature">
                    <div class="login-feature-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div>
                        <div class="login-feature-title">Manajemen Data Produksi</div>
                        <p class="login-feature-text">Simpan data per kecamatan, triwulan, varietas, dan faktor pendukung produktivitas.</p>
                    </div>
                </div>

                <div class="login-feature">
                    <div class="login-feature-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <div>
                        <div class="login-feature-title">Analisis dan Forecast</div>
                        <p class="login-feature-text">Lihat hasil prediksi SARIMA, tren produksi, dan evaluasi model secara lebih informatif.</p>
                    </div>
                </div>

                <div class="login-feature mb-0">
                    <div class="login-feature-icon">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <div>
                        <div class="login-feature-title">Laporan Siap Unduh</div>
                        <p class="login-feature-text">Unduh laporan produksi, rekap kecamatan, dan dokumen PDF/Excel.</p>
                    </div>
                </div>
            </div>

            <div class="login-panel">
                <div class="login-card">
                    <div class="login-brand">
                        <i class="fas fa-seedling"></i>
                    </div>

                    <h2 class="login-title">Login Akun</h2>
                    <p class="login-subtitle">
                        Masukkan username dan password untuk mengakses dashboard analisis produktivitas mangga.
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

                    <form action="{{ url('/login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" name="username" id="username"
                                class="form-control @error('username') is-invalid @enderror"
                                placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-login">
                                <i class="fas fa-sign-in-alt me-1"></i>
                                Masuk ke Sistem
                            </button>

                            <button type="reset" class="btn btn-outline-secondary btn-reset">
                                Reset Form
                            </button>
                        </div>
                    </form>

                    <p class="login-footer-note">
                        Sistem Informasi Perkebunan Berbasis Web untuk Prediksi Produktivitas Komoditas Mangga.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
