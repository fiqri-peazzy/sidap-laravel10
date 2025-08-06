<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Cabor;
use Illuminate\Validation\Rule;

class Cabor extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $nama_cabang = '';
    public $deskripsi = '';
    public $status = 'aktif';
    public $editingId = null;
    public $showModal = false;
    public $deleteId = null;

    protected $rules = [
        'nama_cabang' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'status' => 'required|in:aktif,nonaktif',
    ];

    protected $messages = [
        'nama_cabang.required' => 'Nama cabang olahraga wajib diisi.',
        'nama_cabang.max' => 'Nama cabang olahraga maksimal 255 karakter.',
        'status.required' => 'Status wajib dipilih.',
        'status.in' => 'Status harus aktif atau nonaktif.',
    ];

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
        $cabang = \App\Models\Cabor::findOrFail($id);
        $this->editingId = $id;
        $this->nama_cabang = $cabang->nama_cabang;
        $this->deskripsi = $cabang->deskripsi;
        $this->status = $cabang->status;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'nama_cabang' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cabang_olahraga', 'nama_cabang')->ignore($this->editingId)
            ],
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if ($this->editingId) {
            $cabang = \App\Models\Cabor::findOrFail($this->editingId);
            $cabang->update([
                'nama_cabang' => $this->nama_cabang,
                'deskripsi' => $this->deskripsi,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Data cabang olahraga berhasil diperbarui.');
        } else {
            \App\Models\Cabor::create([
                'nama_cabang' => $this->nama_cabang,
                'deskripsi' => $this->deskripsi,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Data cabang olahraga berhasil ditambahkan.');
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
            \App\Models\Cabor::findOrFail($this->deleteId)->delete();
            session()->flash('message', 'Data cabang olahraga berhasil dihapus.');
            $this->deleteId = null;
        }
    }

    public function resetForm()
    {
        $this->nama_cabang = '';
        $this->deskripsi = '';
        $this->status = 'aktif';
        $this->editingId = null;
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function render()
    {
        $cabangOlahraga = Cabor::where('nama_cabang', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.cabor');
    }
}