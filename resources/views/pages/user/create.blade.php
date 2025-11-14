<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('{{ asset("asset/img/bg-login.png") }}') center/cover no-repeat fixed;
            height: 100vh;
        }
        .register-card {
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

    <div class="card shadow-lg register-card">
        <div class="row g-0">

            {{-- Panel kiri: identitas modul --}}
            <div class="col-md-6 left-panel d-flex flex-column justify-content-center align-items-center text-center">
                <img src="{{ asset('asset/img/logo_modul.png') }}" alt="Logo Modul">
                <h3 class="fw-bold mb-3">UMKM</h3>
                <p>
                    Bergabunglah dengan <strong>Bina Desa UMKM</strong> dan nikmati kemudahan dalam pengelolaan akun serta aktivitas bisnis Anda!
                </p>
            </div>

            {{-- Panel kanan: form register --}}
            <div class="col-md-6 right-panel">
                <h3 class="text-center mb-4 fw-bold text-primary">Register Akun</h3>

                {{-- Pesan sukses --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Pesan error --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
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

                    {{-- Password --}}
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
                        <small class="text-muted">Minimal 8 karakter dan mengandung huruf kapital.</small>
                    </div>

                    {{-- Tombol Register --}}
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Daftar</button>
                </form>

                <p class="text-center mt-4 mb-0">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-decoration-none">Login di sini</a>
                </p>
            </div>

        </div>
    </div>

</body>
</html>
