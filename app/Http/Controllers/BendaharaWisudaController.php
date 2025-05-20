<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisuda;

class BendaharaWisudaController extends Controller
{
    public function index()
    {
        $wisudaList = Wisuda::with('user')->get();
        return view('bendahara.wisuda', compact('wisudaList'));
    }

    public function validasi($id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->validasi_bendahara = true;
        $wisuda->save();

        return back()->with('success', 'Validasi pembayaran berhasil');
    }
}
