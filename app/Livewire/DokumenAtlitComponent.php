<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Atlit;
use App\Models\DokumenAtlit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DokumenAtlitComponent extends Component
{
    use WithFileUploads;

    public $atlit;
    public $dokumenList = [];

    // Form data
    public $kategori_berkas;
    public $keterangan;
    public $file_upload;

    // Modal control
    public $showUploadModal = false;

    protected function rules()
    {
        return [
            'kategori_berkas' => 'required|in:Ijazah,Akta Kelahiran,Kartu Pelajar,Dokumen Pendukung',
            'keterangan' => 'nullable|string|max:500',
            'file_upload' => 'required|file|mimes:pdf|max:5120', // 5MB
        ];
    }

    protected $messages = [
        'kategori_berkas.required' => 'Kategori berkas wajib dipilih.',
        'kategori_berkas.in' => 'Kategori berkas tidak valid.',
        'keterangan.max' => 'Keterangan maksimal 500 karakter.',
        'file_upload.required' => 'File PDF wajib diupload.',
        'file_upload.file' => 'File yang diupload tidak valid.',
        'file_upload.mimes' => 'File harus berformat PDF.',
        'file_upload.max' => 'Ukuran file maksimal 5MB.',
    ];

    public function mount(Atlit $atlit)
    {
        $this->atlit = $atlit;
        $this->loadDokumen();
    }

    public function loadDokumen()
    {
        $this->dokumenList = DokumenAtlit::with('verifikator')
            ->where('atlit_id', $this->atlit->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function openUploadModal()
    {
        $this->resetForm();
        $this->showUploadModal = true;
    }

    public function closeUploadModal()
    {
        $this->showUploadModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->kategori_berkas = '';
        $this->keterangan = '';
        $this->file_upload = null;
        $this->resetErrorBag();
    }

    public function uploadDokumen()
    {
        $this->validate();

        try {
            // Cek apakah kategori sudah ada (kecuali Dokumen Pendukung)
            if ($this->kategori_berkas !== 'Dokumen Pendukung') {
                $existing = DokumenAtlit::where('atlit_id', $this->atlit->id)
                    ->where('kategori_berkas', $this->kategori_berkas)
                    ->exists();

                if ($existing) {
                    $this->addError('kategori_berkas', 'Dokumen ' . $this->kategori_berkas . ' sudah pernah diupload. Hapus yang lama terlebih dahulu.');
                    return;
                }
            }

            // Generate nama file yang unik
            $originalName = $this->file_upload->getClientOriginalName();
            $fileName = time() . '_' . $this->atlit->id . '_' . str_replace(' ', '_', $this->kategori_berkas) . '.pdf';

            // Simpan file ke storage private
            $filePath = $this->file_upload->storeAs('dokumen_atlit', $fileName, 'private');

            // Simpan data ke database
            DokumenAtlit::create([
                'atlit_id' => $this->atlit->id,
                'kategori_berkas' => $this->kategori_berkas,
                'nama_file' => $originalName,
                'file_path' => $fileName,
                'keterangan' => $this->keterangan,
                'status_verifikasi' => 'pending',
            ]);

            // Reload data
            $this->loadDokumen();

            // Close modal dan reset form
            $this->closeUploadModal();

            session()->flash('success', 'Dokumen berhasil diupload dan menunggu verifikasi.');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat upload dokumen: ' . $e->getMessage());
        }
    }

    public function deleteDokumen($dokumenId)
    {
        try {
            $dokumen = DokumenAtlit::where('id', $dokumenId)
                ->where('atlit_id', $this->atlit->id)
                ->firstOrFail();

            // Hapus file dari storage
            if (Storage::disk('private')->exists('dokumen_atlit/' . $dokumen->file_path)) {
                Storage::disk('private')->delete('dokumen_atlit/' . $dokumen->file_path);
            }

            // Hapus record dari database
            $dokumen->delete();

            // Reload data
            $this->loadDokumen();

            session()->flash('success', 'Dokumen berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menghapus dokumen.');
        }
    }

    public function getStatistikDokumen()
    {
        return [
            'total' => $this->dokumenList->count(),
            'verified' => $this->dokumenList->where('status_verifikasi', 'verified')->count(),
            'pending' => $this->dokumenList->where('status_verifikasi', 'pending')->count(),
            'rejected' => $this->dokumenList->where('status_verifikasi', 'rejected')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.dokumen-atlit-component', [
            'statistik' => $this->getStatistikDokumen(),
            'kategoriBerkas' => DokumenAtlit::KATEGORI_BERKAS,
        ]);
    }
}
