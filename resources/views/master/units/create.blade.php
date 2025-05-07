@extends('layouts.admin.base-dashboard')

@section('title', 'Create Units')

@section('content')
<div class="card">
    <form action="{{ route('units.store') }}" method="POST"
        class="form-horizontal needs-validation">
        @csrf
        
        <h5 class="card-header">Create Unit</h5>
        <div class="card-body">
            <div class="form-body">
                <div class="form-group row @error('name') has-error @enderror">
                    <label class="control-label text-right col-md-3">Name</label>
                    <div class="col-md-5">
                        <input type="text" name="name" id="unitName"
                            class="form-control @error('name') has-error @enderror" autocomplete="name"
                            value="{{ old('name') }}">

                        @error('name')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('description') has-error @enderror">
                    <label class="control-label text-right col-md-3">Description</label>
                    <div class="col-md-5">
                        <textarea name="description" id="unitDescription" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>

                        @error('description')
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
                                <a href="{{ route('units.index') }}" class="btn btn-info btn-rounded"
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
            $('#unitName').keyup(function() {
		        $(this).val($(this).val().toUpperCase());
	        });

            $('#unitDescription').keyup(function() {
		        $(this).val($(this).val().toUpperCase());
	        });
        });
    </script>
@endpush