<?php

namespace App\Livewire\Atlit;

use App\Models\KategoriAtlit;
use App\Models\Cabor;
use Livewire\Component;
use Livewire\WithPagination;

class KategoriAtlitTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterCabor = '';
    public $filterStatus = '';
    public $perPage = 10;

    // Form properties
    public $kategoriId;
    public $cabang_olahraga_id = '';
    public $nama_kategori = '';
    public $deskripsi = '';
    public $status = 'aktif';
    public $showForm = false;
    public $editMode = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'cabang_olahraga_id' => 'required|exists:cabang_olahraga,id',
        'nama_kategori' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'status' => 'required|in:aktif,nonaktif',
    ];

    protected $messages = [
        'cabang_olahraga_id.required' => 'Cabang olahraga harus dipilih.',
        'cabang_olahraga_id.exists' => 'Cabang olahraga tidak valid.',
        'nama_kategori.required' => 'Nama kategori harus diisi.',
        'nama_kategori.max' => 'Nama kategori maksimal 255 karakter.',
        'status.required' => 'Status harus dipilih.',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCabor' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    // Fix untuk filter - menggunakan updatedProperty untuk real-time filtering
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterCabor()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterCabor = '';
        $this->filterStatus = '';
        $this->resetPage();
    }

    public function openForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editMode = false;
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->kategoriId = null;
        $this->cabang_olahraga_id = '';
        $this->nama_kategori = '';
        $this->deskripsi = '';
        $this->status = 'aktif';
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        KategoriAtlit::create([
            'cabang_olahraga_id' => $this->cabang_olahraga_id,
            'nama_kategori' => $this->nama_kategori,
            'deskripsi' => $this->deskripsi,
            'status' => $this->status,
        ]);

        $this->closeForm();
        session()->flash('success', 'Kategori atlit berhasil ditambahkan.');
        $this->dispatch('showAlert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Kategori atlit berhasil ditambahkan.'
        ]);
    }

    public function edit($id)
    {
        $kategori = KategoriAtlit::find($id);
        if ($kategori) {
            $this->kategoriId = $kategori->id;
            $this->cabang_olahraga_id = $kategori->cabang_olahraga_id;
            $this->nama_kategori = $kategori->nama_kategori;
            $this->deskripsi = $kategori->deskripsi;
            $this->status = $kategori->status;
            $this->showForm = true;
            $this->editMode = true;
        }
    }

    public function update()
    {
        $this->validate();

        $kategori = KategoriAtlit::find($this->kategoriId);
        if ($kategori) {
            $kategori->update([
                'cabang_olahraga_id' => $this->cabang_olahraga_id,
                'nama_kategori' => $this->nama_kategori,
                'deskripsi' => $this->deskripsi,
                'status' => $this->status,
            ]);

            $this->closeForm();
            session()->flash('success', 'Kategori atlit berhasil diperbarui.');
            $this->dispatch('showAlert', [
                'type' => 'success',
                'title' => 'Berhasil!',
                'message' => 'Kategori atlit berhasil diperbarui.'
            ]);
        }
    }

    // Method untuk konfirmasi delete
    public function confirmDelete($id)
    {
        $kategori = KategoriAtlit::find($id);
        if ($kategori) {
            // Cek apakah kategori masih digunakan
            if ($kategori->atlit()->count() > 0) {
                $this->dispatch('showAlert', [
                    'type' => 'warning',
                    'title' => 'Peringatan!',
                    'message' => 'Kategori tidak dapat dihapus karena masih digunakan oleh atlit.'
                ]);
                return;
            }

            $this->dispatch('confirmDelete', [
                'id' => $id,
                'title' => 'Hapus Kategori',
                'text' => 'Apakah Anda yakin ingin menghapus kategori "' . $kategori->nama_kategori . '"?',
                'confirmButtonText' => 'Ya, Hapus!',
                'cancelButtonText' => 'Batal'
            ]);
        }
    }

    // Method untuk menghapus data setelah konfirmasi
    public function delete($id)
    {
        $kategori = KategoriAtlit::find($id);
        if ($kategori) {
            $kategori->delete();
            session()->flash('success', 'Kategori atlit berhasil dihapus.');
            $this->dispatch('showAlert', [
                'type' => 'success',
                'title' => 'Berhasil!',
                'message' => 'Kategori atlit berhasil dihapus.'
            ]);
        }
    }

    public function render()
    {
        $query = KategoriAtlit::with('cabangOlahraga');

        // Fix untuk search - menggunakan LIKE untuk pencarian yang lebih fleksibel
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_kategori', 'like', '%' . $this->search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                    ->orWhereHas('cabangOlahraga', function ($subQuery) {
                        $subQuery->where('nama_cabang', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->filterCabor) {
            $query->where('cabang_olahraga_id', $this->filterCabor);
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $kategoriAtlit = $query->withCount('atlit')->latest()->paginate($this->perPage);
        $cabangOlahraga = Cabor::aktif()->orderBy('nama_cabang')->get();

        return view('livewire.atlit.kategori-atlit-table', compact('kategoriAtlit', 'cabangOlahraga'));
    }
}
