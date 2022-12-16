@extends('user.layout.master')
@section('title', 'Contact')
@section('content')
    <!-- Contact Start -->
    <div class="container-fluid">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="pr-3">Contact
                Us</span></h2>
        <div class="row px-xl-5">
            <div class="col-lg-6 mb-5">
                <div class="contact-form bg-light p-5">
                    @if (session('success'))
                        <div id="success">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong><i class="fa-solid fa-face-smile-beam"></i></strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    <form action="{{ route('user#sendMessage') }}" method="post">
                        @csrf
                        <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                        <div class="my-3 row">
                            <div class="col-6">
                                <input type="text" class="  form-control" placeholder="Enter Your Name"
                                    value="{{ Auth::user()->name }}" name="userName" disabled>
                            </div>
                            <div class="  col-6">
                                <input type="text" class=" form-control" placeholder="Enter Your Email.."
                                    value="{{ Auth::user()->email }}" name="userEmail" disabled>
                            </div>
                        </div>
                        <div class=" my-3">
                            <input type="text" class=" form-control @error('subject') is-invalid @enderror"
                                placeholder="Subject" name="subject" value="{{ old('subject') }}">
                            @error('subject')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class=" my-3">
                            <textarea name="message" class=" form-control @error('message') is-invalid @enderror" id="" cols="30"
                                rows="10" placeholder="Your Message" name="message">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <button class="btn btn-warning py-2 px-4 text-white" type="submit" id="sendMessageButton">Send
                                Message <i class="fa-solid fa-paper-plane ms-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 mb-5 ">
                <h3 class="border-bottom my-3 py-2">Message History</h3>
                @foreach ($messages as $m)
                    <div class="text mt-3 message-box">
                        <input type="hidden" name="" class="messageId" value="{{ $m->id }}">
                        <div class="d-flex justify-content-between">
                            <h4 class="">{{ $m->subject }}</h4>
                            <div class="">
                                <div class="btn-group">
                                    <i class="fa-solid fa-ellipsis-vertical fa-2x" data-bs-toggle="dropdown"
                                        aria-expanded="false"></i>
                                    <ul class="dropdown-menu">
                                        <li><button class="dropdown-item deleteMessage" type="button">Delete</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <small class=" text-danger">{{ $m->created_at->format('j-F-Y (h:i A)') }}</small>
                        <p class=" mt-2">
                            {{ Str::words($m->message, 40, ' ...') }}
                        </p>
                        <div class=" text-end">
                            <a href="{{ route('user#viewReply', $m->id) }}" class=" btn btn-outline-warning">View Reply</a>
                        </div>
                    </div>
                @endforeach
                <div class=" mt-2">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
@section('scriptsource')
    <script>
        $(document).ready(function() {
            $(".deleteMessage").click(function() {
                $parentNode = $(this).parents(".message-box");
                $messageId = $parentNode.find(".messageId").val();
                $.ajax({
                    type: "get",
                    url: "http://127.0.0.1:8000/user/contact/ajax/delete/Message",
                    data: {
                        message_id: $messageId,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $parentNode.remove();
                        }
                    }
                });
            })
        });
    </script>
@endsection
