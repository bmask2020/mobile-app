@extends('dashboard.master')

@section('title')
    Brands
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
                    <li class="breadcrumb-item active"><a>Brands</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                  
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-md">
                                <thead>
                                    <tr>
                                        <th style="width:80px;"><strong>ID</strong></th>
                                        <th><strong>Name</strong></th>
                                        <th><strong>Image</strong></th>
                                        <th><strong>Edit</strong></th>
                                        <th><strong>Delete</strong></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data as $val)
                                        
                                   
                                    <tr>
                                        <td><strong>{{ $val->id }}</strong></td>
                                        <td>{{ $val->name }}</td>
                                        <td>
                                            <img src="{{ asset($val->img) }}" style="width:100px" alt="">
                                        </td>
                                      
                                        <td>
                                            <a href="{{ route('edit.brand', ['id' => $val->id]) }}" class="btn btn-warning">Edit</a>
                                        </td>

                                        <td>
                                            <a href="{{ route('delete.brand', ['id' => $val->id]) }}" type="button" class="btn btn-danger">Delete</a>
                                        </td>

                                    </tr>
                                    @endforeach
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
         
       
        </div>
    </div>
</div>
@endsection