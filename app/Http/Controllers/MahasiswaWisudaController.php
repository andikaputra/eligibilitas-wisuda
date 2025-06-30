<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wisuda;

class MahasiswaWisudaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = Wisuda::where('user_id', $user->username)->first();

        return view('mahasiswa.wisuda', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'link_bukti_pembayaran' => 'required|url',
            'link_repositori' => 'required|url',
            'link_publish_jurnal' => 'required|url',
            'link_bukti_skripsi' => 'required|url',
            'link_bukti_perpus' => 'required|url',
        ]);

        $user = Auth::user();
        Wisuda::updateOrCreate(
            ['user_id' => $user->username],
            $request->only([
                'link_bukti_pembayaran',
                'link_repositori',
                'link_publish_jurnal',
                'link_bukti_skripsi',
                'link_bukti_perpus',
            ])
        );


        return redirect()->route('mahasiswa.wisuda.index')->with('success', 'Data berhasil disimpan.');
    }
}
