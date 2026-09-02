<?php

namespace App\Http\Controllers;

use App\Models\Ijazah;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SuperAdminIjazahController extends Controller
{
    /**
     * Menampilkan data Ijazah mahasiswa untuk divalidasi Superadmin.
     */
    public function index()
    {
        $this->ensureSuperadmin();

        $ijazahs = Ijazah::with('user')
            ->latest()
            ->get();

        return view('superadmin.ijazah', compact('ijazahs'));
    }

    /**
     * Menetapkan status validasi untuk satu data atau seluruh data Ijazah mahasiswa.
     */
    public function validasi(Request $request, Ijazah $ijazah)
    {
        $this->ensureSuperadmin();

        $validated = $request->validate([
            'field' => 'nullable|in:nama,nik,tempat_lahir,tanggal_lahir,nim,prodi',
            'status' => 'required|integer|in:1,2',
        ]);

        $fieldLabels = [
            'nama' => 'Nama Lengkap',
            'nik' => 'NIK',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'nim' => 'NIM',
            'prodi' => 'Program Studi',
        ];

        $field = $validated['field'] ?? null;

        $fields = $field
            ? [$field]
            : array_keys($fieldLabels);

        foreach ($fields as $field) {
            $column = 'validasi_' . $field;
            $ijazah->{$column} = $validated['status'];
        }

        $ijazah->save();

        $target = $field
            ? 'Data ' . $fieldLabels[$field]
            : 'Seluruh data Ijazah mahasiswa';

        $message = $validated['status'] === 1
            ? $target . ' berhasil divalidasi.'
            : $target . ' ditandai perlu diperbaiki.';

        return redirect()
            ->route('superadmin.ijazah.index')
            ->with('success', $message);
    }

    /**
     * Mengunduh daftar data Ijazah dalam format PDF.
     */
    public function exportPdf()
    {
        $this->ensureSuperadmin();

        $ijazahs = Ijazah::with('user')
            ->orderBy('id')
            ->get();

        $pdf = Pdf::loadView(
            'superadmin.ijazah-export-pdf',
            compact('ijazahs')
        )->setPaper('a4', 'landscape');

        return $pdf->download('daftar-data-ijazah.pdf');
    }

    private function ensureSuperadmin(): void
    {
        abort_unless(auth()->user()?->role === 'superadmin', 403);
    }
}
