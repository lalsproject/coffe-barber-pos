@extends('layouts.admin.base-dashboard')

@section('title', 'Revenue Report by Branch')

@section('content')

    @include('layouts.admin.include.message')

    @role('admin')
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="mb-0 mx-auto" style="font-weight: 600;">Revenue Report by Branch</h1>
            </div>
            <div class="card-body mt-4">
                {{-- Filter Date --}}
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-inline mb-4" action="{{ route('transaction.home') }}" method="GET">
                            {{-- Start Date --}}
                            <div class="input-group mb-2 mr-sm-2">
                                <label class="sr-only" for="start_date">Start Date</label>
                                <input type="text" name="start_date" id="start_date"
                                    class="form-control start_date @error('start_date') is-invalid @enderror"
                                    value="{{ old('start_date', isset($start_date) ? $start_date : date('Y-m-d')) }}" readonly>
                            </div>

                            {{-- End Date --}}
                            <div class="input-group mb-2 mr-sm-2">
                                <label class="sr-only" for="end_date">End Date</label>
                                <input type="text" name="end_date" id="end_date"
                                    class="form-control end_date @error('end_date') is-invalid @enderror"
                                    value="{{ old('end_date', isset($end_date) ? $end_date : date('Y-m-d')) }}" readonly>
                            </div>

                            {{-- Branch Select --}}
                            <div class="input-group mb-2 mr-sm-2">
                                <label class="sr-only" for="branch_id">Branch</label>
                                <select name="branch" id="branch_id"
                                    class="form-control @error('branch') is-invalid @enderror">
                                    <option value="">-- Pilih Cabang --</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ old('branch') == $branch->id || (isset($branch_id) && $branch_id == $branch->id) ? 'selected' : '' }}>
                                            {{ $branch->branch }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Error message for branch --}}
                            @error('branch')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror

                            {{-- Submit Button --}}
                            <button type="submit" class="btn btn-primary mb-2 text-white">
                                <i class="la la-search text-white"></i> Filter
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Cards for Revenue Information --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="row m-0">
                            {{-- Total Sales --}}
                            <div class="col-md-12 col-lg-6 col-xl-3">
                                <div class="card-body">
                                    <div class="icon-rounded icon-rounded-success float-left m-r-20"
                                        style="background-color: rgba(40, 167, 69, 0.4);">
                                        <i class="la la-money f-w-600" style="color: #155d27;"></i>
                                    </div>
                                    <h6 class="text-muted m-t-10" style="color: #155d27;">Total Penjualan (Rp)</h6>
                                    <h5 class="card-title m-b-5 counter" data-count="{{ $total_selling }}"
                                        style="color: #155d27;">0</h5>
                                </div>
                            </div>

                            {{-- Total Profit --}}
                            <div class="col-md-12 col-lg-6 col-xl-3">
                                <div class="card-body">
                                    <div class="icon-rounded icon-rounded-info float-left m-r-20"
                                        style="background-color: rgba(23, 162, 184, 0.4);">
                                        <i class="la la-money f-w-600" style="color: #0d6e7d;"></i>
                                    </div>
                                    <h6 class="text-muted m-t-10" style="color: #0d6e7d;">Total Keuntungan (Rp)</h6>
                                    <h5 class="card-title m-b-5 counter" data-count="{{ $total_selling }}"
                                        style="color: #0d6e7d;">0</h5>
                                </div>
                            </div>

                            {{-- Total Transactions --}}
                            <div class="col-md-12 col-lg-6 col-xl-3">
                                <div class="card-body">
                                    <div class="icon-rounded icon-rounded-secondary float-left m-r-20"
                                        style="background-color: rgba(108, 117, 125, 0.4);">
                                        <i class="la la-money f-w-600" style="color: #495057;"></i>
                                    </div>
                                    <h6 class="text-muted m-t-10" style="color: #495057;">Total Transaksi</h6>
                                    <h5 class="card-title m-b-5 counter" data-count="{{ $total_transaction }}"
                                        style="color: #495057;">0</h5>
                                </div>
                            </div>

                            {{-- Total Products Sold --}}
                            <div class="col-md-12 col-lg-6 col-xl-3">
                                <div class="card-body">
                                    <div class="icon-rounded icon-rounded-info float-left m-r-20"
                                        style="background-color: rgba(161, 242, 57, 0.4);">
                                        <i class="la la-money f-w-600" style="color: #4d8c1e;"></i>
                                    </div>
                                    <h6 class="text-muted m-t-10" style="color: #4d8c1e;">Total Terjual</h6>
                                    <h5 class="card-title m-b-5 counter" data-count="{{ $total_product_selling }}"
                                        style="color: #4d8c1e;">0</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole


    @role('inventory')
        <p>Inventory</p>
    @endrole

    @role('cashier')
        <h1>Hi {{ Auth::user()->name }}</h1>
        <div class="card">
            <div class="card-header d-flex justify-content-end">
                <button id='btnCloseStore' type="submit" class="btn btn-primary mb-2 invisible text-white"
                    data-bs-toggle="modal" data-bs-target="#depositClose">
                    <i class="la la-industry text-white"></i> Tutup Toko
                </button>
            </div>
            <div class="card-body">
                <div class="card-body">
                    {{-- Filter Date --}}
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-inline mb-4" action="{{ route('transaction.home') }}" method="GET">
                                <label class="sr-only" for="start_date">Start Date</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input type="text" name="start_date" id="start_date"
                                        class="form-control start_date
                                    @error('start_date') is-invalid @enderror"
                                        value="{{ old('start_date', isset($start_date) ? $start_date : date('Y-m-d')) }}"
                                        readonly>
                                </div>

                                <label class="sr-only" for="start_date">End Date</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input type="text" name="end_date" id="end_date"
                                        class="form-control end_date
                                    @error('end_date') is-invalid @enderror"
                                        value="{{ old('end_date', isset($end_date) ? $end_date : date('Y-m-d')) }}" readonly>
                                </div>
                                
                                <div class="input-group mb-2 mr-sm-2 @error('branch') has-error @enderror">
                                    <select name="branch" id="branch_id"
                                        class="form-control @error('branch') has-error @enderror">
                                        <option value="">-- Pilih Cabang --</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ old('branch') == $branch->id || (isset($branch_id) && $branch_id == $branch->id) ? 'selected' : '' }}>
                                                {{ $branch->branch }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <div class="text-danger">
                                            <small class="col-md-8">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary mb-2 text-white">
                                    <i class="la la-search text-white"></i> Filter
                                </button>


                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="row m-0 col-border-xl">
                                <div class="col-md-12 col-lg-6 col-xl-3">
                                    <div class="card-body">
                                        <div class="icon-rounded icon-rounded-success float-left m-r-20">
                                            <i class="la la-money f-w-600"></i>
                                        </div>
                                        <h6 class="text-muted m-t-10">
                                            Total Penjualan (Rp)
                                        </h6>
                                        <h5 class="card-title m-b-5 counter" data-count="{{ $total_selling }}">0</h5>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-3">
                                    <div class="card-body">
                                        <div class="icon-rounded icon-rounded-success` float-left m-r-20">
                                            <i class="la la-money f-w-600"></i>
                                        </div>
                                        <h6 class="text-muted m-t-10">
                                            Total Keuntungan (Rp)
                                        </h6>
                                        <h5 class="card-title m-b-5 counter" data-count="{{ $total_selling }}">0</h5>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-3">
                                    <div class="card-body">
                                        <div class="icon-rounded icon-rounded-primary float-left m-r-20">
                                            <i class="la la-money f-w-600"></i>
                                        </div>
                                        <h6 class="text-muted m-t-10">
                                            Total Transaksi
                                        </h6>
                                        <h5 class="card-title m-b-5 counter" data-count="{{ $total_transaction }}">0</h5>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-3">
                                    <div class="card-body">
                                        <div class="icon-rounded icon-rounded-info float-left m-r-20"
                                            style="background-color: rgb(161 242 57 / 40%);">
                                            <i class="la la-money f-w-600"></i>
                                        </div>
                                        <h6 class="text-muted m-t-10">
                                            Total Terjual
                                        </h6>
                                        <h5 class="card-title m-b-5 counter" data-count="{{ $total_product_selling }}">0</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="is_deposit" name="is_deposit" value="{{ $is_deposit }}">
        <input type="hidden" id="is_btn_visible" name="is_btn_visible" value="{{ $is_btn_visible }}">
        <div class="modal fade" id="depositModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 id="paymentMethodTitle" class="modal-title">Open Store</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <span class="input-group-text">Money Deposit</span>
                            <input id="currencyDeposit" type="text" aria-label="currency" class="form-control">
                        </div>

                        <div class="input-group @error('branch') has-error @enderror mt-3">
                            <label for="branch" class="input-group-text">Cabang</label>
                            <select name="branch" id="branch_store"
                                class="form-control @error('branch') has-error @enderror">
                                <option value="">-- Pilih Cabang --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->branch }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="text-danger">
                                    <small class="col-md-8">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="input-group @error('type') has-error @enderror mt-3">
                            <label for="type" class="input-group-text">Type</label>
                            <select name="type" id="type" class="form-control @error('type') has-error @enderror">
                                <option value="">-- Choose Type --</option>
                                <option value="CASH_IN">
                                    CASH IN
                                </option>
                                <option value="CASH_OUT">
                                    CASH OUT
                                </option>
                            </select>

                            @error('type')
                                <div class="text-danger">
                                    <small class="col-md-8">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer row mx-1">
                        <button onclick="onDepositSubmit()" id="buttonPaymentCurrency"
                            class="btn btn-primary col-12">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="depositClose" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 id="paymentMethodTitle" class="modal-title">Close Store</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <span class="input-group-text">Money Revenue</span>
                            <input id="currencyClosingInput" type="text" aria-label="currency" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer row mx-1">
                        <button onclick="onCloseStoreSubmit()" id="buttonPaymentCurrency"
                            class="btn btn-primary col-12">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    @endrole

@endsection

@push('script')
    <script>
        var deposit = [];
        let branchSelected;
        let currencyDeposit;
        let currencyClosing;
        let typeDeposit;

        $(document).ready(function() {
            const depositModal = new bootstrap.Modal($('#depositModal'));
            const isDeposit = $('#is_deposit').val();
            const isVisibleBtn = $('#is_btn_visible').val();
            if (!isDeposit) {
                depositModal.show();
            }

            if (!isVisibleBtn) {
                $('#btnCloseStore').removeClass('invisible');
            } else {
                $('#btnCloseStore').addClass('invisible');
            }



            $('#currencyDeposit').on('input', function() {
                // Get the input value
                let inputValue = $(this).val();
                // Remove non-numeric characters (except for the decimal point)
                inputValue = inputValue.replace(/[^0-9]/g, '');
                currencyDeposit = inputValue;
                // Convert to Rupiah format
                let formattedValue = formatRupiah(inputValue);
                $(this).val(formattedValue);
            });


            $('#currencyClosingInput').on('input', function() {
                // Get the input value
                let inputValue = $(this).val();
                // Remove non-numeric characters (except for the decimal point)
                inputValue = inputValue.replace(/[^0-9]/g, '');
                currencyClosing = inputValue;
                // Convert to Rupiah format
                let formattedValue = formatRupiah(inputValue);
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

            $('.start_date').datepicker({
                format: 'yyyy-mm-dd',
                orientation: "top auto",
                autoclose: true,
                todayHighlight: false,
                todayBtn: false
            });

            $('.end_date').datepicker({
                format: 'yyyy-mm-dd',
                orientation: "top auto",
                autoclose: true,
                todayHighlight: false,
                todayBtn: false
            });
        });

        $('#branch_store').change(function() {
            let selectedValue = $(this).val(); // Get the selected value
            let selectedText = $(this).find('option:selected').text(); // Get the selected text

            branchSelected = selectedValue;
            console.log('Selected Value:', selectedValue);
            console.log('Selected Text:', selectedText);
        });

        $('#type').change(function() {
            let selectedValue = $(this).val(); // Get the selected value
            let selectedText = $(this).find('option:selected').text(); // Get the selected text

            typeDeposit = selectedValue;
            console.log('Selected Value:', selectedValue);
            console.log('Selected Text:', selectedText);
        });

        function onDepositSubmit() {
            deposit.push({
                id_branch: branchSelected,
                amount: currencyDeposit,
                type: typeDeposit,
            });
            console.log(deposit);
            const CSRF_TOKENS = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('transaction.deposit') }}",
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKENS // Send CSRF token in headers
                },
                contentType: 'application/json', // Set content type to JSON
                data: JSON.stringify(deposit), // Convert data to JSON string
                success: function(response) {
                    console.log('Response:', response);
                    console.log(depositModal);
                    $('#depositModal').modal('hide');
                },
                error: function(xhr) {
                    console.log(xhr)
                }
            });
        }

        function onCloseStoreSubmit() {
            const CSRF_TOKENS = $('meta[name="csrf-token"]').attr('content');
            console.log(currencyClosing);
            $.ajax({
                url: "{{ route('transaction.close-store') }}",
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKENS // Send CSRF token in headers
                },
                contentType: 'application/json', // Set content type to JSON
                data: currencyClosing, // Convert data to JSON string
                success: function(response) {
                    console.log('Response:', response);
                    $('#depositClose').modal('hide');
                },
                error: function(xhr) {
                    console.log(xhr)
                }
            });
        }
        $(function() {
            $('#productName').keyup(function() {
                $(this).val($(this).val().toUpperCase());
            });

            $("#branch_id").select2({
                tags: false
            });

            $('#productDescription').keyup(function() {
                $(this).val($(this).val().toUpperCase());
            });
        });
    </script>
@endpush
