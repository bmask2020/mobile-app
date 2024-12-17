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
                    <h4 class="text-center mb-4">reset Password</h4>
                    @if( Session::has('msg') )
                        <p class="text-danger text-center">{{ Session::get('msg') }}</p>
                    @endif
                    <form action="{{ route('admin.forget.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="mb-1"><strong>Write New Password</strong></label>
                            <input type="password" name="password" class="form-control">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </div>
                       
                        <input type="hidden" name="id" value="{{ $id }}">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                        </div>
                    </form>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
