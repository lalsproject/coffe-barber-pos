@extends('layouts.admin.base-dashboard')

@section('title', 'Detail Approval Purchase Order (PO)')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-8">
                <table class="table table-borderless mb-4">
                    <tr>
                        <td style="width: 80px; white-space: nowrap;">Delivery Date</td>
                        <td>:</td>
                        <td>{{ $purchaseOrder->delivery_date }}</td>
                    </tr>
                    <tr>
                        <td style="width: 80px; white-space: nowrap;">Shipping Address</td>
                        <td>:</td>
                        <td>{{ $purchaseOrder->shipping_address }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-borderless mb-4">
                    {{-- <tr>
                        <td style="width: 80px; white-space: nowrap;">Status Approval</td>
                        <td>:</td>
                        <td>
                            <span style="padding: 0.8em;" class="badge badge-@if ($purchaseOrder->status == 'approved'){{ 'success' }} @elseif ($purchaseOrder->status == 'completed'){{ 'completed' }} @else{{ 'danger' }} @endif}">
                                {{ ucfirst($purchaseOrder->status) }}
                            </span>
                        </td>
                    </tr> --}}
                </table>
            </div>
        </div>
        

        <a href="{{ route('purchase-orders.list-approval') }}" class="btn btn-success btn-sm mr-4" style="color: #fff;">
            <i class="la la-chevron-left" style="color: #fff;"></i>
            Back
        </a>
        {{-- <a href="{{ route('purchase-orders.approval-form', $purchaseOrderId) }}" 
            class="btn {{ $purchaseOrder->status == 'completed' ? 'btn-disabled' : 'btn-info' }} btn-info text-white btn-sm {{ $purchaseOrder->status == 'completed' ? 'disabled-link' : '' }}">
                <i class="la la-check-circle-o"  style="color: #fff; font-size: 1.5em;"></i>
            Approval
        </a> --}}
    </div>
    <div class="card-body">
        <h1 class="text-center" style="margin-bottom: 1em;">List Approval Purchase Order (PO)</h1>
        <div class="table-responsive">
            <table id="bs4-table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="header-color" style="width: 10px;">No</th>
                        <th class="header-color">Product</th>
                        <th class="header-color">Qty</th>
                        <th class="header-color" style="width: 10px; white-space: nowrap;">Item Status</th>
                        <th class="header-color">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchaseOrderItems as $purchaseOrderItem)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $purchaseOrderItem->productName }}</td>
                            <td>{{ $purchaseOrderItem->qty }}</td>
                            <td>
                                <span style="padding: 0.8em;" class="badge badge-{{ $purchaseOrderItem->status == 'pending' ? 'danger' : 'success' }}">
                                    {{ ucfirst($purchaseOrderItem->status) }}
                                </span>
                            </td>
                            <td>
                                @if ($purchaseOrderItem->status == 'pending')
                                    <div class="row">
                                        <div class="col-md-1 mr-5">
                                            <form action="{{ route('purchase-orders.add-inventory', $purchaseOrderItem->id) }}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <button type="submit" class="btn btn-success btn-sm" >
                                                    <i class="la la-check-circle-o"  style="color: #fff; font-size: 1.5em;"></i>
                                                    Add to Inventory
                                                </button> 
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </td
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection