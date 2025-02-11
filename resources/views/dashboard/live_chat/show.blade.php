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

        <div class="row" id="messages_parent">
          
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

           

        </div>

        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Replay</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form>
                            <div class="form-group">
                                <textarea class="form-control" rows="4" id="message"></textarea>
                            </div>
                            <input type="hidden" id="name" value="{{ Auth::user()->name }}">
                            <input type="hidden" id="sender" value="{{ Auth::user()->id }}">
                            <input type="hidden" id="message_no" value="{{ $data->message_no }}">
                            <input type="hidden" id="time" value="{{ \Carbon\Carbon::now()->diffForHumans() }}">
                            <button type="button" class="btn btn-success sendReplay">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection


@section('js')
    <script>
        $(document).ready(function(){

            $('.sendReplay').on('click', function(e) {

                e.preventDefault();
                let name        = $('#name').val();
                let sender      = $('#sender').val();
                let time        = $('#time').val();
                let message     = $('#message').val();
                let message_no = $('#message_no').val();
                if(message == '') {

                    Swal.fire({
                        title: 'Error!',
                        text: 'Plz Type Your Replay',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })

                } else {

                    $.ajax({

                        method: 'post',
                        url: '/api/live-chat/replay',
                        data : {

                            sender: sender,
                            name: name,
                            message: message,
                            message_no: message_no
                        },
                        headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                        }, 

                        success: function(response) {
                            
                            if(response == true) {

                                 $('#messages_parent').append('<div class="col-xl-12">\
                                    <div class="card">\
                                        <div class="card-header" style="display:flex;justify-content:flex-end">\
                                            <h5 class="card-title" style="direction: rtl;text-align:right">'+ name +'</h5>\
                                        </div>\
                                        <div class="card-body">\
                                            <p class="card-text" style="direction: rtl;text-align:right">'+ message +'</p>\
                                        </div>\
                                        <div class="card-footer d-sm-flex justify-content-between align-items-center">\
                                            <div class="card-footer-link mb-4 mb-sm-0">\
                                                <p class="card-text text-dark d-inline">'+ time +'</p>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>')

                                Swal.fire({
                                title: 'Done',
                                text: 'Replay Sent Successfully',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                                })


                            }
                        }

                    })
                   
                }
                
            })
        })
    </script>
@endsection