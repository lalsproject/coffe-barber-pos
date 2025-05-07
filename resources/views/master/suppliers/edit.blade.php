@extends('layouts.admin.base-dashboard')

@section('title', 'Edit Suppliers')

@section('content')
<div class="card">
    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST"
        class="form-horizontal needs-validation">
        @csrf
        @method('PATCH')

        <h5 class="card-header">Edit Suppliers</h5>
        <div class="card-body">
            <div class="form-body">
                <div class="form-group row @error('name') has-error @enderror">
                    <label class="control-label text-right col-md-3">Name</label>
                    <div class="col-md-5">
                        <input type="text" name="name" id="supplierName"
                            class="form-control @error('name') has-error @enderror" autocomplete="name"
                            value="{{ old('name', $supplier->name) }}">

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
                            value="{{ old('email', $supplier->email) }}">

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
                            value="{{ old('phone', $supplier->phone) }}">

                        @error('phone')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('contact_person') has-error @enderror">
                    <label class="control-label text-right col-md-3">PIC / Contact Person</label>
                    <div class="col-md-5">
                        <input type="text" name="contact_person" id="supplierContactPerson"
                            class="form-control @error('contact_person') has-error @enderror" autocomplete="contact_person"
                            value="{{ old('contact_person', $supplier->contact_person) }}">

                        @error('contact_person')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>


                <div class="form-group row @error('bank_info') has-error @enderror">
                    <label class="control-label text-right col-md-3">Bank Info</label>
                    <div class="col-md-5">
                        <textarea name="bank_info" id="bank_info" class="form-control @error('bank_info') is-invalid @enderror">{{ old('bank_info', $supplier->bank_info) }}</textarea>

                        @error('bank_info')
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
                                    <i class="la la-save" style="color: #fff; font-size: 1.5em;"></i> Update
                                </button>
                                <a href="{{ route('suppliers.index') }}" class="btn btn-info btn-rounded"
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
            $(".country_id").select2({
                tags: false
            });

            $(".province_id").select2({
                tags: false
            });

            $(".city_id").select2({
                tags: false
            });

            $(".currency_code").select2({
                tags: false
            });

            $('#supplierName').keyup(function() {
		        $(this).val($(this).val().toUpperCase());
	        });

            $('#supplierContactPerson').keyup(function() {
		        $(this).val($(this).val().toUpperCase());
	        });
        });
    </script>
@endpush
