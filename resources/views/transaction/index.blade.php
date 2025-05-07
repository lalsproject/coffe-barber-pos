@extends('layouts.admin.base-dashboard')

@push('style')
    <style>
        .custom_rounded {
            border-radius: 10px
        }

        .vertical-scrollable {
            max-height: 600px;
            /* Set the max-height for the scrollable area */
            overflow-y: scroll;
            /* Enable vertical scroll */
            overflow-x: hidden;
        }

        @media (min-width: 768px) and (max-width: 1024px) {
                    
        }
    </style>
@endpush

@section('title', 'Order Products')


@section('content')
    <div class="container">
        <input type="hidden" id="is_product_available" name="is_product_avaible" value="{{ $is_product_available }}">
        @include('layouts.admin.include.message')

        <div class="row align-items-start">
            <div class="input-group col-md-7 col-lg-7 mt-4 mb-4 custom_rounded" style="height: 50px; padding:0px;">
                <input id="searchProduct" class="form-control border-end-0 border custom_rounded" type="search"
                    placeholder="Product">
                <span class="input-group-append">
                    <button class="btn btn-outline-secondary bg-white border-bottom-0 border custom_rounded ms-n5"
                        style="height: 50px;" type="button">
                        <i class="la la-search"></i>
                    </button>
                </span>
            </div>


            <div id="not_found" class="col-6 row d-none">
                <div class="">
                    <h3 style="color: black;">Product tidak tersedia</h3>
                </div>
            </div>

            <div id="content_view_search" class="col-md-6 col-lg-6 row vertical-scrollable d-none">

            </div>

            <div id="view_product" class="col-md-6 col-lg-6 row  vertical-scrollable">
                @foreach ($products as $product)
                    <div class="list-group col-12 " style="margin-left:15px; margin-bottom:8px;">
                        <div id="view-product" class="row border-end-0 border custom_rounded "
                            style="background: white; padding-top: 10px; padding-left: 10px; padding-right: 55px; padding-bottom: 10px;">
                            <div class="col-3">
                                <img class="card-img-top" src="{{ $product->getImage() }}"
                                    style="object-fit: cover; width:50px;height:50px;" alt="Card image cap">
                            </div>
                            <div class="col-3 text-center align-items-center" style="padding-top: 15px;">
                                {{ $product->name }}
                            </div>
                            <div class="col-3 text-center align-items-center" style="padding-top: 15px;">
                                {{ $product->price }}
                            </div>
                            <div class="col-3">
                                <button
                                    onclick="onButtonAddProductClick({{ $product->id }}, '{{ $product->name }}', '{{ $product->price }}',{{ $product->stock }})"
                                    type="button" class="btn btn-success btn-cart"
                                    style="font-size: 12px; margin:8px;"> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="product_checkout" class="col-md-6 col-lg-6 d-none" style="margin-left: 10px">
                <div class="card border-0 position-relative"
                    style="border-radius: 16px; box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.1); overflow: d-none;">
                    <h6 class="card-header " style="background: white"> Produk Checkout </h6>
                    <div class="card-body">
                        <div id="group_product" class="list-group scrollable-list">

                        </div>

                        <div class="row mx-1 mt-3" style="border-bottom: 1px solid">
                            <div class="col-6" style="padding:8px">Total : </div>
                            <div id="productPrice" class="col-6 d-flex justify-content-end" style="padding:8px">0</div>
                        </div>

                        <div class="row mx-1 mt-3">
                            <button id="openModalButton" type="button"
                                class="btn btn-primary d-flex justify-content-center col-12" data-bs-toggle="modal"
                                data-bs-target="#selectPaymentModal">Checkout</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <di class="modal fade" id="selectPaymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="selectPaymentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="paymentModalLabel">Payment</h1>
                        <button onclick="onDismissModal()" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-center mb-4">Total Bill</h2>
                        <h1 id="paymentModalCurrency" class="text-center text-danger mb-5"></h1>

                        <h3 class="mb-3">Select Payment</h3>

                        <div class="list-group">
                            <a id="selectedCash" href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                data-bs-target="#paymentModalCash" data-bs-toggle="modal">
                                Cash
                                <i class="la la-chevron-right"></i>
                            </a>
                            <a id="selectedQris" href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                data-bs-target="#paymentModalCash" data-bs-toggle="modal">
                                Qris
                                <i class="la la-chevron-right"></i>
                            </a>
                            <a id="selectedOnline" href="#"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
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

    <div class="modal fade" id="paymentModalCash" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="paymentModalCashLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 id="paymentMethodTitle" class="modal-title"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <h2 class="text-center mb-4">Total Bill</h2>
                    <h1 id="paymentModalCurrencyCash" class="text-center text-danger mb-5"></h1>

                    <div class="input-group">
                        <span class="input-group-text">Uang yang diterima</span>
                        <input id="currencyPay" type="text" aria-label="currency" class="form-control">

                    </div>

                </div>
                <div class="modal-footer row mx-1">
                    <button onclick="onTransactionSubmited()" id="buttonPaymentCurrency"
                        class="btn btn-primary col-12">Terima</button>
                </div>
            </div>
        </div>
    </div>

    </div>


@endsection
@push('script')
    <script>
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        let ddMenuFlag = false;
        let timeoutId;
        let paymentModal;
        let cashModal;
        let query = {
            productName: ''
        }
        var product = [];
        let totalProduct = 0;
        let paymentMethod;
        var transaction = [];
        let transactioDetailModal;


        function onButtonAddProductClick(product_id, product_name, product_price, product_stock) {
            var findProduct = product.find(product => product.id == product_id);
            if (findProduct) {
                return;
            }
            product.push({
                id: product_id,
                name: product_name,
                price: product_price,
                stock: product_stock,
                quantity: 1
            });
            if (product.length != 0) {
                $('#product_checkout').removeClass('d-none');
                $('#group_product').empty();
                console.log(product);
                product.map(data =>
                    $('#group_product').prepend(`
                    <div id="view-product${data.id}"  class="row mx-1" style="border-bottom: 1px solid">
                        <div class="col-4">${data.name}</div>
                        <div class="col-4">${data.price}</div>
                        <div class="col-4" style="padding-left:6px;padding-right:6px;">
                            <div class="row">
                                <div class="row main align-items-center">
                                    <div class="col">
                                        <button  onclick="onDecrementClicked(${data.id})"  id="btn-decrement${data.id}" href="#" type="button" class="btn btn-outline-warning"
                                            style="padding: 8px">-</button><input type="text" id="inputproduk${data.id}" data-id="${data.id}" href="#" class="quantity-input border"
                                            style="width:50px; text-align: center;" value="${data.quantity}" disabled></input>
                                        <button onclick="onIncrementClicked(${data.id})" id="btn-increment${data.id}" type="button" class="btn btn-outline-warning" style="padding: 8px">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-1"> <span><i class="la la-close" style="font-size: 10px;"></i></span></div> --}}
                    </div>
                `)
                );
                totalProduct += parseInt(product_price);
                $('#productPrice').text(totalProduct);
            } else {
                $('#product_checkout').addClass('d-none');
                $('#group_product').empty();
            }
        }

        function onIncrementClicked(id) {
            var quantityInput = $('#inputproduk' + id).val();
            if (isNaN(parseInt(quantityInput))) {
                $('#inputproduk' + id).val(1);
                return
            }
            var quantity = parseInt(quantityInput) + 1;
            const foundProduct = product.find(item => item.id === id);
            const stockProduct = parseInt(foundProduct.stock);
            console.log("quantity : " + quantity + "stock : " + foundProduct.stock);
            if (quantity > stockProduct) {
                return
            }

            foundProduct.quantity = quantity;
            var productPrice = parseInt(foundProduct.price);
            totalProduct += productPrice;

            console.log(totalProduct);
            $('#productPrice').text(totalProduct);
            $('#inputproduk' + id).val(quantity);
        }

        function onDecrementClicked(id) {
            var quantityInput = $('#inputproduk' + id).val();
            if (isNaN(parseInt(quantityInput))) {
                return
            }
            var quantity = parseInt(quantityInput) - 1;
            if (quantity == 0) {
                const foundProduct = product.find(item => item.id === id);
                var productPrice = parseInt(foundProduct.price);
                totalProduct -= productPrice;
                console.log(foundProduct);
                product = product.filter(item => item.id !== id);

                if (product.length == 0) {
                    totalProduct = 0;
                    $('#product_checkout').addClass('d-none');
                } else {
                    $('#view-product' + id).remove();
                }
                $('#productPrice').text(totalProduct);
            } else {
                const foundProduct = product.find(item => item.id === id);
                foundProduct.quantity = quantity
                var productPrice = parseInt(foundProduct.price);
                totalProduct -= productPrice;

                console.log(totalProduct);
                $('#productPrice').text(totalProduct);
                $('#inputproduk' + id).val(quantity);
            }
        }

        function handleSearch() {
            $.ajax({
                url: "{{ route('transaction.search') }}",
                type: 'GET',
                /* send the csrf-token and the input to the controller */
                data: {
                    _token: CSRF_TOKEN,
                    queryParam: {
                        productName: query.productName,
                    }
                },
                success: function(response) {
                    if (!!response?.data?.length) {
                        console.log(response.data)
                        $('#not_found').addClass('d-none');
                        $('#view_product').addClass('d-none');
                        $('#content_view_search').removeClass('d-none');
                        $('#content_view_search').empty();
                        console.log($('#not_found'));
                        response?.data?.map((item) => {
                            const imageUrl = item.image ? `${item.image}` : '';
                            const limitedName = item.name.length > 50 ?
                                `${item.name.substring(0, 50)}...` : item
                                .name; // JavaScript equivalent of Str::limit
                            const price = item.price ? item.price :
                                'N/A'; // Ensure there's no undefined price
                            $('#content_view_search').append(`
                      <div  class="list-group col-12 " style="margin-left:10px; margin-bottom:8px;">
                        <div id="view-product"  class=" row border-end-0 border custom_rounded " style="background: white; padding:10px">
                            <div class="col-3">
                            <img class="card-img-top" src="${imageUrl}" style="object-fit: cover; width:50px;height:50px;" alt="Card image cap" >
                            </div>
                            <div class="col-3 text-center align-items-center" style="padding-top: 15px;">
                            ${limitedName}
                            </div>
                            <div class="col-3 text-center align-items-center" style="padding-top: 15px;">
                            ${price}
                            </div>
                            <div class="col-3">
                                <button
                                onclick="onButtonAddProductClick(${item.id}, '${item.name}', ${item.price}, ${item.stock})" type="button"
                                class="btn btn-outline-primary btn-cart" style="font-size: 12px; margin:8px;"> Tambah</button>
                            </div>
                        </div>
                      </div>
                    `);
                        });
                    } else {
                        $('#not_found').removeClass('d-none');
                        $('#view_product').addClass('d-none');
                        $('#content_view_search').addClass('d-none');
                    }
                },
                error: function(xhr) {
                    console.log(xhr)
                }
            });
        }

        function onTransactionSubmited() {
            var cashPay = $('#currencyPay').val();
            var paymentMethod = $('#paymentMethodTitle').text();
            transaction.push({
                products_payment: product,
                total_product: totalProduct,
                cash_pay: cashPay,
                payment_method: paymentMethod,
            });
            const CSRF_TOKENS = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('transaction.submit') }}",
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKENS // Send CSRF token in headers
                },
                contentType: 'application/json', // Set content type to JSON
                data: JSON.stringify(transaction), // Convert data to JSON string
                success: function(response) {
                    const transaction = response.transaction;
                    const transactionDetails = response.transaction_details;
                    const cashback = parseInt(transaction.money_received) - parseInt(transaction
                        .total_transaction);
                    const convertedDate = dayjs(transaction.created_at).format('DD/MM/YYYY  HH:mm:ss');
                    const invoiceNumber = `${transaction.transaction_number.substring(0, 10)}...`
                    console.log('Response:', response.transaction);
                    console.log('Response:', response.transaction_details);
                    onShowDialog(transaction.id);
                    transactioDetailModal = `<div class="modal fade" id="receiptModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="receiptModalLabel">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="receiptModalLabel">Receipt</h5>
                                                    <button onclick="reloadPage()" type="button" class="btn-close"  id="reloadButton" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-center mb-4">
                                                            <h3>Rapid Babershop</h3>
                                                            <p class="text-muted">${response.branch_name}</p>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-6">
                                                            <p><strong>Kasir:</strong> ${response.cashier_name}</p>
                                                            <p><strong>Waktu:</strong> ${convertedDate}</p>
                                                            </div>
                                                            <div class="col-6 text-end" >
                                                            <p class="d-flex justify-content-end"><strong>No. Struk:</strong>${invoiceNumber}</p>
                                                            <p class="d-flex justify-content-end"><strong>Jenis Pembayaran:</strong> ${transaction.payment_method}</p>
                                                            </div>
                                                        </div>
                                                        <h5 class="text-center mb-3">### PAID ###</h5>
                                                        ${transactionDetails.map((item) => {
                                                        return  `
                                                                    <div class="d-flex justify-content-between">
                                                                        <strong>${item.product_name}</strong>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between">
                                                                        <span>${item.product_price} x ${item.quantity}</span>
                                                                        <span>${item.total}</span>
                                                                    </div>
                                                                    `
                                                        }).join('')}
                                                        <div class="d-flex justify-content-between mt-2">
                                                            <span>Kembali</span>
                                                            <span>${cashback}</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between mt-2">
                                                         <a href="/transaction/export/${transaction.id}" type="button" class="btn btn-success col-12 print-btn" data-bs-dismiss="modal">Print</a>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                     <p class="text-muted">Powered by Rapid BaberShop</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`

                },
                error: function(xhr) {
                    console.log(xhr)
                }
            });
        }

        function showDetailTransaction() {
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

        function onShowDialog(transaction_id) {
            console.log(transaction_id);
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('transaction.dialog') }}",
                method: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    queryParam: {
                        transaction_id: transaction_id,
                    }
                },
                success: function(response) {
                    $('body').append(response);
                    $('#receiptModal').modal('show');
                },
                error: function() {
                    alert('An error occurred while loading the dialog.');
                }
            });
        }

        function reloadPage() {
            console.log('ds');
            location.reload();
        }

        const setSearch = (field, value) => {
            $('#content_view_search').empty();
            if (value.length === 0) {
                query = {
                    ...query,
                    [field]: value
                };
                $('#not_found').addClass('d-none');
                $('#view_product').removeClass('d-none');
                $('#content_view_search').addClass('d-none');
                return;
            }
            query = {
                ...query,
                [field]: value
            }
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                handleSearch()
            }, 500);
        }

        $(document).ready(function() {
            const isProductAvailable = $('#is_product_available').val();

            $('#reloadButton').click(function() {
                 console.log('onclose');
                 reloadPage();
            });

            if (!isProductAvailable) {
                $('#not_found').removeClass('d-none');
            }else{
                $('#not_found').addClass('d-none');
            }

            $('#buttonPaymentCurrency').prop('disabled', true);

            $('#searchProduct').on('input', debounce(function() {
                let searchValue = $(this).val();
                setSearch('productName', searchValue)
            }, 500));

            function debounce(func, wait) {
                let timeout;
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }

            $('#currencyPay').on('input', function() {
                // Get the input value
                let inputValue = $(this).val();
                // Remove non-numeric characters (except for the decimal point)
                inputValue = inputValue.replace(/[^0-9]/g, '');
                // Convert to Rupiah format
                let formattedValue = formatRupiah(inputValue);
                if (parseInt(inputValue) >= parseInt(totalProduct)) {
                    $('#buttonPaymentCurrency').prop('disabled', false);
                } else {
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

        });

        var selectPaymentModal = document.getElementById('selectPaymentModal');
        selectPaymentModal.addEventListener('shown.bs.modal', function() {
            var rupiah = totalProduct.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
            $('#paymentModalCurrency').text(rupiah);
        });

        var paymentModalCash = document.getElementById('paymentModalCash');
        paymentModalCash.addEventListener('shown.bs.modal', function() {
            console.log(paymentMethod);
            var rupiah = totalProduct.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
            $('#paymentMethodTitle').text(paymentMethod);
            $('#paymentModalCurrencyCash').text(rupiah);
        });

        $(document).on('input', '.quantity-input', function() {
            var product_id = $(this).data('id'); // Extract product_id from the input's id
            var quantityValue = $('#inputproduk' + product_id).val();
            if (isNaN(parseInt(quantityValue))) {
                return
            }
            console.log('quatity : ' + parseInt(quantityValue));
            const foundProduct = product.find(item => item.id === product_id);
            foundProduct.quantity = quantityValue;
            if (parseInt(quantityValue) === 0) {
                product = product.filter(item => item.id !== product_id);
                totalProduct = 0;
                product.map((item) => {
                    var productPrice = parseInt(item.price) * parseInt(item.quantity);
                    totalProduct += productPrice
                })
                if (product.length == 0) {
                    totalProduct = 0;
                    $('#product_checkout').addClass('d-none');
                } else {
                    $('#view-product' + product_id).remove();
                }
            } else {
                totalProduct = 0;
                product.map((item) => {
                    var productPrice = parseInt(item.price) * parseInt(item.quantity);
                    totalProduct += productPrice
                })
            }
            if (!isNaN(totalProduct)) {
                $('#productPrice').text(totalProduct);
                console.log(totalProduct);
            }
        });
    </script>
@endpush
