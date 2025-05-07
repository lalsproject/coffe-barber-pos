@extends('layouts.admin.base-dashboard')

@section('title', 'Create Service')

@section('content')
<div class="card">
    <form action="{{ route('services.store') }}" method="POST" class="form-horizontal needs-validation">
        @csrf
        <h5 class="card-header">Create Service</h5>
        <div class="card-body">
            <div class="form-body">
                <div class="form-group row @error('name') has-error @enderror">
                    <label class="control-label text-right col-md-3">Service Name</label>
                    <div class="col-md-5">
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror" 
                            autocomplete="name" 
                            value="{{ old('name') }}" required>

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
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3">{{ old('description') }}</textarea>

                        @error('description')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('price') has-error @enderror">
                    <label class="control-label text-right col-md-3">Price</label>
                    <div class="col-md-5">
                        <input type="number" name="price" step="0.01"
                            class="form-control @error('price') is-invalid @enderror" 
                            autocomplete="price" 
                            value="{{ old('price') }}" required>

                        @error('price')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('status') has-error @enderror">
                    <label for="status" class="control-label text-right col-md-3">Status</label>
                    <div class="col-md-3">
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="">-- Select Status --</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>

                        @error('status')
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
                                <a href="{{ route('services.index') }}" class="btn btn-info btn-rounded" style="color: #fff;">
                                    <i class="la la-chevron-left" style="color: #fff; font-size: 1.5em;"></i> Back
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
