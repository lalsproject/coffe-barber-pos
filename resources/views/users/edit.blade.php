@extends('layouts.admin.base-dashboard')

@section('title', 'Edit User')

@section('content')
<div class="card">
    <form action="{{ route('users.update', $user->id) }}" method="POST"
        class="form-horizontal needs-validation">
        @csrf
        @method('PATCH')

        <h5 class="card-header">Edit User</h5>
        <div class="card-body">
            <div class="form-body">
                <div class="form-group row @error('name') has-error @enderror">
                    <label class="control-label text-right col-md-3">Full Name</label>
                    <div class="col-md-5">
                        <input type="text" name="name"
                            class="form-control @error('name') has-error @enderror" autocomplete="name"
                            value="{{ old('name', $user->name) }}">

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
                            value="{{ old('email', $user->email) }}">

                        @error('email')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('role') is-invalid @enderror">
                    <label for="role" class="control-label text-right col-md-3">Role</label>
                    <div class="col-md-3">
                        <select name="role" id="role"
                            class="form-control @error('role') is-invalid @enderror">
                            <option value="">-- Choose Role --</option>
                            <option value="admin"
                                {{ old('role') == 'admin' ? 'selected' : '' }}
                                {{ $user->role == 'admin' ? 'selected' : '' }}>
                                As Admin
                            </option>
                            <option value="cashier"
                                {{ old('role') == 'cashier' ? 'selected' : '' }}
                                {{ $user->role == 'cashier' ? 'selected' : '' }}>
                                As Cashier Staff
                            </option>
                        </select>

                        @error('role')
                            <div class="text-danger">
                                <small class="col-md-8">{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('password') has-error @enderror">
                    <label class="control-label text-right col-md-3">Password</label>
                    <div class="col-md-5">
                        <input type="password" name="password"
                            class="form-control @error('password') has-error @enderror" autocomplete="password"
                            value="{{ old('password') }}">

                        @error('password')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('password') has-error @enderror">
                    <label class="control-label text-right col-md-3">Password Confirmation</label>
                    <div class="col-md-5">
                        <input type="password" name="password_confirmation"
                            class="form-control @error('password') has-error @enderror" autocomplete="password_confirmation"
                            value="{{ old('password_confirmation') }}">

                        @error('password')
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
                            <option value="active"
                                {{ old('status') == 'active' ? 'selected' : '' }}
                                {{ $user->status == 'active' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="inactive"
                                {{ old('status') == 'inactive' ? 'selected' : '' }}
                                {{ $user->status == 'inactive' ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>
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
                                    <i class="la la-save" style="color: #fff; font-size: 1.5em;"></i> Update
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-info btn-rounded"
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
