<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\MhsTa;
use App\Models\Prodi;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\MhsSempro;
use App\Exports\DosenExport;
use App\Imports\DosenImport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    public function index()
    {
        // Mengambil data dosen beserta jurusan dan prodi
        $dosen = Dosen::with(['jurusan', 'prodi'])->get();
        return view('admin.dosen.index', compact('dosen'));
    }


    


    public function export()
    {
        return Excel::download(new DosenExport(), 'dosen.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new DosenImport, $request->file('file'));

            return redirect()->route('dosen.index')->with('success', 'Dosen data imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to import data. Error: ' . $e->getMessage());
        }
    }

    public function create()
    {
        // Mengambil data jurusan dan prodi untuk dropdown
        $jurusan = Jurusan::all();
        $prodi = Prodi::all();
        return view('admin.dosen.create', compact('jurusan', 'prodi'));
    }

    public function show($id_dosen)
    {
        // Menampilkan detail dosen
        $dosen = Dosen::findOrFail($id_dosen);
        $dosen = Dosen::with('user')->findOrFail($id_dosen);
        return view('admin.dosen.show', compact('dosen'));
    }

    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'nidn' => 'required|unique:dosen,nidn|max:20',
            'gender' => 'required|in:0,1', // Misalnya 0 untuk perempuan dan 1 untuk laki-laki
            'jurusan_id' => 'required|exists:jurusan,id_jurusan', // Pastikan jurusan_id valid
            'prodi_id' => 'required|exists:prodi,id_prodi', // Pastikan prodi_id valid
            'golongan' => 'required|in:1,2,3,4',
            'status_dosen' => 'required|in:0,1', // Pastikan status sesuai
            'email' => 'required|email|unique:users,email|max:255', // Validasi email agar unik
            'password' => 'required|string|min:6', // Validasi password minimal 6 karakter
            'image' => 'nullable|image|max:2048',
        ]);

        // Buat user baru dengan role dosen
        $user = User::create([
            'name' => $request->nama_dosen,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dosen', // Tetapkan role sebagai 'dosen'
        ]);

        // Simpan data dosen
        $dosen = new Dosen;
        $dosen->nama_dosen = $request->nama_dosen;
        $dosen->nidn = $request->nidn;
        $dosen->gender = $request->gender;
        $dosen->jurusan_id = $request->jurusan_id;
        $dosen->prodi_id = $request->prodi_id;
        $dosen->golongan = $request->golongan;
        $dosen->status_dosen = $request->status_dosen;
        $dosen->user_id = $user->id; // Menyimpan id user yang baru dibuat

        // Upload image jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/dosen'), $imageName);
            $dosen->image = $imageName;
        }

        $dosen->save();

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil ditambahkan beserta akun login.');
    }




    public function edit($id)
    {
        $dosen = Dosen::with(['user'])->findOrFail($id); // Load associated user
        $jurusan = Jurusan::all(); // Get all jurusan
        $prodi = Prodi::all(); // Get all prodi

        return view('admin.dosen.edit', compact('dosen', 'jurusan', 'prodi'));
    }

    public function update(Request $request, $id)
    {
        $dosen = Dosen::with('user')->findOrFail($id); // Load associated user
        $user = $dosen->user; // Get the associated user

        // Validate the incoming request data
        $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'nidn' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, // Ignore current user's email
            'password' => 'nullable|string|min:8',
            'gender' => 'required|in:0,1',
            'jurusan_id' => 'required|exists:jurusan,id_jurusan',
            'prodi_id' => 'required|exists:prodi,id_prodi',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status_dosen' => 'required|in:0,1',
            'golongan' => 'required|in:1,2,3,4',
        ]);

        // Update the user details
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save(); // Save user

        // Update the dosen details
        $dosen->nama_dosen = $request->nama_dosen;
        $dosen->nidn = $request->nidn;
        $dosen->gender = $request->gender;
        $dosen->jurusan_id = $request->jurusan_id;
        $dosen->prodi_id = $request->prodi_id;
        $dosen->status_dosen = $request->status_dosen;
        $dosen->golongan = $request->golongan; // Update golongan

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($dosen->image && file_exists(public_path('images/dosen/' . $dosen->image))) {
                unlink(public_path('images/dosen/' . $dosen->image));
            }

            // Upload new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/dosen'), $imageName);
            $dosen->image = $imageName; // Update image path
        }

        $dosen->save(); // Save dosen

        return redirect()->route('dosen.index')->with('success', 'Data Dosen berhasil diperbarui.');
    }


    public function destroy($id_dosen)
    {
        // Ambil data dosen berdasarkan id
        $dosen = Dosen::findOrFail($id_dosen);

        // Cek apakah user yang sedang login adalah user yang terkait dengan dosen yang akan dihapus
        if (Auth::user()->id === $dosen->user_id) {
            return redirect()->route('dosen.index')->with('error', 'Anda tidak dapat menghapus akun yang sedang Anda gunakan.');
        }

        // Menghapus gambar jika ada
        if ($dosen->image) {
            unlink(public_path('images/dosen/' . $dosen->image));
        }

        // Menghapus data dosen
        $dosen->delete();

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil dihapus.');
    }
}
