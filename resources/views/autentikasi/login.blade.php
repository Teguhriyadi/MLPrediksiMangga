<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ env('APP_NAME') }} - Login
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #224abe);
            height: 100vh;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
        }
    </style>
</head>

<body>

    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="card login-card shadow-lg p-4">
            <h4 class="text-center mb-4">
                Analisa Triwulan Mangga
            </h4>

            <form action="{{ url('/login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan Password"
                        required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>

                    <button type="reset" class="btn btn-outline-secondary">
                        Batal
                    </button>
                </div>

            </form>

        </div>

    </div>

</body>

</html>
