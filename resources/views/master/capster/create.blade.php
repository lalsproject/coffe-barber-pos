@extends('layouts.admin.base-dashboard')

@section('title', 'Tambah Capster')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0 mx-auto" style="font-weight: 600;">Tambah Capster</h1>
            <div class="d-flex align-items-center">
                <a href="{{ route('capsters.index') }}" class="btn btn-info btn-sm d-flex align-items-center text-white">
                    <i class="la la-chevron-left text-white"></i>
                    Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('capsters.store') }}" method="POST" class="form-horizontal needs-validation">
                @csrf
                <div class="form-body">
                    <div class="form-group row @error('name') has-error @enderror">
                        <label class="control-label text-left col-md-3">Full Name</label>
                        <div class="col-md-9">
                            <input type="text" name="name" class="form-control @error('name') has-error @enderror"
                                autocomplete="name" value="{{ old('name') }}">

                            @error('name')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('phone') has-error @enderror">
                        <label class="control-label text-left col-md-3">Phone</label>
                        <div class="col-md-9">
                            <input type="text" name="phone" class="form-control @error('phone') has-error @enderror"
                                autocomplete="phone" value="{{ old('phone') }}">

                            @error('phone')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('status') is-invalid @enderror">
                        <label for="status" class="control-label text-left col-md-3">Status</label>
                        <div class="col-md-3">
                            <select name="status" id="status"
                                class="form-control @error('status') is-invalid @enderror">
                                <option value="">-- Pilih Status --</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif
                                </option>
                            </select>

                            @error('status')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-start">
                    <button type="submit" class="btn btn-primary btn-rounded mr-2">
                        <i class="la la-save text-white" style="font-size: 1.5em;"></i> Tambah
                    </button>
                    <a href="{{ route('capsters.index') }}" class="btn btn-info btn-rounded text-white">
                        <i class="la la-chevron-left text-white" style="font-size: 1.5em;"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
