@extends('dashboard.master')

@section('title')
    Brand Edit
@endsection


@section('content')
<div class="content-body">
    <div class="container-fluid">
        <!-- Add Project -->
       
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
              
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a>Brand {{ $data->name }} Edit</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Brand Edit Form</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form enctype="multipart/form-data" action="{{ route('update.brand') }}" method="POST">
                                @csrf
                                @if( Session::has('msg') )
                                <p class="text-danger text-center">{{ Session::get('msg') }}</p>
                                @endif
                                <div class="form-group" style="display:flex;justify-content:center">
                                   <img src="{{ asset($data->img) }}" style="width:300px" alt="">
                                </div>
                                <br><br>

                                <div class="form-group">
                                    <input type="text" name="name" class="form-control input-default " value="{{ $data->name }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>

                                <div class="form-group">
                                    <input type="file" name="img" class="form-control input-default ">
                                </div>
                               
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <button type="submit" class="btn btn-primary">Update</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

          
        </div>
    </div>
</div>
@endsection