@extends('layouts.admin.base-dashboard')

@section('title', 'List Products')

@section('content')
    @include('layouts.admin.include.message')

    <div class="card">
        <div class="card-header">
            <a href="{{ route('products.create') }}" class="btn btn-success btn-sm" style="color: #fff;">
                <i class="la la-plus" style="color: #fff;"></i>
                Tambah
            </a>
        </div>
        <div class="card-body">
            <h1 class="text-center" style="margin-bottom: 1em;">List Product</h1>
            <div class="table-responsive">
                <table id="bs4-table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="header-color" style="width: 10px;">No</th>
                            <th class="header-color">Product Code</th>
                            <th class="header-color">Item Description</th>
                            <th class="header-color">Brand</th>
                            <th class="header-color">Stock</th>
                            <th class="header-color">Price</th>
                            <th class="header-color" style="white-space: nowrap;">Created At</th>
                            <th class="header-color">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
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
                                <td>{{ $product->price }}</td>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
