@extends('admin.layout.master')

@section('title', 'Order List')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class=" my-3">
                        <a href="{{ route('admin#orderList') }}" class=" text-dark">
                            <i class="fa-solid fa-arrow-left-long"></i> Back
                        </a>
                    </div>
                    <div class="card col-4">
                        <div class="card-header bg-white">
                            <h3><i class="fa-solid fa-clipboard me-2"></i> Order Info
                            </h3>
                            <small class=" text-warning">
                                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                                Include
                                Delivery Charges</small>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col"><i class="fa fa-user me-3"></i> Name </div>
                                <div class="col text-uppercase">{{ $orderList[0]->user_name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col"><i class="fa-solid fa-barcode me-3"></i> Order Code</div>
                                <div class="col">{{ $orderList[0]->order_code }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col"><i class="fa-solid fa-calendar-days me-3"></i> Order Date</div>
                                <div class="col">{{ $orderList[0]->created_at->format('j-F-Y') }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col"><i class="fa-solid fa-money-bill-wave me-3"></i> Total</div>
                                <div class="col">{{ $order->total_price }}kyats</div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($orderList as $o)
                                    <tr class="tr-shadow">
                                        <td class=" d-none"></td>
                                        <td>{{ $o->id }}</td>
                                        <td><img src="{{ asset('storage/' . $o->product_image) }}"
                                                style="object-fit: cover;object-position:center;" class=" img-120 "
                                                alt=""></td>
                                        <td>{{ $o->product_name }}</td>
                                        <td>{{ $o->qty }}</td>
                                        <td>{{ $o->total }}kyats</td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
