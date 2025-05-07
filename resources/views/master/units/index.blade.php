@extends('layouts.admin.base-dashboard')

@section('title', 'Daftar Unit')

@section('content')
    @include('layouts.admin.include.message')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0 mx-auto" style="font-weight: 600;">Daftar Unit</h1>
            <div class="d-flex align-items-center">
                <a href="{{ route('units.create') }}" class="btn btn-success btn-sm d-flex align-items-center"
                    style="color: #fff;">
                    <i class="la la-plus" style="color: #fff;"></i>
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
                            <th>Nama</th>
                            <th>Description</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($units as $unit)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $unit->name }}</td>
                                <td>{{ $unit->description }}</td>
                                <td>
                                    <a href="{{ route('units.edit', $unit->id) }}"
                                        class="btn btn-info btn-sm button-font-size">
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
