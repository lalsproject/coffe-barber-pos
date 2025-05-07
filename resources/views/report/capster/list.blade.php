@extends('layouts.admin.base-dashboard')

@section('title', 'Daftar Struk Capster')

@section('content')
    @include('layouts.admin.include.message')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0 mx-auto" style="font-weight: 600;">Daftar Struk Capster</h1>
        </div>
        <div class="card-body">
            <div class="card-body">
                {{-- Filter Date --}}
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-inline mb-4" action="{{ route('capster.report.search') }}" method="GET">
                            <input type="hidden" id="type_transaction" name="type_transaction" value="list_transaction">
                            <label class="sr-only" for="start_date">Date</label>
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

                            <div class="input-group @error('branch') has-error @enderror mb-2 mr-sm-2">
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

                            <div class="input-group @error('user') has-error @enderror mb-2 mr-sm-2">
                                <select name="user" id="user_id"
                                    class="form-control @error('user') has-error @enderror">
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

                            <div class="input-group @error('capster') has-error @enderror mb-2 mr-sm-2">
                                <select name="capster" id="capster_id"
                                    class="form-control @error('capster') has-error @enderror">
                                    <option value="">-- Pilih Capster --</option>
                                    @foreach ($capsters as $capster)
                                        <option value="{{ $capster->id }}"
                                            {{ old('capster') == $capster->id || (isset($capster_id) && $capster_id == $capster->id) ? 'selected' : '' }}>
                                            {{ $capster->name }}
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
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table id="bs4-table" class="table table-striped table-bordered" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th>Nama Capster</th>
                            <th>Nama Layanan</th>
                            <th>Metode Pembayaran</th>
                            <th>Tanggal Transaksi</th>
                            <th>Status</th>
                            <th>Total Transaksi</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @foreach ($transactionDetails as $transactionDetail)
                                    <td>{{ $transactionDetail['capsterName']->name }}</td>
                                    <td>
                                        @foreach ($transactionDetail['serviceNames'] as $service)
                                            {{ $service }}
                                        @endforeach
                                    </td>
                                @endforeach
                                <td>{{ $transaction->payment_method }}</td>
                                <td>{{ date('d F Y', strtotime($transaction->created_at)) }}</td>
                                <td>
                                    <span style="font-size: 1em; font-weight: bold;"
                                        class="badge badge-{{ $transaction->status == 'paid' ? 'success' : 'danger' }}">
                                        {{ ucwords($transaction->status) }}
                                    </span>
                                </td>
                                <td>
                                    Rp. {{ number_format($transaction->total, 0, ',', '.') }}
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

        <div id="dialogContainer"></div>
    </div>
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
                url: "{{ route('transaction.capster.dialog') }}",
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

            $("#capster_id").select2({
                tags: false
            });

            $('#productDescription').keyup(function() {
                $(this).val($(this).val().toUpperCase());
            });
        });
    </script>
@endpush
