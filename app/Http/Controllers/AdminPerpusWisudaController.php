<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisuda;

class AdminPerpusWisudaController extends Controller
{
    public function index()
    {
        $data = Wisuda::with('user')->get();
        return view('adminperpus.index', compact('data'));
    }

    public function validasiperpus($id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->validasi_perpus = 1 ;
        $wisuda->save();

        return redirect()->route('adminperpus.wisuda.index')->with('success', 'Validasi berhasil');
    }
    public function validasiskripsi($id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->validasi_skripsi = 1 ;
        $wisuda->save();

        return redirect()->route('adminperpus.wisuda.index')->with('success', 'Validasi berhasil');
    }
    public function validasijurnal($id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->validasi_jurnal = 1 ;
        $wisuda->save();

        return redirect()->route('adminperpus.wisuda.index')->with('success', 'Validasi berhasil');
    }
    public function validasirepo($id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->validasi_repo = 1 ;
        $wisuda->save();

        return redirect()->route('adminperpus.wisuda.index')->with('success', 'Validasi berhasil');
    }
}
