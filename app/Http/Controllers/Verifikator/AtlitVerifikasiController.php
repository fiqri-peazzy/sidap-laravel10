<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Models\Atlit;
use App\Models\DokumenAtlit;
use App\Models\Cabor;
use App\Models\KategoriAtlit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AtlitVerifikasiController extends Controller
{
    // ============================================
    // SECTION: DASHBOARD & STATISTICS
    // ============================================

    /**
     * Display a listing of athletes for verification
     */
    public function index()
    {
        // Statistik untuk dashboard - STATUS VERIFIKASI ATLET
        $stats = [
            'total' => Atlit::count(),
            'pending' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_PENDING)->count(),
            'verified' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_VERIFIED)->count(),
            'rejected' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_REJECTED)->count(),
        ];

        return view('verifikator.atlit.index', compact('stats'));
    }

    /**
     * Get athlete statistics for dashboard
     */
    public function getStats()
    {
        try {
            $stats = [
                // Statistik STATUS VERIFIKASI ATLET
                'atlet_total' => Atlit::count(),
                'atlet_pending' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_PENDING)->count(),
                'atlet_verified' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_VERIFIED)->count(),
                'atlet_rejected' => Atlit::where('status_verifikasi', Atlit::STATUS_VERIFIKASI_REJECTED)->count(),

                // Statistik STATUS VERIFIKASI DOKUMEN
                'dokumen_pending' => DokumenAtlit::where('status_verifikasi', 'pending')->count(),
                'dokumen_verified' => DokumenAtlit::where('status_verifikasi', 'verified')->count(),
                'dokumen_rejected' => DokumenAtlit::where('status_verifikasi', 'rejected')->count(),

                // Statistik STATUS ATLET (Aktif/Nonaktif/Pensiun)
                'atlet_aktif' => Atlit::where('status', Atlit::STATUS_AKTIF)->count(),
                'atlet_nonaktif' => Atlit::where('status', Atlit::STATUS_NONAKTIF)->count(),
                'atlet_pensiun' => Atlit::where('status', Atlit::STATUS_PENSIUN)->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting stats', [
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil statistik!'
            ], 500);
        }
    }

    /**
     * Get recent verification activities
     */
    public function getRecentActivities(Request $request)
    {
        try {
            $limit = $request->get('limit', 10);
            $activities = collect();

            // Recent athlete verifications
            $recentAtletVerifications = Atlit::whereNotNull('verified_at')
                ->with(['verifikator'])
                ->orderBy('verified_at', 'desc')
                ->limit($limit)
                ->get()
                ->map(function ($atlit) {
                    return [
                        'type' => 'atlet_verification',
                        'action' => $atlit->status_verifikasi, // KOREKSI: gunakan status_verifikasi
                        'subject' => $atlit->nama_lengkap,
                        'verifier' => $atlit->verifikator->name ?? 'Unknown',
                        'timestamp' => $atlit->verified_at,
                        'reason' => $atlit->catatan_verifikasi // KOREKSI: gunakan catatan_verifikasi
                    ];
                });

            // Recent document verifications
            $recentDocumentVerifications = DokumenAtlit::whereNotNull('verified_at')
                ->with(['verifikator', 'atlit'])
                ->orderBy('verified_at', 'desc')
                ->limit($limit)
                ->get()
                ->map(function ($dokumen) {
                    return [
                        'type' => 'document_verification',
                        'action' => $dokumen->status_verifikasi,
                        'subject' => $dokumen->atlit->nama_lengkap . ' - ' . $dokumen->kategori_berkas,
                        'verifier' => $dokumen->verifikator->name ?? 'Unknown',
                        'timestamp' => $dokumen->verified_at,
                        'reason' => $dokumen->alasan_ditolak
                    ];
                });

            // Merge and sort by timestamp
            $activities = $activities
                ->merge($recentAtletVerifications)
                ->merge($recentDocumentVerifications)
                ->sortByDesc('timestamp')
                ->take($limit)
                ->values();

            return response()->json([
                'success' => true,
                'data' => $activities
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting recent activities', [
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil aktivitas terbaru!'
            ], 500);
        }
    }

    // ============================================
    // SECTION: ATHLETE DETAIL
    // ============================================

    /**
     * Display the specified athlete for verification
     */
    public function show(Atlit $atlit)
    {
        // Load relasi yang diperlukan
        $atlit->load([
            'cabangOlahraga',
            'kategoriAtlit',
            'klub',
            'user',
            'verifikator',
            'dokumen' => function ($query) {
                $query->orderBy('kategori_berkas')->orderBy('created_at', 'desc');
            }
        ]);

        // Statistik dokumen
        $documentStats = $atlit->getDocumentStats();

        return view('verifikator.atlit.show', compact('atlit', 'documentStats'));
    }

    // ============================================
    // SECTION: ATHLETE VERIFICATION
    // ============================================

    /**
     * Verify athlete data (Verifikasi DATA ATLET)
     */
    public function verifyAtlit(Request $request, Atlit $atlit)
    {
        // Validasi bahwa atlet masih dalam STATUS VERIFIKASI pending
        if ($atlit->status_verifikasi !== Atlit::STATUS_VERIFIKASI_PENDING) {
            return response()->json([
                'success' => false,
                'message' => 'Data atlet sudah pernah diverifikasi sebelumnya!'
            ], 422);
        }

        DB::beginTransaction();
        try {
            $atlit->update([
                'status_verifikasi' => Atlit::STATUS_VERIFIKASI_VERIFIED, // KOREKSI: gunakan status_verifikasi
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'catatan_verifikasi' => null, // KOREKSI: gunakan catatan_verifikasi
            ]);

            // Log aktivitas verifikasi
            Log::info('Atlet verified', [
                'atlit_id' => $atlit->id,
                'atlit_name' => $atlit->nama_lengkap,
                'verified_by' => Auth::id(),
                'verifier_name' => Auth::user()->name,
                'timestamp' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data atlet berhasil diverifikasi!',
                'data' => [
                    'status_verifikasi' => $atlit->status_verifikasi, // KOREKSI
                    'verified_at' => $atlit->verified_at->format('d/m/Y H:i'),
                    'verifier_name' => Auth::user()->name
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error verifying atlet', [
                'atlit_id' => $atlit->id,
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memverifikasi data atlet!'
            ], 500);
        }
    }

    /**
     * Reject athlete data (Tolak DATA ATLET)
     */
    public function rejectAtlit(Request $request, Atlit $atlit)
    {
        // Validasi input
        $request->validate([
            'alasan' => 'required|string|max:500|min:10'
        ], [
            'alasan.required' => 'Alasan penolakan harus diisi.',
            'alasan.max' => 'Alasan penolakan maksimal 500 karakter.',
            'alasan.min' => 'Alasan penolakan minimal 10 karakter.'
        ]);

        // Validasi bahwa atlet masih dalam STATUS VERIFIKASI pending
        if ($atlit->status_verifikasi !== Atlit::STATUS_VERIFIKASI_PENDING) {
            return response()->json([
                'success' => false,
                'message' => 'Data atlet sudah pernah diverifikasi sebelumnya!'
            ], 422);
        }

        DB::beginTransaction();
        try {
            $atlit->update([
                'status_verifikasi' => Atlit::STATUS_VERIFIKASI_REJECTED, // KOREKSI: gunakan status_verifikasi
                'catatan_verifikasi' => $request->alasan, // KOREKSI: gunakan catatan_verifikasi
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            // Log aktivitas penolakan
            Log::info('Atlet rejected', [
                'atlit_id' => $atlit->id,
                'atlit_name' => $atlit->nama_lengkap,
                'reason' => $request->alasan,
                'rejected_by' => Auth::id(),
                'rejector_name' => Auth::user()->name,
                'timestamp' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data atlet berhasil ditolak!',
                'data' => [
                    'status_verifikasi' => $atlit->status_verifikasi, // KOREKSI
                    'rejected_at' => $atlit->verified_at->format('d/m/Y H:i'),
                    'rejector_name' => Auth::user()->name,
                    'reason' => $request->alasan
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error rejecting atlet', [
                'atlit_id' => $atlit->id,
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menolak data atlet!'
            ], 500);
        }
    }

    /**
     * Bulk verify multiple athletes (Verifikasi MASSAL DATA ATLET)
     */
    public function bulkVerifyAtlet(Request $request)
    {
        $request->validate([
            'atlet_ids' => 'required|array|min:1',
            'atlet_ids.*' => 'required|integer|exists:atlit,id'
        ]);

        DB::beginTransaction();
        try {
            $verifiedCount = 0;
            $errors = [];

            foreach ($request->atlet_ids as $atletId) {
                $atlit = Atlit::find($atletId);

                // KOREKSI: gunakan status_verifikasi
                if ($atlit && $atlit->status_verifikasi === Atlit::STATUS_VERIFIKASI_PENDING) {
                    $atlit->update([
                        'status_verifikasi' => Atlit::STATUS_VERIFIKASI_VERIFIED, // KOREKSI
                        'verified_by' => Auth::id(),
                        'verified_at' => now(),
                        'catatan_verifikasi' => null, // KOREKSI
                    ]);
                    $verifiedCount++;
                } else {
                    $errors[] = "Atlet {$atlit->nama_lengkap} tidak dapat diverifikasi (status verifikasi: {$atlit->status_verifikasi})";
                }
            }

            DB::commit();

            $message = "{$verifiedCount} atlet berhasil diverifikasi.";
            if (!empty($errors)) {
                $message .= " Beberapa atlet dilewati: " . implode(', ', $errors);
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'verified_count' => $verifiedCount,
                    'errors' => $errors
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error in bulk verification', [
                'atlet_ids' => $request->atlet_ids,
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat verifikasi massal!'
            ], 500);
        }
    }

    // ============================================
    // SECTION: DOCUMENT VERIFICATION
    // ============================================

    /**
     * Verify athlete document (Verifikasi DOKUMEN ATLET)
     */
    public function verifyDokumen(Request $request, Atlit $atlit, DokumenAtlit $dokumen)
    {
        // Pastikan dokumen milik atlet yang benar
        if ($dokumen->atlit_id !== $atlit->id) {
            return response()->json([
                'success' => false,
                'message' => 'Dokumen tidak ditemukan atau tidak sesuai dengan atlet!'
            ], 404);
        }

        // Validasi bahwa dokumen masih dalam STATUS VERIFIKASI pending
        if ($dokumen->status_verifikasi !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Dokumen sudah pernah diverifikasi sebelumnya!'
            ], 422);
        }

        DB::beginTransaction();
        try {
            $dokumen->update([
                'status_verifikasi' => 'verified',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'alasan_ditolak' => null, // Reset alasan jika sebelumnya ditolak
                'keterangan' => 'Dokumen telah diverifikasi oleh ' . Auth::user()->name
            ]);

            // Log aktivitas verifikasi dokumen
            Log::info('Document verified', [
                'dokumen_id' => $dokumen->id,
                'atlit_id' => $atlit->id,
                'atlit_name' => $atlit->nama_lengkap,
                'document_category' => $dokumen->kategori_berkas,
                'document_name' => $dokumen->nama_file,
                'verified_by' => Auth::id(),
                'verifier_name' => Auth::user()->name,
                'timestamp' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diverifikasi!',
                'data' => [
                    'status_verifikasi' => $dokumen->status_verifikasi,
                    'verified_at' => $dokumen->verified_at->format('d/m/Y H:i'),
                    'verifier_name' => Auth::user()->name
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error verifying document', [
                'dokumen_id' => $dokumen->id,
                'atlit_id' => $atlit->id,
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memverifikasi dokumen!'
            ], 500);
        }
    }

    /**
     * Reject athlete document (Tolak DOKUMEN ATLET)
     */
    public function rejectDokumen(Request $request, Atlit $atlit, DokumenAtlit $dokumen)
    {
        // Pastikan dokumen milik atlet yang benar
        if ($dokumen->atlit_id !== $atlit->id) {
            return response()->json([
                'success' => false,
                'message' => 'Dokumen tidak ditemukan atau tidak sesuai dengan atlet!'
            ], 404);
        }

        // Validasi input
        $request->validate([
            'alasan' => 'required|string|max:500|min:10'
        ], [
            'alasan.required' => 'Alasan penolakan harus diisi.',
            'alasan.max' => 'Alasan penolakan maksimal 500 karakter.',
            'alasan.min' => 'Alasan penolakan minimal 10 karakter.'
        ]);

        // Validasi bahwa dokumen masih dalam STATUS VERIFIKASI pending
        if ($dokumen->status_verifikasi !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Dokumen sudah pernah diverifikasi sebelumnya!'
            ], 422);
        }

        DB::beginTransaction();
        try {
            $dokumen->update([
                'status_verifikasi' => 'rejected',
                'alasan_ditolak' => $request->alasan,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'keterangan' => 'Dokumen ditolak oleh ' . Auth::user()->name . ': ' . $request->alasan
            ]);

            // Log aktivitas penolakan dokumen
            Log::info('Document rejected', [
                'dokumen_id' => $dokumen->id,
                'atlit_id' => $atlit->id,
                'atlit_name' => $atlit->nama_lengkap,
                'document_category' => $dokumen->kategori_berkas,
                'document_name' => $dokumen->nama_file,
                'reason' => $request->alasan,
                'rejected_by' => Auth::id(),
                'rejector_name' => Auth::user()->name,
                'timestamp' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil ditolak!',
                'data' => [
                    'status_verifikasi' => $dokumen->status_verifikasi,
                    'rejected_at' => $dokumen->verified_at->format('d/m/Y H:i'),
                    'rejector_name' => Auth::user()->name,
                    'reason' => $request->alasan
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error rejecting document', [
                'dokumen_id' => $dokumen->id,
                'atlit_id' => $atlit->id,
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menolak dokumen!'
            ], 500);
        }
    }

    public function statistikVerifikasi()
    {
        return view('verifikator.statistik');
    }
}
