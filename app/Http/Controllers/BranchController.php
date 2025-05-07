<?php

namespace App\Http\Controllers;


use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::orderBy('created_at','desc')->get();

        return view('master.branch.index',compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.branch.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch' => 'required',
            'status' => 'required'
        ]);

        Branch::create([
              'branch' => $request->branch,
              'status' => $request->status
        ]);

        return redirect()->route('branch.index')->with('success','Berhasil Menambahkan Cabang');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch = Branch::find($id);

        return view('master.branch.edit',compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'branch' => 'required',
            'status' => 'required'
        ]);

        $branch = Branch::find($id);

        $branch->update([
            'branch' => $request->branch,
            'status' => $request->status
        ]);

        return redirect()->route('branch.index')->with('success','Sukses ubah cabang');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::find($id);

        $branch->delete();

        return redirect()->route('branch.index')->with('success','Sukses hapus cabang');
    }
}
