<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Klub;
use App\Models\Cabor;
use Illuminate\Support\Facades\Storage;

class KlubComponent extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Properties untuk form
    public $search = '';
    public $nama_klub = '';
    public $alamat = '';
    public $kota = '';
    public $provinsi = '';
    public $kode_pos = '';
    public $telepon = '';
    public $email = '';
    public $tahun_berdiri = '';
    public $ketua_klub = '';
    public $sekretaris = '';
    public $bendahara = '';
    public $website = '';
    public $deskripsi = '';
    public $logo = '';
    public $existing_logo = '';
    public $status = 'aktif';
    public $cabang_olahraga_ids = [];

    // Properties untuk modal dan aksi
    public $editingId = null;
    public $showModal = false;
    public $showDetailModal = false;
    public $deleteId = null;
    public $detailKlub = null;
    public $activeTab = 'info'; // info, cabang, kontak

    protected function rules()
    {
        return [
            'nama_klub' => 'required|string|max:255|unique:klub,nama_klub,' . $this->editingId,
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:klub,email,' . $this->editingId,
            'tahun_berdiri' => 'nullable|integer|min:1900|max:' . date('Y'),
            'ketua_klub' => 'nullable|string|max:255',
            'sekretaris' => 'nullable|string|max:255',
            'bendahara' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,nonaktif',
            'cabang_olahraga_ids' => 'nullable|array',
            'cabang_olahraga_ids.*' => 'exists:cabang_olahraga,id',
        ];
    }

    public function messages()
    {
        return [
            'nama_klub.required' => 'Nama klub wajib diisi.',
            'nama_klub.unique' => 'Nama klub sudah digunakan.',
            'alamat.required' => 'Alamat wajib diisi.',
            'kota.required' => 'Kota wajib diisi.',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'tahun_berdiri.integer' => 'Tahun berdiri harus berupa angka.',
            'tahun_berdiri.min' => 'Tahun berdiri minimal 1900.',
            'tahun_berdiri.max' => 'Tahun berdiri maksimal ' . date('Y') . '.',
            'website.url' => 'Format website tidak valid.',
            'logo.image' => 'File harus berupa gambar.',
            'logo.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'logo.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->activeTab = 'info';
        $this->showModal = true;
    }

    public function edit($id)
    {
        $klub = \App\Models\Klub::with('cabangOlahraga')->findOrFail($id);
        $this->editingId = $id;
        $this->nama_klub = $klub->nama_klub;
        $this->alamat = $klub->alamat;
        $this->kota = $klub->kota;
        $this->provinsi = $klub->provinsi;
        $this->kode_pos = $klub->kode_pos;
        $this->telepon = $klub->telepon;
        $this->email = $klub->email;
        $this->tahun_berdiri = $klub->tahun_berdiri;
        $this->ketua_klub = $klub->ketua_klub;
        $this->sekretaris = $klub->sekretaris;
        $this->bendahara = $klub->bendahara;
        $this->website = $klub->website;
        $this->deskripsi = $klub->deskripsi;
        $this->existing_logo = $klub->logo;
        $this->status = $klub->status;
        $this->cabang_olahraga_ids = $klub->cabangOlahraga->pluck('id')->toArray();
        $this->activeTab = 'info';
        $this->showModal = true;
    }

    public function detail($id)
    {
        $this->detailKlub = \App\Models\Klub::with('cabangOlahraga')->findOrFail($id);
        $this->showDetailModal = true;
    }

    public function save()
    {
        $this->validate();

        $klubData = [
            'nama_klub' => $this->nama_klub,
            'alamat' => $this->alamat,
            'kota' => $this->kota,
            'provinsi' => $this->provinsi,
            'kode_pos' => $this->kode_pos,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'tahun_berdiri' => $this->tahun_berdiri,
            'ketua_klub' => $this->ketua_klub,
            'sekretaris' => $this->sekretaris,
            'bendahara' => $this->bendahara,
            'website' => $this->website,
            'deskripsi' => $this->deskripsi,
            'status' => $this->status,
        ];

        // Handle logo upload
        if ($this->logo) {
            $logoName = time() . '.' . $this->logo->getClientOriginalExtension();
            $this->logo->storeAs('public/klub/logo', $logoName);
            $klubData['logo'] = $logoName;

            // Delete old logo if editing
            if ($this->editingId && $this->existing_logo) {
                Storage::delete('public/klub/logo/' . $this->existing_logo);
            }
        }

        if ($this->editingId) {
            $klub = \App\Models\Klub::findOrFail($this->editingId);
            $klub->update($klubData);
            session()->flash('message', 'Data klub berhasil diperbarui.');
        } else {
            $klub = \App\Models\Klub::create($klubData);
            session()->flash('message', 'Data klub berhasil ditambahkan.');
        }

        // Sync cabang olahraga
        if (!empty($this->cabang_olahraga_ids)) {
            $klub->cabangOlahraga()->sync($this->cabang_olahraga_ids);
        } else {
            $klub->cabangOlahraga()->detach();
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if ($this->deleteId) {
            $klub = \App\Models\Klub::findOrFail($this->deleteId);

            // Delete logo if exists
            if ($klub->logo) {
                Storage::delete('public/klub/logo/' . $klub->logo);
            }

            $klub->delete();
            session()->flash('message', 'Data klub berhasil dihapus.');
            $this->deleteId = null;
        }
    }

    public function resetForm()
    {
        $this->nama_klub = '';
        $this->alamat = '';
        $this->kota = '';
        $this->provinsi = '';
        $this->kode_pos = '';
        $this->telepon = '';
        $this->email = '';
        $this->tahun_berdiri = '';
        $this->ketua_klub = '';
        $this->sekretaris = '';
        $this->bendahara = '';
        $this->website = '';
        $this->deskripsi = '';
        $this->logo = '';
        $this->existing_logo = '';
        $this->status = 'aktif';
        $this->cabang_olahraga_ids = [];
        $this->editingId = null;
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->detailKlub = null;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $klub = \App\Models\Klub::with('cabangOlahraga')
            ->search($this->search)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $cabangOlahraga = Cabor::aktif()->orderBy('nama_cabang')->get();

        return view('livewire.klub-component', [
            'klub' => $klub,
            'cabangOlahraga' => $cabangOlahraga
        ]);
    }
}