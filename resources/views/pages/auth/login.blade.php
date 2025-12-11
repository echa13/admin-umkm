<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('{{ asset("asset/img/bg-login.png") }}') center/cover no-repeat fixed;
            height: 100vh;
        }
        .login-card {
            border-radius: 20px;
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }
        .left-panel {
            background: rgba(13, 110, 253, 0.9);
            color: white;
            padding: 3rem 2rem;
        }
        .left-panel img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 20px;
        }
        .right-panel {
            background: white;
            padding: 3rem;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center">

    <div class="card shadow-lg login-card">
        <div class="row g-0">

            {{-- Panel kiri: identitas modul --}}
            <div class="col-md-6 left-panel d-flex flex-column justify-content-center align-items-center text-center">
                <img src="{{ asset('asset/img/logo-umkm.png') }}" alt="Logo Modul">
                <h3 class="fw-bold mb-3">UMKM</h3>
                <p>
                    Selamat datang di portal <strong>Bina Desa UMKM</strong>.
                    Akses sistem, kelola data, dan nikmati kemudahan pengelolaan proyek Anda!
                </p>
            </div>

            {{-- Panel kanan: form login --}}
            <div class="col-md-6 right-panel">
                <h3 class="text-center mb-4 fw-bold">Login</h3>

                {{-- Pesan error dari session --}}
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- Pesan sukses --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Form login --}}
                <form method="POST" action="{{ route('auth.login') }}">
                    @csrf

                    {{-- Input Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan password"
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol Login --}}
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Login</button>
                </form>

                <p class="text-center mt-4 mb-0">
                    Belum punya akun?
                    <a href="{{ route('registers') }}" class="text-decoration-none">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
