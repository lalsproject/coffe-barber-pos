@extends('layouts.admin.base-dashboard')

@section('title', 'Daftar Capster')

@section('content')
    @include('layouts.admin.include.message')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0 mx-auto" style="font-weight: 600;">Daftar Capster</h1>
            <div class="d-flex align-items-center">
                <a href="{{ route('capsters.create') }}" class="btn btn-success btn-sm d-flex align-items-center text-white">
                    <i class="la la-plus text-white"></i>
                    Tambah
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-4">
                <table id="bs4-table" class="table table-striped table-bordered table-hover" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th>Nama Lengkap</th>
                            <th>Nomor Handphone</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($capsters as $capster)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $capster->name }}</td>
                                <td>{{ $capster->phone }}</td>
                                <td>
                                    <span class="badge badge-{{ $capster->status == 'inactive' ? 'danger' : 'success' }}">
                                        {{ $capster->status == 'inactive' ? 'Inactive' : 'Active' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('capsters.edit', $capster->id) }}"
                                        class="btn btn-info btn-sm text-white">
                                        <i class="la la-edit text-white button-font-size"></i>
                                        Edit
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
