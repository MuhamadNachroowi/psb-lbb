<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran - LBB Darul Ulum Jombang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Form Pendaftaran LBB Darul Ulum Jombang</h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('pendaftaran.store') }}">
                            @csrf

                            <!-- Data Diri -->
                            <h5 class="mb-3">Data Diri Calon Siswa</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap *</label>
                                        <input type="text" class="form-control" name="nama" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin *</label>
                                        <select class="form-control" name="jenis_kelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tempat Lahir *</label>
                                        <input type="text" class="form-control" name="tempat_lahir" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Lahir *</label>
                                        <input type="date" class="form-control" name="tanggal_lahir" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap *</label>
                                <textarea class="form-control" name="alamat" rows="3" required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Asal Sekolah *</label>
                                        <input type="text" class="form-control" name="asal_sekolah" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Asrama *</label>
                                        <input type="text" class="form-control" name="asrama" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Wali -->
                            <h5 class="mb-3 mt-4">Data Wali</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Wali *</label>
                                        <input type="text" class="form-control" name="nama_wali" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">No. HP Wali *</label>
                                        <input type="text" class="form-control" name="no_hp_wali" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Program dan Kelas -->
                            <h5 class="mb-3 mt-4">Pilihan Program (Maksimal 2 Program)</h5>
                            <div id="program-container">
                                <div class="program-item mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Program *</label>
                                            <select class="form-control program-select" name="program_id[]" required onchange="updateKelas(this)">
                                                <option value="">Pilih Program</option>
                                                @foreach($programs as $program)
                                                <option value="{{ $program->id }}" data-jenis-kelamin="{{ $program->jenis_kelamin }}">
                                                    {{ $program->nama_program }} ({{ $program->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Kelas *</label>
                                            <select class="form-control kelas-select" name="kelas_id[]" required>
                                                <option value="">Pilih Program Terlebih Dahulu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="tambahProgram()" id="btn-tambah-program">+ Tambah Program</button>

                            <!-- Metode Pembayaran -->
                            <h5 class="mb-3 mt-4">Metode Pembayaran</h5>
                            <div class="mb-3">
                                <select class="form-control" name="metode_pembayaran" required>
                                    <option value="">Pilih Metode Pembayaran</option>
                                    <option value="lunas">Lunas di Awal</option>
                                    <option value="angsur">Angsuran</option>
                                    <option value="boking">Booking (Bayar Nanti)</option>
                                </select>
                            </div>

                            <div class="alert alert-info">
                                <h6>Informasi Promo:</h6>
                                @if($promo->count() > 0)
                                    @foreach($promo as $p)
                                    <p class="mb-1">
                                        <strong>{{ $p->nama_promo }}</strong><br>
                                        {{ $p->deskripsi }}<br>
                                        Diskon: 
                                        @if($p->jenis_diskon == 'persentase')
                                            {{ $p->nilai_diskon }}%
                                        @else
                                            Rp {{ number_format($p->nilai_diskon, 0, ',', '.') }}
                                        @endif
                                        <br>
                                        Berlaku sampai: {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}
                                    </p>
                                    @endforeach
                                @else
                                    <p class="mb-0">Tidak ada promo yang sedang berlangsung</p>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">Daftar Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let programCount = 1;
        const maxPrograms = 2;

        function updateKelas(selectElement) {
            const programId = selectElement.value;
            const kelasSelect = selectElement.closest('.program-item').querySelector('.kelas-select');
            
            if (!programId) {
                kelasSelect.innerHTML = '<option value="">Pilih Program Terlebih Dahulu</option>';
                return;
            }

            // Get selected program data
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const jenisKelamin = selectedOption.getAttribute('data-jenis-kelamin');
            
            // Update jenis kelamin field
            document.querySelector('select[name="jenis_kelamin"]').value = jenisKelamin;

            // Fetch kelas data
            fetch(`/api/kelas/${programId}`)
                .then(response => response.json())
                .then(data => {
                    kelasSelect.innerHTML = '<option value="">Pilih Kelas</option>';
                    data.forEach(kelas => {
                        const option = document.createElement('option');
                        option.value = kelas.id;
                        option.textContent = `${kelas.nama_kelas} (Kuota: ${kelas.kuota})`;
                        kelasSelect.appendChild(option);
                    });
                });
        }

        function tambahProgram() {
            if (programCount >= maxPrograms) {
                document.getElementById('btn-tambah-program').disabled = true;
                return;
            }

            programCount++;
            const container = document.getElementById('program-container');
            const newItem = document.createElement('div');
            newItem.className = 'program-item mb-3';
            newItem.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Program ${programCount}</label>
                        <select class="form-control program-select" name="program_id[]" required onchange="updateKelas(this)">
                            <option value="">Pilih Program</option>
                            @foreach($programs as $program)
                            <option value="{{ $program->id }}" data-jenis-kelamin="{{ $program->jenis_kelamin }}">
                                {{ $program->nama_program }} ({{ $program->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kelas ${programCount}</label>
                        <select class="form-control kelas-select" name="kelas_id[]" required>
                            <option value="">Pilih Program Terlebih Dahulu</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="hapusProgram(this)">Hapus</button>
            `;
            container.appendChild(newItem);

            if (programCount >= maxPrograms) {
                document.getElementById('btn-tambah-program').disabled = true;
            }
        }

        function hapusProgram(button) {
            button.closest('.program-item').remove();
            programCount--;
            document.getElementById('btn-tambah-program').disabled = false;
        }
    </script>
</body>
</html>