@extends('layouts.auth')

@section('title', 'Register')

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('Register') }}</h1>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger border-left-danger" role="alert">
                                        <ul class="pl-4 my-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('register') }}" class="user">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="name" placeholder="{{ __('Nama') }}" value="{{ old('name') }}" required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-user" name="phone" placeholder="{{ __('No. Telp') }}" value="{{ old('phone') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="address" placeholder="{{ __('Alamat') }}" value="{{ old('address') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email" placeholder="{{ __('Alamat Email') }}" value="{{ old('email') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password" placeholder="{{ __('Password') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </form>

                                <hr>

                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">
                                        {{ __('Already have an account? Login!') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
