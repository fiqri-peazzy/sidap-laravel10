<?php

namespace App\Livewire\Verifikator;

use App\Models\Atlit;
use App\Models\DokumenAtlit;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AtlitShow extends Component
{
    public $atlit;
    public $documentStats = [];
    public $selectedDokumen = null;
    public $showVerifyModal = false;
    public $showRejectModal = false;
    public $showDokumenVerifyModal = false;
    public $showDokumenRejectModal = false;

    // Modal data
    public $modalType = ''; // 'atlit' or 'dokumen'
    public $modalAction = ''; // 'verify' or 'reject'
    public $alasanPenolakan = '';
    public $currentDokumen = null;

    protected $rules = [
        'alasanPenolakan' => 'required|string|max:500|min:10'
    ];

    protected $messages = [
        'alasanPenolakan.required' => 'Alasan penolakan harus diisi.',
        'alasanPenolakan.max' => 'Alasan penolakan maksimal 500 karakter.',
        'alasanPenolakan.min' => 'Alasan penolakan minimal 10 karakter.'
    ];

    protected $listeners = [
        'refreshAtletData' => 'refreshAtletData',
        'documentUpdated' => 'refreshAtletData'
    ];

    public function mount(Atlit $atlit, $documentStats = [])
    {
        $this->atlit = $atlit->load([
            'cabangOlahraga',
            'kategoriAtlit',
            'klub',
            'user',
            'verifikator',
            'dokumen' => function ($query) {
                $query->orderBy('kategori_berkas')->orderBy('created_at', 'desc');
            }
        ]);

        $this->documentStats = $documentStats ?: $this->atlit->getDocumentStats();

        // Auto-select first document if available
        if ($this->atlit->dokumen && $this->atlit->dokumen->count() > 0) {
            $this->selectedDokumen = $this->atlit->dokumen->first();
        }
    }

    public function refreshAtletData()
    {
        $this->atlit = $this->atlit->fresh([
            'cabangOlahraga',
            'kategoriAtlit',
            'klub',
            'user',
            'verifikator',
            'dokumen' => function ($query) {
                $query->orderBy('kategori_berkas')->orderBy('created_at', 'desc');
            }
        ]);

        // Refresh document stats
        $this->documentStats = $this->atlit->getDocumentStats();

        // Refresh selected document if it exists
        if ($this->selectedDokumen) {
            $this->selectedDokumen = $this->atlit->dokumen->find($this->selectedDokumen->id);
        }
    }

    // Modal methods untuk verifikasi atlet
    public function openVerifyAtlitModal()
    {
        if ($this->atlit->status !== 'pending') {
            session()->flash('warning', 'Atlet sudah pernah diverifikasi sebelumnya!');
            return;
        }

        $this->modalType = 'atlit';
        $this->modalAction = 'verify';
        $this->showVerifyModal = true;
    }

    public function openRejectAtlitModal()
    {
        if ($this->atlit->status !== 'pending') {
            session()->flash('warning', 'Atlet sudah pernah diverifikasi sebelumnya!');
            return;
        }

        $this->modalType = 'atlit';
        $this->modalAction = 'reject';
        $this->alasanPenolakan = '';
        $this->showRejectModal = true;
    }

    // Modal methods untuk verifikasi dokumen
    public function openVerifyDokumenModal($dokumenId)
    {
        $dokumen = DokumenAtlit::find($dokumenId);

        if (!$dokumen || $dokumen->atlit_id !== $this->atlit->id) {
            session()->flash('error', 'Dokumen tidak ditemukan!');
            return;
        }

        if ($dokumen->status_verifikasi !== 'pending') {
            session()->flash('warning', 'Dokumen sudah pernah diverifikasi sebelumnya!');
            return;
        }

        $this->currentDokumen = $dokumen;
        $this->modalType = 'dokumen';
        $this->modalAction = 'verify';
        $this->showDokumenVerifyModal = true;
    }

    public function openRejectDokumenModal($dokumenId)
    {
        $dokumen = DokumenAtlit::find($dokumenId);

        if (!$dokumen || $dokumen->atlit_id !== $this->atlit->id) {
            session()->flash('error', 'Dokumen tidak ditemukan!');
            return;
        }

        if ($dokumen->status_verifikasi !== 'pending') {
            session()->flash('warning', 'Dokumen sudah pernah diverifikasi sebelumnya!');
            return;
        }

        $this->currentDokumen = $dokumen;
        $this->modalType = 'dokumen';
        $this->modalAction = 'reject';
        $this->alasanPenolakan = '';
        $this->showDokumenRejectModal = true;
    }

    // Close all modals
    public function closeModals()
    {
        $this->showVerifyModal = false;
        $this->showRejectModal = false;
        $this->showDokumenVerifyModal = false;
        $this->showDokumenRejectModal = false;
        $this->alasanPenolakan = '';
        $this->currentDokumen = null;
        $this->resetValidation();
    }

    // Verify atlet
    public function verifyAtlit()
    {
        if ($this->atlit->status !== 'pending') {
            session()->flash('warning', 'Atlet sudah pernah diverifikasi sebelumnya!');
            $this->closeModals();
            return;
        }

        try {
            $this->atlit->update([
                'status' => 'diverifikasi',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'alasan_ditolak' => null,
            ]);

            Log::info('Atlet verified', [
                'atlit_id' => $this->atlit->id,
                'atlit_name' => $this->atlit->nama_lengkap,
                'verified_by' => Auth::id(),
                'verifier_name' => Auth::user()->name,
            ]);

            $this->refreshAtletData();
            $this->closeModals();

            session()->flash('success', 'Data atlet berhasil diverifikasi!');
        } catch (\Exception $e) {
            Log::error('Error verifying atlet', [
                'atlit_id' => $this->atlit->id,
                'error' => $e->getMessage(),
            ]);

            session()->flash('error', 'Terjadi kesalahan saat memverifikasi data atlet!');
        }
    }

    // Reject atlet
    public function rejectAtlit()
    {
        $this->validate();

        if ($this->atlit->status !== 'pending') {
            session()->flash('warning', 'Atlet sudah pernah diverifikasi sebelumnya!');
            $this->closeModals();
            return;
        }

        try {
            $this->atlit->update([
                'status' => 'ditolak',
                'alasan_ditolak' => $this->alasanPenolakan,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            Log::info('Atlet rejected', [
                'atlit_id' => $this->atlit->id,
                'atlit_name' => $this->atlit->nama_lengkap,
                'reason' => $this->alasanPenolakan,
                'rejected_by' => Auth::id(),
                'rejector_name' => Auth::user()->name,
            ]);

            $this->refreshAtletData();
            $this->closeModals();

            session()->flash('success', 'Data atlet berhasil ditolak!');
        } catch (\Exception $e) {
            Log::error('Error rejecting atlet', [
                'atlit_id' => $this->atlit->id,
                'error' => $e->getMessage(),
            ]);

            session()->flash('error', 'Terjadi kesalahan saat menolak data atlet!');
        }
    }

    // Verify dokumen
    public function verifyDokumen()
    {
        if (!$this->currentDokumen) {
            session()->flash('error', 'Dokumen tidak ditemukan!');
            return;
        }

        if ($this->currentDokumen->status_verifikasi !== 'pending') {
            session()->flash('warning', 'Dokumen sudah pernah diverifikasi sebelumnya!');
            $this->closeModals();
            return;
        }

        try {
            $this->currentDokumen->update([
                'status_verifikasi' => 'verified',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'alasan_ditolak' => null,
                'keterangan' => 'Dokumen telah diverifikasi oleh ' . Auth::user()->name
            ]);

            Log::info('Document verified', [
                'dokumen_id' => $this->currentDokumen->id,
                'atlit_id' => $this->atlit->id,
                'document_category' => $this->currentDokumen->kategori_berkas,
                'verified_by' => Auth::id(),
                'verifier_name' => Auth::user()->name,
            ]);

            $this->refreshAtletData();
            $this->closeModals();

            session()->flash('success', 'Dokumen berhasil diverifikasi!');
        } catch (\Exception $e) {
            Log::error('Error verifying document', [
                'dokumen_id' => $this->currentDokumen->id,
                'error' => $e->getMessage(),
            ]);

            session()->flash('error', 'Terjadi kesalahan saat memverifikasi dokumen!');
        }
    }

    // Reject dokumen
    public function rejectDokumen()
    {
        $this->validate();

        if (!$this->currentDokumen) {
            session()->flash('error', 'Dokumen tidak ditemukan!');
            return;
        }

        if ($this->currentDokumen->status_verifikasi !== 'pending') {
            session()->flash('warning', 'Dokumen sudah pernah diverifikasi sebelumnya!');
            $this->closeModals();
            return;
        }

        try {
            $this->currentDokumen->update([
                'status_verifikasi' => 'rejected',
                'alasan_ditolak' => $this->alasanPenolakan,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'keterangan' => 'Dokumen ditolak oleh ' . Auth::user()->name . ': ' . $this->alasanPenolakan
            ]);

            Log::info('Document rejected', [
                'dokumen_id' => $this->currentDokumen->id,
                'atlit_id' => $this->atlit->id,
                'document_category' => $this->currentDokumen->kategori_berkas,
                'reason' => $this->alasanPenolakan,
                'rejected_by' => Auth::id(),
                'rejector_name' => Auth::user()->name,
            ]);

            $this->refreshAtletData();
            $this->closeModals();

            session()->flash('success', 'Dokumen berhasil ditolak!');
        } catch (\Exception $e) {
            Log::error('Error rejecting document', [
                'dokumen_id' => $this->currentDokumen->id,
                'error' => $e->getMessage(),
            ]);

            session()->flash('error', 'Terjadi kesalahan saat menolak dokumen!');
        }
    }

    // Select dokumen for preview
    public function selectDokumen($dokumenId)
    {
        $this->selectedDokumen = DokumenAtlit::find($dokumenId);

        if (!$this->selectedDokumen || $this->selectedDokumen->atlit_id !== $this->atlit->id) {
            $this->selectedDokumen = null;
            session()->flash('error', 'Dokumen tidak dapat dimuat!');
            return;
        }
    }

    // Download document
    public function downloadDokumen($dokumenId)
    {
        $dokumen = DokumenAtlit::find($dokumenId);

        if (!$dokumen || $dokumen->atlit_id !== $this->atlit->id) {
            session()->flash('error', 'Dokumen tidak ditemukan!');
            return;
        }

        // Return download response would be handled differently in Livewire
        session()->flash('info', 'Fitur download akan segera tersedia!');
    }

    public function render()
    {
        $dokumens = $this->atlit->dokumen ?? collect();

        return view('livewire.verifikator.atlit-show', compact('dokumens'));
    }
}
