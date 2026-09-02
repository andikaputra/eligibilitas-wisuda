<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wisuda;

class MahasiswaWisudaController extends Controller
{
    /**
     * Menampilkan form pendaftaran Wisuda.
     */
    public function index()
    {
        $user = Auth::user();

        $data = Wisuda::firstOrCreate([
            'user_id' => $user->username
        ]);

        return view('mahasiswa.wisuda', compact('data'));
    }

    /**
     * Menyimpan data pendaftaran Wisuda.
     */
    public function store(Request $request)
    {
                    $request->validate([
                'link_repositori' => 'required|url',
                'link_tracer_study' => 'required|url',
                'link_pembayaran_wisuda' => 'required|url',
                'link_bukti_perpus' => 'required|url',
                
            ]);

        $user = Auth::user();

        Wisuda::updateOrCreate(
            [
                'user_id' => $user->username
            ],
            [
                'link_repositori' => $request->link_repositori,
                'link_tracer_study' => $request->link_tracer_study,
                'link_pembayaran_wisuda' => $request->link_pembayaran_wisuda,
                'link_bukti_perpus' => $request->link_bukti_perpus,
               
            ]
        );

        return redirect()
            ->route('mahasiswa.wisuda.index')
            ->with('success', 'Data Wisuda berhasil disimpan.');
    }
}