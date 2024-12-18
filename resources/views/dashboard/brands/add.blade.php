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
                            <form>
                                <div class="form-group">
                                    <label for="name">Brand Name</label>
                                    <input type="text" id="name" class="form-control input-default " placeholder="Brand Name">
                                </div>
                                <div class="form-group">
                                    <label for="img">Brand Image</label>
                                    <input type="file" class="form-control input-rounded" id="img" placeholder="input-rounded">
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