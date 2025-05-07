@extends('layouts.admin.base-dashboard')

@section('title', 'Daftar Produk')

@section('content')
    @include('layouts.admin.include.message')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0 mx-auto" style="font-weight: 600;">Daftar Produk</h1>
            <div class="d-flex align-items-center">
                <a href="{{ route('products.create') }}" class="btn btn-success btn-sm d-flex align-items-center text-white">
                    <i class="la la-plus text-white"></i>
                    Tambah
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-4">
                <table class="table table-striped table-bordered table-hover" id="table-product" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th class="header-color" style="width: 10px;">No</th>
                            <th class="header-color">Kode Produk</th>
                            <th class="header-color">Deskripsi Produk</th>
                            <th class="header-color">Brand</th>
                            <th class="header-color">Stok</th>
                            <th class="header-color">Harga</th>
                            <th class="header-color" style="white-space: nowrap;">Terakhir Update</th>
                            <th class="header-color">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->brand->name }}</td>
                                <td>
                                    <span style="font-size: 1em; font-weight: bold;" class="badge badge-{{ $product->stock == 0 ? 'danger' : 'success' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td style="white-space: nowrap;">
                                    {{ date('d-m-Y H:i:s', strtotime($product->created_at)) }}
                                </td>
                                <td>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info btn-sm mb-4"
                                        style="color: #fff;">
                                        <i class="la la-edit" style="color: #fff; font-size: 1.5em;"></i>
                                        Ubah
                                    </a>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm text-white mb-4" style="background-color: purple; border: 1px solid purple;">
                                        <i class="la la-eye" style="color: #fff; font-size: 1.5em;"></i> View Image</a>
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#table-product').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, 'desc']
                ], // 0 adalah id
                ajax: '{{ url()->current() }}',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'productName'
                    },
                    {
                        data: 'productDescription'
                    },
                    {
                        data: 'brandName'
                    },
                    {
                        data: 'productStock'
                    },
                    {
                        data: 'productPrice'
                    },
                    {
                        data: 'updated_at'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
        });
    </script>
@endpush
