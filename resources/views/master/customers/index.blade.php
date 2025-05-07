@extends('layouts.admin.base-dashboard')

@section('title', 'Daftar Pelanggan')

@section('content')
    @include('layouts.admin.include.message')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0 mx-auto" style="font-weight: 600;">Daftar Pelanggan</h1>
            <div class="d-flex align-items-center">
                <a href="{{ route('customers.create') }}"
                    class="btn btn-success btn-sm d-flex align-items-center mr-2 text-white">
                    <i class="la la-plus text-white"></i>
                    Tambah
                </a>
                <a href="{{ route('customers.import') }}" class="btn btn-success btn-sm d-flex align-items-center text-white">
                    <i class="zmdi zmdi-upload zmdi-hc-fw text-white"></i>
                    Impor
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
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>
                                    <a href="{{ route('customers.edit', $customer->id) }}"
                                        class="btn btn-info btn-sm text-white">
                                        <i class="la la-edit text-white" style="font-size: 1.5em;"></i> Edit
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
