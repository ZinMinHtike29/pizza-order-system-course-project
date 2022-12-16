<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Product;
use App\Models\Reply;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    //Get All Product List
    public function productList()
    {
        $products = Product::get();
        return response()->json($products, 200);
    }

    //Get All Category List
    public function categoryList()
    {
        $categories = Category::orderBy("id", "desc")->get();
        return response()->json($categories, 200);
    }

    //Get All Order List
    public function orderList()
    {
        $order = Order::get();
        return response()->json($order, 200);
    }

    //Get All Order List
    public function contactList()
    {
        $contact = Contact::get();
        return response()->json($contact, 200);
    }

    //Get All Reply List
    public function replyList()
    {
        $reply = Reply::get();
        return response()->json($reply, 200);
    }

    //Create New Category
    public function categoryCreate(Request $request)
    {
        $data = [
            "name" => $request->name,
        ];
        $response = Category::create($data);
        return response()->json($response, 200);
    }

    //Create New Contact
    public function contactCreate(Request $request)
    {
        $data = [
            "user_id" => $request->userId,
            "subject" => $request->subject,
            "message" => $request->message
        ];
        $response = Contact::create($data);
        return response()->json($response, 200);
    }

    //Delete Category with Get Method
    public function deleteCategoryWithGet($id)
    {
        $data = Category::where("id", $id)->first();
        if (isset($data)) {
            Category::where("id", $id)->delete();
            return response()->json(["message" => "Delete Success..", "status" => true], 200);
        }
        return response()->json(["message" => "There is No Category..", "status" => false], 200);
    }

    //Delete Category
    public function deleteCategory(Request $request)
    {
        $data = Category::where("id", $request->id)->first();
        if (isset($data)) {
            Category::where("id", $request->id)->delete();
            return response()->json(["message" => "Delete Success..", "status" => true], 200);
        }
        return response()->json(["message" => "There is No Category..", "status" => false], 404);
    }

    //Category Details
    public function categoryDetails(Request $request)
    {
        $data = Category::where("id", $request->id)->first();
        if (isset($data)) {
            return response()->json(["status" => true, "data" => $data], 200);
        }
        return response()->json(["message" => "There is No Category..", "status" => false], 404);
    }

    //Update Category
    public function updateCategory(Request $request)
    {
        $dbdata = Category::where("id", $request->id)->first();
        if (isset($dbdata)) {
            $data = $this->getCategoryData($request);
            Category::where("id", $request->id)->update($data);
            $response = Category::where("id", $request->id)->first();
            return response()->json(["status" => true, "message" => "Category Update Success..", "data" => $response], 200);
        }
        return response()->json(["message" => "There is No Category For Update..", "status" => false], 404);
    }

    //Get Category Data
    private function getCategoryData($request)
    {
        return [
            "name" => $request->name,
        ];
    }
}