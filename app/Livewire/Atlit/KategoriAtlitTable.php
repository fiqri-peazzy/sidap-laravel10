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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterCabor()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
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
        }
    }

    public function delete($id)
    {
        $kategori = KategoriAtlit::find($id);

        if ($kategori) {
            // Cek apakah kategori masih digunakan oleh atlit
            if ($kategori->atlit()->count() > 0) {
                session()->flash('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh atlit.');
                return;
            }

            $kategori->delete();
            session()->flash('success', 'Kategori atlit berhasil dihapus.');
        }
    }

    public function render()
    {
        $query = KategoriAtlit::with('cabangOlahraga');

        if ($this->search) {
            $query->search($this->search);
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
