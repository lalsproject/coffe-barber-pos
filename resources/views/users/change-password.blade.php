@extends('layouts.admin.base-dashboard')

@section('content')
<div class="card">
    @include('layouts.admin.include.message')

    <form action="{{ route('users.update-password') }}" method="POST"
        class="form-horizontal needs-validation">
        @csrf
        @method('PATCH')

        <h5 class="card-header">Change Password</h5>
        <div class="card-body">
            <div class="form-body">
                <div class="form-group row @error('password') has-error @enderror">
                    <label class="control-label text-right col-md-3">Password</label>
                    <div class="col-md-5">
                        {{-- <input type="password" name="password"
                            class="form-control @error('password') has-error @enderror" autocomplete="password">

                        @error('password')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror --}}

                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <span toggle="#password-field" class="la la-eye field-icon toggle-password"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label text-right col-md-3">Confirm Password</label>
                    <div class="col-md-5">
                        {{-- <input type="password" id="password-confirm" name="password_confirmation"
                            class="form-control" autocomplete="password"> --}}

                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="passwordConfirmation" class="form-control">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <span toggle="#password-field" class="la la-eye field-icon toggle-password-confirmation"></span>
                                </span>
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
                                        <i class="la la-save" style="color: #fff; font-size: 1.5em;"></i> Simpan
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-info btn-rounded"
                                    style="color: #fff;"> <i class="la la-chevron-left" style="color: #fff; font-size: 1.5em;"></i> Kembali
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
        $(document).on('click', '.toggle-password', function() {
            $(this).toggleClass("la-eye la-eye-slash");

            var inputPassword = $("#password");
            inputPassword.attr('type') === 'password' ? inputPassword.attr('type','text') : inputPassword.attr('type','password')
        });

        $(document).on('click', '.toggle-password-confirmation', function() {
            var inputPasswordConfirmation = $("#passwordConfirmation");
            inputPasswordConfirmation.attr('type') === 'password' ? inputPasswordConfirmation.attr('type','text') : inputPasswordConfirmation.attr('type','password')
         });
    });
</script>
@endpush
