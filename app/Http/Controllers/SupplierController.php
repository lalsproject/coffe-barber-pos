<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\SupplierImport;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Province;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::get();
        return view('master.suppliers.index', ['suppliers' => $suppliers]);
    }

    public function create()
    {
       
        return view('master.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'contact_person' => 'required',
            'bank_info' => 'required'
        ]);

        Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'contact_person' => $request->contact_person,
            'bank_info' => $request->bank_info,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier success update');
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return view('master.suppliers.edit', [
            'supplier' => $supplier
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'contact_person' => 'required',
            'bank_info' => 'required'
        ]);

        $supplier = Supplier::find($id);
        $supplier->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'contact_person' => $request->contact_person,
            'bank_info' => $request->bank_info
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier success update');
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier success delete');
    }

    public function import()
    {
        return view('master.suppliers.import');
    }

    public function importProcess(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(new SupplierImport, request()->file('file'));

            return redirect()->back()->with('success', 'Data suppliers has been import successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Import data failed or duplicate!');
        }
    }
}
