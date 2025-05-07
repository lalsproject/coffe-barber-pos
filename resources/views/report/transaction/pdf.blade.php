<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transaction - Invoice</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Receipt</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size:1.6em;
        }
        .text-center {
            text-align: center;
        }
        .text-end {
            text-align: right;
        }
        .d-flex {
            display: flex;
            justify-content: space-between;
        }
        .mb-3 {
            margin-bottom: 0.5rem;
        }
        .mb-4 {
            margin-bottom: 0.5rem;
        }
        .mt-2 {
            margin-top: 3px;
        }
        .mt-5 {
            margin-top: 0.5rem; /* Bootstrap mb-5 is 3rem */
        }
        strong {
            font-weight: bold;
        }
        .dashed-line {
            border-bottom: 1px dashed #000; /* Dashed bottom border */
            width: 100%; /* Full width of container */
        }
        .margin-custom {
            margin-left: 20px;
        }
        .margin-left {
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="text-center mb-4">
        <h3>Rapid Barbershop</h3>
        <h5 style="margin-top:-8px;" >{{ $transaction->branch->branch }}</h5>
    </div>

    <div class="row mb-3">
        {{-- <div class="col-md-6">
            <p><strong>Kasir:</strong> {{ $transaction->user->name }}</p>
            <p><strong>Waktu:</strong> {{ $transaction->transaction_date_time }}</p>
        </div>
        <div class="col-md-6">
            <p class="text-end"><strong>No. Struk:</strong> {{ $transaction->transaction_number }}</p>
            <p class="text-end"><strong>Jenis Pembayaran:</strong> {{ $transaction->payment_method }}</p>
        </div> --}}
        <p class="margin-custom"><strong>Kasir:</strong> {{ $transaction->user->name }}</p>
        <p class="margin-custom"><strong>Waktu:</strong> {{ $transaction->transaction_date_time }}</p>
        <p class="margin-custom"><strong>No. Struk:</strong> {{ $transaction->transaction_number }}</p>
        <p class="margin-custom"><strong>Metode:</strong> {{ $transaction->payment_method }}</p>
    </div>

    <div style="border-bottom: 1px dashed #000; width: 100%;" class="my-4 mt-5 mb-4 "></div>


    @foreach ($transaction_details as $item)
        <div style="margin-left:2px;">
            <strong>{{ $item->product->name }}</strong>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p style="margin-left:2px;">{{ $item->product->price }} x {{ $item->quantity }}</p>
            </div>
            <div class="col-md-6 text-end">
                <span>{{ $item->product->price * $item->quantity }}</span>&nbsp;
            </div>
        </div>
    @endforeach
    
    <div class="row">
        <div class="col-md-6">
            <span  style="margin-left:2px">Kembali</span>
        </div>
        <div class="col-md-6 text-end">
            <span  class="">{{ $cashback }}</span>&nbsp;
        </div>
    </div>

    <div style="border-bottom: 1px dashed #000; width: 100%;" class="my-4 mt-5"></div>

    <div class="text-center mt-5">
        <p class="text-muted">Powered by Rapid Barbershop</p>
    </div>
</body>
</html>
