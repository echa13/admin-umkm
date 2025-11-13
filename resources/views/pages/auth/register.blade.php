<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height:100vh;">

    <div class="card shadow-lg p-4" style="width: 420px; border-radius:15px;">
        <h3 class="text-center mb-3 text-primary">Register Akun</h3>

        {{-- Pesan sukses atau error --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Register --}}
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            {{-- Nama --}}
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
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
                <label for="email" class="form-label">Email</label>
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
                <label for="password" class="form-label">Password</label>
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
            <button type="submit" class="btn btn-success w-100">Daftar</button>

            {{-- Link ke login --}}
            <p class="text-center mt-3 mb-0">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login di sini</a>
            </p>
        </form>
    </div>

</body>
</html>
