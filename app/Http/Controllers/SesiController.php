<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use Illuminate\Http\Request;

class SesiController extends Controller
{
    public function index()
    {
        $sesi = Sesi::all();
        return view('admin.sesi.index', compact('sesi'));
    }

    public function create()
    {
        return view('admin.sesi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sesi' => 'required|unique:sesi',
            'jam' => 'required',
        ]);

        Sesi::create($request->all());

        return redirect()->route('sesi.index')->with('success', 'Sesi created successfully.');
    }

    public function edit($id)
    {
        $sesi = Sesi::findOrFail($id);
        return view('admin.sesi.edit', compact('sesi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sesi' => 'required',
            'jam' => 'required',
        ]);

        $sesi = Sesi::findOrFail($id);
        $sesi->update($request->all());

        return redirect()->route('sesi.index')->with('success', 'Sesi updated successfully.');
    }

    public function destroy($id)
    {
        $sesi = Sesi::findOrFail($id);
        $sesi->delete();

        return redirect()->route('sesi.index')->with('success', 'Sesi deleted successfully.');
    }
}
