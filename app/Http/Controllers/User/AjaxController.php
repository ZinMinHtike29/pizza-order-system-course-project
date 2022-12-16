<?php

namespace App\Http\Controllers\user;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    //return Pizzalist
    public function pizzaList(Request $request)
    {
        if ($request->status == "desc") {
            $data = Product::orderBy("created_at", "desc")->get();
        } else {
            $data = Product::orderBy("created_at", "asc")->get();
        }
        return response()->json($data, 200);
    }

    //Add to Cart
    public function addToCart(Request $request)
    {
        $data = $this->getOrderData($request);
        Cart::create($data);
        $response = [
            "message" => "Add To Cart Complete",
            "status" => "success"
        ];
        return response()->json($response, 200);
    }

    //Order Products
    public function order(Request $request)
    {
        $total = 0;
        foreach ($request->all() as $item) {
            $data = OrderList::create($item);
            $total += $data->total;
        }
        Cart::where("user_id", Auth::user()->id)->delete();
        Order::create([
            "user_id" => Auth::user()->id,
            "order_code" => $data->order_code,
            "total_price" => $total + 3000
        ]);

        $response = [
            "message" => "Order Complete",
            "status" => true,
        ];
        return response()->json($response, 200);
    }

    //Clear Cart
    public function clearCart()
    {
        Cart::where("user_id", Auth::user()->id)->delete();
    }

    //Clear Current Product
    public function clearCurrentProduct(Request $request)
    {
        // logger($request->all());
        Cart::where("user_id", Auth::user()->id)
            ->where("id", $request->order_id)
            ->where("product_id", $request->product_id)
            ->delete();
    }

    //Increase View Count
    public function increaseViewCount(Request $request)
    {
        $pizza = Product::where("id", $request->productId)->first();
        $data = [
            "view_count" => $pizza->view_count + 1
        ];
        Product::where("id", $request->productId)->update($data);
    }

    //Get Order Data
    private function getOrderData($request)
    {
        return [
            "user_id" => $request->userId,
            "product_id" => $request->pizzaId,
            "qty" => $request->count,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ];
    }
}