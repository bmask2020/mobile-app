@extends('dashboard.master')

@section('title')
    Product View
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
                    <li class="breadcrumb-item active"><a>All Products</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    @if( Session::has('msg') )
                        <p class="text-danger text-center">{{ Session::get('msg') }}</p>
                    @endif
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-md">
                                <thead>
                                    <tr>
                                        <th style="width:80px;"><strong>ID</strong></th>
                                        <th><strong>Name</strong></th>
                                        <th><strong>Price</strong></th>
                                        <th><strong>Brand</strong></th>
                                        <th><strong>In Stock</strong></th>
                                        <th><strong>Quantity</strong></th>
                                        <th><strong>Image</strong></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data as $val)
                                        
                                        @php($brand = DB::table('brands')->where('id', '=', $val->brand)->first())
                                        <tr>
                                            <td><strong>{{ $val->id }}</strong></td>
                                            <td>{{ $val->pro_name }}</td>
                                            <td>{{ $val->price}} SAR</td>
                                            <td>{{ $brand->name }}</td>
                                            <td>
                                                @if($val->avalibale == 1)
                                                <span class="badge light badge-success">In Stock</span>
                                                @else 
                                                <span class="badge light badge-danger">Out Stock</span>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                {{ $val->quantity }}
                                            </td>
                                            <td>
                                                <img src="{{ asset($val->img) }}" style="width:100px" alt="">
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('edit.product', ['id' => $val->id]) }}">Edit</a>
                                                        <a class="dropdown-item" href="{{ route('delete.product', ['id' => $val->id]) }}">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{ $data->links() }}
                </div>
            </div>
       
           
        </div>
    </div>
</div>
@endsection