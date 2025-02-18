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
                    @if( Session::has('msg') )
                    <p class="text-danger text-center">{{ Session::get('msg') }}</p>
                    @endif
                    <div class="card-body">
                        <div class="basic-form">
                            <img src="{{ asset($data->img) }}" alt="" style="width: 150px;display:block;margin:0 auto 2rem auto" draggable="false">
                            <form method="POST" action="{{ route('update.product') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="pro_name" class="form-control input-default " placeholder="Product Name" value="{{ $data->pro_name }}">
                                    @error('pro_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="number" name="price" class="form-control input-default " placeholder="Product Price" value="{{ $data->price }}">
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <input type="number" name="quantity" class="form-control input-default " placeholder="Product Quantity" value="{{ $data->quantity }}">
                                    @error('quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <select name="brand" id="" class="form-control">
                                        <option value="" selected style="color: #000">Product Brand Select</option>
                                        @foreach ($brand as $val)
                                            <option style="color: #000" value="{{ $val->id }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <select name="avalibale" id="" class="form-control">
                                        <option value="" style="color: #000" selected>Plz Select Product avalibale</option>
                                        <option value="1" style="color: #000">In Stock</option>
                                        <option value="0" style="color: #000">Out Stock</option>
                                    </select>
                                    @error('avalibale')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <div class="form-group">
                                        <input type="file" name="img" class="form-control" id="">
                                </div>


                                <textarea name="details" id="" class="form-control" cols="30" rows="10">
                                    {{ $data->details }}
                                </textarea>
                                <br><br>
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