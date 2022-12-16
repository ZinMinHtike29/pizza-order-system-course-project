@extends('admin.layout.master')

@section('title', 'Change Role')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class=" ms-5">
                                <a href="{{ route('admin#list') }}">
                                    <i class=" fa-solid fa-arrow-left text-dark"></i>
                                </a>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit Profile</h3>
                            </div>
                            <hr>
                            <form action="{{ route('admin#change', $account->id) }}" enctype="multipart/form-data"
                                method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
                                        @if ($account->image == null)
                                            @if ($account->gender != 'female')
                                                <img class=" img-thumbnail shadow-sm"
                                                    src="{{ asset('image/Default-welcomer.png') }}" alt="John Doe" />
                                            @else
                                                <img class=" img-thumbnail shadow-sm"
                                                    src="{{ asset('image/Profile-Female-PNG-Image.png') }}"
                                                    alt="John Doe" />
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/' . $account->image) }}"
                                                class=" img-thumbnail shadow-sm" alt="John Doe" />
                                        @endif
                                        <div class=" mt-3">
                                            <button type="submit" class=" btn btn-dark col-12"><i
                                                    class="fa-solid fa-circle-up me-2"></i>Change </button>
                                        </div>
                                    </div>
                                    <div class="row col-6">
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input disabled id="cc-payment" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Your Name..."
                                                value="{{ old('name', $account->name) }}">
                                            @error('name')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Role</label>
                                            <select name="role" class=" form-select" id="">
                                                <option value="admin" @if ($account->role == 'admin') selected @endif>
                                                    Admin</option>
                                                <option value="user" @if ($account->role == 'user') selected @endif>
                                                    User</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Email</label>
                                            <input disabled id="cc-payment" name="email" type="text"
                                                class="form-control @error('email') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Your Email..."
                                                value="{{ old('email', $account->email) }}">
                                            @error('email')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Phone</label>
                                            <input disabled id="cc-payment" name="phone" type="number"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false"
                                                placeholder="Enter Your Phone Number..."
                                                value="{{ old('email', $account->phone) }}">
                                            @error('phone')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Gender</label>
                                            <select disabled name="gender"
                                                class=" form-select @error('gender') is-invalid @enderror" id="">
                                                <option value="">Choose Gender</option>
                                                <option value="male" @if ($account->gender == 'male') selected @endif>
                                                    Male
                                                </option>
                                                <option value="female" @if ($account->gender == 'female') selected @endif>
                                                    Female</option>
                                            </select>
                                            @error('gender')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Address</label>
                                            <textarea disabled name="address" class="form-control @error('address') is-invalid @enderror" id=""
                                                cols="30" rows="10" placeholder=" Enter Your Address...">{{ old('email', $account->address) }}</textarea>
                                            @error('address')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
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
