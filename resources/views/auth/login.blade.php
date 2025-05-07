@extends('layouts.admin.base-auth')

@section('title', 'Sign In')

@section('content')
    <!-- Apply the custom center-form class to the wrapper -->
    <div class="center-form">
        <form class="sign-in-form" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="card shadow-sm">
                <div class="card-body">
                    <a href="{{ url('/login') }}" class="brand text-center d-block mb-4">
                        <img src="{{ isset($settings->logo) ? $settings->getImage() : asset('admin/assets/img/logos/default.jpg') }}"
                        alt="{{ env('APP_NAME') }}"  style="width:150px;" />
                    </a>

                    <h5 class="sign-in-heading text-center mb-4">Sign in to your account</h5>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email"
                            value="{{ old('email') }}" required autofocus>

                        @error('email')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                                required>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <span toggle="#password" class="la la-eye field-icon toggle-password"></span>
                                </span>
                            </div>
                        </div>

                        @error('password')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="checkbox mb-3">
                        <div class="custom-control custom-checkbox checkbox-primary form-check">
                            <input type="checkbox" class="custom-control-input" id="rememberMe" name="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="rememberMe">Remember me</label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="float-right">Forgot Password?</a>
                        @endif
                    </div>

                    <button class="btn btn-primary btn-rounded btn-lg btn-block" type="submit">Sign In</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            $(document).on('click', '.toggle-password', function() {
                $(this).toggleClass("la-eye la-eye-slash");

                var inputPassword = $("#password");
                var currentType = inputPassword.attr('type');
                inputPassword.attr('type', currentType === 'password' ? 'text' : 'password');
            });
        });
    </script>
@endpush
