<?php

namespace App\Http\Controllers;

use App\Models\himbauandinas;
use App\Models\qa;
use App\Models\qapertanyaan;
use App\Models\qasebagai;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\statusadmin;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Auth;
class AdministratorController extends Controller
{
    //

    public function index()
    {
        $datauser = user::paginate(15);
        $datastatusadmin = statusadmin::all();

        $user = Auth::user();


        return view('backend.15_administrator.user.index', [
            'title' => 'Daftar User Admin Sipjaki ',
            'datauser' => $datauser,
            'datastatusadmin' => $datastatusadmin,
            'user' => $user,

        ]);
    }


        public function administratorshowbyname($name)
        {
            $datauser = user::where('name', $name)->firstOrFail();


            $user = Auth::user();

            return view('backend.15_administrator.user.show', [
                'data' => $datauser,
                'user' => $user,
                'title' => 'Details Admin Sipjaki',
            ]);

        }


                // -------------------- UPDATE DATA ADMINISTRATOR ----------------------
                public function updateadministrator($name)
                {
                    // Cari data undang-undang berdasarkan nilai 'judul'
                    $user = user::where('name', $name)->firstOrFail();
                    $statusadminList = statusadmin::all();

                    $user = Auth::user();

                    // Tampilkan form update dengan data yang ditemukan
                    return view('backend.15_administrator.user.update', [
                        'datauser' => $user,
                        'datalistadmin' => $statusadminList,
                        'user' => $user,
                        'title' => 'Update Data Administrator'
                    ]);
                }

                // -------------------- UPDATE DATA CREATE UPDATE UNDANG UNDANG JASA KONSTRUKSI ----------------------

                public function createupdateadministrator(Request $request, $name)
                {
                    // Validasi input
                    $request->validate([
                        'name' => 'required|string|max:255',
                        'statusadmin' => 'required|exists:statusadmins,id',
                        'username' => 'required|string|max:255|unique:users,username,' . $name . ',name',
                        'phone_number' => 'required|string|max:15',
                        'email' => 'required|email|max:255|unique:users,email,' . $name . ',name',
                        'password' => 'nullable|string|min:6|confirmed', // Konfirmasi password opsional
                        'avatar' => 'nullable|file|mimes:jpg,jpeg,png|max:20480',
                    ]);

                    // Cari data administrator berdasarkan nama
                    $user = User::where('name', $name)->firstOrFail();

                    // Path folder penyimpanan
                    $storagePath = storage_path('app/public/user/avatar');

                    // Cek dan buat folder jika tidak ada
                    if (!File::exists($storagePath)) {
                        File::makeDirectory($storagePath, 0755, true);
                    }

                    // Simpan file avatar dan ambil path-nya
                    if ($request->hasFile('avatar')) {
                        $file = $request->file('avatar');
                        $filePath = $file->store('user/avatar', 'public');
                    } else {
                        $filePath = $user->avatar; // Default ke avatar yang ada jika tidak ada file baru
                    }

                    // Update data administrator dengan data dari form
                    $user->update([
                        'name' => $request->input('name'),
                        'statusadmin_id' => $request->input('statusadmin'),
                        'username' => $request->input('username'),
                        'phone_number' => $request->input('phone_number'),
                        'email' => $request->input('email'),
                        'password' => $request->input('password') ? bcrypt($request->input('password')) : $user->password,
                        'avatar' => $filePath, // Menggunakan variabel filePath yang benar
                    ]);

                    // Flash pesan session
                    session()->flash('update', 'Data Administrator Berhasil Diupdate!');

                    // Redirect ke halaman yang sesuai
                    return redirect('/administrator');
                }



                    // ==================== DELETE SURAT ADMINISTRATOR

                    public function deleteadministrator($name)
                    {
                        // Cari entri berdasarkan name
                        $entry = user::where('name', $name)->first();

                        if ($entry) {
                            // Hapus file terkait jika ada
                            if ($entry->avatar) {
                                Storage::disk('public')->delete($entry->avatar);
                            }

                            // Hapus entri dari database
                            user::destroy($entry->id);

                            // Set pesan flash untuk sukses
                            session()->flash('delete', 'Data Berhasil Dihapus!');

                            // Redirect ke halaman yang sesuai
                            return redirect('/administrator');
                        } else {
                            // Set pesan flash jika data tidak ditemukan
                            session()->flash('error', 'Data Tidak Ditemukan!');

                            // Redirect ke halaman yang sesuai
                            return redirect('/administrator');
                        }
                    }

// ======================================================================= MENU KATEGORI ADMINISTRATOR ===============    //

public function kategoriadmin()
{

    $datastatusadmin = statusadmin::paginate(15);

    $user = Auth::user();

    return view('backend.15_administrator.kategoriadmin.index', [
        'title' => 'Kategori Admin',
        'datastatusadmin' => $datastatusadmin,
        'user' => $user,

    ]);
}


             // ==================== DELETE AKUN ADMINISTRATOR

             public function deletekategoriadmin($status)
             {
                 // Cari entri berdasarkan status
                 $entry = statusadmin::where('status', $status)->first();

                 if ($entry) {
                     // Hapus entri dari database
                     $entry->delete();

                     // Set pesan flash untuk sukses
                     session()->flash('delete', 'Data Berhasil Dihapus!');
                 } else {
                     // Set pesan flash jika data tidak ditemukan
                     session()->flash('error', 'Data Tidak Ditemukan!');
                 }

                 // Redirect ke halaman yang sesuai
                 return redirect('/kategoriadmin');
             }


// CREATE DATA KATEGORI ADMINSTRATOR
             public function createkategoriadmin()
                {

                    $user = Auth::user();

                    // Tampilkan form update dengan data yang ditemukan
                    return view('backend.15_administrator.kategoriadmin.create', [
                        'title' => 'Create Kategori Admin',
                        'user' => $user,
                    ]);
                }

                public function createstorekategoriadmin(Request $request)
                {
                    // Validasi input
                    $request->validate([
                        'status' => 'required|string|max:255',

                    ]);
                    // Buat entri baru di database
                    statusadmin::create([
                        'status' => $request->input('status'),

                    ]);

                    session()->flash('create', 'Data Berhasil Di Tambahkan !');
                    // Redirect ke halaman yang sesuai
                    return redirect('/kategoriadmin');
                }


                public function qapertanyaan()
                {
                    $dataqa= qa::paginate(15);
                    $dataqasebagaibaru = qasebagai::all();
                    $dataqapertanyaan = qapertanyaan::all();

                    $user = Auth::user();
                    return view('backend.qa.pertanyaan.index', [
                        'title' => 'Daftar Pertanyaan Publik ',
                        'data' => $dataqa,
                        'dataqasebagai' => $dataqasebagaibaru,
                        'dataqapertanyaan' => $dataqapertanyaan,
                        'user' => $user,

                    ]);
                }

}


