<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Pimpinan;
use Illuminate\Http\Request;
use App\Exports\PimpinanExport;
use App\Models\JabatanPimpinan;
use Maatwebsite\Excel\Facades\Excel;

class PimpinanController extends Controller
{
    public function index()
    {
        $pimpinan = Pimpinan::with(['dosen', 'jabatanPimpinan'])->get();
        return view('admin.pimpinan.index', compact('pimpinan'));
    }

    public function export()
    {
        return Excel::download(new PimpinanExport(), 'pimpinan.xlsx');
    }

    public function create()
    {
        $dosen = Dosen::all();
        $jabatan = JabatanPimpinan::all();
        return view('admin.pimpinan.create', compact('dosen', 'jabatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id_dosen',
            'jabatan_pimpinan_id' => 'required|exists:jabatan_pimpinan,id_jabatan_pimpinan',
            'periode' => 'required',
        ]);

        Pimpinan::create($request->all());

        return redirect()->route('pimpinan.index')->with('success', 'Pimpinan created successfully.');
    }

    public function edit($id_pimpinan)
    {
        $pimpinan = Pimpinan::findOrFail($id_pimpinan);
        $dosen = Dosen::all();
        $jabatan = JabatanPimpinan::all();
        return view('admin.pimpinan.edit', compact('pimpinan', 'dosen', 'jabatan'));
    }

    public function update(Request $request, $id_pimpinan)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id_dosen',
            'jabatan_pimpinan_id' => 'required|exists:jabatan_pimpinan,id_jabatan_pimpinan',
            'periode' => 'required',
        ]);

        $pimpinan = Pimpinan::findOrFail($id_pimpinan);
        $pimpinan->update($request->all());

        return redirect()->route('pimpinan.index')->with('success', 'Pimpinan updated successfully.');
    }

    public function show($id_pimpinan)
    {
        $pimpinan = Pimpinan::findOrFail($id_pimpinan);
        return view('pimpinan.show', compact('pimpinan'));
    }

    public function destroy($id_pimpinan)
    {
        $pimpinan = Pimpinan::findOrFail($id_pimpinan);
        $pimpinan->delete();

        return redirect()->route('pimpinan.index')->with('success', 'Pimpinan deleted successfully.');
    }
}
