@extends('dashboard.master')


@section('title')
    Add New Brand
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
      
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add New Brand</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            @if( Session::has('msg') )
                            <p class="text-danger text-center">{{ Session::get('msg') }}</p>
                            @endif

                            <form action="{{ route('store.brand') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Brand Name</label>
                                    <input type="text" name="name" id="name" class="form-control input-default " placeholder="Brand Name">
                                    @error('name')
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

                                <button type="submit" class="btn btn-primary">Save Brand</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

           
         
        </div>
    </div>
</div>
@endsection