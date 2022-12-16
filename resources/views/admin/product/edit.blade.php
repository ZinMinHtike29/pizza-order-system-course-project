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
                            <div class=" ms-5">
                                <i class=" fa-solid fa-arrow-left" onclick="history.back()"></i>
                            </div>
                            <div class="card-title">
                                {{-- <h3 class="text-center title-2">Pizza Details</h3> --}}
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 offset-2">
                                    <div class="image">
                                        <img src="{{ asset('storage/' . $pizza->image) }}"
                                            class=" shadow-sm img-thumbnail" />
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class=" my-3 btn btn-danger fs-5 d-block w-50">{{ $pizza->name }} </div>
                                    <span class="
                                        my-3 btn btn-dark"><i
                                            class="fa-solid fs-4 fa-money-bill-1-wave me-2"></i>{{ $pizza->price }} kyats
                                    </span>
                                    <span class=" my-3 btn btn-dark"><i
                                            class="fa-solid fs-4 fa-clock me-2"></i>{{ $pizza->waiting_time }}
                                        mins</span>
                                    <span class=" my-3 btn btn-dark"><i
                                            class="fa-solid fs-4 fa-eye me-2"></i>{{ $pizza->view_count }}
                                    </span>
                                    <span class=" my-3 btn btn-dark"><i
                                            class="fa-solid fs-4 fa-clone me-2"></i>{{ $pizza->category_name }}
                                    </span>
                                    <span class=" my-3 btn btn-dark"><i
                                            class="fa-solid fs-4 fa-calendar-days me-2"></i>{{ $pizza->created_at->format('d-F-Y') }}
                                    </span>
                                    <div class="my-3"><i class="fa-solid fs-4 fa-file-lines me-2"></i> Details
                                        <div>{{ $pizza->description }}</div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class=" row mt-3">
                                <div class=" col-3 offset-2">
                                    <a href="{{ route('admin#edit') }}">
                                        <button class=" btn btn-dark"><i class="fa-solid fa-pen-to-square me-2"></i>Edit
                                            Pizza
                                        </button>
                                    </a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
