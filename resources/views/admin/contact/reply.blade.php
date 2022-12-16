@extends('admin.layout.master')
@section('title')
    Admin Reply Page
@endsection
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-6 offset-3">

                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <a href="{{ route('admin#messageList') }}" class=" text-dark"><i
                                        class="fa-solid fa-arrow-left-long"></i>Back</a>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Message Details</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <h3> <i class="fa-solid fa-share me-2"></i> Sent From :</h3>
                                    </div>
                                    <div class="col-8">
                                        <h3>{{ $message->user_name }}</h3>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <h3> <i class="fa-solid fa-at me-2"></i>Email:</h3>
                                    </div>
                                    <div class="col-8">
                                        <h3>{{ $message->user_email }}</h3>
                                    </div>
                                </div>
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
                                <div class="row mt-2">
                                    <form class="col" action="{{ route('admin#replyMessage') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="messageId" value="{{ $message->id }}">
                                        <label for="">Reply Message :</label>
                                        <textarea class="form-control @error('adminreply') is-invalid @enderror" name="adminreply" id="" cols="30"
                                            rows="10" placeholder=" Enter Your Message"></textarea>
                                        @error('adminreply')
                                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="row my-3">
                                            <button type="submit" class=" btn btn-primary col-3 offset-9">Send
                                                Message</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
