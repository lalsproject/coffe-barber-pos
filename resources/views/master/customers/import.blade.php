@extends('layouts.admin.base-dashboard')

@section('title', 'Import Customer - Excel')

@section('content')
@include('layouts.admin.include.message')

<div class="card">
    <form action="{{ route('customers.importProcess') }}" method="POST"
        class="form-horizontal needs-validation" enctype="multipart/form-data">
        @csrf
        <h5 class="card-header">Import Customers - Excel</h5>
        <div class="card-body">
            <div class="form-body">
                <div class="form-group row @error('file') has-error @enderror">
                    <label for="file" class="control-label text-right col-md-3">File</label>
                    <div class="col-md-5">
                        <input type="file" name="file" id="file" class="form-control
                            @error('file') has-error @enderror" value="{{ old('file') }}">

                        @error('file')
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
                                    <i class="la la-save" style="color: #fff; font-size: 1.5em;"></i> Import
                                </button>
                                <a href="{{ asset('excel_templates/template_import_data_customers.xlsx') }}"
                                    class="btn btn-success btn-rounded text-white">
                                    <i class="la la-download" style="color: #fff; font-size: 1.5em;"></i> Download Import Template
                                </a>
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