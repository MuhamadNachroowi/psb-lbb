<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LBB Darul Ulum Jombang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/images/hero-bg.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .program-card {
            transition: transform 0.3s;
        }
        .program-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">LBB Darul Ulum Jombang</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/profil">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pengumuman">Pengumuman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light text-primary ms-2" href="/pendaftaran">Daftar Sekarang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold">Selamat Datang di LBB Darul Ulum Jombang</h1>
            <p class="lead">Membangun Generasi Cerdas dan Berakhlak Mulia</p>
            <a href="/pendaftaran" class="btn btn-primary btn-lg mt-3">Daftar Sekarang</a>
        </div>
    </section>

    <!-- Program Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Program Belajar</h2>
            <div class="row">
                @foreach($programs as $program)
                <div class="col-md-4 mb-4">
                    <div class="card program-card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $program->nama_program }}</h5>
                            <p class="card-text">
                                Jenis Kelamin: {{ $program->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}<br>
                                Kuota Tersedia: {{ $program->kuota_tersedia }}/{{ $program->kuota }}<br>
                                Biaya: Rp {{ number_format($program->biaya, 0, ',', '.') }}
                            </p>
                            <ul class="list-group list-group-flush">
                                @foreach($program->kelas as $kelas)
                                <li class="list-group-item">{{ $kelas->nama_kelas }} ({{ $kelas->kuota }} siswa)</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pengumuman Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Pengumuman & Promo</h2>
            <div class="row">
                @foreach($articles as $article)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($article->gambar)
                        <img src="{{ asset('storage/' . $article->gambar) }}" class="card-img-top" alt="{{ $article->judul }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->judul }}</h5>
                            <p class="card-text">{{ Str::limit(strip_tags($article->konten), 100) }}</p>
                            <small class="text-muted">{{ $article->created_at->format('d M Y') }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; 2024 LBB Darul Ulum Jombang. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>