<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transaction - Recap Capster Revenue</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
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
            margin-bottom: 1rem;
        }
        .mb-4 {
            margin-bottom: 1.5rem;
        }
        .mt-2 {
            margin-top: 0.5rem;
        }
        .mt-5 {
            margin-top: 4rem; /* Bootstrap mb-5 is 3rem */
        }
        strong {
            font-weight: bold;
        }
        .dashed-line {
            border-bottom: 1px dashed #000; /* Dashed bottom border */
            width: 100%; /* Full width of container */
        }
    </style>
</head>
<body>
    <div class="text-center mb-4">
        <h3>Daily Recap Revenue</h3>
        <p class="text-muted">{{ $deposit_transaction->branch->branch }}</p>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <p><strong>Kasir:</strong> {{ $deposit_transaction->user->name }}</p>
            <p><strong>Waktu:</strong> {{ $start_date }}</p>
        </div>
    </div>

    <h5 class="text-center mb-3">### PAID ###</h5>

    <div class="row">
        <span class="col-md-6"><strong>Total Revenue</strong></span>
        <span class="col-md-6 text-end">{{ $revenue }}</span>
    </div>
    <div class="row">
        <span class="col-md-6"><strong>Cash IN</strong></span>
        <span class="col-md-6 text-end">{{ $cash_in }}</span>
    </div>
    <div class="row">
        <span class="col-md-6"><strong>Total</strong></span>
        <span class="col-md-6 text-end">{{ $total  }}</span>
    </div>
    @if(Auth::user()->role == 'admin')
        <div class="row">
            <span class="col-md-6"><strong>Difference Receipt</strong></span>
            <span class="col-md-6 text-end">{{ $difference_receipt }}</span>
        </div>
    @endif

    <div style="border-bottom: 1px dashed #000; width: 100%;" class="my-4 mt-5"></div>

    <div class="text-center mt-5">
        <p class="text-muted">Powered by Rapid Barbershop</p>
    </div>
</body>
</html>
