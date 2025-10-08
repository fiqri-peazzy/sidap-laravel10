<?php

namespace App\Livewire\Verifikator;

use App\Models\Atlit;
use App\Models\DokumenAtlit;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AtlitShow extends Component
{
    public $atlit;
    public $documentStats = [];
    public $selectedDokumen = null;

    // Modal states
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

    // ==========================================================
    // LIFECYCLE
    // ==========================================================

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

        $this->documentStats = $this->atlit->getDocumentStats();

        if ($this->selectedDokumen) {
            $this->selectedDokumen = $this->atlit->dokumen->find($this->selectedDokumen->id);
        }
    }

    // ==========================================================
    // MODALS - OPEN
    // ==========================================================

    public function openVerifyAtlitModal()
    {
        if ($this->atlit->status_verifikasi !== Atlit::STATUS_VERIFIKASI_PENDING) {
            session()->flash('warning', 'Data atlet sudah diverifikasi sebelumnya.');
            return;
        }

        $this->modalType = 'atlit';
        $this->modalAction = 'verify';
        $this->showVerifyModal = true;
    }

    public function openRejectAtlitModal()
    {
        if ($this->atlit->status_verifikasi !== Atlit::STATUS_VERIFIKASI_PENDING) {
            session()->flash('warning', 'Data atlet sudah diverifikasi sebelumnya.');
            return;
        }

        $this->modalType = 'atlit';
        $this->modalAction = 'reject';
        $this->alasanPenolakan = '';
        $this->showRejectModal = true;
    }

    public function openVerifyDokumenModal($dokumenId)
    {
        $dokumen = DokumenAtlit::find($dokumenId);

        if (!$dokumen || $dokumen->atlit_id !== $this->atlit->id) {
            session()->flash('error', 'Dokumen tidak ditemukan!');
            return;
        }

        if ($dokumen->status_verifikasi !== 'pending') {
            session()->flash('warning', 'Dokumen sudah diverifikasi sebelumnya.');
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
            session()->flash('warning', 'Dokumen sudah diverifikasi sebelumnya.');
            return;
        }

        $this->currentDokumen = $dokumen;
        $this->modalType = 'dokumen';
        $this->modalAction = 'reject';
        $this->alasanPenolakan = '';
        $this->showDokumenRejectModal = true;
    }

    // ==========================================================
    // CLOSE MODALS - PERBAIKAN: Method ini HARUS ada dan tidak di-comment
    // ==========================================================

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

    // ==========================================================
    // VERIFY / REJECT ATLIT
    // ==========================================================

    public function verifyAtlit()
    {
        if (!$this->atlit || $this->atlit->status_verifikasi !== Atlit::STATUS_VERIFIKASI_PENDING) {
            session()->flash('warning', 'Data atlet sudah diverifikasi sebelumnya.');
            $this->closeModals();
            return;
        }

        DB::beginTransaction();
        try {
            $this->atlit->update([
                'status_verifikasi' => Atlit::STATUS_VERIFIKASI_VERIFIED,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'catatan_verifikasi' => null,
            ]);

            Log::info('Atlit verified successfully', [
                'atlit_id' => $this->atlit->id,
                'verified_by' => Auth::id(),
                'verifier_name' => Auth::user()->name,
            ]);

            DB::commit();

            // PERBAIKAN: Refresh dulu SEBELUM close modal
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
            $this->documentStats = $this->atlit->getDocumentStats();

            // Close modal setelah refresh
            $this->closeModals();

            // Flash message & dispatch browser event untuk animasi
            session()->flash('success', 'Data atlet berhasil diverifikasi!');
            $this->dispatch('atlit-verified');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to verify atlit', [
                'atlit_id' => $this->atlit->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->closeModals();
            session()->flash('error', 'Terjadi kesalahan saat memverifikasi atlet: ' . $e->getMessage());
        }
    }

    public function rejectAtlit()
    {
        $this->validate();

        if (!$this->atlit || $this->atlit->status_verifikasi !== Atlit::STATUS_VERIFIKASI_PENDING) {
            session()->flash('warning', 'Data atlet sudah diverifikasi sebelumnya.');
            $this->closeModals();
            return;
        }

        DB::beginTransaction();
        try {
            $this->atlit->update([
                'status_verifikasi' => Atlit::STATUS_VERIFIKASI_REJECTED,
                'catatan_verifikasi' => $this->alasanPenolakan,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            Log::info('Atlit rejected', [
                'atlit_id' => $this->atlit->id,
                'reason' => $this->alasanPenolakan,
                'rejected_by' => Auth::id(),
                'rejector_name' => Auth::user()->name,
            ]);

            DB::commit();

            // PERBAIKAN: Refresh dulu SEBELUM close modal
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
            $this->documentStats = $this->atlit->getDocumentStats();

            // Close modal setelah refresh
            $this->closeModals();

            // Flash message & dispatch browser event
            session()->flash('success', 'Data atlet berhasil ditolak!');
            $this->dispatch('atlit-rejected');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to reject atlit', [
                'atlit_id' => $this->atlit->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->closeModals();
            session()->flash('error', 'Terjadi kesalahan saat menolak atlet: ' . $e->getMessage());
        }
    }
    // ==========================================================
    // VERIFY / REJECT DOKUMEN
    // ==========================================================

    public function verifyDokumen()
    {
        if (!$this->currentDokumen) {
            session()->flash('error', 'Dokumen tidak ditemukan!');
            return;
        }

        if ($this->currentDokumen->status_verifikasi !== 'pending') {
            session()->flash('warning', 'Dokumen sudah diverifikasi sebelumnya.');
            $this->closeModals();
            return;
        }

        DB::beginTransaction();
        try {
            $this->currentDokumen->update([
                'status_verifikasi' => 'verified',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'alasan_ditolak' => null,
                'keterangan' => 'Diverifikasi oleh ' . Auth::user()->name,
            ]);

            Log::info('Dokumen verified', [
                'dokumen_id' => $this->currentDokumen->id,
                'atlit_id' => $this->atlit->id,
                'verified_by' => Auth::id(),
            ]);

            DB::commit();

            $this->refreshAtletData();
            $this->closeModals();
            session()->flash('success', 'Dokumen berhasil diverifikasi!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error verifying dokumen', [
                'dokumen_id' => $this->currentDokumen->id,
                'error' => $e->getMessage()
            ]);

            session()->flash('error', 'Gagal memverifikasi dokumen: ' . $e->getMessage());
        }
    }

    public function rejectDokumen()
    {
        $this->validate();

        if (!$this->currentDokumen) {
            session()->flash('error', 'Dokumen tidak ditemukan!');
            return;
        }

        if ($this->currentDokumen->status_verifikasi !== 'pending') {
            session()->flash('warning', 'Dokumen sudah diverifikasi sebelumnya.');
            $this->closeModals();
            return;
        }

        DB::beginTransaction();
        try {
            $this->currentDokumen->update([
                'status_verifikasi' => 'rejected',
                'alasan_ditolak' => $this->alasanPenolakan,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'keterangan' => 'Ditolak oleh ' . Auth::user()->name . ': ' . $this->alasanPenolakan,
            ]);

            Log::info('Dokumen rejected', [
                'dokumen_id' => $this->currentDokumen->id,
                'reason' => $this->alasanPenolakan,
                'rejected_by' => Auth::id(),
            ]);

            DB::commit();

            $this->refreshAtletData();
            $this->closeModals();
            session()->flash('success', 'Dokumen berhasil ditolak!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error rejecting dokumen', [
                'dokumen_id' => $this->currentDokumen->id,
                'error' => $e->getMessage()
            ]);

            session()->flash('error', 'Gagal menolak dokumen: ' . $e->getMessage());
        }
    }

    // ==========================================================
    // OTHER HELPERS
    // ==========================================================

    public function selectDokumen($dokumenId)
    {
        $this->selectedDokumen = DokumenAtlit::find($dokumenId);

        if (!$this->selectedDokumen || $this->selectedDokumen->atlit_id !== $this->atlit->id) {
            $this->selectedDokumen = null;
            session()->flash('error', 'Dokumen tidak valid.');
        }
    }

    public function render()
    {
        $dokumens = $this->atlit->dokumen ?? collect();
        return view('livewire.verifikator.atlit-show', compact('dokumens'));
    }
}
