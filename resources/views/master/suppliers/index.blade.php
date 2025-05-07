@extends('layouts.admin.base-dashboard')

@section('title', 'Daftar Supplier')

@section('content')
    @include('layouts.admin.include.message')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0 mx-auto" style="font-weight: 600;">Daftar Supplier</h1>
            <div class="d-flex align-items-center">
                <a href="{{ route('suppliers.create') }}"
                    class="btn btn-success btn-sm d-flex align-items-center mr-2 text-white">
                    <i class="la la-plus text-white"></i> Tambah
                </a>
                <a href="{{ route('suppliers.import') }}" class="btn btn-success btn-sm d-flex align-items-center text-white">
                    <i class="zmdi zmdi-upload zmdi-hc-fw text-white"></i> Impor
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-4">
                <table id="bs4-table" class="table table-striped table-bordered table-hover" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th>Nama</th>
                            <th>Alamat Email</th>
                            <th>Nomor Handphone</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->email }}</td>
                                <td>{{ $supplier->phone }}</td>
                                <td>
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                        class="btn btn-info btn-sm button-font-size">
                                        <i class="la la-edit button-font-size"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
