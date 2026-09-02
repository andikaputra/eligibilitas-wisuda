<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wisuda;
use App\Models\Yudisium;
use Barryvdh\DomPDF\Facade\Pdf;

class SuperAdminController extends Controller
{
    /**
     * Helper untuk mendapatkan daftar tahun angkatan untuk filter
     */
    protected function getAngkatanList()
    {
        $dbAngkatan = User::whereNotNull('angkatan')
            ->where('angkatan', '!=', '')
            ->distinct()
            ->pluck('angkatan')
            ->toArray();

        $currentYear = (int) date('Y');
        $defaultYears = [];
        for ($y = $currentYear; $y >= $currentYear - 6; $y--) {
            $defaultYears[] = (string) $y;
        }

        $allYears = array_unique(array_merge($defaultYears, $dbAngkatan));
        rsort($allYears);
        return $allYears;
    }

    /**
     * Helper untuk menerapkan filter angkatan pada query Wisuda / Yudisium / User
     */
    protected function applyAngkatanFilter($query, $selectedAngkatan, $directColumn = 'angkatan')
    {
        if (empty($selectedAngkatan)) {
            return $query;
        }

        if ($selectedAngkatan === 'sebelumnya') {
            return $query->where(function ($q) use ($directColumn) {
                if ($directColumn) {
                    $q->whereNull($directColumn)->orWhere($directColumn, '');
                }
                $q->orWhereHas('user', function ($u) {
                    $u->whereNull('angkatan')->orWhere('angkatan', '');
                });
            });
        }

        return $query->where(function ($q) use ($selectedAngkatan, $directColumn) {
            if ($directColumn) {
                $q->where($directColumn, $selectedAngkatan);
            }
            $q->orWhereHas('user', function ($u) use ($selectedAngkatan) {
                $u->where('angkatan', $selectedAngkatan);
            });
        });
    }

    /**
     * ============================================================
     * DASHBOARD WISUDA
     * ============================================================
     */
    public function dashboard(Request $request)
    {
        $selectedAngkatan = $request->get('angkatan');
        $angkatanList = $this->getAngkatanList();

        $query = Wisuda::with('user')
            ->where('validasi_bendahara', 1)
            ->where('validasi_repo', 1)
            ->where('validasi_skripsi', 1)
            ->where('validasi_jurnal', 1)
            ->where('validasi_perpus', 1);

        $query = $this->applyAngkatanFilter($query, $selectedAngkatan, null);
        $wisudas = $query->get();

        return view(
            'superadmin.validasi.index',
            compact('wisudas', 'selectedAngkatan', 'angkatanList')
        );
    }


    /**
     * ============================================================
     * VALIDASI KEUANGAN YUDISIUM
     * ============================================================
     *
     * Menampilkan seluruh data Yudisium mahasiswa.
     */
    public function yudisiumKeuangan(Request $request)
    {
        $selectedAngkatan = $request->get('angkatan');
        $angkatanList = $this->getAngkatanList();

        $query = Yudisium::with('user');
        $query = $this->applyAngkatanFilter($query, $selectedAngkatan, 'angkatan');

        $yudisiums = $query->orderBy('id', 'desc')->get();

        return view(
            'superadmin.yudisium.keuangan',
            compact('yudisiums', 'selectedAngkatan', 'angkatanList')
        );
    }

    /**
     * ============================================================
     * VALIDASI KEUANGAN WISUDA
     * ============================================================
     */
    public function wisudaKeuangan(Request $request)
    {
        $selectedAngkatan = $request->get('angkatan');
        $angkatanList = $this->getAngkatanList();

        $query = Wisuda::with('user');
        $query = $this->applyAngkatanFilter($query, $selectedAngkatan, null);

        $wisudas = $query->orderBy('id', 'desc')->get();

        return view(
            'superadmin.wisuda.keuangan',
            compact('wisudas', 'selectedAngkatan', 'angkatanList')
        );
    }

    /**
 * ============================================================
 * VALIDASI PEMBAYARAN WISUDA
 * ============================================================
 *
 * Status:
 * 1 = Disetujui
 * 2 = Ditolak / Perlu diperbaiki
 */
public function validasiWisudaKeuangan(
    Request $request,
    $id
) {
    $wisuda = Wisuda::findOrFail($id);

    $request->validate([
        'status' => 'required|integer|in:1,2',
    ]);

    $wisuda->validasi_pembayaran_wisuda = $request->status;
    $wisuda->save();

    $message = $request->status == 1
        ? 'Pembayaran Wisuda berhasil disetujui.'
        : 'Pembayaran Wisuda ditolak dan perlu diperbaiki.';

    return redirect()
        ->route('superadmin.wisuda.keuangan')
        ->with('success', $message);
}

/**
 * ============================================================
 * VALIDASI PERPUSTAKAAN WISUDA
 * ============================================================
 */
public function wisudaPerpustakaan(Request $request)
{
    $selectedAngkatan = $request->get('angkatan');
    $angkatanList = $this->getAngkatanList();

    $query = Wisuda::with('user');
    $query = $this->applyAngkatanFilter($query, $selectedAngkatan, null);

    $wisudas = $query->orderBy('id', 'desc')->get();

    return view(
        'superadmin.wisuda.perpustakaan',
        compact('wisudas', 'selectedAngkatan', 'angkatanList')
    );
}

    /**
     * ============================================================
     * VALIDASI DOKUMEN PERPUSTAKAAN WISUDA
     * ============================================================
     *
     * Jenis yang diperbolehkan:
     * - repositori
     * - tracer_study
     * - bebas_perpus
     *
     * Status:
     * 1 = Disetujui
     * 2 = Ditolak / Perlu diperbaiki
     */
    public function validasiWisudaPerpustakaan(
        Request $request,
        $id,
        $jenis
    ) {
        $wisuda = Wisuda::findOrFail($id);

        $fields = [
            'repositori' => 'validasi_repositori',
            'tracer_study' => 'validasi_tracer_study',
            'bebas_perpus' => 'validasi_bebas_perpus_wisuda',
        ];

        if (!array_key_exists($jenis, $fields)) {
            abort(404);
        }

        $request->validate([
            'status' => 'required|integer|in:1,2',
        ]);

        $field = $fields[$jenis];

        $wisuda->{$field} = $request->status;
        $wisuda->save();

        $message = $request->status == 1
            ? 'Dokumen berhasil divalidasi.'
            : 'Dokumen ditolak dan perlu diperbaiki.';

        return redirect()
            ->route('superadmin.wisuda.perpustakaan')
            ->with('success', $message);
    }

    /**
     * ============================================================
     * VALIDASI DOKUMEN KEUANGAN YUDISIUM
     * ============================================================
     *
     * Jenis yang diperbolehkan:
     *
     * - pembayaran_alumni
     * - bebas_keuangan
     * - pembayaran_yudisium
     *
     * Status:
     * 0 = Belum divalidasi
     * 1 = Disetujui
     * 2 = Ditolak / Perlu diperbaiki
     */
    public function validasiYudisiumKeuangan(
        Request $request,
        $id,
        $jenis
    ) {
        $yudisium = Yudisium::findOrFail($id);

        $fields = [
            'pembayaran_alumni' => 'validasi_pembayaran_alumni',
            'bebas_keuangan' => 'validasi_bebas_keuangan',
            'pembayaran_yudisium' => 'validasi_pembayaran_yudisium',
        ];

        if (!array_key_exists($jenis, $fields)) {
            abort(404);
        }

        $request->validate([
            'status' => 'required|integer|in:1,2',
        ]);

        $field = $fields[$jenis];

        $yudisium->{$field} = $request->status;
        $yudisium->save();

        $message = $request->status == 1
            ? 'Dokumen berhasil divalidasi.'
            : 'Dokumen ditolak dan perlu diperbaiki.';

        return redirect()
            ->route('superadmin.yudisium.keuangan')
            ->with('success', $message);
    }



/**
 * ============================================================
 * HALAMAN VALIDASI PERPUSTAKAAN YUDISIUM
 * ============================================================
 */
public function yudisiumPerpustakaan(Request $request)
{
    $selectedAngkatan = $request->get('angkatan');
    $angkatanList = $this->getAngkatanList();

    $query = Yudisium::with('user');
    $query = $this->applyAngkatanFilter($query, $selectedAngkatan, 'angkatan');

    $yudisiums = $query->orderBy('id', 'desc')->get();

    return view(
        'superadmin.yudisium.perpustakaan',
        compact('yudisiums', 'selectedAngkatan', 'angkatanList')
    );
}

/**
 * ============================================================
 * VALIDASI PERPUSTAKAAN YUDISIUM
 * ============================================================
 *
 * target:
 * foto    = validasi foto
 * artikel = validasi artikel / LOA
 *
 * status:
 * 1 = Disetujui
 * 2 = Ditolak / Perlu diperbaiki
 */
public function validasiYudisiumPerpustakaan(
    Request $request,
    $id
) {
    $yudisium = Yudisium::findOrFail($id);

    $request->validate([
        'status' => 'required|integer|in:1,2',
        'target' => 'required|in:foto,artikel',
    ]);

    /*
    |------------------------------------------------------------
    | VALIDASI FOTO
    |------------------------------------------------------------
    */

    if ($request->target === 'foto') {

        $yudisium->validasi_foto = $request->status;
        $yudisium->save();

        $message = $request->status == 1
            ? 'Dokumen foto Yudisium berhasil disetujui.'
            : 'Dokumen foto Yudisium ditolak dan perlu diperbaiki.';
    }


    /*
    |------------------------------------------------------------
    | VALIDASI ARTIKEL / LOA
    |------------------------------------------------------------
    */

    if ($request->target === 'artikel') {

        $yudisium->validasi_artikel_loa = $request->status;
        $yudisium->save();

        $message = $request->status == 1
            ? 'Artikel / LOA berhasil disetujui.'
            : 'Artikel / LOA ditolak dan perlu diperbaiki.';
    }


    return redirect()
        ->route('superadmin.yudisium.perpustakaan')
        ->with('success', $message);
}

/**
 * ============================================================
 * SIAP YUDISIUM
 * ============================================================
 *
 * Menampilkan monitoring seluruh persyaratan Yudisium mahasiswa.
 */
public function siapYudisium(Request $request)
{
    $selectedAngkatan = $request->get('angkatan');
    $angkatanList = $this->getAngkatanList();

    $query = Yudisium::with('user');
    $query = $this->applyAngkatanFilter($query, $selectedAngkatan, 'angkatan');

    $yudisiums = $query->orderBy('id', 'desc')->get();

    return view(
        'superadmin.yudisium.siap',
        compact('yudisiums', 'selectedAngkatan', 'angkatanList')
    );
}

/**
 * ============================================================
 * CETAK SEMUA KARTU YUDISIUM
 * ============================================================
 *
 * Hanya mahasiswa yang seluruh persyaratan
 * Yudisiumnya sudah disetujui.
 */
public function cetakSemuaKartuYudisium(Request $request)
{
    $selectedAngkatan = $request->get('angkatan');
    $angkatanList = $this->getAngkatanList();

    $query = Yudisium::with('user')
        ->where('validasi_foto', 1)
        ->where('validasi_pembayaran_alumni', 1)
        ->where('validasi_bebas_keuangan', 1)
        ->where('validasi_pembayaran_yudisium', 1)
        ->where('validasi_artikel_loa', 1);

    $query = $this->applyAngkatanFilter($query, $selectedAngkatan, 'angkatan');
    $yudisiums = $query->orderBy('no_urut', 'asc')->get();

    return view(
        'superadmin.yudisium.cetak-semua',
        compact('yudisiums', 'selectedAngkatan', 'angkatanList')
    );
}

/**
 * ============================================================
 * NOMOR URUT YUDISIUM
 * ============================================================
 */
public function noUrutYudisium(
    Request $request,
    $id
) {
    $request->validate([
        'no_urut' => 'required|integer|min:1',
    ]);

    $yudisium = Yudisium::findOrFail($id);

    $yudisium->no_urut = $request->no_urut;
    $yudisium->save();

    return redirect()
        ->route('superadmin.yudisium.siap')
        ->with(
            'success',
            'Nomor urut Yudisium berhasil disimpan.'
        );
}

    /**
     * ============================================================
     * SIAP WISUDA
     * ============================================================
     *
     * Menampilkan monitoring seluruh persyaratan Wisuda mahasiswa.
     */
    public function siapWisuda(Request $request)
    {
        $selectedAngkatan = $request->get('angkatan');
        $angkatanList = $this->getAngkatanList();

        $query = Wisuda::with('user');
        $query = $this->applyAngkatanFilter($query, $selectedAngkatan, null);

        $wisudas = $query->orderBy('id', 'desc')->get();

        return view(
            'superadmin.wisuda.siap',
            compact('wisudas', 'selectedAngkatan', 'angkatanList')
        );

    }

/**
 * ============================================================
 * CETAK KARTU WISUDA PER MAHASISWA
 * ============================================================
 */
public function cetakKartuWisuda($id)
{
    $wisuda = Wisuda::with('user')
        ->findOrFail($id);

    return view(
        'superadmin.wisuda.cetak-kartu',
        compact('wisuda')
    );
}


/**
 * ============================================================
 * CETAK SEMUA KARTU WISUDA
 * ============================================================
 */
public function cetakSemuaKartuWisuda()
{
    $wisudas = Wisuda::with('user')
        ->whereNotNull('no_urut')
        ->where('validasi_bendahara', 1)
        ->where('validasi_repositori', 1)
        ->where('validasi_tracer_study', 1)
        ->where('validasi_pembayaran_wisuda', 1)
        ->where('validasi_bebas_perpus_wisuda', 1)
        ->orderBy('no_urut', 'asc')
        ->get();

    return view(
        'superadmin.wisuda.cetak-semua',
        compact('wisudas')
    );
}

    /**
     * ============================================================
     * NOMOR URUT WISUDA
     * ============================================================
     */
    public function noUrutWisuda(
        Request $request,
        $id
    ) {
        $request->validate([
            'no_urut' => 'required|integer|min:1',
        ]);

        $wisuda = Wisuda::findOrFail($id);

        $wisuda->no_urut = $request->no_urut;
        $wisuda->save();

        return redirect()
            ->route('superadmin.wisuda.siap')
            ->with(
                'success',
                'Nomor urut Wisuda berhasil disimpan.'
            );
    }

    /**
     * ============================================================
     * MANAJEMEN USER
     * ============================================================
     */
    public function index(Request $request)
    {
        $selectedAngkatan = $request->get('angkatan');
        $angkatanList = $this->getAngkatanList();

        $query = User::orderBy('created_at', 'desc');
        if (!empty($selectedAngkatan)) {
            if ($selectedAngkatan === 'sebelumnya') {
                $query->where(function($q) {
                    $q->whereNull('angkatan')->orWhere('angkatan', '');
                });
            } else {
                $query->where('angkatan', $selectedAngkatan);
            }
        }

        $users = $query->get();

        return view(
            'superadmin.users.index',
            compact('users', 'selectedAngkatan', 'angkatanList')
        );
    }


    public function create()
    {
        $prodiList = [
            'Pendidikan Bahasa dan Sastra Indonesia',
            'Pendidikan Guru Sekolah Dasar',
            'Pendidikan Pendidikan Bahasa Inggris',
            'Sistem Informasi',
            'Manajemen Ekonomi',
            'Pariwisata Budaya dan Keagamaan',
            'Hukum Adat',
        ];

        $roles = [
            'mahasiswa' => 'Mahasiswa',
            'admin_perpus' => 'Admin Perpustakaan',
            'bendahara' => 'Bendahara',
            'superadmin' => 'Superadmin',
        ];

        return view(
            'superadmin.users.create',
            compact('roles', 'prodiList')
        );
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'prodi' => 'required|string',
            'angkatan' => 'nullable|string|max:20',
            'wa' => 'required|string',
        ]);

        $angkatan = $request->angkatan;
        if (empty($angkatan) && preg_match('/^20([0-9]{2})/', $request->username, $matches)) {
            $angkatan = '20' . $matches[1];
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'prodi' => $request->prodi,
            'angkatan' => $angkatan,
            'wa' => '62' . ltrim($request->wa, '0'),
            'role' => 'mahasiswa',
            'password' => bcrypt($request->username),
        ]);

        Wisuda::create([
            'user_id' => $request->username,
            'validasi_bendahara' => '1',
        ]);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User berhasil dibuat'
            );
    }


    public function edit(User $user)
    {
        return view(
            'users.edit',
            compact('user')
        );
    }


    public function update(
        Request $request,
        User $user
    ) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User berhasil diperbarui'
            );
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User berhasil dihapus'
            );
    }

    /**
     * ============================================================
     * RESET PASSWORD USER
     * ============================================================
     *
     * Password akan dikembalikan ke NIM.
     */
    public function resetPassword(User $user)
    {
        $user->password = bcrypt($user->username);
        $user->save();

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Password user berhasil direset. Password kembali ke NIM.'
            );
    }


    /**
     * ============================================================
     * NOMOR URUT PESERTA WISUDA
     * ============================================================
     */
    public function noUrut(
        Request $request,
        $id
    ) {
        $request->validate([
            'no_urut' => 'required|integer|min:1',
        ]);

        $wisuda = Wisuda::findOrFail($id);

        $wisuda->no_urut = $request->no_urut;
        $wisuda->save();

        return redirect()
            ->route('superadmin.validasi.index')
            ->with(
                'success',
                'Nomor urut peserta berhasil disimpan.'
            );
    }

    /**
     * ============================================================
     * CETAK KARTU YUDISIUM - SATU MAHASISWA
     * ============================================================
     */
    public function cetakKartuYudisium($id)
    {
        $yudisium = Yudisium::with('user')->findOrFail($id);

        /*
        |------------------------------------------------------------
        | Pastikan seluruh persyaratan sudah disetujui
        |------------------------------------------------------------
        */

        $siapYudisium =
            $yudisium->validasi_foto == 1 &&
            $yudisium->validasi_pembayaran_alumni == 1 &&
            $yudisium->validasi_bebas_keuangan == 1 &&
            $yudisium->validasi_pembayaran_yudisium == 1 &&
            $yudisium->validasi_artikel_loa == 1;

        if (!$siapYudisium) {
            return back()->with(
                'error',
                'Mahasiswa belum memenuhi seluruh persyaratan Yudisium.'
            );
        }

        return view(
            'mahasiswa.kartu-yudisium',
            [
                'user' => $yudisium->user,
                'yudisium' => $yudisium,
            ]
        );
    }

    /**
     * ============================================================
     * EXPORT DAFTAR WISUDA KE PDF
     * ============================================================
     */
    public function exportPdf()
    {
        $data = Wisuda::with('user')->get();

        $pdf = Pdf::loadView(
            'wisuda.export-pdf',
            compact('data')
        )->setPaper(
            'a4',
            'landscape'
        );

        return $pdf->download(
            'daftar-wisuda.pdf'
        );
    }
}