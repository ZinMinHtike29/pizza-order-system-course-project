<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //Direct Orser List Page
    public function orderList()
    {
        $order = Order::select("orders.*", "users.name as user_name")
            ->when(request("key"), function ($query) {
                $query->where("order_code", "like", request("key"));
            })
            ->orderBy("orders.created_at", "desc")
            ->leftJoin("users", "users.id", "orders.user_id")
            ->get();
        return view("admin.order.list", compact("order"));
    }

    //Sort With Ajax
    public function changeStatus(Request $request)
    {
        // ->orWhere("orders.status", $request->status)
        // ->get();
        $order =  Order::select("orders.*", "users.name as user_name")
            ->when(request("key"), function ($query) {
                $query->where("order_code", "like", request("key"));
            })
            ->orderBy("orders.created_at", "desc")
            ->leftJoin("users", "users.id", "orders.user_id");
        if ($request->orderStatus == null) {
            $order = $order->get();
        } else {
            $order = $order->orWhere("orders.status", $request->orderStatus)->get();
        }
        return view("admin.order.list", compact("order"));
    }

    //Change Order Status With Ajax
    public function ajaxChangeStatus(Request $request)
    {
        Order::where("id", $request->orderId)->update(["status" => $request->status]);
    }

    //Direct Order  List Info Page With Data
    public function listInfo($orderCode)
    {
        $order = Order::where("order_code", $orderCode)->first();
        $orderList = OrderList::select("order_lists.*", "products.name as product_name", "products.image as product_image", "users.name as user_name")
            ->leftJoin("products", "products.id", "order_lists.product_id")
            ->leftJoin("users", "users.id", "order_lists.user_id")
            ->where("order_lists.order_code", $orderCode)
            ->get();
        return view("admin.order.productList", compact("orderList", "order"));
    }
}