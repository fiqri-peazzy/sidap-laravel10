<?php

namespace App\Http\Controllers;

use App\Models\KategoriAtlit;
use App\Models\Cabor;
use Illuminate\Http\Request;

class KategoriAtlitController extends Controller
{
    public function index()
    {
        return view('atlit.kategori.index');
    }

    public function create()
    {
        $cabangOlahraga = Cabor::aktif()->orderBy('nama_cabang')->get();
        return view('atlit.kategori.create', compact('cabangOlahraga'));
    }

    public function store(Request $request)
    {
        $request->validate(KategoriAtlit::rules());

        KategoriAtlit::create($request->all());

        return redirect()->route('kategori-atlit.index')->with('success', 'Kategori atlit berhasil ditambahkan.');
    }

    public function show(KategoriAtlit $kategoriAtlit)
    {
        return view('atlit.kategori.show', compact('kategoriAtlit'));
    }

    public function edit(KategoriAtlit $kategoriAtlit)
    {
        $cabangOlahraga = Cabor::aktif()->orderBy('nama_cabang')->get();
        return view('atlit.kategori.edit', compact('kategoriAtlit', 'cabangOlahraga'));
    }

    public function update(Request $request, KategoriAtlit $kategoriAtlit)
    {
        $request->validate(KategoriAtlit::rules($kategoriAtlit->id));

        $kategoriAtlit->update($request->all());

        return redirect()->route('kategori-atlit.index')->with('success', 'Kategori atlit berhasil diperbarui.');
    }

    public function destroy(KategoriAtlit $kategoriAtlit)
    {
        $kategoriAtlit->delete();

        return redirect()->route('kategori-atlit.index')->with('success', 'Kategori atlit berhasil dihapus.');
    }
}
