<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Yudisium;
use App\Models\Wisuda;

class MahasiswaYudisiumController extends Controller
{
    /**
     * Menampilkan halaman pendaftaran Yudisium mahasiswa.
     */
    public function index()
    {
        $user = Auth::user();

        $data = Yudisium::firstOrCreate([
            'user_id' => $user->username
        ]);

        return view(
            'mahasiswa.yudisium',
            compact('data')
        );
    }


    /**
     * Menyimpan pendaftaran Yudisium mahasiswa.
     */
    public function store(Request $request, \App\Services\GoogleDriveService $driveService)
    {
        $user = Auth::user();
        $existing = Yudisium::where('user_id', $user->username)->first();

        // Validasi input
        $rules = [
            'link_pembayaran_alumni' => 'required|url',
            'link_bebas_keuangan' => 'required|url',
            'link_pembayaran_yudisium' => 'required|url',
            'link_artikel_loa' => 'required|url',
            'foto_files' => 'nullable|array',
            'foto_files.*' => 'image|mimes:jpeg,png,jpg|max:5120',
            'link_foto' => 'nullable|url',
        ];

        // Jika belum ada foto sama sekali dan tidak ada upload baru
        if (!$request->hasFile('foto_files') && empty($request->link_foto) && empty($existing?->link_foto)) {
            $rules['foto_files'] = 'required|array';
        }

        $request->validate($rules, [
            'foto_files.required' => 'Foto mahasiswa (Pas Foto & Foto Keluarga) wajib diunggah.',
            'foto_files.*.image' => 'File yang diunggah harus berupa gambar.',
            'foto_files.*.mimes' => 'Format foto harus berupa JPG atau PNG.',
            'foto_files.*.max' => 'Ukuran setiap file foto maksimal 5 MB.',
            'link_pembayaran_alumni.required' => 'Link bukti pembayaran alumni wajib diisi.',
            'link_bebas_keuangan.required' => 'Link surat bebas keuangan wajib diisi.',
            'link_pembayaran_yudisium.required' => 'Link bukti pembayaran yudisium wajib diisi.',
            'link_artikel_loa.required' => 'Link artikel / LoA wajib diisi.',
        ]);

        $linkFoto = $existing?->link_foto;

        // Jika mahasiswa mengunggah file foto baru
        if ($request->hasFile('foto_files')) {
            try {
                $files = $request->file('foto_files');
                $linkFoto = $driveService->uploadStudentPhotos($user, $files, $user->angkatan);
            } catch (\Exception $e) {
                return back()
                    ->withInput()
                    ->with('error', 'Gagal mengunggah foto ke Google Drive: ' . $e->getMessage() . '. Pastikan folder Google Drive telah dibagikan ke Service Account.');
            }
        } elseif ($request->filled('link_foto')) {
            $linkFoto = $request->link_foto;
        }

        Yudisium::updateOrCreate(
            [
                'user_id' => $user->username
            ],
            [
                'angkatan' => $user->angkatan,
                'link_foto' => $linkFoto,
                'link_pembayaran_alumni' => $request->link_pembayaran_alumni,
                'link_bebas_keuangan' => $request->link_bebas_keuangan,
                'link_pembayaran_yudisium' => $request->link_pembayaran_yudisium,
                'link_artikel_loa' => $request->link_artikel_loa,
            ]
        );

        return redirect()
            ->route('mahasiswa.yudisium.index')
            ->with(
                'success',
                'Data pendaftaran Yudisium dan Foto berhasil disimpan ke Google Drive Kampus.'
            );
    }


    /**
     * Menampilkan kartu peserta Yudisium & Wisuda.
     *
     * Kartu hanya dapat dibuka apabila seluruh
     * validasi Yudisium sudah disetujui.
     */
    public function kartu()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Ambil data Yudisium mahasiswa
        |--------------------------------------------------------------------------
        */

        $yudisium = Yudisium::where(
            'user_id',
            $user->username
        )->first();


        /*
        |--------------------------------------------------------------------------
        | Cek seluruh validasi Yudisium
        |--------------------------------------------------------------------------
        |
        | 1 = Sudah divalidasi
        | 0 = Belum divalidasi
        | 2 = Ditolak / perlu diperbaiki
        |
        */

        $yudisiumLengkap =
            $yudisium &&
            $yudisium->validasi_foto == 1 &&
            $yudisium->validasi_pembayaran_alumni == 1 &&
            $yudisium->validasi_bebas_keuangan == 1 &&
            $yudisium->validasi_pembayaran_yudisium == 1 &&
            $yudisium->validasi_artikel_loa == 1;


        /*
        |--------------------------------------------------------------------------
        | Jika Yudisium belum lengkap
        |--------------------------------------------------------------------------
        */

        if (!$yudisiumLengkap) {

            return redirect()
                ->route('mahasiswa.yudisium.index')
                ->with(
                    'error',
                    'Kartu peserta belum dapat diakses. Pastikan seluruh dokumen Yudisium sudah divalidasi.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil data Wisuda
        |--------------------------------------------------------------------------
        */

        $wisuda = Wisuda::where(
            'user_id',
            $user->username
        )->first();


        /*
        |--------------------------------------------------------------------------
        | Tampilkan kartu
        |--------------------------------------------------------------------------
        */

        return view(
            'mahasiswa.kartu',
            compact(
                'user',
                'yudisium',
                'wisuda'
            )
        );
    }
/**
 * ============================================================
 * KARTU YUDISIUM
 * ============================================================
 */
public function kartuYudisium()
{
    $user = Auth::user();

    $yudisium = Yudisium::where(
        'user_id',
        $user->username
    )->first();

    /*
    |------------------------------------------------------------
    | Cek seluruh persyaratan Yudisium
    |------------------------------------------------------------
    */

    $yudisiumLengkap =
        $yudisium &&
        $yudisium->validasi_foto == 1 &&
        $yudisium->validasi_pembayaran_alumni == 1 &&
        $yudisium->validasi_bebas_keuangan == 1 &&
        $yudisium->validasi_pembayaran_yudisium == 1 &&
        $yudisium->validasi_artikel_loa == 1;


    if (!$yudisiumLengkap) {

        return redirect()
            ->route('mahasiswa.yudisium.index')
            ->with(
                'error',
                'Kartu Yudisium belum dapat diakses. Pastikan seluruh persyaratan Yudisium sudah divalidasi.'
            );
    }


    return view(
        'mahasiswa.kartu-yudisium',
        compact(
            'user',
            'yudisium'
        )
    );
}

}