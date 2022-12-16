@extends('admin.layout.master')

@section('title', 'details')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="row mb-3">
            <div class="col-3 offset-7">
                @if (session('updateSuccess'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="fa-solid fa-circle-check"></i> {{ session('updateSuccess') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Account Info</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 offset-2">
                                    <div class="image">
                                        @if (Auth::user()->image == null)
                                            @if (Auth::user()->gender != 'female')
                                                <img class=" img-thumbnail shadow-sm"
                                                    src="{{ asset('image/Default-welcomer.png') }}" alt="John Doe" />
                                            @else
                                                <img class=" img-thumbnail shadow-sm"
                                                    src="{{ asset('image/Profile-Female-PNG-Image.png') }}"
                                                    alt="John Doe" />
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                                class=" img-thumbnail shadow-sm" alt="John Doe" />
                                        @endif
                                    </div>
                                </div>
                                <div class="col-5 offset-1">
                                    <h3 class=" my-3"><i class="fa-solid fa-user-pen me-2"></i>{{ Auth::user()->name }}
                                    </h3>
                                    <h3 class=" my-3"><i class="fa-solid fa-envelope me-2"></i>{{ Auth::user()->email }}
                                    </h3>
                                    <h3 class=" my-3"><i class="fa-solid fa-phone me-2"></i>{{ Auth::user()->phone }}</h3>
                                    <h3 class=" my-3"><i
                                            class="fa-solid fa-address-card me-2"></i>{{ Auth::user()->address }}</h3>
                                    <h3 class="my-3"><i
                                            class="fa-solid fa-mars-and-venus me-2"></i>{{ Auth::user()->gender }}</h3>
                                    <h3 class=" my-3"><i
                                            class="fa-solid fa-calendar-days me-2"></i>{{ Auth::user()->created_at->format('d-F-Y') }}
                                    </h3>
                                </div>
                            </div>
                            <div class=" row mt-3">
                                <div class=" col-3 offset-2">
                                    <a href="{{ route('admin#edit') }}">
                                        <button class=" btn btn-dark"><i class="fa-solid fa-pen-to-square me-2"></i>Edit
                                            Profile
                                        </button>
                                    </a>
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
