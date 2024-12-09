<?php

namespace App\Http\Controllers;

use App\Models\TempatPKL;
use Illuminate\Http\Request;

class TempatPKLController extends Controller
{
    public function index()
    {
        $tempatPKL = TempatPKL::all();
        return view('admin.tempat_pkl.index', compact('tempatPKL'));
    }

    public function create()
    {
        return view('admin.tempat_pkl.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kuota' => 'required|integer|min:1',
            'status' => 'required|in:0,1',
        ]);

        TempatPKL::create($request->all());

        return redirect()->route('tempat_pkl.index')->with('success', 'Data tempat PKL berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tempatPkl = TempatPkl::findOrFail($id); // Sesuaikan nama variabel
        return view('admin.tempat_pkl.edit', compact('tempatPkl'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kuota' => 'required|integer|min:1',
            'status' => 'required|in:0,1',
        ]);

        $tempatPkl = TempatPkl::findOrFail($id);
        $tempatPkl->update($request->all());

        return redirect()->route('tempat_pkl.index')->with('success', 'Data tempat PKL berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $tempatPKL = TempatPkl::findOrFail($id);
        $tempatPKL->delete();

        return redirect()->route('tempat_pkl.index')->with('success', 'Data tempat PKL berhasil dihapus.');
    }
}
