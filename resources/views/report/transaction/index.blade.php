@extends('layouts.admin.base-dashboard')

@section('title', 'Daily Revenue Report POS')

@section('content')
    @include('layouts.admin.include.message')

    <div class="card shadow-sm border-light">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0 mx-auto" style="font-weight: 600;">Daily Revenue Report POS</h1>
        </div>
        <div class="card-body mt-4">
            {{-- Filter Date --}}
            <div class="row">
                <div class="col-md-7">
                    <form class="form-inline mb-4" action="{{ route('report.search') }}" method="GET">
                        <input type="hidden" id="type_transaction" name="type_transaction" value="daily_revenue">
                        <label class="sr-only" for="start_date">Date</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <input type="text" name="start_date" id="start_date"
                                class="form-control start_date
                                @error('start_date') is-invalid @enderror"
                                value="{{ old('start_date', isset($start_date) ? $start_date : date('Y-m-d')) }}" readonly>
                        </div>

                        <label class="sr-only" for="start_date">End Date</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <input type="text" name="end_date" id="end_date"
                                class="form-control end_date
                                @error('end_date') is-invalid @enderror"
                                value="{{ old('end_date', isset($end_date) ? $end_date : date('Y-m-d')) }}" readonly>
                        </div>

                        <div class="input-group @error('branch') has-error @enderror mb-2 mr-sm-2">
                            <select name="branch" id="branch_id" class="form-control @error('branch') has-error @enderror">
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

                        <div class="input-group @error('user') has-error @enderror mb-2 mr-sm-2">
                            <select name="user" id="user_id" class="form-control @error('user') has-error @enderror">
                                <option value="">-- Pilih Cashier --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user') == $user->id || (isset($user_id) && $user_id == $user->id) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="text-danger">
                                    <small class="col-md-8">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mb-2" style="color: #fff;">
                            <i class="la la-search" style="color: #fff;"></i> Filter
                        </button>

                        <button type="submit" name="action" class="btn btn-success mb-2 ml-1"
                            style="color: #fff; font-weight: bold;" value="export-pdf">
                            <i class="la la-file-pdf-o" style="color: #fff; font-size: 1.3em;"></i> Export PDF
                        </button>
                    </form>
                </div>

                <div class="col-md-1">
                    <form action="{{ route('report.today') }}" method="GET">
                        <button type="submit" class="btn btn-primary mb-2" style="color: #fff;">
                            <i class="la la-eye" style="color: #fff;"></i> Today
                        </button>
                    </form>
                </div>

                <div class="col-md-1 ml-2">
                    <form action="{{ route('report.weekly') }}" method="GET">
                        <button type="submit" class="btn btn-primary mb-2" style="color: #fff;">
                            <i class="la la-eye" style="color: #fff;"></i> Weekly
                        </button>
                    </form>
                </div>

                <div class="col-md-1 ml-2">
                    <form action="{{ route('report.monthly') }}" method="GET">
                        <button type="submit" class="btn btn-primary mb-2" style="color: #fff;">
                            <i class="la la-eye" style="color: #fff;"></i> Monthly
                        </button>
                    </form>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table id="bs4-table" class="table table-striped table-bordered table-hover" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th>Nomor Invoice</th>
                            <th>Payment Method</th>
                            <th>Transaction Date</th>
                            <th>Status</th>
                            <th>Total Transaction</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaction->transaction_number }}</td>
                                <td>{{ $transaction->payment_method }}</td>
                                <td>{{ date('d F Y', strtotime($transaction->created_at)) }}</td>
                                <td>
                                    <span style="font-size: 1em; font-weight: bold;"
                                        class="badge badge-{{ $transaction->status == 'paid' ? 'success' : 'danger' }}">
                                        {{ ucwords($transaction->status) }}
                                    </span>
                                </td>
                                <td>
                                    Rp. {{ number_format($transaction->total_transaction, 0, ',', '.') }}
                                </td>
                                <td>
                                    <button onclick="onShowDialog({{ $transaction->id }})" type="submit"
                                        class="btn btn-primary mb-2" style="color: #fff;">
                                        <i class="la la-search" style="color: #fff;"></i> Lihat
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="dialogContainer"></div>
@endsection

@push('script')
    <script>
        $(function() {
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
        })

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
        $(function() {
            $('#productName').keyup(function() {
                $(this).val($(this).val().toUpperCase());
            });

            $("#branch_id").select2({
                tags: false
            });

            $("#user_id").select2({
                tags: false
            });

            $('#productDescription').keyup(function() {
                $(this).val($(this).val().toUpperCase());
            });
        });
    </script>
@endpush
