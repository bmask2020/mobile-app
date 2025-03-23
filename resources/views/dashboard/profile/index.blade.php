@extends('dashboard.master')

@section('title')
    Profile
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
      
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
              
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a >Profile</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Profile Update</h4>
                    </div>
                    <div class="card-body">
                        @if( Session::has('msg') )
                            <p class="text-danger text-center">{{ Session::get('msg') }}</p>
                        @endif
                        <div class="basic-form">
                            <form action="{{ route('admin.profile.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control input-default" value="{{ $user->name }}" placeholder="Enter Your Name">
                                </div>
                             
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control input-default" value="{{ $user->email }}" placeholder="Enter Your Email">
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" class="form-control input-default" placeholder="Enter Your Password">
                                </div>

                                <div class="form-group">
                                    <label for="img">Profile Image</label>
                                    <input type="file" name="img" id="img" class="form-control input-default ">
                                </div>

                                <button type="submit" class="btn btn-success">Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

          
        </div>
    </div>
</div>
@endsection