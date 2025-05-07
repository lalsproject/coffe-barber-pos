<?php

namespace App\Http\Controllers;

use App\Models\Capster;
use Illuminate\Http\Request;

class CapsterController extends Controller
{
    public function index()
    {
        $capsters = Capster::select('id', 'name', 'phone', 'status')
                        ->orderBy('id', 'desc')
                        ->get();
        
        return view('master.capster.index', compact('capsters'));
    }
    
    public function create()
    {
        return view('master.capster.create');
    }

    public function store(Request $request)
    {
        $validasiData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:14',
            'status' => 'required'
        ]);

        Capster::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);

        return redirect()->route('capsters.index')->with('success', 'Capster created!');
    }

    public function edit($id)
    {
        $capster = Capster::findOrFail($id);

        return view('master.capster.edit', compact('capster'));
    }

    public function update(Request $request, $id)
    {
        $validasiData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:14',
            'status' => 'required'
        ]);

        $capster = Capster::findOrFail($id);
        $capster->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);

        return redirect()->route('capsters.index')->with('success', 'Capster updated!');
    }
}
