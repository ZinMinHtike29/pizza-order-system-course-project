@extends('admin.layout.master')

@section('title', 'Update Product')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class=" ms-5">
                                <a href="{{ route('product#list') }}">
                                    <i class=" fa-solid fa-arrow-left text-dark"></i></a>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Update Pizza</h3>
                            </div>
                            <hr>
                            <form action="{{ route('product#update') }}" enctype="multipart/form-data" method="post">
                                @csrf
                                <input type="hidden" name="pizzaId" value="{{ $pizza->id }}">
                                <div class="row">
                                    <div class="col-4 offset-1 text-center">
                                        <img src="{{ asset('storage/' . $pizza->image) }}" class=" shadow-sm"
                                            alt="John Doe" />
                                        <div class=" mt-3">
                                            <input type="file" class=" form-control @error('image') is-invalid @enderror"
                                                name="pizzaImage">
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
                                            <input id="cc-payment" name="pizzaName" type="text"
                                                class="form-control @error('pizzaName') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Your Name..."
                                                value="{{ old('pizzaName', $pizza->name) }}">
                                            @error('pizzaName')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Description</label>
                                            <textarea id="cc-payment" name="pizzaDescription" type="text"
                                                class="form-control @error('pizzaDescription') is-invalid @enderror" aria-required="true" aria-invalid="false"
                                                placeholder="Enter Description..." cols="30" rows="10">{{ old('pizzaDescription', $pizza->description) }}</textarea>
                                            @error('pizzaDescription')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Pizza Category</label>
                                            <select name="pizzaCategory"
                                                class=" form-select @error('pizzaCategory') is-invalid @enderror"
                                                id="">
                                                <option value="">Choose Category</option>
                                                @foreach ($category as $c)
                                                    <option value="{{ $c->id }}"
                                                        @if ($pizza->category_id == $c->id) selected @endif>
                                                        {{ $c->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('pizzaCategory')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Price</label>
                                            <input id="cc-payment" name="pizzaPrice" type="number"
                                                class="form-control @error('pizzaPrice') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Price..."
                                                value="{{ old('pizzaPrice', $pizza->price) }}">
                                            @error('pizzaPrice')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Waiting Time</label>
                                            <input id="cc-payment" name="pizzaWaitingTime" type="number"
                                                class="form-control @error('pizzaWaitingTime') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false"
                                                placeholder="Enter Waiting Time..."
                                                value="{{ old('pizzaWaitingTime', $pizza->waiting_time) }}">
                                            @error('pizzaWaitingTime')
                                                <small class=" invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">View Count</label>
                                            <input id="cc-payment" name="viewCount" type="number" class="form-control"
                                                disabled aria-required="true" aria-invalid="false"
                                                placeholder="Enter Waiting Time..." value="{{ $pizza->view_count }}">
                                        </div>
                                        <div class=" form-group">
                                            <label for="cc-payment" class="control-label mb-1">Created At</label>
                                            <input type="text" name="createdAt" disabled class=" form-control"
                                                value="{{ $pizza->created_at->format('d-M-Y') }}">
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
