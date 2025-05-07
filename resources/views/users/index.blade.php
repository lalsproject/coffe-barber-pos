@extends('layouts.admin.base-dashboard')

@section('title', 'Daftar User')

@section('content')
    @include('layouts.admin.include.message')

    <div class="card shadow-sm border-light">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0 mx-auto" style="font-weight: 600;">Daftar User</h1>
            <a href="{{ route('users.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                <i class="la la-plus text-white"></i> Tambah
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-4">
                <table id="bs4-table" class="table table-striped table-bordered table-hover" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th>Nama Lengkap</th>
                            <th>Alamat Email</th>
                            <th>Peran</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <span
                                        class="button-font-size badge badge-{{ $user->status == 'inactive' ? 'danger' : 'success' }}">
                                        {{ $user->status == 'inactive' ? 'Inactive' : 'Active' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        class="btn btn-info btn-sm button-font-size text-white">
                                        <i class="la la-edit text-white button-font-size "></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#role-filter').select2();

            $('#role-filter').change(function() {
                var selectedRole = $(this).val();
                if (selectedRole) {
                    $('#bs4-table tbody tr').each(function() {
                        var role = $(this).find('td:nth-child(4)').text().toLowerCase();
                        if (role.indexOf(selectedRole.toLowerCase()) > -1 || selectedRole === '') {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                } else {
                    $('#bs4-table tbody tr').show();
                }
            });

            $('#search-input').keyup(function() {
                var searchText = $(this).val().toLowerCase();
                $('#bs4-table tbody tr').each(function() {
                    var rowText = $(this).text().toLowerCase();
                    $(this).toggle(rowText.indexOf(searchText) > -1);
                });
            });
        });
    </script>
@endsection
