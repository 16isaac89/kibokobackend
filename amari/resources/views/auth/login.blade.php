@extends('layouts.app')
@section('styles')
<style>
    .login-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }

    .form-control {
        height: calc(1.5em + 1rem + 2px);
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
    }

    .input-group-text {
        border-radius: 8px 0 0 8px !important;
    }

    .btn-primary {
        background-color: #2c5cc5;
        border-color: #2c5cc5;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #1d4ed8;
        border-color: #1d4ed8;
        transform: translateY(-1px);
    }

    .toggle-password {
        border-radius: 0 8px 8px 0 !important;
        cursor: pointer;
    }

    .custom-control-label::before,
    .custom-control-label::after {
        top: 0.15rem;
    }
</style>
@endsection
@section('content')
<div class="login-container d-flex justify-content-center align-items-center" style="min-height: 100vh; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="card login-card shadow-lg" style="width: 100%; max-width: 450px; border: none; border-radius: 12px; overflow: hidden;">
        <!-- Card Header with Logo -->
        <div class="card-header bg-primary text-white text-center py-4" style="border-bottom: none;">
            <img src="{{ asset('/images/logo/amari.jpg') }}" alt="Kiboko Enterprises" class="img-fluid mb-3" style="max-height: 80px;">
            <h3 class="mb-0">Welcome Back</h3>
            <p class="mb-0 text-white-50">Sign in to your account</p>
        </div>

        <div class="card-body p-4 p-md-5">
            @if(session('message'))
                <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-info-circle mr-2"></i>
                    {{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
             @if(session('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Warning!</strong> {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Field -->
                <div class="form-group mb-4">
                    <label for="email" class="form-label text-muted small font-weight-bold">EMAIL ADDRESS/Username </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0">
                                <i class="fas fa-envelope text-primary"></i>
                            </span>
                        </div>
                        <input id="email" name="email" type="text"
                               class="form-control border-left-0 {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               placeholder="your@email.com"
                               value="{{ old('email') }}"
                               required autocomplete="email" autofocus>
                    </div>
                    @if($errors->has('email'))
                        <div class="invalid-feedback d-block">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <!-- Password Field -->
                <div class="form-group mb-4">
                    <label for="password" class="form-label text-muted small font-weight-bold">PASSWORD</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0">
                                <i class="fas fa-lock text-primary"></i>
                            </span>
                        </div>
                        <input id="password" name="password" type="password"
                               class="form-control border-left-0 {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="••••••••"
                               required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary border-left-0 toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    @if($errors->has('password'))
                        <div class="invalid-feedback d-block">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                        <label class="custom-control-label text-muted small" for="remember">Remember me</label>
                    </div>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="small text-primary">Forgot password?</a>
                    @endif
                </div>

                <!-- Submit Button -->
               <button type="submit" id="loginButton" class="btn btn-primary btn-block py-2 mb-3" style="font-weight: 500;">
    <span id="loginButtonText">SIGN IN <i class="fas fa-arrow-right ml-2"></i></span>
    <span id="loginButtonSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
</button>



                <!-- Additional Links -->
                <p class="text-center text-muted small mt-4 mb-0">
                    Don't have an account? <a href="#" class="text-primary">Contact admin</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    // Toggle password visibility
    $(document).ready(function() {
        $('.toggle-password').click(function() {
            const input = $(this).closest('.input-group').find('input');
            const icon = $(this).find('i');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Toggle password visibility
        $('.toggle-password').click(function() {
            const input = $(this).closest('.input-group').find('input');
            const icon = $(this).find('i');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Show spinner on form submit
        $('form').on('submit', function() {
            $('#loginButton').attr('disabled', true);
            $('#loginButtonText').addClass('d-none');
            $('#loginButtonSpinner').removeClass('d-none');
        });
    });
</script>

@endsection
