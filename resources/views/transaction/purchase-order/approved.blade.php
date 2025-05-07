@extends('layouts.admin.base-dashboard')

@section('title', 'Create Approval (Purchase Order)')

@section('content')
@include('layouts.admin.include.message')
<div class="card">
    <form action="{{ route('purchase-orders.approved', $purchaseOrderId) }}" method="POST"
        class="form-horizontal needs-validation">
        @csrf
        @method('PATCH')

        <h5 class="card-header">Create Approval (Purchase Order)</h5>
        <div class="card-body">
            <div class="form-body">
                <div class="form-group row @error('status') has-error @enderror">
                    <label for="status" class="control-label text-right col-md-3">Status</label>
                    <div class="col-md-3">
                        <select name="status" id="status"
                            class="form-control status @error('status') has-error @enderror">
                            <option value="">-- Choose Status --</option>
                            <option value="approved" 
                                {{ $purchaseOrder->status == 'approved' ? 'selected' : '' }}>
                                Approved
                            </option>
                            <option value="completed"
                                {{ $purchaseOrder->status == 'completed' ? 'selected' : '' }}>
                                Completed
                            </option>
                        </select>

                        @error('status')
                            <div class="text-danger">
                                <small class="col-md-8">{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('notes') has-error @enderror">
                    <label class="control-label text-right col-md-3">Notes</label>
                    <div class="col-md-5">
                        <input type="text" name="notes"
                            class="form-control @error('name') has-error @enderror" id="notes" autocomplete="name"
                            value="{{ old('notes', $purchaseOrder->notes) }}" required {{ $purchaseOrder->status == 'completed' ? 'readonly' : '' }}>

                        @error('notes')
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
                                <a href="{{ route('purchase-orders.detail-approval', $purchaseOrderId) }}" class="btn btn-info btn-rounded"
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
        $(function() {
            $('#status').change(function() {
                var selected = $(this).val();

                if (selected == 'completed') {
                    $('#notes').val('completed');
                    $("#notes").attr("disabled", "disabled"); 
                } else {
                    $('#notes').val('');
                    $("#notes").removeAttr("disabled"); 
                }
            });
        });
    </script>
@endpush