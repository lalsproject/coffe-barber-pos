@extends('layouts.admin.base-dashboard')

@section('title', 'List Transaction Capster')

@section('content')
    @include('layouts.admin.include.message')

    <div class="card shadow-sm border-light">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0 mx-auto" style="font-weight: 600;">Daftar Transaksi Capster</h1>
            <a href="{{ route('transaction.capsters.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                <i class="la la-plus text-white"></i> Tambah
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-4">
                <table id="bs4-table" class="table table-striped table-bordered table-hover" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th>Nama Capster</th>
                            <th>Nama Layanan</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactionDetails as $transactionDetail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transactionDetail['capsterName']->name }}</td>
                                <td>
                                    @foreach ($transactionDetail['serviceNames'] as $service)
                                        {{ $service }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('transaction.capsters.edit', $transactionDetail['capsterId']) }}"
                                        class="btn btn-info btn-sm button-font-size text-white">
                                        <i class="la la-edit text-white button-font-size"></i> Edit
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
