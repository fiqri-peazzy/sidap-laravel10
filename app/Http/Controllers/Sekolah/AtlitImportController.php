<?php

namespace App\Http\Controllers\Sekolah;

use App\Exports\AtlitImportTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\AtlitImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AtlitImportController extends Controller
{
    public function create()
    {
        return view('sekolah.atlit.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:5120',
        ], [
            'file.required' => 'Silakan pilih file Excel terlebih dahulu.',
            'file.mimes' => 'File harus berformat .xlsx atau .xls.',
            'file.max' => 'Ukuran file maksimal 5MB.',
        ]);

        $import = new AtlitImport(Auth::user()->sekolah_id);
        Excel::import($import, $request->file('file'));

        return view('sekolah.atlit.import-result', [
            'importedCount' => $import->getImportedCount(),
            'errors' => $import->getErrors(),
        ]);
    }

    public function downloadTemplate()
    {
        return Excel::download(new AtlitImportTemplateExport(), 'template-import-atlet.xlsx');
    }
}
