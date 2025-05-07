@extends('layouts.admin.base-dashboard')

@section('title', 'Change Profile')

@section('content')
<div class="card">
    @include('layouts.admin.include.message')

    <form action="{{ route('users.update-profile') }}" method="POST"
        class="form-horizontal needs-validation">
        @csrf
        @method('PATCH')

        <h5 class="card-header">Change Profile</h5>
        <div class="card-body">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group row @error('name') has-error @enderror">
                            <label class="control-label text-right col-md-4">Name</label>
                            <div class="col-md-8">
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
                            <label class="control-label text-right col-md-4">Email</label>
                            <div class="col-md-8">
                                <input type="text" name="email"
                                    class="form-control @error('email') has-error @enderror" autocomplete="email"
                                    value="{{ old('email', $user->email) }}">

                                @error('email')
                                    <div class="text-danger">
                                        <small>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>
                        </div>
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
                                <a href="{{ route('home') }}" class="btn btn-info btn-rounded" style="color: #fff;"> <i
                                    class="la la-chevron-left" style="color: #fff; font-size: 1.5em;"></i> Back
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
