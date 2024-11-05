<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Jurusan;
use App\Exports\ProdiExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProdiController extends Controller
{
    public function index()
    {
        $prodi = Prodi::with('jurusan')->get();
        return view('admin.prodi.index', compact('prodi'));
    }

    public function export()
    {
        return Excel::download(new ProdiExport(), 'prodi.xlsx');
    }

    public function create()
    {
        $jurusan = Jurusan::all();
        return view('admin.prodi.create', compact('jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_prodi' => 'required',
            'prodi' => 'required|unique:prodi,prodi',
            'jenjang' => 'required',
            'jurusan_id' => 'required|exists:jurusan,id_jurusan',
        ]);

        Prodi::create($request->all());

        return redirect()->route('prodi.index')->with('success', 'Prodi created successfully.');
    }

    public function edit($id_prodi)
    {
        $prodi = Prodi::findOrFail($id_prodi);
        $jurusan = Jurusan::all();
        return view('admin.prodi.edit', compact('prodi', 'jurusan'));
    }

    public function update(Request $request, $id_prodi)
    {
        $request->validate([
            'kode_prodi' => 'required',
            'prodi' => 'required',
            'jenjang' => 'required',
            'jurusan_id' => 'required|exists:jurusan,id_jurusan',
        ]);

        $prodi = Prodi::findOrFail($id_prodi);
        $prodi->update($request->all());

        return redirect()->route('prodi.index')->with('success', 'Prodi updated successfully.');
    }

    public function destroy($id_prodi)
    {
        $prodi = Prodi::findOrFail($id_prodi);
        $prodi->delete();

        return redirect()->route('prodi.index')->with('success', 'Prodi deleted successfully.');
    }
}
