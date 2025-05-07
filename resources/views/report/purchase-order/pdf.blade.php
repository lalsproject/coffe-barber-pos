<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Order Report</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        thead {
            display: table-header-group
        }

        tfoot {
            display: table-row-group
        }

        tr {
            page-break-inside: avoid
        }

        .page {
            page-break-after: always;
            page-break-inside: avoid;
            overflow: hidden;
        }

        .no-border {
            border-left: none !important;
        }

        .table-invoice-info,
        .table-product {
            border-collapse: collapse;
        }

        .dotted-border {
            border: 1px solid;
            border-style: dotted;
            color: black;
        }

        .table-invoice-info td {
            padding: 0.3em;
        }

        .table-product {
            width: 61em;
            height: 40em;
        }

        .table-product td, th {
            padding: 0.3em;
        }

        .table-product th {
          border: 1px dotted black;
        }

        .table-product td {
            border-right: 1px dotted black;
            border-left: 1px dotted black;
        }

        .table-product tr {
            border-left: 1px dotted black;
            border-right: 1px dotted black;
        }

        .bold {
            font-weight: bolder;
            color: black;
            font-family: 'Times New Roman', Times, serif
        }

        .transfer-info {
            border: 1px solid black;
            border-radius: 10px;
            padding: 1em;
            width: 27em;
        }

        .nowrap { white-space: nowrap; }
        .pt-info { margin-top: -1em; }
        .borderbottom { border-bottom: double; }
        .bottom-border {border-bottom: double; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-md-8">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents('img/'.'bpas.png')) }}"
                style="margin-bottom: 1.2em;  width:150px; height:150px;">
            <br>
            <table>
                <tr>
                    <td class="bold">
                        {{ $purchaseOrders->supplierType == 'bpas' ? env('HEADER_REPORT_COMPANY_NAME') : env('HEADER_REPORT_COMPANY_NAME_CLASS') }}
                    </td>
                </tr>
                <tr>
                    <td class="bold">{{ env('HEADER_REPORT_COMPANY_STREET') }}</td>
                </tr>
                <tr>
                    <td class="bold">{{ env('HEADER_REPORT_COMPANY_DETAIL_SUBDISTRICT') }}</td>
                </tr>
                <tr>
                    <td class="bold">{{ env('HEADER_REPORT_COMPANY_CITY') }}</td>
                </tr>
                <tr>
                    <td class="bold">{{ env('HEADER_REPORT_COMPANY_PHONE') }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-4">
            <p class="bold" style="margin-bottom: 0.5em; color: black; font-size: 1.5em;">PURCHASE ORDER</p>
            <table class="table-invoice-info">
                <tr>
                    <td class="bold text-right">DATE</td>
                    <td class="dotted-border bold">{{ date('d F Y', strtotime($purchaseOrders->created_at)) }}</td>
                </tr>
                <tr>
                    <td class="bold text-right">NO</td>
                    <td class="dotted-border bold">{{ $purchaseOrders->po_number }}</td>
                </tr>
            </table>
        </div>
    </div>
    <br><br><br>

    <div class="row">
        <div class="col-md-6">
            <table>
                <tr>
                    <td class="bold">TO</td>
                    <td class="bold">&nbsp;:&nbsp;</td>
                    <td class="bold">{{ $purchaseOrders->supplierName }}</td>
                </tr>
                <tr>
                    <td class="bold">ATTN</td>
                    <td class="bold">&nbsp;:&nbsp;</td>
                    <td class="bold">{{ strtoupper($purchaseOrders->supplierContact) }}</td>
                </tr>
                <tr>
                    <td class="bold">TELP</td>
                    <td class="bold">&nbsp;:&nbsp;</td>
                    <td class="bold">{{ $purchaseOrders->supplierPhone }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6"></div>
    </div>

    <br><br>
    <p class="bold" style="margin-left: 2em;">
        Please deliver the following goods, in accordance with the quantity, description and price mentioned below.
    </p>

    <div class="row">
        <div class="col-md-12">
            <table class="table-product">
                <thead>
                    <tr style="line-height: 1.5em; height: 1.5em;">
                        <th style="width: 10px; text-align: center;">No.</th>
                        <th class="text-center">ITEM DESCRIPTION</th>
                        <th class="text-center" style="white-space: nowrap;">QTY</th>
                        <th class="text-center" style="white-space: nowrap;">UNIT PRICE</th>
                        <th class="text-center" style="white-space: nowrap;">TOTAL PRICE ({{ $purchaseOrders->supplierCurrencyCode }})</th>
                    </tr>
                </thead>
                @php
                    $ppn = $totalNett * env('PPN_TAX') / 100;
                    $grandTotalWithPPN = $totalNett + $ppn;
                @endphp
                <tbody>
                    @foreach ($purchaseOrderItems as $purchaseOrderItem)
                        <tr style="line-height: 15px; height: 15px;">
                            <td class="bold" style="vertical-align: center; text-align: center;">{{ $loop->iteration }}</td>
                            <td class="bold" style="vertical-align: center; text-align: left;">{{ $purchaseOrderItem->productName }} {{ $purchaseOrderItem->description }}</td>
                            <td class="bold" style="vertical-align: center; text-align: center; white-space: nowrap;">{{ $purchaseOrderItem->qty }} {{ $purchaseOrderItem->unitName }}</td>
                            {{-- <td class="bold" style="vertical-align: center; text-align: center;">{{ number_format($purchaseOrderItem->price,0,',','.') }}</td> --}}
                            <td class="bold" style="vertical-align: center; text-align: center;">{{ number_format($purchaseOrderItem->price,2,',','.') }}</td>
                            <td class="bold" style="vertical-align: center; border-bottom: 1px solid dotted; text-align: center;">{{ number_format($purchaseOrderItem->qty * $purchaseOrderItem->price,2,',','.') }}</td>
                        </tr>
                    @endforeach

                    <tr class="empty-row">
                        <td style="border-right: 1px dotted black;"></td>
                        <td style="border-right: 1px dotted black;"></td>
                        <td style="border-right: 1px dotted black;"></td>
                        <td style="border-right: 1px dotted black;"></td>
                        <td style="border-right: 1px dotted black;"></td>
                    </tr>
                </tbody>
                <tfoot>
                    @php
                        $ppn = $totalNett * env('PPN_TAX') / 100;
                        $grandTotalWithPPN = $totalNett + $ppn;
                        $totalAfterDiscount = $purchaseOrders->subtotal - $discount;
                    @endphp

                    <tr style="line-height: 8px; height: 8px; border-top: 1px dotted black;">
                        <td colspan="2" style="font-weight: bold;"></td>
                        <td colspan="2" style="white-space: nowrap; font-weight: bold; text-align: right;">SUB TOTAL ({{ $purchaseOrders->supplierCurrencyCode }})</td>
                        <td style="font-weight: bold; text-align: center;">{{ number_format($purchaseOrders->subtotal, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="white-space: nowrap; font-weight: bold;"></td>
                        <td colspan="2" style="text-align: right; font-weight: bold;">DISCOUNT ({{ $purchaseOrders->supplierCurrencyCode }})</td>
                        <td style="font-weight: bold; text-align: center;">{{ number_format(($purchaseOrders->subtotal * $purchaseOrders->discount) / 100, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="white-space: nowrap; font-weight: bold;">DELIVERY TIME : ASAP</td>
                        <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL AFTER DISC ({{ $purchaseOrders->supplierCurrencyCode }})</td>
                        <td style="font-weight: bold; text-align: center;">{{ number_format($totalAfterDiscount, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right; font-weight: bold;">PPN {{ env('PPN_TAX') }}% ({{ $purchaseOrders->supplierCurrencyCode }})</td>
                        <td style="font-weight: bold; text-align: center;">
                            @if ($purchaseOrders->supplierFreePPN == 'no')
                                {{ $purchaseOrders->supplierCurrencyCode == 'IDR' ? number_format($ppn, 2, ',', '.') : '' }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="white-space: nowrap; font-weight: bold; border-bottom: 1px dotted black;"></td>
                        <td colspan="2" style="text-align: right; font-weight: bold; border-bottom: 1px dotted black;">NET TOTAL ({{ $purchaseOrders->supplierCurrencyCode }})</td>
                        <td style="font-weight: bold; text-align: center;  border-bottom: 1px dotted black;">
                            @if ($purchaseOrders->supplierCurrencyCode == 'IDR')
                                @if ($purchaseOrders->supplierFreePPN == 'no')
                                    {{ number_format($grandTotalWithPPN, 2, ',', '.') }}
                                @else
                                    {{ number_format($totalNett, 2, ',', '.') }}
                                @endif
                            @else
                                {{ number_format($totalNett, 2, ',', '.') }}
                            @endif
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div style="margin-top: 2.5em;">
                <h5 class="bold" style="margin-left: 2.5em;">Approved By</h5>
            </div>
        </div>
        <div class="col-md-4">
            <div style="margin-top: 2.5em;">
                <h5 class="bold" style="margin-left: 2.5em;">Prepared By</h5>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="admin-info" style="margin-top: 8em;" >
                <p class="bold">(@for ($i = 1; $i < 20; $i++) &nbsp; @endfor)</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-info" style="margin-top: 8em;">
                <p class="bold">({!! str_repeat("&nbsp;", 6) !!} {{ ucwords($purchaseOrders->userName) }} {!! str_repeat("&nbsp;", 6) !!})</p>
            </div>
        </div>
    </div>
</body>
</html>
