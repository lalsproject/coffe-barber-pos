<?php

namespace App\Http\Controllers;

use App\Imports\CustomerImport;
use App\Models\City;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Province;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->get();
        return view('master.customers.index', ['customers' => $customers]);
    }

    public function create()
    {
        return view('master.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer success create');
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('master.customers.edit', [
            'customer' => $customer
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        $customer = Customer::find($id);
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer success update');
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer success delete');
    }

    public function import()
    {
        return view('master.customers.import');
    }

    public function importProcess(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(new CustomerImport, request()->file('file'));

            return redirect()->back()->with('success', 'Data customers has been import successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Import data failed or duplicate!');
        }
    }
}
