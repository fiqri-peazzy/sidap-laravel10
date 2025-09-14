<?php
// Controller: App/Http/Controllers/AtlitController.php

namespace App\Http\Controllers;

use App\Models\Atlit;
use App\Models\Klub;
use App\Models\Cabor;
use App\Models\KategoriAtlit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\DokumenAtlit;

class AtlitController extends Controller
{
    public function index()
    {
        return view('admin.atlit.index');
    }

    public function create()
    {
        $klub = Klub::aktif()->orderBy('nama_klub')->get();
        $cabangOlahraga = Cabor::aktif()->orderBy('nama_cabang')->get();

        return view('admin.atlit.create', compact('klub', 'cabangOlahraga'));
    }

    public function store(Request $request)
    {
        $request->validate(Atlit::rules());

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $path = $foto->storeAs('atlit/foto', $filename, 'public');
            $data['foto'] = $filename;
        }

        $atlit = Atlit::create($data);

        if ($atlit->email) {
            $atlit->createUser();
        }

        return redirect()->route('admin.atlit.index')->with('success', 'Data atlit berhasil ditambahkan.');
    }

    public function show(Atlit $atlit)
    {
        return view('admin.atlit.show', compact('atlit'));
    }

    public function edit(Atlit $atlit)
    {
        $klub = Klub::aktif()->orderBy('nama_klub')->get();
        $cabangOlahraga = Cabor::aktif()->orderBy('nama_cabang')->get();
        $kategoriAtlit = KategoriAtlit::where('cabang_olahraga_id', $atlit->cabang_olahraga_id)
            ->aktif()
            ->orderBy('nama_kategori')
            ->get();

        return view('admin.atlit.edit', compact('atlit', 'klub', 'cabangOlahraga', 'kategoriAtlit'));
    }

    public function update(Request $request, Atlit $atlit)
    {
        $request->validate(Atlit::rules($atlit->id));

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($atlit->foto) {
                Storage::disk('public')->delete('atlit/foto/' . $atlit->foto);
            }

            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $path = $foto->storeAs('atlit/foto', $filename, 'public');
            $data['foto'] = $filename;
        }

        $atlit->update($data);

        // Buat atau update user jika email berubah
        if ($atlit->email && !$atlit->user_id) {
            $atlit->createUser();
        } elseif ($atlit->user_id && $atlit->email) {
            $atlit->user->update([
                'name' => $atlit->nama_lengkap,
                'email' => $atlit->email,
            ]);
        }

        return redirect()->route('admin.atlit.index')->with('success', 'Data atlit berhasil diperbarui.');
    }

    public function destroy(Atlit $atlit)
    {
        // Hapus foto jika ada
        if ($atlit->foto) {
            Storage::disk('public')->delete('atlit/foto/' . $atlit->foto);
        }

        // Hapus user terkait jika ada
        if ($atlit->user_id) {
            User::find($atlit->user_id)->delete();
        }

        $atlit->delete();

        return redirect()->route('admin.atlit.index')->with('success', 'Data atlit berhasil dihapus.');
    }

    public function getKategori($cabangOlahragaId)
    {
        $kategori = KategoriAtlit::where('cabang_olahraga_id', $cabangOlahragaId)
            ->aktif()
            ->orderBy('nama_kategori')
            ->get();

        return response()->json($kategori);
    }


    // Method untuk halaman kategori
    public function kategori()
    {
        return view('admin.atlit.kategori');
    }

    public function profil()
    {
        // Mendapatkan data atlit berdasarkan user yang login
        $atlit = Atlit::with(['klub', 'cabangOlahraga', 'kategoriAtlit', 'user'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('atlit.profil', compact('atlit'));
    }

    /**
     * Update profil atlit (akan di-handle oleh Livewire component)
     * Method ini sebagai fallback jika diperlukan
     */
    public function updateProfil(Request $request)
    {
        // Redirect ke halaman profil karena update di-handle oleh Livewire
        return redirect()->route('atlit.profil')->with('info', 'Gunakan form di halaman profil untuk mengupdate data.');
    }


    public function dokumenIndex()
    {
        $atlit = Atlit::with(['klub', 'cabangOlahraga', 'kategoriAtlit'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('atlit.dokumen.index', compact('atlit'));
    }

    /**
     * Menampilkan form upload dokumen
     */
    public function dokumenCreate()
    {
        $atlit = Atlit::where('user_id', Auth::id())->firstOrFail();
        return view('atlit.dokumen.create', compact('atlit'));
    }

    /**
     * Menyimpan dokumen yang diupload (akan di-handle oleh Livewire)
     */
    public function dokumenStore(Request $request)
    {
        return redirect()->route('atlit.dokumen.index')
            ->with('info', 'Silakan gunakan form upload di halaman dokumen.');
    }

    /**
     * Download dokumen
     */
    public function dokumenDownload(DokumenAtlit $dokumen)
    {
        // Pastikan dokumen milik atlit yang login
        $atlit = Atlit::where('user_id', Auth::id())->firstOrFail();

        if ($dokumen->atlit_id !== $atlit->id) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        $filePath = storage_path('app/private/dokumen_atlit/' . $dokumen->file_path);

        if (!file_exists($filePath)) {
            return redirect()->route('atlit.dokumen.index')
                ->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath, $dokumen->nama_file);
    }

    /**
     * Hapus dokumen
     */
    public function dokumenDestroy(DokumenAtlit $dokumen)
    {
        // Pastikan dokumen milik atlit yang login
        $atlit = Atlit::where('user_id', Auth::id())->firstOrFail();

        if ($dokumen->atlit_id !== $atlit->id) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        try {
            // Hapus file dari storage
            $filePath = 'dokumen_atlit/' . $dokumen->file_path;
            if (Storage::disk('private')->exists($filePath)) {
                Storage::disk('private')->delete($filePath);
            }

            // Hapus record dari database
            $dokumen->delete();

            return redirect()->route('atlit.dokumen.index')
                ->with('success', 'Dokumen berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('atlit.dokumen.index')
                ->with('error', 'Terjadi kesalahan saat menghapus dokumen.');
        }
    }
}
