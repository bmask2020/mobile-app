@extends('dashboard.master')

@section('title')
    Live Chat
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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Live Chat</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
          
            @foreach ($message as $val)
                
            
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header" style="display:flex;justify-content:flex-end">
                        <h5 class="card-title" style="direction: rtl;text-align:right">{{ $val->name }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text" style="direction: rtl;text-align:right">{{ $val->message }}</p>
                    </div>
                    <div class="card-footer d-sm-flex justify-content-between align-items-center">
                        <div class="card-footer-link mb-4 mb-sm-0">
                            <p class="card-text text-dark d-inline">{{ \Carbon\Carbon::parse($val->created_at)->diffForHumans() }}</p>
                        </div>

                       
                    </div>
                </div>
            </div>
            @endforeach

            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Replay</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form>
                                <div class="form-group">
                                    <textarea class="form-control" rows="4" id="comment"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection