<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('id', 'desc')->get();
        return view('master.brands.index', [
            'brands' => $brands
        ]);
    }

    public function create()
    {
        return view('master.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands',
            'description' => 'required'
        ]);

        Brand::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand success create');
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('master.brands.edit', ['brand' => $brand]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $brand = Brand::find($id);
        $brand->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand success update');
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Brand success delete');
    }
}
