<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::select('id', 'name', 'description', 'price', 'status')
                            ->orderBy('id', 'desc')
                            ->get();

        return view('master.services.index', compact('services'));
    }

    public function create()
    {
        return view('master.services.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'status' => 'required|string'
        ]);

        Service::create([
            'name' => $request->name,
            'description' => $request->description, 
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return redirect()->route('services.index')->with('success', 'Service created!');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);

        return view('master.services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'status' => 'required|string'
        ]);

        $service = Service::findOrFail($id);
        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return redirect()->route('services.index')->with('success', 'Service updated!');
    }
}