@extends('layouts.admin.base-dashboard')

@section('title', 'Create Brand')

@section('content')
    <div class="card">
        <form action="{{ route('brands.store') }}" method="POST" class="form-horizontal needs-validation">
            @csrf
            <h5 class="card-header">Create Brand</h5>
            <div class="card-body">
                <div class="form-body">
                    <div class="form-group row @error('name') has-error @enderror">
                        <label class="control-label text-right col-md-3">Name</label>
                        <div class="col-md-5">
                            <input type="text" name="name" id="brandName"
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
                            <textarea name="description" id="brandDescription" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>

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
                                        <i class="la la-save text-white" style="font-size: 1.5em;"></i> Create
                                    </button>
                                    <a href="{{ route('brands.index') }}" class="btn btn-info btn-rounded text-white"> <i
                                            class="la la-chevron-left text-white" style="font-size: 1.5em;"></i> Back
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
            $('#brandName').keyup(function() {
                $(this).val($(this).val().toUpperCase());
            });

            $('#brandDescription').keyup(function() {
                $(this).val($(this).val().toUpperCase());
            });
        });
    </script>
@endpush
