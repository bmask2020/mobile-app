@extends('dashboard.master')

@section('title')
    Add New Product
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
      
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add New Product</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            @if( Session::has('msg') )
                            <p class="text-danger text-center">{{ Session::get('msg') }}</p>
                            @endif

                            <form action="{{ route('store.product') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Product Name</label>
                                    <input type="text" name="pro_name" id="name" class="form-control input-default " placeholder="Brand Name">
                                    @error('pro_name')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="price">Product Price</label>
                                    <input type="number" name="price" id="price" class="form-control input-default " placeholder="Product Price">
                                    @error('price')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="quantity">Product Quantity</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control input-default " placeholder="Product Quantity">
                                    @error('quantity')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="brand">Product Brand</label>
                                    <select name="brand" id="brand" class="form-control">
                                        <option value="" selected style="color:#000">Plz Select Product Brand</option>
                                        @foreach ($brand as $val)
                                            <option value="{{ $val->id }}" style="color:#000">{{ $val->name }}</option>
                                        @endforeach

                                    </select>
                                    @error('brand')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>



                                <div class="form-group">
                                    <label for="avalibale">Product Avalibale</label>
                                    <select name="avalibale" id="avalibale" class="form-control">
                                        <option value="" selected style="color:#000">Plz Select Product Stock</option>
                                        <option value="1" style="color:#000">in stock</option>
                                        <option value="2" style="color:#000">out of stock</option>
                                    </select>
                                    @error('avalibale')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="img">Brand Image</label>
                                    <input type="file" name="img" class="form-control input-rounded" id="img" placeholder="input-rounded">
                                    @error('img')
                                    <span>{{ $message }}</span>
                                    @enderror
                                </div>

                                <textarea name="details" id="" class="form-control" cols="30" rows="10">
                                  
                                </textarea>
                                <br><br>
                                <button type="submit" class="btn btn-primary">Save Product</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

           
         
        </div>
    </div>
</div>
@endsection