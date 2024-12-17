@extends('auth.master')

@section('content')
<div class="col-md-6">
    <div class="authincation-content">
        <div class="row no-gutters">
            <div class="col-xl-12">
                <div class="auth-form">
                    <div class="text-center mb-3">
                        <img src="{{ asset('/images/logo-full.png') }}" alt="">
                    </div>
                    <h4 class="text-center mb-4">Forget Password</h4>
                    @if( Session::has('msg') )
                        <p class="text-danger text-center">{{ Session::get('msg') }}</p>
                    @endif
                    <form action="{{ route('admin.forget.password') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="mb-1"><strong>Email</strong></label>
                            <input type="email" name="email" class="form-control">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </div>
                       
                      
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block">Send Password</button>
                        </div>
                    </form>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
