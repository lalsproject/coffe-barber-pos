@extends('layouts.admin.base-dashboard')

@section('title', 'Create Capster')

@section('content')
@include('layouts.admin.include.message')
<div class="card">
   
    <h5 class="card-header">Create Capster Transaction</h5>
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
                                {{ old('capster_id') == $capster->id ? 'selected' : '' }}>
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

            <div class="form-group row @error('service_id') is-invalid @enderror">
                <label class="control-label text-right col-md-3">Add Service</label>
                <div class="col-md-9">
                    <button onclick="" type="button" id="add_service" class="addCF btn btn-success mb-4">
                        Add New
                    </button>
                    <div class="table-scrollable form-body">
                        <table class="table table-bordered table-striped table-hover service_table">
                            <thead>
                                <tr>
                                    <th class="header-color text-white">Service Name</th>
                                    <th class="header-color text-white">Qty</th>
                                    <th class="header-color text-white">Price</th>
                                    <th class="header-color text-white">Total Price</th>
                                    <th class="header-color text-white">Action</th>
                                </tr>
                            </thead>
                        </table>
                        <hr>
                    </div>
                </div>
            </div>

            <div class="form-group row ">
                <div class="col-md-10 text-right control-label">
                    <div style="font-weight: bold">Total:
                        <span id="total" name="total"></span>
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
                            <button  id="openModalButton" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectPaymentModal">
                                <i class="la la-save" style="color: #fff; font-size: 1.5em;"></i> Create
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <di class="modal fade" id="selectPaymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="selectPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="paymentModalLabel">Payment</h1>
                <button onclick="onDismissModal()" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2 class="text-center mb-4">Total Bill</h2>
                <h1 id="paymentModalCurrency" class="text-center text-danger mb-5"></h1>

                <h3 class="mb-3">Select Payment</h3>

                <div class="list-group">
                    <a id="selectedCash" href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-bs-target="#paymentModalCash" data-bs-toggle="modal">
                      Cash
                      <i class="la la-chevron-right"></i>
                    </a>
                    <a id="selectedQris" href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-bs-target="#paymentModalCash" data-bs-toggle="modal">
                      Qris
                      <i class="la la-chevron-right"></i>
                    </a>
                    <a id="selectedOnline" href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                      Online Payment
                      <i class="la la-chevron-right"></i>
                    </a>
                </div>
            </div>
            <div class="modal-footer">
              {{-- <button class="btn btn-primary" data-bs-target="#paymentModalCash" data-bs-toggle="modal">Open second modal</button> --}}
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="paymentModalCash" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="paymentModalCashLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
                <h1 id="paymentMethodTitle" class="modal-title" ></h1>
                <button  type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <h2 class="text-center mb-4">Total Bill</h2>
                <h1 id="paymentModalCurrencyCash" class="text-center text-danger mb-5"></h1>

                <div class="input-group">
                    <span class="input-group-text">Uang yang diterima</span>
                    <input id="currencyPay" type="text" aria-label="currency" class="form-control">

                </div>

            </div>
            <div class="modal-footer row mx-1" >
                <button onclick="onTransactionSubmited()" id="buttonPaymentCurrency" class="btn btn-primary col-12" disabled>Terima</button>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection

@push('script')
    <script>
        let total=0;
        var transaction = [];
        let paymentMethod;

        $(document).ready(function () {

            $("#capster_id").select2({
                tags: false
            });

            $("#service_id").select2({
                tags: false
            });
            
            var i = 0;
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

             // Get all anchor elements inside the list-group
            let listItems = document.querySelectorAll('.list-group a');
            // Loop through the items and add click event listeners
            listItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Remove 'active' class from all items
                    // listItems.forEach(i => i.classList.remove('active'));

                    // Add 'active' class to the clicked item
                    // this.classList.add('active');
                    paymentMethod = this.textContent.trim();
                    // Get the text of the selected item
                    console.log(this.textContent.trim());
                });
            });

            $('#currencyPay').on('input', function () {
                // Get the input value
                let inputValue = $(this).val();
                // Remove non-numeric characters (except for the decimal point)
                inputValue = inputValue.replace(/[^0-9]/g, '');
                // Convert to Rupiah format
                let formattedValue = formatRupiah(inputValue);
                if(parseInt(inputValue) >= parseInt(total) && parseInt(total) > 0){
                    $('#buttonPaymentCurrency').prop('disabled', false);
                }else{
                    $('#buttonPaymentCurrency').prop('disabled', true);
                }
                // Update the input field with the formatted value
                $(this).val(formattedValue);
           });

            // Function to format the number to Rupiah
            function formatRupiah(value) {
                if (!value) return '';

                // Convert to number
                let number = parseInt(value);

                // Format the number to Rupiah
                return number.toLocaleString('id-ID');
            }


        });


        var selectPaymentModal = document.getElementById('selectPaymentModal');
        selectPaymentModal.addEventListener('shown.bs.modal', function () {
            $('#paymentModalCurrency').text('Rp '+total);
        });

        var paymentModalCash = document.getElementById('paymentModalCash');
        paymentModalCash.addEventListener('shown.bs.modal',function() {
            console.log(paymentMethod);
            $('#paymentMethodTitle').text(paymentMethod);
            $('#paymentModalCurrencyCash').text('Rp '+total);
        });


        function onTransactionSubmited(){
            var cashPay = $('#currencyPay').val();
            var paymentMethod =  $('#paymentMethodTitle').text();
            const selectedOption = $('#capster_id').find('option:selected');
            const capsterId = $('select[name="capster_id"]').val();
            var total = $('#totalData').val();
            let serviceIds = {};
             // Iterate over all select and input elements in the table
            $('select[name^="serviceInput"], input[name^="serviceInput"]').each(function () {
                const name = $(this).attr('name'); // Get the 'name' attribute
                const value = $(this).val(); // Get the value of the element
                // Extract index and key from the 'name' using a regular expression
                const match = name.match(/serviceInput\[(\d+)]\[(\w+)]/);
                if (match) {
                    const [_, index, key] = match;
                    // Initialize the object for the index if not already done
                    if (!serviceIds[index]) {
                        serviceIds[index] = {};
                    }
                    // Assign the value to the corresponding key
                    serviceIds[index][key] = value;
                }
            });
            console.log("Grouped Services :"+serviceIds);
            transaction = [];
            transaction.push({
                capsterId : capsterId,
                serviceIds : serviceIds,
                total : total,
                cash_pay : cashPay,
                payment_method : paymentMethod,
            });

            console.log(transaction);
        
            const CSRF_TOKENS = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('transaction.submit.capster') }}",
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                headers: {
                 'X-CSRF-TOKEN': CSRF_TOKENS // Send CSRF token in headers
                },
                contentType: 'application/json', // Set content type to JSON
                data: JSON.stringify(transaction), // Convert data to JSON string
                success: function (response) {
                    const transactionCapster = response.transactionCapster;
                    const transactionDetails = response.transactionDetails;
                    const cashback =  parseInt(transactionCapster.money_received) - parseInt(transactionCapster.total);
                    const convertedDate = dayjs(transactionCapster.created_at).format('DD/MM/YYYY  HH:mm:ss');
                    const invoiceNumber =  `${transactionCapster.transaction_number.substring(0, 10)}...`
                    console.log('Response:', transactionCapster.id);
                    console.log('Response:', response.transactionDetails);
                    onShowDialog(transactionCapster.id);
                    transactioDetailModal = `<div class="modal fade" id="receiptModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="receiptModalLabel">Receipt</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="text-center mb-4">
                                                                <h3>Rapid Babershop</h3>
                                                                <p class="text-muted">${response.branchName}</p>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-6">
                                                                <p><strong>Kasir:</strong> ${response.cashierName}</p>
                                                                <p><strong>Waktu:</strong> ${convertedDate}</p>
                                                                </div>
                                                                <div class="col-6 text-end" >
                                                                <p class="d-flex justify-content-end"><strong>No. Struk:</strong>${invoiceNumber}</p>
                                                                <p class="d-flex justify-content-end"><strong>Jenis Pembayaran:</strong> ${transactionCapster.payment_method}</p>
                                                                </div>
                                                                 <div class="col-6 text-start" >
                                                                    <p class="d-flex justify-content-start"><strong>Capster:</strong>${response.capsterName}</p>
                                                                 </div>
                                                            </div>
                                                            <h5 class="text-center mb-3">### PAID ###</h5>
                                                            ${transactionDetails.map((item) => {
                                                            return  `
                                                                <div class="d-flex justify-content-between">
                                                                    <strong>${item.service_name}</strong>
                                                                </div>
                                                                <div class="d-flex justify-content-between">
                                                                    <span>${item.service_price} x ${item.quantity}</span>
                                                                    <span>${item.total}</span>
                                                                </div>
                                                                `
                                                            }).join('')}
                                                            <div class="d-flex justify-content-between mt-2">
                                                                <span>Kembali</span>
                                                                <span>${cashback}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between mt-2">
                                                             <a href="/transaction/capster/export/${transactionCapster.id}" type="button" class="btn btn-success col-12 print-btn" data-bs-dismiss="modal">Print</a>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-center">
                                                         <p class="text-muted">Powered by Rapid BaberShop</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>`

                        },
                error: function (xhr) {
                    console.error('Error:', xhr.responseJSON.message);
                    alert(xhr.responseJSON.message); // Show error message to the user
                }
            });
        }

        function onShowDialog(transaction_id) {
            console.log(transaction_id);
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('transaction.capster.dialog') }}",
                method: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    queryParam: {
                        transaction_id: transaction_id,
                    }
                },
                success: function (response) {
                    $('body').append(response);
                    $('#receiptModal').modal('show');
                },
                error: function () {
                    alert('An error occurred while loading the dialog.');
                }
            });
        }

        function showDetailTransaction(){
            $('body').append(transactioDetailModal);
            $('#receiptModal').modal('show');
            $(document).on('click', '.print-btn', function(e) {
                console.log('onclick print');
                e.preventDefault(); // Prevent default anchor behavior
                const url = $(this).attr('href'); // Get the URL from the anchor's href attribute
                // Implement the printing functionality here, e.g., open the URL in a new tab
                window.open(url, '_blank'); // Open in a new tab for printing
            });
        }

        function reloadPage(){
            location.reload();
        }
    
    </script>
@endpush
