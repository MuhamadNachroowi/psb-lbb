<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalonSiswa;
use App\Models\Program;
use App\Models\Kelas;
use App\Models\Article;
use App\Models\PromoDiskon;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CalonSiswaExport; // Ganti dengan nama export class Anda

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $stats = [
            'total_siswa' => CalonSiswa::count(),
            'siswa_baru_bulan_ini' => CalonSiswa::whereMonth('created_at', now()->month)->count(),
            'total_program' => Program::count(),
            'pembayaran_pending' => Pembayaran::where('status', 'pending')->count(),
        ];

        $siswaPerBulan = CalonSiswa::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->get();

        return view('admin.dashboard', compact('stats', 'siswaPerBulan'));
    }

    // MANAJEMEN CALON SISWA
    public function calonSiswa(Request $request)
    {
        $query = CalonSiswa::with('programs', 'programs.kelas', 'pembayaran');

        // Apply filters
        if ($request->filled('nomor_pendaftaran')) {
            $query->where('nomor_pendaftaran', 'like', '%' . $request->nomor_pendaftaran . '%');
        }

        if ($request->filled('status_bayar')) {
            $query->where('status_bayar', $request->status_bayar);
        }

        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $siswa = $query->get();

        // VARIABLE SEDERHANA JIKA MODEL TIDAK ADA
        $sekolahList = [];
        $asramaList = [];
        $programList = [];
        $kelasList = [];

        return view('admin.calon-siswa.index', compact('siswa'));
    }
    // Export Function dengan Excel Package
    private function exportCalorSiswa($data, $type)
    {
        try {
            $filename = 'data_siswa_' . date('Y-m-d_H-i-s') . '.' . $type;

            return Excel::download(new CalonSiswaExport($data), $filename);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error export: ' . $e->getMessage());
        }
    }

    public function showCalonSiswa($id)
    {
        try {
            $siswa = CalonSiswa::findOrFail($id); // Ganti dengan model yang sesuai
            return view('admin.detail-siswa', compact('siswa'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }
    }

    // MANAJEMEN PROGRAM
    public function program()
    {
        $programs = Program::with('kelas')->get();
        return view('admin.program.index', compact('programs'));
    }

    public function createProgram()
    {
        return view('admin.program.create');
    }

    public function storeProgram(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kuota' => 'required|integer|min:1',
            'biaya' => 'required|numeric|min:0'
        ]);

        Program::create($request->all());

        return redirect()->route('admin.program')->with('success', 'Program berhasil ditambahkan');
    }

    public function editProgram($id)
    {
        $program = Program::findOrFail($id);
        return view('admin.program.edit', compact('program'));
    }

    public function updateProgram(Request $request, $id)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kuota' => 'required|integer|min:1',
            'biaya' => 'required|numeric|min:0'
        ]);

        $program = Program::findOrFail($id);
        $program->update($request->all());

        return redirect()->route('admin.program')->with('success', 'Program berhasil diupdate');
    }

    // MANAJEMEN KELAS
    public function createKelas($programId)
    {
        $program = Program::findOrFail($programId);
        return view('admin.kelas.create', compact('program'));
    }

    public function storeKelas(Request $request, $programId)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'kuota' => 'required|integer|min:1'
        ]);

        Kelas::create([
            'program_id' => $programId,
            'nama_kelas' => $request->nama_kelas,
            'kuota' => $request->kuota
        ]);

        return redirect()->route('admin.program')->with('success', 'Kelas berhasil ditambahkan');
    }

    // MANAJEMEN ARTIKEL
    public function articles()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function createArticle()
    {
        return view('admin.articles.create');
    }

    public function storeArticle(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'jenis' => 'required|in:pengumuman,promo,profil',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai'
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('articles', 'public');
            $data['gambar'] = $gambarPath;
        }

        Article::create($data);

        return redirect()->route('admin.articles')->with('success', 'Artikel berhasil ditambahkan');
    }

    public function editArticle($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.articles.edit', compact('article'));
    }

    public function updateArticle(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'jenis' => 'required|in:pengumuman,promo,profil',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai'
        ]);

        $article = Article::findOrFail($id);
        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($article->gambar) {
                Storage::disk('public')->delete($article->gambar);
            }

            $gambarPath = $request->file('gambar')->store('articles', 'public');
            $data['gambar'] = $gambarPath;
        }

        $article->update($data);

        return redirect()->route('admin.articles')->with('success', 'Artikel berhasil diupdate');
    }

    public function destroyArticle($id)
    {
        $article = Article::findOrFail($id);

        // Hapus gambar jika ada
        if ($article->gambar) {
            Storage::disk('public')->delete($article->gambar);
        }

        $article->delete();

        return redirect()->route('admin.articles')->with('success', 'Artikel berhasil dihapus');
    }

    // MANAJEMEN PROMO DISKON
    public function promo()
    {
        $promos = PromoDiskon::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.promo.index', compact('promos'));
    }

    public function createPromo()
    {
        return view('admin.promo.create');
    }

    public function storePromo(Request $request)
    {
        $request->validate([
            'nama_promo' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jenis_diskon' => 'required|in:persentase,nominal',
            'nilai_diskon' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kuota' => 'nullable|integer|min:1'
        ]);

        PromoDiskon::create($request->all());

        return redirect()->route('admin.promo')->with('success', 'Promo berhasil ditambahkan');
    }

    // MANAJEMEN PEMBAYARAN (Untuk Role Keuangan)
    public function pembayaran(Request $request)
    {
        $query = Pembayaran::with('calonSiswa');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $pembayaran = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.pembayaran.index', compact('pembayaran'));
    }

    public function updateStatusPembayaranDetail(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,success,failed',
            'keterangan' => 'nullable|string'
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan
        ]);

        // Update status pembayaran calon siswa jika pembayaran success
        if ($request->status == 'success') {
            $calonSiswa = $pembayaran->calonSiswa;
            $calonSiswa->update([
                'status_pembayaran' => 'lunas'
            ]);
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diupdate');
    }

    // LAPORAN
    public function laporan(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

        $laporan = CalonSiswa::with('pembayaran')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $totalPendapatan = Pembayaran::where('status', 'success')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('jumlah');

        return view('admin.laporan.index', compact('laporan', 'totalPendapatan', 'startDate', 'endDate'));
    }
}
