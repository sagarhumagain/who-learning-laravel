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
                    <h1 class="">Register</h1>
                    <hr/>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group col-12">
                            <label for="name" class="font-weight-bold">Name</label>

                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            {{-- <input type="text" name="name" v-model="user.name" id="name" placeholder="Enter name" class="form-control"> --}}
                        </div>

                        <div class="form-group col-12">
                            <label for="email" class="font-weight-bold">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-12">
                            <label for="password" class="font-weight-bold">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            {{-- <input type="password" name="password" v-model="user.password" id="password" placeholder="Enter Password" class="form-control"> --}}
                        </div>
                        <div class="form-group col-12">
                            <label for="password_confirmation" class="font-weight-bold">Confirm Password</label>
                            {{-- <input type="password" name="password_confirmation" v-model="user.password_confirmation" id="password_confirmation" placeholder="Enter Password" class="form-control"> --}}
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                        </div>
                        <div class="col-12 mb-2 text-center">
                            <button type="submit" class="btn-fill mt-3">
                                {{ "Register" }}
                            </button>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <label>Already have an account? <a href="/login">Login Now!</a></label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
