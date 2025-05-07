@extends('layouts.admin.base-dashboard')

@section('title', 'Create Purchase Order')

@section('content')
@include('layouts.admin.include.message')

<div class="card">
    <form action="{{ route('purchase-orders.store') }}" method="POST"
        class="form-horizontal needs-validation">
        @csrf

        <h5 class="card-header">Create Purchase Order</h5>
        <div class="card-body">
            <div class="form-body">
                <div class="form-group row @error('supplier_id') has-error @enderror">
                    <label for="supplier_id" class="control-label text-right col-md-3">Supplier</label>
                    <div class="col-md-3">
                        <select name="supplier_id" id="supplier_id"
                            class="form-control supplier_id @error('supplier_id') has-error @enderror" required>
                            <option value="">-- Choose Supplier --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('supplier_id')
                            <div class="text-danger">
                                <small class="col-md-8">{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('delivery_date') has-error @enderror">
                    <label class="control-label text-right col-md-3">Delivery Date</label>
                    <div class="col-md-5">
                        <div class="input-group mb-2 mr-sm-2">
                            <input type="text" name="delivery_date" id="delivery_date" class="form-control delivery_date
                                @error('delivery_date') is-invalid @enderror" value="{{ old('delivery_date', isset($delivery_date) ? $delivery_date : date('Y-m-d')) }}" readonly>
                        </div>

                        @error('delivery_date')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('shipping_address') has-error @enderror">
                    <label class="control-label text-right col-md-3">Shipping Address</label>
                    <div class="col-md-5">
                        <textarea name="shipping_address" id="purchaseOrderShippingAddress"
                            class="form-control @error('shipping_address') is-invalid @enderror" required style="height: 10em;">{{ old('shipping_address') }}</textarea>

                        @error('shipping_address')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('purchase_order') is-invalid @enderror">
                    <label class="control-label text-right col-md-3">Add Product</label>
                    <div class="col-md-9">
                        <button type="button" id="add_purchase_order" class="addCF btn btn-success mb-4">
                            Add New
                        </button>
                        <div class="table-scrollable form-body">
                            <table class="table table-bordered table-striped table-hover purchase_order_table">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="purchaseOrderInput[0][product_id]" id="product_id"
                                                class="form-control product_id choose-product-id" required>
                                                <option value="">-- Choose Product --</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control quantity" size="5" name="purchaseOrderInput[0][qty]" required>
                                        </td>
                                        <td>
                                            <input type="number" step="any" class="form-control price" size="5" name="purchaseOrderInput[0][price]" required>
                                        </td>
                                        <td>
                                            <input type="number" step="any" class="form-control total_amount" size="7" name="purchaseOrderInput[0][total_amount]">
                                        </td>
                                        <td>
                                            <button class="btn btn-danger remove_purchase_order_row">Remove</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                        </div>
                    </div>
                </div>

                <div class="form-group row @error('discount') has-error @enderror">
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                        <div style="font-weight: bold">Sub Total:
                            <span id="total"></span>
                        </div>

                        <input type="hidden" name="nettPrice" id="subTotal">
                        <input type="hidden" name="total" id="totalData">
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
                                    <i class="la la-save" style="color: #fff; font-size: 1.5em;"></i> Create
                                </button>
                                <a href="{{ route('purchase-orders.list-approval') }}" class="btn btn-info btn-rounded"
                                    style="color: #fff;"> <i class="la la-chevron-left" style="color: #fff; font-size: 1.5em;"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('script')
    <script>
        function addCommas(nStr)
        {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
        }

        $(function () {
            $(".supplier_id").select2({
                tags: false
            });

            $(".choose-product-id").select2({
                tags: false,
                width: '100%'
            });

            $('.delivery_date').datepicker({
                format: 'yyyy-mm-dd',
                orientation: "top auto",
                autoclose: true,
                todayHighlight: false,
                todayBtn: false
            });

            $('#purchaseOrderProject').keyup(function() {
		        $(this).val($(this).val().toUpperCase());
	        });

            $('#purchaseOrderShippingAddress').keyup(function() {
		        $(this).val($(this).val().toUpperCase());
	        });

            $('#purchaseOrderConsignedTo').keyup(function() {
		        $(this).val($(this).val().toUpperCase());
	        });

            CKEDITOR.replace('remarks');
        });

        var i = 0;
        $("#add_purchase_order").click(function(){
            ++i;
            $(".purchase_order_table").append("<tr><td><select name='purchaseOrderInput["+i+"][product_id]' class='form-control product_id choose-product-id"+i+"'><option value=''>-- Choose Product --</option>@foreach ($products as $product) <option value='{{ $product->id }}'>{{ $product->name }}</option>@endforeach</select></td><td><input type='text' class='form-control quantity' size='5' name='purchaseOrderInput["+i+"][qty]'></td><td><input type='number' step='any' class='form-control price' size='5' name='purchaseOrderInput["+i+"][price]'></td><td><input type='number' step='any' class='form-control total_amount' size='7' name='purchaseOrderInput["+i+"][total_amount]'></td><td><button type='button' class='btn btn-danger remove_purchase_order_row'>Remove</button></td>");

            $('.choose-product-id'+i).select2({
                tags: false,
                width: '100%'
            });
        });

        $(document).on("click", ".remove_purchase_order_row", function () {
            var $table = $(this).closest('table');
            $(this).closest('tr').remove();
            $table.trigger("recalc");
        });

        $(document).on("keyup", ".purchase_order_table input", function () {
            $(this).trigger("recalc");
        });

        $(document).on("recalc", ".purchase_order_table tr", function () {
            var total = +$(this).find(".quantity").val() * +$(this).find(".price").val();
            $(this).find(".total_amount").val(total);
            console.log("total " + total)
        });

        $(document).on("recalc", ".purchase_order_table", function () {
            var total = 0;
            $(this).find(".total_amount").each(function () {
                total += +$(this).val();
            });

            console.log("addCommas " + total)
            // $("#total").text((total/1000).toFixed(3));
            $("#total").text(addCommas(total))
            $("#totalData").text(total);

            netAmount = total;
            discount = $("#discount").val() / 100;
            if (discount) {
                netAmount = total - discount;
            }

            $("#subTotal").val(netAmount)
        });

        $(".purchase_order_table").trigger("recalc");

        var total = $('#totalData').val();
        console.log(total);

        $("#discount").keyup(function() {
            var discount = $("#discount").val();
            var subTotal = $('#subTotal').val();
            var nettPrice = subTotal - (subTotal * (discount / 100))
            $("#nettPrice").html(addCommas(nettPrice));
        });
    </script>
@endpush
