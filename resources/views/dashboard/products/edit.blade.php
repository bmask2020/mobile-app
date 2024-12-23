@extends('dashboard.master')

@section('title')
    Product Edit
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
                    <li class="breadcrumb-item"><a href="{{ route('view.products') }}">Products</a></li>
                    <li class="breadcrumb-item active"><a>Edit</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    
                    <div class="card-body">
                        <div class="basic-form">
                            <img src="{{ asset($data->img) }}" alt="" style="width: 150px;display:block;margin:0 auto 2rem auto" draggable="false">
                            <form>
                                <div class="form-group">
                                    <input type="text" class="form-control input-default " placeholder="Product Name" value="{{ $data->pro_name }}">
                                </div>

                                <div class="form-group">
                                    <input type="number" class="form-control input-default " placeholder="Product Price" value="{{ $data->price }}">
                                </div>

                                <div class="form-group">
                                    <select name="" id="" class="form-control">
                                        <option value="" selected style="color: #000">Product Brand Select</option>
                                        @foreach ($brand as $val)
                                            <option style="color: #000" value="{{ $val->id }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <select name="" id="" class="form-control">
                                        <option value="" selected>Plz Select Product avalibale</option>
                                        <option value="1">In Stock</option>
                                        <option value="0">Out Stock</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                        <input type="file" name="" class="form-control" id="">
                                </div>

                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        
        </div>
    </div>
</div>
@endsection