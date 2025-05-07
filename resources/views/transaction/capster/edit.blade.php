@extends('layouts.admin.base-dashboard')

@section('title', 'Edit Capster')

@section('content')
@include('layouts.admin.include.message')

<div class="card">
    <form action="{{ route('transaction.capsters.update',$transactionCaspter->id) }}" method="POST"
        class="form-horizontal needs-validation" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <h5 class="card-header">Edit Capster Transaction</h5>
        <div class="card-body">
            <div class="form-body">
                
                <div class="form-group row @error('capster_id') has-error @enderror">
                    <label for="capster_id" class="control-label text-right col-md-3">Capster</label>
                    <div class="col-md-3">
                        <select name="capster_id" id="capster_id"
                            class="form-control @error('capster_id') has-error @enderror">
                            <option value="">-- Pilih Capster --</option>
                            @foreach ($capsters as $capster)
                                <option value="{{ $capster->id }}"
                                    {{ old('capster_id') == $capster->id ? 'selected' : '' }}
                                    {{ $transactionCaspter->capster_id == $capster->id ? 'selected' : '' }}
                                    >
                                    {{ $capster->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('capster_id')
                            <div class="text-danger">
                                <small class="col-md-8">{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('purchase_order') is-invalid @enderror">
                    <label class="control-label text-right col-md-3">Edit Service</label>
                    <div class="col-md-9">
                        <button type="button" id="add_service" class="addCF btn btn-success mb-4">
                            Add New
                        </button>
                        <div class="table-scrollable form-body">
                            <table class="table table-bordered table-striped table-hover service_table">
                                <thead>
                                    <tr>
                                        <th>Service Name</th>
                                        <th>Service Qty</th>
                                        <th>Service Price</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transctionCapsterDetails as $key => $value)
                                        <tr>
                                            <td>
                                                <select name="serviceInput[{{ $value['id'] }}][service_id]" id="service_id{{ $value['id'] }}"
                                                    class="form-control service_id choose-service-id{{ $value['id'] }}">
                                                    <option value="">-- Choose Service --</option>
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}"
                                                            {{ $value->service_id == $service->id ? 'selected' : '' }}>
                                                            {{ $service->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input name='serviceInput[{{ $value['id'] }}][quantity]' id="quantity{{ $value['id'] }}" type="text"  class='form-control quantity{{ $value['id'] }}' size="5" name="quantity" required>
                                            </td>
                                            <td>
                                                <input name='serviceInput[{{ $value['id'] }}][price_service]' id='price_service{{ $value['id'] }}' name='price_service' class='form-control price_service' size='5' disabled />
                                            </td>
                                            <td>
                                                <input id='price_total{{ $value['id'] }}' name='serviceInput[{{ $value['id'] }}][price_total]' class='form-control price_total' size='5' value='0' disabled />
                                            </td>
                                            <td>
                                                <button class="btn btn-danger remove_purchase_order_row{{ $value['id'] }}">Remove</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                        </div>
                    </div>
                </div>

                <div class="form-group row ">
                    <div class="col-md-10 text-right control-label">
                        <div style="font-weight: bold">Total:
                            <span id="total" name="total">{{ $transactionCaspter->total  }}</span>
                        </div>
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
                                <a href="{{ route('transaction.capsters.index') }}" class="btn btn-info btn-rounded"
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
        let total=0;
        $(document).ready(function () {
            var i = {{ $value['id'] }};
            $("#add_service").click(function () {
                ++i;
                $(".service_table").append(`
                    <tr>
                        <td>
                            <select name='serviceInput[${i}][service_id]' class='form-control service_id choose-service-id${i}'>
                                <option value=''>-- Choose Service --</option>
                                @foreach ($services as $service)
                                    <option value='{{ $service->id }}' data-price='{{ $service->price }}' data-name='{{ $service->name }}' >{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input name='serviceInput[${i}][quantity]' id="quantity${i}" type="text" class='form-control quantity${i}' size="5" name="quantity" value='0' required>
                        </td>
                        <td>
                            <input name='serviceInput[${i}][price_service]' id='price_service${i}' name='price_service' class='form-control price_service' size='5' value='0' disabled />
                        </td>
                        <td>
                            <input id='price_total${i}' name='serviceInput[${i}][price_total]' class='form-control price_total' size='5' value='0' disabled />
                        </td>
                        <td>
                            <button type='button' class='btn btn-danger remove_purchase_order_row${i}'>Remove</button>
                        </td>
                    </tr>
                `);

                // Initialize select2 for the new element
                $(`.choose-service-id${i}`).select2({
                    tags: false,
                    width: '100%'
                });

                // Bind event listener for the new select element
                (function (rowId) {

                    $(`.quantity${rowId}`).on('input', function () {
                        
                        var $input = $(`#price_service${rowId}`);
                        var price = parseInt($input.val().replace(/\D/g, '')) || 0;
                        var quantity = parseInt($(`#quantity${rowId}`).val());

                        console.log("Service Quantity " + price   + " clicked");
                        if(isNaN(parseInt(quantity))){
                            return
                        }
                        var finalPrice = price * quantity;
                        var formattedPrice = 'Rp ' + new Intl.NumberFormat('id-ID').format(finalPrice);
                        $(`#price_total${rowId}`).val(formattedPrice);
                        updateTotal();
                    });

                    $(`.choose-service-id${rowId}`).on('change', function () {
                        console.log("Service ID change " + rowId + " clicked");
                        var price = $(this).find('option:selected').data('price') || 0;
                        var name = $(this).find('option:selected').data('name') || '';
                        var formattedPrice = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
                        $(`#price_service${rowId}`).val(formattedPrice);
                        updateTotal();
                        $(`.quantity${rowId}`).val('1').trigger('input');
                    });

                    $(`.remove_purchase_order_row${rowId}`).on('click', function () {
                        var $input = $(`#price_service${rowId}`);
                        var price = parseInt($input.val().replace(/\D/g, '')) || 0;
                        var $table = $(this).closest('table');
                        $(this).closest('tr').remove();
                        $table.trigger("recalc");
                        updateTotal();       
                    });
                })(i); // Pass the current value of `i` to create a unique scope

                // Function to update total
                function updateTotal() {
                    let newTotal = 0;                 
                    // Iterate over all elements with class 'price_service'
                    $('.price_total').each(function () {
                        // Parse the value, remove non-numeric characters, and add to the total
                        const price = parseInt($(this).val().replace(/\D/g, '')) || 0;
                        newTotal += price;
                    });

                    // Update the total in the UI
                    $('#total').text(new Intl.NumberFormat('id-ID').format(newTotal));
                    total = newTotal; // Update the running total
                    $('#totalData').val(newTotal);
                }
            });

            @foreach ($transctionCapsterDetails as $key => $value)
                 // Initialize select2 for the new element
                $(`.choose-service-id{{ $value['id'] }}`).select2({
                    tags: false,
                    width: '100%'
                });

                

                $(`.quantity{{ $value['id'] }}`).on('input', function () {
                    
                    var $input = $(`#price_service{{ $value['id'] }}`);
                    var price = parseInt($input.val().replace(/\D/g, '')) || 0;
                    var quantity = parseInt($(`#quantity{{ $value['id'] }}`).val());

                    console.log("Service Quantity " + price   + " clicked");
                    if(isNaN(parseInt(quantity))){
                        return
                    }
                    var finalPrice = price * quantity;
                    var formattedPrice = 'Rp ' + new Intl.NumberFormat('id-ID').format(finalPrice);
                    $(`#price_total{{ $value['id'] }}`).val(formattedPrice);
                    updateTotal();
                });


                var formattedPrice = 'Rp ' + new Intl.NumberFormat('id-ID').format(`{{ $value->service->price }}`);
                $(`#price_service{{ $value['id'] }}`).val(formattedPrice);
                $(`.quantity{{ $value['id'] }}`).val(`{{ $value['quantity'] }}`).trigger('input');

                $(`.choose-service-id{{ $value['id'] }}`).on('change', function () {
                    console.log("Service ID change " + rowId + " clicked");
                    var price = $(this).find('option:selected').data('price') || 0;
                    var name = $(this).find('option:selected').data('name') || '';
                    var formattedPrice = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
                    $(`#price_service{{ $value['id'] }}`).val(formattedPrice);
                    updateTotal();
                    $(`.quantity{{ $value['id'] }}`).val('1').trigger('input');
                });

                $(`.remove_purchase_order_row{{ $value['id'] }}`).on('click', function () {
                    var $input = $(`#price_service{{ $value['id'] }}`);
                    var price = parseInt($input.val().replace(/\D/g, '')) || 0;
                    var $table = $(this).closest('table');
                    $(this).closest('tr').remove();
                    $table.trigger("recalc");
                    updateTotal();       
                });

            @endforeach

            // Function to update total
            function updateTotal() {
                let newTotal = 0;                 
                // Iterate over all elements with class 'price_service'
                $('.price_total').each(function () {
                    // Parse the value, remove non-numeric characters, and add to the total
                    const price = parseInt($(this).val().replace(/\D/g, '')) || 0;
                    newTotal += price;
                });

                // Update the total in the UI
                $('#total').text(new Intl.NumberFormat('id-ID').format(newTotal));
                total = newTotal; // Update the running total
                $('#totalData').val(newTotal);
            }

        });
    </script>
@endpush
