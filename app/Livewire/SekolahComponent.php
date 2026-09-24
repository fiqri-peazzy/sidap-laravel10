<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sekolah;
use Illuminate\Support\Facades\Hash;

class SekolahComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Properties untuk form
    public $search = '';
    public $npsn = '';
    public $nama_sekolah = '';
    public $jenjang = 'SMA';
    public $alamat = '';
    public $kota = '';
    public $provinsi = '';
    public $kode_pos = '';
    public $telepon = '';
    public $email = '';
    public $kepala_sekolah = '';
    public $status = 'aktif';

    // Properties untuk akun operator (dipakai saat create, atau saat edit jika belum ada operator)
    public $operator_email = '';
    public $operator_password = '';
    public $hasOperator = false;
    public $currentOperatorEmail = null;

    // Properties untuk modal dan aksi
    public $editingId = null;
    public $showModal = false;
    public $showDetailModal = false;
    public $deleteId = null;
    public $detailSekolah = null;

    protected function rules()
    {
        $rules = [
            'npsn' => 'nullable|string|max:20|unique:sekolah,npsn,' . $this->editingId,
            'nama_sekolah' => 'required|string|max:255',
            'jenjang' => 'required|in:SD,SMP,SMA,SMK,Lainnya',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:sekolah,email,' . $this->editingId,
            'kepala_sekolah' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ];

        if (!$this->hasOperator) {
            $rules['operator_email'] = 'nullable|email|unique:users,email';
            $rules['operator_password'] = 'nullable|string|min:6|required_with:operator_email';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nama_sekolah.required' => 'Nama sekolah wajib diisi.',
            'npsn.unique' => 'NPSN sudah digunakan.',
            'alamat.required' => 'Alamat wajib diisi.',
            'kota.required' => 'Kota wajib diisi.',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'operator_email.unique' => 'Email operator sudah digunakan akun lain.',
            'operator_password.required_with' => 'Password operator wajib diisi jika email operator diisi.',
            'operator_password.min' => 'Password operator minimal 6 karakter.',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $sekolah = Sekolah::with('operator')->findOrFail($id);
        $this->editingId = $id;
        $this->npsn = $sekolah->npsn;
        $this->nama_sekolah = $sekolah->nama_sekolah;
        $this->jenjang = $sekolah->jenjang;
        $this->alamat = $sekolah->alamat;
        $this->kota = $sekolah->kota;
        $this->provinsi = $sekolah->provinsi;
        $this->kode_pos = $sekolah->kode_pos;
        $this->telepon = $sekolah->telepon;
        $this->email = $sekolah->email;
        $this->kepala_sekolah = $sekolah->kepala_sekolah;
        $this->status = $sekolah->status;
        $this->hasOperator = (bool) $sekolah->operator;
        $this->currentOperatorEmail = $sekolah->operator->email ?? null;
        $this->showModal = true;
    }

    public function detail($id)
    {
        $this->detailSekolah = Sekolah::with('operator')->findOrFail($id);
        $this->showDetailModal = true;
    }

    public function save()
    {
        $this->validate();

        $sekolahData = [
            'npsn' => $this->npsn,
            'nama_sekolah' => $this->nama_sekolah,
            'jenjang' => $this->jenjang,
            'alamat' => $this->alamat,
            'kota' => $this->kota,
            'provinsi' => $this->provinsi,
            'kode_pos' => $this->kode_pos,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'kepala_sekolah' => $this->kepala_sekolah,
            'status' => $this->status,
        ];

        if ($this->editingId) {
            $sekolah = Sekolah::findOrFail($this->editingId);
            $sekolah->update($sekolahData);

            if (!$this->hasOperator && $this->operator_email && $this->operator_password) {
                $sekolah->createUser($this->operator_email, $this->operator_password);
            }

            session()->flash('message', 'Data sekolah berhasil diperbarui.');
        } else {
            $sekolah = Sekolah::create($sekolahData);

            if ($this->operator_email && $this->operator_password) {
                $sekolah->createUser($this->operator_email, $this->operator_password);
            }

            session()->flash('message', 'Data sekolah berhasil ditambahkan.');
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
            $sekolah = Sekolah::findOrFail($this->deleteId);
            $sekolah->delete();
            session()->flash('message', 'Data sekolah berhasil dihapus.');
            $this->deleteId = null;
        }
    }

    public function resetForm()
    {
        $this->npsn = '';
        $this->nama_sekolah = '';
        $this->jenjang = 'SMA';
        $this->alamat = '';
        $this->kota = '';
        $this->provinsi = '';
        $this->kode_pos = '';
        $this->telepon = '';
        $this->email = '';
        $this->kepala_sekolah = '';
        $this->status = 'aktif';
        $this->operator_email = '';
        $this->operator_password = '';
        $this->hasOperator = false;
        $this->currentOperatorEmail = null;
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
        $this->detailSekolah = null;
    }

    public function render()
    {
        $sekolah = Sekolah::withCount('atlit')
            ->search($this->search)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.sekolah-component', [
            'sekolah' => $sekolah,
        ]);
    }
}
