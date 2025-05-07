@extends('layouts.admin.base-dashboard')

@section('title', 'List Delivery Goods')

@section('content')
    @include('layouts.admin.include.message')

    @inject('deliveryGoodsLetters', 'App\Models\DeliveryGoodsLetter')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0 mx-auto" style="font-weight: 600;">Daftar Purchase Order (PO)</h1>
            <div class="d-flex align-items-center">
                <a href="{{ route('delivery-goods.create') }}"
                    class="btn btn-success btn-sm d-flex align-items-center text-white">
                    <i class="la la-plus text-white"></i>
                    Add
                </a>
            </div>
        </div>
        <div class="card-body">
            <h1 class="text-center" style="margin-bottom: 1em;">List Delivery Goods (SPB)</h1>
            <div class="table-responsive">
                <table id="bs4-table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="header-color" style="width: 10px;">No</th>
                            <th class="header-color">Pelanggan</th>
                            <th class="header-color">Project</th>
                            <th class="header-color">Delivery Goods Number (SPB)</th>
                            <th class="header-color">Delivery Date</th>
                            <th class="header-color">Status</th>
                            <th class="header-color">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deliveryGoods as $deliveryGood)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $deliveryGood->customerName }}</td>
                                <td>{{ $deliveryGood->project }}</td>
                                <td>{{ strtoupper($deliveryGood->delivery_goods_number) }}</td>
                                <td>{{ date('j F Y', strtotime($deliveryGood->delivery_date)) }}</td>
                                <td>
                                    <form
                                        action="{{ route('delivery-goods.exportDeliveryGoods', $deliveryGood->deliveryGoodsLettersId) }}"
                                        method="POST">
                                        @csrf

                                        <button type="submit" class="btn btn-info btn-sm"
                                            style="background-color: purple; border: 1px solid purple;">
                                            <i class="la la-file-pdf-o" style="color: #fff; font-size: 1.5em;"></i> Preview
                                        </button>
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
