<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::orderBy('id', 'desc')->get();
        return view('master.units.index', ['units' => $units]);
    }

    public function create()
    {
        return view('master.units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        Unit::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('units.index')->with('success', 'Unit success create');
    }

    public function edit($id)
    {
        $unit = Unit::find($id);
        return view('master.units.edit', ['unit' => $unit]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $unit = Unit::find($id);
        $unit->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('units.index')->with('success', 'Unit success update');
    }

    public function destroy($id)
    {
        $unit = Unit::find($id);
        $unit->delete();
        return redirect()->route('units.index')->with('success', 'Unit success delete');
    }
}
