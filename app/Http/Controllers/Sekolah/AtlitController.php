<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use App\Models\Atlit;
use App\Models\Klub;
use App\Models\Cabor;
use App\Models\KategoriAtlit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AtlitController extends Controller
{
    public function index()
    {
        return view('sekolah.atlit.index');
    }

    public function create()
    {
        $klub = Klub::aktif()->orderBy('nama_klub')->get();
        $cabangOlahraga = Cabor::aktif()->orderBy('nama_cabang')->get();

        return view('sekolah.atlit.create', compact('klub', 'cabangOlahraga'));
    }

    public function store(Request $request)
    {
        $request->validate(Atlit::rules());

        $data = $request->all();
        $data['sekolah_id'] = Auth::user()->sekolah_id;
        $data['status_verifikasi'] = Atlit::STATUS_VERIFIKASI_PENDING;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('atlit/foto', $filename, 'public');
            $data['foto'] = $filename;
        }

        $atlit = Atlit::create($data);

        if ($request->has('riwayat')) {
            foreach ($request->riwayat as $r) {
                if (!empty($r['tahun']) && !empty($r['klub_id']) && !empty($r['cabang_olahraga_id'])) {
                    $atlit->riwayat()->create([
                        'tahun' => $r['tahun'],
                        'klub_id' => $r['klub_id'],
                        'cabang_olahraga_id' => $r['cabang_olahraga_id'],
                        'kategori_atlit_id' => $r['kategori_atlit_id'],
                        'status' => $r['status'] ?? 'aktif',
                    ]);
                }
            }
        } else {
            $atlit->riwayat()->create([
                'tahun' => date('Y'),
                'klub_id' => $atlit->klub_id,
                'cabang_olahraga_id' => $atlit->cabang_olahraga_id,
                'kategori_atlit_id' => $atlit->kategori_atlit_id,
                'status' => $atlit->status,
            ]);
        }

        if ($atlit->email) {
            $atlit->createUser();
        }

        return redirect()->route('sekolah.atlit.index')->with('success', 'Data atlet berhasil ditambahkan dan menunggu verifikasi.');
    }

    public function show(Atlit $atlit)
    {
        $this->authorizeSekolah($atlit);

        return view('sekolah.atlit.show', compact('atlit'));
    }

    public function edit(Atlit $atlit)
    {
        $this->authorizeSekolah($atlit);

        $klub = Klub::aktif()->orderBy('nama_klub')->get();
        $cabangOlahraga = Cabor::aktif()->orderBy('nama_cabang')->get();
        $kategoriAtlit = KategoriAtlit::where('cabang_olahraga_id', $atlit->cabang_olahraga_id)
            ->aktif()
            ->orderBy('nama_kategori')
            ->get();

        return view('sekolah.atlit.edit', compact('atlit', 'klub', 'cabangOlahraga', 'kategoriAtlit'));
    }

    public function update(Request $request, Atlit $atlit)
    {
        $this->authorizeSekolah($atlit);

        $request->validate(Atlit::rules($atlit->id));

        $data = $request->all();
        unset($data['sekolah_id']); // operator tidak boleh pindahkan atlet ke sekolah lain

        if ($request->hasFile('foto')) {
            if ($atlit->foto) {
                Storage::disk('public')->delete('atlit/foto/' . $atlit->foto);
            }

            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('atlit/foto', $filename, 'public');
            $data['foto'] = $filename;
        }

        $atlit->update($data);

        if ($request->has('riwayat')) {
            $atlit->riwayat()->delete();
            foreach ($request->riwayat as $r) {
                if (!empty($r['tahun']) && !empty($r['klub_id']) && !empty($r['cabang_olahraga_id'])) {
                    $atlit->riwayat()->create([
                        'tahun' => $r['tahun'],
                        'klub_id' => $r['klub_id'],
                        'cabang_olahraga_id' => $r['cabang_olahraga_id'],
                        'kategori_atlit_id' => $r['kategori_atlit_id'],
                        'status' => $r['status'] ?? 'aktif',
                    ]);
                }
            }
        }

        if ($atlit->email && !$atlit->user_id) {
            $atlit->createUser();
        } elseif ($atlit->user_id && $atlit->email) {
            $atlit->user->update([
                'name' => $atlit->nama_lengkap,
                'email' => $atlit->email,
            ]);
        }

        return redirect()->route('sekolah.atlit.index')->with('success', 'Data atlet berhasil diperbarui.');
    }

    public function destroy(Atlit $atlit)
    {
        $this->authorizeSekolah($atlit);

        if ($atlit->foto) {
            Storage::disk('public')->delete('atlit/foto/' . $atlit->foto);
        }

        if ($atlit->user_id) {
            $atlit->user()->delete();
        }

        $atlit->delete();

        return redirect()->route('sekolah.atlit.index')->with('success', 'Data atlet berhasil dihapus.');
    }

    /**
     * Pastikan atlet yang diakses memang milik sekolah operator yang login.
     */
    private function authorizeSekolah(Atlit $atlit)
    {
        if ($atlit->sekolah_id !== Auth::user()->sekolah_id) {
            abort(403, 'Anda tidak memiliki akses ke data atlet ini.');
        }
    }
}
