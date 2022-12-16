@extends('user.layout.master')
@section('title', 'Reply Page')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-6 offset-3">

                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <a class=" text-dark" onclick="history.back()"><i
                                        class="fa-solid fa-arrow-left-long"></i>Back</a>
                            </div>
                            <div class="card-title">
                                <h3 class=" title-2">Your Message</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <h3> <i class="fa-solid fa-scroll me-2"></i>Subject:</h3>
                                    </div>
                                    <div class="col-8">
                                        <h3>{{ $message->subject }}</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <h3 class=" text-muted mb-1">Message:</h3>
                                    <p>{{ $message->message }}</p>
                                </div>
                            </div>
                            <h3 class=" title-2">Admin's Reply</h3>
                            <hr>
                            <div class="row">
                                @if (!empty($reply))
                                    <h3 class=" text-muted mb-1">Message:</h3>
                                    <p>{{ $reply->reply_message }}</p>
                                @else
                                    <h3 class=" text-center">There is No Reply Here!</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
