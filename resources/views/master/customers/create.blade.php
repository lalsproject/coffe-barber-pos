@extends('layouts.admin.base-dashboard')

@section('title', 'Create Customer')

@section('content')
<div class="card">
    <form action="{{ route('customers.store') }}" method="POST"
        class="form-horizontal needs-validation">
        @csrf
        <h5 class="card-header">Create Pelanggan</h5>
        <div class="card-body">
            <div class="form-body">
                <div class="form-group row @error('name') has-error @enderror">
                    <label class="control-label text-right col-md-3">Name</label>
                    <div class="col-md-5">
                        <input type="text" name="name" id="customerName"
                            class="form-control @error('name') has-error @enderror" autocomplete="name"
                            value="{{ old('name') }}">

                        @error('name')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

            
                <div class="form-group row @error('email') has-error @enderror">
                    <label class="control-label text-right col-md-3">Email</label>
                    <div class="col-md-5">
                        <input type="email" name="email"
                            class="form-control @error('email') has-error @enderror" autocomplete="email"
                            value="{{ old('email') }}">

                        @error('email')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('phone') has-error @enderror">
                    <label class="control-label text-right col-md-3">Phone</label>
                    <div class="col-md-5">
                        <input type="phone" name="phone"
                            class="form-control @error('phone') has-error @enderror" autocomplete="phone"
                            value="{{ old('phone') }}">

                        @error('phone')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>


                <div class="form-group row @error('address') has-error @enderror">
                    <label class="control-label text-right col-md-3">Address</label>
                    <div class="col-md-5">
                        <textarea name="address" id="customerAddress" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>

                        @error('address')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
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
                                <a href="{{ route('customers.index') }}" class="btn btn-info btn-rounded"
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
        $(function () {
            $('#customerName').keyup(function() {
		        $(this).val($(this).val().toUpperCase());
	        });

            $('#customerCompany').keyup(function() {
		        $(this).val($(this).val().toUpperCase());
	        });

            $('#customerAddress').keyup(function() {
		        $(this).val($(this).val().toUpperCase());
	        });

            $(".province_id").select2({
                tags: false
            });

            $(".city_id").select2({
                tags: false
            });
        });
    </script>
@endpush