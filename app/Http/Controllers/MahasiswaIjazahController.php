<?php

namespace App\Http\Controllers;

use App\Models\Ijazah;
use Illuminate\Http\Request;

class MahasiswaIjazahController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $ijazah = $user->ijazah;

        return view('mahasiswa.ijazah', compact('user', 'ijazah'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'nim' => 'required|string|max:50',
            'prodi' => 'required|string|max:255',
        ]);

        Ijazah::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'nama' => $validated['nama'],
                'nik' => $validated['nik'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'nim' => $validated['nim'],
                'prodi' => $validated['prodi'],

                // Belum divalidasi setelah data disimpan/diperbaiki
                'validasi_nama' => null,
                'validasi_nik' => null,
                'validasi_tempat_lahir' => null,
                'validasi_tanggal_lahir' => null,
                'validasi_nim' => null,
                'validasi_prodi' => null,
            ]
        );

        return redirect()
            ->route('mahasiswa.ijazah.index')
            ->with('success', 'Data Ijazah berhasil disimpan.');
    }
}