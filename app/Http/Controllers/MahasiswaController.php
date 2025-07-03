<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MhsTa;
use App\Models\Prodi;
// use App\Exports\ExportMahasiswa;
use App\Models\Mahasiswa;
use App\Models\MhsSempro;
use Illuminate\Http\Request;
use App\Exports\MahasiswaExport;
use App\Imports\ImportMahasiswa;
use App\Imports\MahasiswaImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::with('prodi')->get();
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function export()
    {
        return Excel::download(new MahasiswaExport(), 'mahasiswa.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new MahasiswaImport, $request->file('file'));

            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa data imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to import data. Error: ' . $e->getMessage());
        }
    }


    public function create()
    {
        $prodi = Prodi::all();
        return view('admin.mahasiswa.create', compact('prodi'));
    }

    public function store(Request $request)
{
    // Validasi input form
    $request->validate([
        'nama' => 'required|string|max:255',
        'nim' => 'required|string|unique:mahasiswa,nim|max:20',
        'gender' => 'required|in:0,1',
        'prodi_id' => 'required|exists:prodi,id_prodi',
        'status_mahasiswa' => 'required|in:0,1',
        'email' => 'required|email|unique:users,email|max:255',
        'password' => 'required|string|min:6',
        // 'role' => 'required|in:admin,dosen,mahasiswa',
    ]);

    // Debug log


    // Buat user baru dengan role yang dipilih
    $user = User::create([
        'name' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'mahasiswa',// Ambil dari input
    ]);

    // Simpan data mahasiswa
    $mahasiswa = new Mahasiswa();
    $mahasiswa->nama = $request->nama;
    $mahasiswa->nim = $request->nim;
    $mahasiswa->gender = $request->gender;
    $mahasiswa->prodi_id = $request->prodi_id;
    $mahasiswa->status_mahasiswa = $request->status_mahasiswa;
    $mahasiswa->user_id = $user->id; // Menyimpan id user yang baru dibuat

    // Simpan data mahasiswa ke database
    $mahasiswa->save();

    return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan beserta akun login.');
}







    public function edit($id_mahasiswa)
    {
        // Retrieve the mahasiswa record by ID with the associated user
        $mahasiswa = Mahasiswa::with(['user'])->findOrFail($id_mahasiswa);

        // Retrieve all prodi for the dropdown
        $prodi = Prodi::all();

        // Return the edit view with mahasiswa and prodi data
        return view('admin.mahasiswa.edit', compact('mahasiswa', 'prodi'));
    }

    public function update(Request $request, $id_mahasiswa)
{
    // Find the mahasiswa record by ID
    $mahasiswa = Mahasiswa::with('user')->findOrFail($id_mahasiswa);

    // Validate incoming request data
    $request->validate([
        'nama' => 'required|string|max:255',
        'nim' => 'required|string|max:255',
        'prodi_id' => 'required|exists:prodi,id_prodi',
        'image' => 'nullable|image|max:2048',
        'gender' => 'required|in:0,1', // Assuming 0 is for female and 1 is for male
        'status_mahasiswa' => 'required|in:0,1', // Assuming 0 for inactive and 1 for active
        'email' => 'required|email|max:255|unique:users,email,' . $mahasiswa->user->id, // Validate email with user ID
        'password' => 'nullable|string|min:6|confirmed', // Ensure password is confirmed
    ]);

    // Handle image upload if a new image is uploaded
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($mahasiswa->image) {
            $oldImagePath = public_path('images/mahasiswa/' . $mahasiswa->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image file
            }
        }

        // Store the new image
        $filename = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images/mahasiswa'), $filename);
        $request->merge(['image' => $filename]);
    }

    // Update the mahasiswa record with the validated data, excluding the image
    $mahasiswa->update($request->except('image')); // Exclude image to avoid overwriting if no new image is uploaded

    // If a new image was uploaded, update the image column
    if ($request->hasFile('image')) {
        $mahasiswa->image = $filename;
        $mahasiswa->save();
    }

    // Update the associated User record
    $user = $mahasiswa->user; // Get the associated user directly
    $user->email = $request->email; // Update email

    // Update password if provided
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password); // Hash the new password
    }

    $user->save(); // Save the updated user record

    // Redirect back to the index route with a success message
    return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil diupdate.');
}






    public function destroy($id_mahasiswa)
{
    $mahasiswa = Mahasiswa::findOrFail($id_mahasiswa);

    // Hapus gambar jika ada
    if ($mahasiswa->image) {
        $imagePath = public_path('images/mahasiswa/' . $mahasiswa->image);
        if (file_exists($imagePath)) {
            unlink($imagePath); // Hapus file gambar
        } else {
            dd('Image file does not exist at: ' . $imagePath);
        }
    }

    // Simpan id user yang akan dihapus
    $userId = $mahasiswa->user_id;

    // Hapus catatan mahasiswa
    $mahasiswa->delete();

    // Hapus catatan user terkait
    User::destroy($userId);

    return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa dan akun login berhasil dihapus.');
}



    public function show($id_mahasiswa)
    {
        $mahasiswa = Mahasiswa::with('prodi')->findOrFail($id_mahasiswa);
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    
}
