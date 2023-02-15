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
                    <form method="POST" action="{{ route('epubReader') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- form fiel for epub file input --}}

                        <div class="form-group col-12 mb-3">
                            <label for="file" class="font-weight-bold">File</label>
                            <input id="file" type="file"  name="file" value="{{ old('file') }}" class="form-control @error('file') is-invalid @enderror"  required autocomplete="" autofocus>
                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="col-12 mb-2 text-center mt-3 ">
                            <button type="submit"   class="btn-fill ">
                                {{ __('submit') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
