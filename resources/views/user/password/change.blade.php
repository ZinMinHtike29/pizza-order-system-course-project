@extends('user.layout.master');
@section('title', 'Change Password')
@section('content')
    <div class="row">
        <div class="col-6 offset-3">
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h3 class="text-center title-2">Change Password</h3>
                                    </div>
                                    <hr>
                                    @if (session('changeSuccess'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong><i
                                                    class="fa-solid fa-cloud-arrow-down me-2"></i>{{ session('changeSuccess') }}</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if (session('notMatch'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong><i class="fa-solid fa-xmark me-2"></i>{{ session('notMatch') }}</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <form action="{{ route('user#changePassword') }}" method="post"
                                        novalidate="novalidate">
                                        @csrf
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Old Password</label>
                                            <input id="cc-payment" name="oldPassword" type="password"
                                                class="form-control @error('oldPassword') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false"
                                                placeholder="Enter Old Password...">
                                            @error('oldPassword')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">New Password</label>
                                            <input id="cc-payment" name="newPassword" type="password"
                                                class="form-control @error('newPassword') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false"
                                                placeholder="Enter New Password...">
                                            @error('newPassword')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Confirm Password</label>
                                            <input id="cc-payment" name="confirmPassword" type="password"
                                                class="form-control @error('confirmPassword') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Confirm Password...">
                                            @error('confirmPassword')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div>
                                            <button id="payment-button" type="submit"
                                                class="btn btn-lg btn-dark btn-block">
                                                <i class="fa-solid fa-key me-2"></i>
                                                <span id="payment-button-amount">Change Password</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
        </div>
    </div>
@endsection
