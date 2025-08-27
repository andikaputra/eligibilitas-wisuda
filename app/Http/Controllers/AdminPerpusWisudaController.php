<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisuda;

class AdminPerpusWisudaController extends Controller
{
    public function index()
    {
        $data = Wisuda::with('user')
            ->where('validasi_bendahara', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('adminperpus.index', compact('data'));
    }

    public function validasiperpus($id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->validasi_perpus = 1 ;
        $wisuda->save();

        return redirect()->route('adminperpus.wisuda.index')->with('success', 'Validasi berhasil');
    }

    public function rejectperpus($id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->validasi_perpus = 2; // This represents rejection (not approved)
        $wisuda->save();

        return redirect()->route('adminperpus.wisuda.index')->with('success', 'ditolak');
    }

    public function validasiskripsi($id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->validasi_skripsi = 1 ;
        $wisuda->save();

        return redirect()->route('adminperpus.wisuda.index')->with('success', 'Validasi berhasil');
    }

    public function rejectskripsi($id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->validasi_skripsi = 2; // This represents rejection (not approved)
        $wisuda->save();

        return redirect()->route('adminperpus.wisuda.index')->with('success', 'Skripsi ditolak');
    }

    public function validasijurnal($id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->validasi_jurnal = 1 ;
        $wisuda->save();

        return redirect()->route('adminperpus.wisuda.index')->with('success', 'Validasi berhasil');
    }

    public function rejectjurnal($id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->validasi_jurnal = 2 ;
        $wisuda->save();

        return redirect()->route('adminperpus.wisuda.index')->with('success', 'ditolak');
    }

    public function validasirepo($id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->validasi_repo = 1 ;
        $wisuda->save();

        return redirect()->route('adminperpus.wisuda.index')->with('success', 'Validasi berhasil');
    }
    public function rejectrepo($id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->validasi_repo = 2 ;
        $wisuda->save();

        return redirect()->route('adminperpus.wisuda.index')->with('success', 'ditolak');
    }
}
