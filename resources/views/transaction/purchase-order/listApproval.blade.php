@extends('layouts.admin.base-dashboard')

@section('title', 'Daftar Approval Purchase Order (PO)')

@section('content')
    @include('layouts.admin.include.message')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0 mx-auto" style="font-weight: 600;">Daftar Approval Purchase Order (PO)</h1>
            <div class="d-flex align-items-center">
                <a href="{{ route('purchase-orders.create') }}"
                    class="btn btn-success btn-sm d-flex align-items-center text-white">
                    <i class="la la-plus text-white"></i>
                    Add Purchase Order
                </a>
            </div>
        </div>
        <form action="{{ route('purchase-orders.show-approval') }}" method="GET" class="form-horizontal needs-validation">
            <div class="card-body">
                <div class="form-body">
                    <div class="form-group row @error('start_date') is-invalid @enderror">
                        <label for="start_date" class="control-label text-right col-md-3">Start Date</label>
                        <div class="col-md-3">
                            <input type="text" name="start_date" id="start_date"
                                class="form-control start_date
                                        @error('start_date') is-invalid @enderror"
                                value="{{ old('start_date', date('Y-m-d')) }}">

                            @error('start_date')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('end_date') is-invalid @enderror">
                        <label for="end_date" class="control-label text-right col-md-3">End Date</label>
                        <div class="col-md-3">
                            <input type="text" name="end_date" id="end_date"
                                class="form-control end_date
                                        @error('end_date') is-invalid @enderror"
                                value="{{ old('end_date', date('Y-m-d')) }}">

                            @error('end_date')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light">
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="offset-sm-3 col-md-5">
                                    <button type="submit" class="btn btn-primary btn-rounded">
                                        <i class="la la-search" style="color: #fff; font-size: 1.5em;"></i> Show
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="bs4-table" class="table table-striped table-bordered" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th class="header-color" style="width: 10px;">No</th>
                            <th class="header-color">Supplier</th>
                            <th class="header-color">Received Stock</th>
                            <th class="header-color">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseOrders as $purchaseOrder)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $purchaseOrder->supplierName }}</td>
                                <td>
                                    <a href="{{ route('purchase-orders.detail-approval', $purchaseOrder->id) }}"
                                        class="btn btn-info btn-sm mb-2 " style="color: #fff;">
                                        <i class="la la-eye" style="color: #fff; font-size: 1.5em;"></i>
                                        View
                                    </a>
                                </td>
                                <td>
                                    <div class="row">
                                        @if ($purchaseOrder->status == 'pending')
                                            <div class="col-md-2 mr-4">
                                                <a href="{{ route('purchase-orders.edit', $purchaseOrder->id) }}"
                                                    class="btn btn-info btn-sm mb-2" style="color: #fff;">
                                                    <i class="la la-edit" style="color: #fff; font-size: 1.5em;"></i>
                                                    Edit
                                                </a>
                                            </div>
                                        @endif
                                        <div class="col-md-2">
                                            <form
                                                action="{{ route('purchase-order.export-purchase-order', $purchaseOrder->id) }}"
                                                method="post">
                                                @csrf
                                                @method('PATCH')

                                                {{-- <button type="submit" class="btn btn-info btn-sm"
                                                    style="background-color: purple; border: 1px solid purple;">
                                                    <i class="la la-check-circle-o"
                                                        style="color: #fff; font-size: 1.5em;"></i>
                                                    Preview
                                                </button> --}}
                                            </form>
                                        </div>
                                    </div>
                                </td>
                                {{-- <td>
                                    <form action="{{ route('purchase-orders.approved', $purchaseOrder->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        
                                        <button type="submit" class="btn btn-success btn-sm" >
                                            <i class="la la-check-circle-o"  style="color: #fff; font-size: 1.5em;"></i>
                                            Approved
                                        </button> 
                                    </form>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            $('.start_date').datepicker({
                format: 'yyyy-mm-dd',
                orientation: 'top auto',
                autoclose: true,
                todayHighlight: true
            });

            $('.end_date').datepicker({
                format: 'yyyy-mm-dd',
                orientation: 'top auto',
                autoclose: true,
                todayHighlight: true
            });
        })
    </script>
@endpush
