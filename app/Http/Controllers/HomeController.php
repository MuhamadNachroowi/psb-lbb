<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Program;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::where('jenis', 'pengumuman')
            ->orWhere('jenis', 'promo')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $programs = Program::with('kelas')->get();

        return view('home', compact('articles', 'programs'));
    }

    public function profil()
    {
        $profil = Article::where('jenis', 'profil')->first();
        return view('profil', compact('profil'));
    }

    public function pengumuman()
    {
        $pengumuman = Article::where('jenis', 'pengumuman')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pengumuman', compact('pengumuman'));
    }
}
