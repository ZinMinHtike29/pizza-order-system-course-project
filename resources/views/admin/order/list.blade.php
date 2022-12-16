@extends('admin.layout.master')

@section('title', 'Order List')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->

                    <div class="row">
                        <div class=" col-4">
                            <h3 class=" text-secondary d-flex">Search Key : <span class=" text-danger">
                                    {{ request('key') }}</span>
                            </h3>
                        </div>
                        <div class=" col-4 offset-4">
                            <form action="{{ route('admin#orderList') }}" class=" d-flex" method="get">
                                <input type="text" class=" form-control" name="key" id=""
                                    placeholder="Search Order." value="{{ request('key') }}">
                                <button type="submit" class=" btn btn-dark">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </form>
                        </div>
                    </div>


                    <div class=" row my-3">
                        <form action="{{ route('admin#changeStatus') }}" method="get" class=" d-flex col-8">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <h3 class=" input-group-text bg-white text-dark">
                                        <i class="fa-solid fa-database me-2"></i>{{ $order->count() }}
                                    </h3>
                                </div>
                                <select name="orderStatus" class=" custom-select form-select col-5 me-1"
                                    id="inputGroupSelect02">
                                    <option value="">All</option>
                                    <option value="0"@if (request('orderStatus') == '0') selected @endif>Pending</option>
                                    <option value="1" @if (request('orderStatus') == '1') selected @endif>Accept</option>
                                    <option value="2" @if (request('orderStatus') == '2') selected @endif>Reject</option>
                                </select>
                                <div class="input-group-append">
                                    <button type="submit" class=" btn bg-dark text-white input-group-text">
                                        <i class="fa-solid fa-magnifying-glass me-2"></i>
                                        Search
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>

                    @if ($order->count() != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>User Id</th>
                                        <th>User Name</th>
                                        <th>Order Date</th>
                                        <th>Order Code</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="dataList">

                                    @foreach ($order as $o)
                                        <tr class="tr-shadow">
                                            <input type="hidden" name="" class="orderId"
                                                value="{{ $o->id }}">
                                            <td class="">{{ $o->user_id }}</td>
                                            <td class=" ">{{ $o->user_name }}</td>
                                            <td class=" ">{{ $o->created_at->format('j-F-Y') }}</td>
                                            <td class=" "><a
                                                    href="{{ route('admin#listInfo', $o->order_code) }}">{{ $o->order_code }}</a>
                                            </td>
                                            <td class="amount">{{ $o->total_price }}kyats</td>
                                            <td class=" ">
                                                <select name="status" id="" class=" form-select statusChange">
                                                    <option value="0"
                                                        @if ($o->status == 0) selected @endif>Pending</option>
                                                    <option value="1"
                                                        @if ($o->status == 1) selected @endif>Accept</option>
                                                    <option value="2"
                                                        @if ($o->status == 2) selected @endif>Reject</option>
                                                </select>

                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{-- {{ $order->links() }} --}}
                            </div>
                        </div>
                    @else
                        <h3 class=" text-secondary text-center mt-3">There Is No Order Here!</h3>
                    @endif
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function() {
            // $("#orderStatus").change(function() {
            //     $status = $("#orderStatus").val();
            //     $list = "";
            //     $.ajax({
            //         type: "get",
            //         url: "http://127.0.0.1:8000/order/ajax/status",
            //         data: {
            //             "status": $status,
            //         },
            //         dataType: "json",
            //         success: function(response) {
            //             for ($i = 0; $i < response.length; $i++) {
            //                 $dbDate = new Date(response[$i].created_at);
            //                 $dbDate = $dbDate.getDate() + "-" + $dbDate.toLocaleString(
            //                     'default', {
            //                         month: 'long'
            //                     }) + "-" + $dbDate.getFullYear();
            //                 $list += `
        //                 <tr class="tr-shadow">
        //                     <input type="hidden" name="" class="orderId"
        //                     value="${response[$i].id}">
        //                     <td class="">${response[$i].user_id}</td>
        //                     <td class=" ">${response[$i].user_name}</td>
        //                     <td class=" ">${$dbDate}</td>
        //                     <td class=" ">${response[$i].order_code}</td>
        //                     <td class=" ">${response[$i].total_price}kyats</td>
        //                     <td class=" ">
        //                         <select name="status" id="" class="form-select statusChange">
        //                             <option value="0" ${response[$i].status == 0 ? "selected" : ""}>Pending</option>
        //                             <option value="1" ${response[$i].status == 1 ? "selected" : ""}>Accept</option>
        //                             <option value="2" ${response[$i].status == 2 ? "selected" : ""}>Reject</option>
        //                         </select>
        //                     </td>
        //                 </tr>
        //                 <tr class="spacer"></tr>
        //                 `
            //             }
            //             $("#count").html(response.length)
            //             $("#dataList").html($list);
            //         }
            //     });
            // });
            $(".statusChange").change(function() {
                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $orderId = $parentNode.find(".orderId").val();
                $.ajax({
                    type: "get",
                    url: "http://127.0.0.1:8000/order/ajax/change/status",
                    data: {
                        status: $currentStatus,
                        orderId: $orderId
                    },
                    dataType: "json",
                });
                // location.reload();
            })
        });
    </script>
@endsection
