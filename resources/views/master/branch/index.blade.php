@extends('layouts.admin.base-dashboard')

@section('title', 'Daftar Cabang')

@section('content')
    @include('layouts.admin.include.message')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0 mx-auto" style="font-weight: 600;">Daftar Cabang</h1>
            <div class="d-flex align-items-center">
                <a href="{{ route('branch.create') }}" class="btn btn-success btn-sm d-flex align-items-center text-white">
                    <i class="la la-plus text-white"></i>
                    Tambah
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="bs4-table" class="table table-striped table-bordered table-hover" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th>Cabang</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($branches as $branch)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $branch->branch }}</td>
                                <td>
                                    <span class="badge badge-{{ $branch->status == 'inactive' ? 'danger' : 'success' }}">
                                        {{ $branch->status == 'inactive' ? 'Tidak Aktif' : 'Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('branch.edit', $branch->id) }}"
                                        class="btn btn-info btn-sm text-white"> <i
                                            class="la la-edit text-white button-font-size"></i>
                                        Ubah
                                    </a>
                                    <form action="{{ route('branch.destroy', $branch->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this item?');"
                                            class="btn btn-danger btn-sm text-white">
                                            <i class="la la-trash text-white button-font-size"></i>Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
