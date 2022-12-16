@extends('user.layout.master');
@section('title', 'My Shop')
@section('content')
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-white pr-3">Filter
                        by Categories</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class=" rounded d-flex align-items-center justify-content-between mb-3 bg-dark text-white px-2">
                            <label class=" mt-2" for="">Categories</label>
                            <span class="badge border font-weight-normal">{{ $category->count() + 1 }}</span>
                        </div>
                        <div class=" d-flex align-items-center justify-content-between mb-3 pt-1">
                            <a href="{{ route('user#home') }}" class=" text-dark">
                                <label class="" for="">All</label>
                            </a>
                        </div>
                        @foreach ($category as $c)
                            <div class=" d-flex align-items-center justify-content-between mb-3 pt-1">
                                <a href="{{ route('user#filter', $c->id) }}" class=" text-dark">
                                    <label class="" for="">{{ $c->name }}</label>
                                </a>
                            </div>
                        @endforeach
                    </form>
                </div>
                <!-- Price End -->

                <div class="">
                    <button class="btn btn btn-warning w-100">Order</button>
                </div>
                <!-- Size End -->
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <a class=" btn btn-dark py-2 position-relative me-3" href="{{ route('user#cartList') }}">
                                    <i class="fa-solid fa-cart-plus"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ count($cart) }}
                                    </span>
                                </a>

                                <a class=" btn btn-dark py-2 position-relative" href="{{ route('user#history') }}">
                                    <i class="fa-solid fa-clock-rotate-left"></i>History
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ count($history) }}
                                    </span>
                                </a>

                            </div>

                            <div class="ml-2">
                                <div class="btn-group">
                                    <select name="sorting" id="sortingOption" class=" form-select">
                                        <option value="">Choose One Option</option>
                                        <option value="ascending">Ascending</option>
                                        <option value="descending">Descending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="dataList" class=" row">
                        @if ($pizza->count() != 0)
                            @foreach ($pizza as $p)
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4" id="myForm">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img style="height: 230px;object-fit:cover;object-position:center;"
                                                class="img-fluid w-100" src="{{ asset('storage/' . $p->image) }}"
                                                alt="">
                                            <div class="product-action">
                                                {{-- <a class="btn btn-outline-dark p-2" href=""><i
                                                        class="fa fa-shopping-cart"></i></a> --}}
                                                <a class="btn btn-outline-dark p-2"
                                                    href="{{ route('user#pizzaDetails', $p->id) }}"><i
                                                        class="fa fa-shopping-cart"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate"
                                                href="">{{ $p->name }}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>{{ $p->price }}kyats</h5>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center mb-1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class=" text-center shadow-sm fs-1 col-6 offset-3 py-5"> There Is No Pizza <i
                                    class=" fa-solid fa-pizza-slice ms-3"></i></p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection


@section('scriptsource')
    <script>
        $(document).ready(function() {
            $("#sortingOption").change(function() {
                $eventOption = $("#sortingOption").val();
                if ($eventOption == "ascending") {
                    $.ajax({
                        type: "get",
                        url: "http://127.0.0.1:8000/user/ajax/pizzaList",
                        data: {
                            "status": "asc"
                        },
                        dataType: "json",
                        success: function(response) {
                            $list = "";
                            for ($i = 0; $i < response.length; $i++) {
                                $list += `
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4" id="myForm">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img style="height: 225px;object-fit:cover;object-position:center;"
                                            class="img-fluid w-100" src="{{ asset('storage/${response[$i].image}') }}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark p-2" href=""><i
                                                    class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark p-2" href=""><i
                                                    class="fa fa-circle-info"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${response[$i].price}kyats</h5>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                        </div>
                                    </div>
                                  </div>
                               </div>`
                            }
                            $("#dataList").html($list);

                        }
                    });
                } else if ($eventOption == "descending") {
                    $.ajax({
                        type: "get",
                        url: "http://127.0.0.1:8000/user/ajax/pizzaList",
                        data: {
                            "status": "desc"
                        },
                        dataType: "json",
                        success: function(response) {
                            $list = "";
                            for ($i = 0; $i < response.length; $i++) {
                                $list += `
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4" id="myForm">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img style="height: 225px;object-fit:cover;object-position:center;"
                                            class="img-fluid w-100" src="{{ asset('storage/${response[$i].image}') }}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark p-2" href=""><i
                                                    class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark p-2" href=""><i
                                                    class="fa fa-circle-info"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${response[$i].price}</h5>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                        </div>
                                    </div>
                                  </div>
                               </div>`
                            }
                            $("#dataList").html($list);
                        }
                    });
                }
            });
        });
    </script>
@endsection
