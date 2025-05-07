@extends('layouts.admin.base-dashboard')

@section('title', 'Buat Cabang')

@section('content')
    <div class="container">
        <div class="card">
            <form action="{{ route('branch.store') }}" class="form-horizontal needs-validation" method="POST">
                @csrf
                <h5 class="card-header">Tambah Cabang</h5>
                <div class="card-body">
                    <div class="form-body">
                        <div class="form-group row @error('branch') is-invalid @enderror">
                            <label for="branch" class="control-label text-right col-md-3">Cabang</label>
                            <div class="col-md-5">
                                <input type="text" name="branch" id="branch"
                                    class="form-control
                            @error('branch') is-invalid @enderror">

                                @error('branch')
                                    <div class="text-danger">
                                        <small>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('status') has-error @enderror">
                            <label class="control-label text-right col-md-3">Status Cabang</label>
                            <div class="col-md-5">
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

                        <div class="card-footer bg-light">
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="offset-sm-3 col-md-5">
                                                <button type="submit" class="btn btn-primary btn-rounded">
                                                    <i class="la la-save text-white" style="font-size: 1.5em;"></i> Simpan
                                                </button>
                                                <a href="{{ route('branch.index') }}" class="btn btn-info btn-rounded"> <i
                                                        class="la la-chevron-left text-white" style="font-size: 1.5em;"></i>
                                                    Kembali
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
