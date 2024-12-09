<?php

namespace App\Http\Controllers;

use App\Models\VerPkl;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VerPklController extends Controller
{
    public function index()
    {

        if (Auth::user()->role == 'admin') {

            $ver_pkl = VerPkl::all();
            $dataVerifikasi = false;
        } else {

            $mahasiswa_id = Auth::user()->mahasiswa->id_mahasiswa;
            $ver_pkl = VerPkl::where('mahasiswa_id', $mahasiswa_id)->get();
            $dataVerifikasi = \App\Models\VerPkl::where('mahasiswa_id', $mahasiswa_id)->exists();
        }

        return view('admin.ver_pkl.index', compact('ver_pkl','dataVerifikasi'));
    }


    public function create()
    {

        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan. Silakan hubungi admin.');
        }

        return view('admin.ver_pkl.create', compact('mahasiswa'));
    }

    public function confirm($id)
    {
        \Log::info('Mengubah status verifikasi PKL ID: ' . $id);
        $verPkl = VerPkl::findOrFail($id);
        $verPkl->status = '1';
        $verPkl->save();
        \Log::info('Status baru: ' . $verPkl->status);

        return redirect()->back()->with('success', 'Status verifikasi berhasil diubah.');
    }




    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|integer|exists:mahasiswa,id_mahasiswa',
            'nilai_industri' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
            'laporan_pkl' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
            'status' => 'required|in:0,1',
        ]);

        // Handle file uploads and create VerPkl record
        $data = $this->handleFileUploads($request);
        VerPkl::create($data);

        return redirect()->route('ver_pkl.index')->with('success', 'Data PKL berhasil disimpan.');
    }

    public function edit($id)
    {
        $ver_pkl = VerPkl::findOrFail($id);
        $mahasiswa = Mahasiswa::all(); // Fetch all Mahasiswa records for the edit view
        return view('admin.ver_pkl.edit', compact('ver_pkl', 'mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mahasiswa_id' => 'required|integer|exists:mahasiswa,id_mahasiswa',
            'nilai_industri' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
            'laporan_pkl' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $ver_pkl = VerPkl::findOrFail($id);
        $data = $this->handleFileUploads($request, $ver_pkl);

        $ver_pkl->update($data);

        return redirect()->route('ver_pkl.index')->with('success', 'Data PKL berhasil diupdate.');
    }

    private function handleFileUploads(Request $request, VerPkl $ver_pkl = null)
    {
        $data = $request->only(['mahasiswa_id', 'status']);

        // Get the Mahasiswa name
        $mahasiswa = Mahasiswa::find($request->mahasiswa_id);
        if (!$mahasiswa) {
            // Handle the case if Mahasiswa not found
            throw new \Exception('Mahasiswa not found');
        }

        // Generate a unique name for the file
        $namaMahasiswa = str_replace(' ', '_', $mahasiswa->nama); // Replace spaces with underscores
        $timestamp = time(); // Get current timestamp to ensure uniqueness

        // Handle nilai_industri file upload
        if ($request->hasFile('nilai_industri')) {
            $originalName = $request->file('nilai_industri')->getClientOriginalExtension(); // Get original file extension
            $data['nilai_industri'] = 'nilai_industri_' . $namaMahasiswa . '_' . $timestamp . '.' . $originalName; // New filename
            $request->file('nilai_industri')->storeAs('nilai_industri', $data['nilai_industri'], 'public'); // Store with new name
        } elseif ($ver_pkl && $ver_pkl->nilai_industri) {
            $data['nilai_industri'] = $ver_pkl->nilai_industri; // Keep old file path if no new file uploaded
        }

        // Handle laporan_pkl file upload
        if ($request->hasFile('laporan_pkl')) {
            $originalName = $request->file('laporan_pkl')->getClientOriginalExtension(); // Get original file extension
            $data['laporan_pkl'] = 'laporan_pkl_' . $namaMahasiswa . '_' . $timestamp . '.' . $originalName; // New filename
            $request->file('laporan_pkl')->storeAs('laporan_pkl', $data['laporan_pkl'], 'public'); // Store with new name
        } elseif ($ver_pkl && $ver_pkl->laporan_pkl) {
            $data['laporan_pkl'] = $ver_pkl->laporan_pkl; // Keep old file path if no new file uploaded
        }

        return $data;
    }



    public function destroy($id)
    {
        // Find the VerPkl record or fail
        $ver_pkl = VerPkl::findOrFail($id);

        // Delete files from storage if they exist
        if (!empty($ver_pkl->nilai_industri) && Storage::exists($ver_pkl->nilai_industri)) {
            Storage::delete($ver_pkl->nilai_industri);
        }
        if (!empty($ver_pkl->laporan_pkl) && Storage::exists($ver_pkl->laporan_pkl)) {
            Storage::delete($ver_pkl->laporan_pkl);
        }

        // Delete the VerPkl record
        $ver_pkl->delete();

        return redirect()->route('ver_pkl.index')->with('success', 'Data PKL berhasil dihapus.');
    }
}
