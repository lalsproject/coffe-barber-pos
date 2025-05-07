@extends('layouts.admin.base-dashboard')

@section('title', 'Daftar Layanan')

@section('content')
    @include('layouts.admin.include.message')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0 mx-auto" style="font-weight: 600;">Daftar Layanan</h1>
            <div class="d-flex align-items-center">
                <a href="{{ route('services.create') }}" class="btn btn-success btn-sm d-flex align-items-center text-white">
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
                            <th>Service Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->description }}</td>
                                <td>{{ 'Rp ' . number_format($service['price'], 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge badge-{{ $service->status == 'inactive' ? 'danger' : 'success' }}">
                                        {{ $service->status == 'inactive' ? 'Inactive' : 'Active' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('services.edit', $service->id) }}"
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
