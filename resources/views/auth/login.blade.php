@extends('layouts.app')

@section('content')

<div class="container h-100">
    <div class="row h-100 align-items-center">
        <div class="col-12 col-md-6 offset-md-3">
            <div class="card shadow sm mt-4 rounded-0">
                <div class="card-body">
                    <div class="text-center">
                        <img src="/images/logo.png" alt="WHO Logo" height="100">
                    </div>

                    <h5 class="mt-8">Welcome Back !</h5>
                    <a href="#" class="mt-2"> Sign in to continue.</a>

                    <hr/>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group col-12 mb-3">
                            <label for="email" class="font-weight-bold">Email</label>
                            <input id="email" type="email"  name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror"  required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            {{-- <input type="text" v-model="formData.email" name="email" id="email" class="form-control"> --}}
                        </div>
                        <div class="form-group col-12 mb-2">
                            <label for="password" class="font-weight-bold">Password</label>
                                <input id="password" type="password"  name="password" required autocomplete="current-password" class="form-control @error('password') is-invalid @enderror">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            {{-- <input type="password" v-model="formData.password" name="password" id="password" class="form-control"> --}}
                        </div>
                        <div class="form-group col-12 d-flex justify-content-between mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                                <div class="forger-password">
                                    <label> <a href="{{ route('password.request') }}">Forgot Password</a></label>
                                </div>
                        </div>

                        <div class="col-12 mb-2 text-center mt-3 ">
                            <button type="submit"   class="btn-fill ">
                                {{ __('Login') }}
                            </button>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <label>Don't have an account? <a href="{{ route('register') }}">Register Now!</a></label>
                        </div>
                        <div class="col-12 text-center mt-3">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
