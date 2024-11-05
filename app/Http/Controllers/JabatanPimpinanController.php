<?php

namespace App\Http\Controllers;

use App\Models\JabatanPimpinan;
use Illuminate\Http\Request;

class JabatanPimpinanController extends Controller
{
    public function index()
    {
        $jabatanPimpinan = JabatanPimpinan::all();
        return view('admin.jabatan_pimpinan.index', compact('jabatanPimpinan'));
    }

    public function create()
    {
        return view('admin.jabatan_pimpinan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jabatan_pimpinan' => 'required',
            'kode_jabatan_pimpinan' => 'required',
            'status_jabatan_pimpinan' => 'required|in:0,1',
        ]);

        JabatanPimpinan::create($request->all());

        return redirect()->route('jabatan_pimpinan.index')->with('success', 'Jabatan Pimpinan created successfully.');
    }

    public function edit($id)
    {
        $jabatanPimpinan = JabatanPimpinan::findOrFail($id);
        return view('admin.jabatan_pimpinan.edit', compact('jabatanPimpinan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jabatan_pimpinan' => 'required',
            'kode_jabatan_pimpinan' => 'required',
            'status_jabatan_pimpinan' => 'required|in:0,1',
        ]);

        $jabatanPimpinan = JabatanPimpinan::findOrFail($id);
        $jabatanPimpinan->update($request->all());

        return redirect()->route('jabatan_pimpinan.index')->with('success', 'Jabatan Pimpinan updated successfully.');
    }

    public function destroy($id)
    {
        $jabatanPimpinan = JabatanPimpinan::findOrFail($id);
        $jabatanPimpinan->delete();

        return redirect()->route('jabatan_pimpinan.index')->with('success', 'Jabatan Pimpinan deleted successfully.');
    }
}
