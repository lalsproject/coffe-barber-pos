@extends('layouts.admin.base-dashboard')

@section('title', 'Edit Capster')

@section('content')
    <div class="card">
        <form action="{{ route('capsters.update', $capster->id) }}" method="POST" class="form-horizontal needs-validation">
            @csrf
            @method('PATCH') {{-- HTTP Request --}}
            <h5 class="card-header">Edit Capster</h5>
            <div class="card-body">
                <div class="form-body">
                    <div class="form-group row @error('name') has-error @enderror">
                        <label class="control-label text-right col-md-3">Full Name</label>
                        <div class="col-md-5">
                            <input type="text" name="name" class="form-control @error('name') has-error @enderror"
                                autocomplete="name" value="{{ old('name', $capster->name) }}">

                            @error('name')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('phone') has-error @enderror">
                        <label class="control-label text-right col-md-3">Phone</label>
                        <div class="col-md-5">
                            <input type="text" name="phone" class="form-control @error('phone') has-error @enderror"
                                autocomplete="phone" value="{{ old('phone', $capster->phone) }}">

                            @error('phone')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('status') is-invalid @enderror">
                        <label for="status" class="control-label text-right col-md-3">Status</label>
                        <div class="col-md-3">
                            <select name="status" id="status"
                                class="form-control @error('status') is-invalid @enderror">
                                <option value="">-- Pilih Status --</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}
                                    {{ $capster->status == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}
                                    {{ $capster->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>

                            @error('status')
                                <div class="text-danger">
                                    <small class="col-md-8">{{ $message }}</small>
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
                                        <i class="la la-save text-white" style="font-size: 1.5em;"></i> Update
                                    </button>
                                    <a href="{{ route('capsters.index') }}" class="btn btn-info btn-rounded text-white"> <i
                                            class="la la-chevron-left text-white"
                                            style="font-size: 1.5em;"></i> Back
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
