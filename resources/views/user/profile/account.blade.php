@extends('user.layout.master');
@section('title', 'User Profile')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Account Profile</h3>
                            </div>
                            <hr>
                            @if (session('updateSuccess'))
                                <div class="alert alert-success col-3 offset-8 alert-dismissible fade show" role="alert">
                                    <strong><i
                                            class="fa-solid fa-right-left me-2"></i>{{ session('updateSuccess') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('user#accChange', Auth::user()->id) }}" enctype="multipart/form-data"
                                method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
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
                                        <div class=" mt-3">
                                            <input type="file" class=" form-control @error('image') is-invalid @enderror"
                                                name="image">
                                            @error('image')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class=" mt-3">
                                            <button type="submit" class=" btn btn-dark col-12"><i
                                                    class="fa-solid fa-circle-up me-2"></i>Update </button>
                                        </div>
                                    </div>
                                    <div class="row col-6">
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input id="cc-payment" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Your Name..."
                                                value="{{ old('name', Auth::user()->name) }}">
                                            @error('name')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Email</label>
                                            <input id="cc-payment" name="email" type="text"
                                                class="form-control @error('email') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Your Email..."
                                                value="{{ old('email', Auth::user()->email) }}">
                                            @error('email')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Phone</label>
                                            <input id="cc-payment" name="phone" type="number"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false"
                                                placeholder="Enter Your Phone Number..."
                                                value="{{ old('email', Auth::user()->phone) }}">
                                            @error('phone')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Gender</label>
                                            <select name="gender"
                                                class=" form-select @error('gender') is-invalid @enderror" id="">
                                                <option value="">Choose Gender</option>
                                                <option value="male" @if (Auth::user()->gender == 'male') selected @endif>
                                                    Male
                                                </option>
                                                <option value="female" @if (Auth::user()->gender == 'female') selected @endif>
                                                    Female</option>
                                            </select>
                                            @error('gender')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Address</label>
                                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="" cols="30"
                                                rows="10" placeholder=" Enter Your Address...">{{ old('email', Auth::user()->address) }}</textarea>
                                            @error('address')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Role</label>
                                            <input id="cc-payment" disabled name="role" type="text"
                                                class="form-control" aria-required="true" aria-invalid="false"
                                                value="{{ Auth::user()->role }}">
                                        </div>
                                    </div>
                                </div>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
