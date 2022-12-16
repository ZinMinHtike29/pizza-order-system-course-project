@extends('user.layout.master')
@section('title', 'Carts')
@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle" id="dataTable">
                        @foreach ($cartList as $cart)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/' . $cart->image) }}" alt=""
                                        style="width:100px; object-fit:cover;object-position:center;"
                                        class=" img-thumbnails">
                                </td>
                                <td class="align-middle">
                                    {{ $cart->pizza_name }}
                                </td>
                                <input type="hidden" name="" class="orderId" value="{{ $cart->id }}">
                                <input type="hidden" name="" class="productId" value="{{ $cart->product_id }}">
                                <input type="hidden" name="" class="userId" value="{{ $cart->user_id }}">
                                <td class="align-middle" id="price">{{ $cart->pizza_price }} kyats</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn me-1">
                                            <button class="btn btn-sm btn-warning btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text"
                                            class="form-control text-bold form-control-sm  border-0 text-center"
                                            id="qty" value="{{ $cart->qty }}">
                                        <div class="input-group-btn ms-1">
                                            <button class="btn btn-sm btn-warning btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle" id="total">{{ $cart->qty * $cart->pizza_price }} kyats</td>
                                <td class="align-middle"><button class="btn btn-sm btn-danger btn-remove"><i
                                            class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class=" pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subTotalPrice">{{ $totalPrice }} kyats</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery fee</h6>
                            <h6 class="font-weight-medium">3000 kyats</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalResult">{{ $totalPrice + 3000 }} kyats</h5>
                        </div>
                        <button class="btn btn-block btn-warning font-weight-bold my-3 py-3" id="orderBtn">Proceed To
                            Checkout</button>
                        <button class="btn btn-block btn-danger font-weight-bold my-3 py-3" id="clearBtn">Clear
                            Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection
@section('scriptsource')
    <script src="{{ asset('js/cart.js') }}"></script>
    <script>
        $("#orderBtn").click(function() {
            $orderList = [];
            $random = Math.floor(Math.random() * 302020202022);
            $("#dataTable tr").each(function(index, row) {
                $orderList.push({
                    'user_id': $(row).find(".userId").val(),
                    "product_id": $(row).find(".productId").val(),
                    "qty": $(row).find("#qty").val(),
                    "total": Number($(row).find("#total").html().replace("kyats", "")),
                    "order_code": "MYSHOP" + $random,
                })
            })

            $.ajax({
                type: "get",
                url: "http://127.0.0.1:8000/user/ajax/order",
                data: Object.assign({}, $orderList),
                dataType: "json",
                success: function(response) {
                    if (response.status == true) {
                        window.location.href = "http://127.0.0.1:8000/user/homePage";
                    }
                }
            });

        })
        //When Clear Button Click
        $('#clearBtn').click(function() {
            $("#dataTable tr").remove();
            $("#subTotalPrice").html(`0kyats`);
            $("#finalResult").html("3000kysts");
            $.ajax({
                type: "get",
                url: "http://127.0.0.1:8000/user/ajax/clear/cart",
                dataType: "json",

            });
        })
        //When remove button click
        $(".btn-remove").click(function() {
            $parentNode = $(this).parents("tr");
            $productId = $parentNode.find(".productId").val();
            $orderId = $parentNode.find(".orderId").val();
            $parentNode.remove();
            $.ajax({
                type: "get",
                url: "http://127.0.0.1:8000/user/ajax/clear/current/product",
                data: {
                    'product_id': $productId,
                    "order_id": $orderId
                },
                dataType: "json",
            });
            $totalPrice = 0;
            //total summary
            $("#dataTable tr").each(function(index, row) {
                $totalPrice += Number($(row).find("#total").text().replace("kyats", ""));
            });
            $("#subTotalPrice").html(`${$totalPrice}kyats`);
            $("#finalResult").html(`${$totalPrice+3000} kyats`);
        });
    </script>
@endsection
