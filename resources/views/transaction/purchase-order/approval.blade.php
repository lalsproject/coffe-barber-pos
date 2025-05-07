@extends('layouts.admin.base-dashboard')

@section('title', 'Create Approval (Purchase Order)')

@section('content')
@include('layouts.admin.include.message')
<div class="card">
    <form action="{{ route('purchase-orders.approvedWithSoNumber', $purchaseOrder->id) }}" method="POST"
        class="form-horizontal needs-validation">
        @csrf
        <h5 class="card-header">Create Approval (Purchase Order)</h5>
        <div class="card-body">
            <div class="form-body">
                <div class="form-group row @error('so_number') has-error @enderror">
                    <label class="control-label text-right col-md-3">SO Number</label>
                    <div class="col-md-5">
                        <input type="text" name="so_number"
                            class="form-control @error('so_number') has-error @enderror" autocomplete="so_number"
                            value="{{ old('so_number') }}">

                        @error('so_number')
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
                                    <i class="la la-save" style="color: #fff; font-size: 1.5em;"></i> Submit
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