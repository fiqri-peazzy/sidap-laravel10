<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cabor;
use App\Models\Klub;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Pelatih;

class PelatihComponent extends Component
{

    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Properties untuk form
    public $pelatih_id;
    public $nama;
    public $email;
    public $telepon;
    public $alamat;
    public $tanggal_lahir;
    public $jenis_kelamin = 'L';
    public $klub_id;
    public $cabang_olahraga_id;
    public $lisensi;
    public $pengalaman_tahun;
    public $status = 'aktif';
    public $foto;
    public $existing_foto;

    // Properties untuk search dan filter
    public $search = '';
    public $filterStatus = '';
    public $filterKlub = '';
    public $filterCabor = '';
    public $perPage = 10;

    // Modal states
    public $showModal = false;
    public $showDeleteModal = false;
    public $editMode = false;

    // Messages
    public $successMessage = '';
    public $errorMessage = '';

    protected function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('pelatih', 'email')->ignore($this->pelatih_id)
            ],
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'klub_id' => 'required|exists:klub,id',
            'cabang_olahraga_id' => 'required|exists:cabang_olahraga,id',
            'lisensi' => 'nullable|string|max:100',
            'pengalaman_tahun' => 'required|integer|min:0|max:50',
            'status' => 'required|in:aktif,nonaktif,cuti',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }

    protected $validationAttributes = [
        'nama' => 'Nama',
        'email' => 'Email',
        'telepon' => 'Telepon',
        'alamat' => 'Alamat',
        'tanggal_lahir' => 'Tanggal Lahir',
        'jenis_kelamin' => 'Jenis Kelamin',
        'klub_id' => 'Klub',
        'cabang_olahraga_id' => 'Cabang Olahraga',
        'lisensi' => 'Lisensi',
        'pengalaman_tahun' => 'Pengalaman (Tahun)',
        'status' => 'Status',
        'foto' => 'Foto'
    ];

    public function mount()
    {
        $this->resetPage();
    }

    public function render()
    {
        $pelatihQuery = Pelatih::with(['klub', 'cabangOlahraga'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('telepon', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterKlub, function ($query) {
                $query->where('klub_id', $this->filterKlub);
            })
            ->when($this->filterCabor, function ($query) {
                $query->where('cabang_olahraga_id', $this->filterCabor);
            })
            ->orderBy('created_at', 'desc');

        $pelatih = $pelatihQuery->paginate($this->perPage);
        $klub = Klub::aktif()->orderBy('nama_klub')->get();
        $cabangOlahraga = Cabor::aktif()->orderBy('nama_cabang')->get();

        return view('livewire.pelatih-component', [
            'pelatih' => $pelatih,
            'klub' => $klub,
            'cabangOlahraga' => $cabangOlahraga
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterKlub()
    {
        $this->resetPage();
    }

    public function updatingFilterCabor()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterStatus = '';
        $this->filterKlub = '';
        $this->filterCabor = '';
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $pelatih = Pelatih::findOrFail($id);

        $this->pelatih_id = $pelatih->id;
        $this->nama = $pelatih->nama;
        $this->email = $pelatih->email;
        $this->telepon = $pelatih->telepon;
        $this->alamat = $pelatih->alamat;
        $this->tanggal_lahir = $pelatih->tanggal_lahir?->format('Y-m-d');
        $this->jenis_kelamin = $pelatih->jenis_kelamin;
        $this->klub_id = $pelatih->klub_id;
        $this->cabang_olahraga_id = $pelatih->cabang_olahraga_id;
        $this->lisensi = $pelatih->lisensi;
        $this->pengalaman_tahun = $pelatih->pengalaman_tahun;
        $this->status = $pelatih->status;
        $this->existing_foto = $pelatih->foto;

        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'nama' => $this->nama,
                'email' => $this->email,
                'telepon' => $this->telepon,
                'alamat' => $this->alamat,
                'tanggal_lahir' => $this->tanggal_lahir,
                'jenis_kelamin' => $this->jenis_kelamin,
                'klub_id' => $this->klub_id,
                'cabang_olahraga_id' => $this->cabang_olahraga_id,
                'lisensi' => $this->lisensi,
                'pengalaman_tahun' => $this->pengalaman_tahun,
                'status' => $this->status,
            ];

            // Handle foto upload
            if ($this->foto) {
                // Delete old foto if exists
                if ($this->existing_foto && Storage::disk('public')->exists($this->existing_foto)) {
                    Storage::disk('public')->delete($this->existing_foto);
                }

                $fotoPath = $this->foto->store('pelatih/foto', 'public');
                $data['foto'] = $fotoPath;
            }

            if ($this->editMode) {
                Pelatih::findOrFail($this->pelatih_id)->update($data);
                $this->successMessage = 'Data pelatih berhasil diperbarui!';
            } else {
                Pelatih::create($data);
                $this->successMessage = 'Data pelatih berhasil ditambahkan!';
            }

            $this->closeModal();
            $this->dispatch('show-success-message', $this->successMessage);
        } catch (\Exception $e) {
            $this->errorMessage = 'Terjadi kesalahan: ' . $e->getMessage();
            $this->dispatch('show-error-message', $this->errorMessage);
        }
    }

    public function confirmDelete($id)
    {
        $this->pelatih_id = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        try {
            $pelatih = Pelatih::findOrFail($this->pelatih_id);

            // Delete foto if exists
            if ($pelatih->foto && Storage::disk('public')->exists($pelatih->foto)) {
                Storage::disk('public')->delete($pelatih->foto);
            }

            $pelatih->delete();

            $this->successMessage = 'Data pelatih berhasil dihapus!';
            $this->showDeleteModal = false;
            $this->dispatch('show-success-message', $this->successMessage);
        } catch (\Exception $e) {
            $this->errorMessage = 'Terjadi kesalahan: ' . $e->getMessage();
            $this->dispatch('show-error-message', $this->errorMessage);
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->resetValidation();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->pelatih_id = null;
    }

    private function resetForm()
    {
        $this->pelatih_id = null;
        $this->nama = '';
        $this->email = '';
        $this->telepon = '';
        $this->alamat = '';
        $this->tanggal_lahir = '';
        $this->jenis_kelamin = 'L';
        $this->klub_id = '';
        $this->cabang_olahraga_id = '';
        $this->lisensi = '';
        $this->pengalaman_tahun = '';
        $this->status = 'aktif';
        $this->foto = null;
        $this->existing_foto = '';
    }

    public function exportData()
    {
        $this->dispatch('export-data');
    }
}