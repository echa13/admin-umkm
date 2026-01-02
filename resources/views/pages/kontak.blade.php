@extends('layouts.admin.app') {{-- Menggunakan layout guest karena ini halaman publik --}}

@section('title', 'Profil Pengembang')

@section('content')

    <style>
        /* 1. Warna Dasar & Konsistensi */
        /* Menggunakan Tailwind/Natural color: Blue/Slate */
        .text-pcr-blue {
            color: #0e203d !important; /* Blue-500 Tailwind */
        }
        .bg-pcr-blue {
            background-color: #0e203d !important;
        }
        .bg-pcr-blue:hover {
            background-color: #0e203d !important; /* Blue-600 Tailwind */
        }
        .contact-title-dark {
            color: #1e293b !important; /* Slate-800 */
        }
        .contact-card-split {
            background-color: #c7ccd4;
            border: 1px solid #c7ccd4; /* Slate-200 */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* 2. Garis Pemisah Vertikal (Hanya di Layar Besar) */
        @media (min-width: 768px) {
            .contact-left-col::after {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 1px;
                height: 100%;
                background-color: #e2e8f0; /* Slate-200 */
            }
        }

        /* 3. Gaya Foto Profil */
        .profile-photo-container {
            width: 120px; /* Ukuran sedikit lebih besar */
            height: 120px;
            padding: 4px;
            /* Border warna tunggal yang elegan */
            background: #294c86; /* Blue-500 */
            border-radius: 50%;
            margin-bottom: 1rem;
        }
        .profile-img-split {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 4px solid #ffffff; /* Border putih di dalam */
        }

        /* 4. Gaya Ikon Sosial Media (Lingkaran & Warna Tunggal) */
        .social-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            text-decoration: none;
            color: #ffffff;
            background-color: #294c86; /* Warna tunggal Blue-500 */
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }

        .social-circle:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            background-color: #294c86; /* Blue-600 saat hover */
        }

        /* Menghilangkan CSS lama yang colorful */
        .linkedin-bg, .github-bg, .instagram-bg, .facebook-bg { background: none; }

    </style>

    {{-- Container utama yang memusatkan konten di tengah halaman --}}
    <div class="container py-5 mt-5">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-9"> {{-- Ukuran lebih sempit agar fokus di tengah --}}
                <div class="card p-4 p-md-5 border-0 rounded-4 contact-card-split">

                    <div class="row">

                        {{-- Kolom Kiri: Identitas & Info Kontak --}}
                        <div class="col-md-5 pe-md-5 contact-left-col text-center text-md-start mb-4 mb-md-0">

                            {{-- FOTO PROFIL --}}
                            <div class="profile-photo-container mx-auto mx-md-0">
                                <img src="{{ asset('asset/img/user.JPG') }}"
                                    alt="Foto Pengembang"
                                    class="rounded-circle profile-img-split">
                            </div>

                            {{-- DETAIL IDENTITAS --}}
                            <h4 class="fw-bolder mb-1 contact-title-dark">Salsabilla Adinda Putri</h4>
                            <p class="text-secondary mb-1">2457301129</p>
                            <p class="text-secondary small mb-4">Kelas: 2 SI D</p>

                            <hr class="my-4">

                            {{-- INFORMASI KONTAK --}}
                            <h5 class="fw-bold mb-3 contact-title-dark">Informasi Detail</h5>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-3 justify-content-center justify-content-md-start">
                                    <i class="fas fa-envelope fa-lg contact-icon me-3 text-pcr-blue"></i>
                                    <a href="mailto:Salsabilla.p@example.com" class="text-decoration-none text-dark fw-medium">salsabila24si@mahasiswa.pcr.ac.id</a>
                                </div>
                                <div class="d-flex align-items-center mb-3 justify-content-center justify-content-md-start">
                                    <i class="fas fa-phone fa-lg contact-icon me-3 text-pcr-blue"></i>
                                    <span class="text-dark fw-medium">+62 813 64109206 </span>
                                </div>
                                <div class="d-flex align-items-start justify-content-center justify-content-md-start">
                                    <i class="fas fa-map-marker-alt fa-lg contact-icon me-3 mt-1 text-pcr-blue"></i>
                                    <p class="mb-0 text-dark fw-medium address-text text-start">
                                        Jl. Tegal Sari No. XX, Kota Pekanbaru, Riau
                                    </p>
                                </div>
                            </div>

                        </div>

                        {{-- Kolom Kanan: Sosial Media & Aksi --}}
                        <div class="col-md-7 ps-md-5">

                            {{-- Tombol Aksi (Kirim Pesan) --}}
                            <div class="mb-5 d-flex justify-content-center justify-content-md-end">
                                <a href="mailto:Salsabila@example.com" class="btn text-white d-flex align-items-center fw-bold btn-custom-send bg-pcr-blue hover:bg-pcr-blue">
                                    Kirim Pesan Langsung
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>

                            <h4 class="fw-bold mb-3 contact-title-dark text-center text-md-start">Social Media Saya</h4>
                            <p class="text-secondary mb-4 small text-center text-md-start">
                                Ikuti saya di media sosial untuk melihat proyek terbaru dan menghubungi secara langsung.
                            </p>

                            {{-- Ikon Sosial Media Lingkaran --}}
                            <div class="d-flex gap-3 social-icons-list justify-content-center justify-content-md-start">

                                {{-- LinkedIn --}}
                                <a href="https://www.linkedin.com/in/salsabila-adinda-putri-502241394/" target="_blank" class="social-circle" title="LinkedIn">
                                    <i class="fab fa-linkedin-in fa-lg"></i>
                                </a>
                                {{-- GitHub --}}
                                <a href="https://github.com/echa13/admin-umkm.git" target="_blank" class="social-circle" title="GitHub">
                                    <i class="fab fa-github fa-lg"></i>
                                </a>
                                {{-- Instagram --}}
                                <a href="https://instagram.com/salsabiladindapp" target="_blank" class="social-circle" title="Instagram">
                                    <i class="fab fa-instagram fa-lg"></i>
                                </a>
                                {{-- Facebook --}}
                                <a href="https://facebook.com/salsabiladindapp" target="_blank" class="social-circle" title="Facebook">
                                    <i class="fab fa-facebook-f fa-lg"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
