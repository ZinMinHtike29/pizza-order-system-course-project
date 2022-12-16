<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //Direct USer Home PAge
    public function home()
    {
        $pizza = Product::orderBy("id", "desc")->get();
        $category = Category::get();
        $cart = Cart::where("user_id", Auth::user()->id)->get();
        $history = Order::where("user_id", Auth::user()->id)->get();
        return view("user.main.home", compact("pizza", "category", "cart", "history"));
    }

    //Direct Change PAssword Page
    public function changePasswordPage()
    {
        return view("user.password.change");
    }

    //Change Password
    public function changePassword(Request $request)
    {
        $this->passwordValidationcheck($request);

        $user = User::select("password")->where("id", Auth::user()->id)->first();
        $db_password = $user->password;

        if (Hash::check($request->oldPassword, $db_password)) {
            $data = ["password" => Hash::make($request->newPassword)];
            User::where("id", Auth::user()->id)->update($data);

            // Auth::logout();
            // return redirect()->route("auth#loginPage");
            return back()->with(["changeSuccess" => "Password Change Success..."]);
        }

        return back()->with(["notMatch" => "The Old Password Not Match. Try Again !"]);
    }

    //User Acc Update Page
    public function accChangePage()
    {
        return view("user.profile.account");
    }

    //User Acc Update
    public function accChange(Request $request, $id)
    {
        $this->accountValidationcheck($request);
        $data = $this->getUserData($request);

        //for image
        if ($request->hasFile("image")) {
            $db_Image = User::where("id", $id)->first();
            $db_Image = $db_Image->image;
            if ($db_Image != null) {
                Storage::delete("public/$db_Image");
            };
            $fileName = uniqid() . $request->file("image")->getClientOriginalName();
            $request->file("image")->storeAs("public", $fileName);
            $data["image"] = $fileName;
        }

        User::where("id", $id)->update($data);
        return back()->with(["updateSuccess" => "User Account Updated.."]);
    }

    //Filter By Category
    public function filter($categoryId)
    {
        $pizza = Product::where("category_id", $categoryId)->orderBy("id", "desc")->get();
        $category = Category::get();
        $cart = Cart::where("user_id", Auth::user()->id)->get();
        $history = Order::where("user_id", Auth::user()->id)->get();
        return view("user.main.home", compact("pizza", "category", "cart", "history"));
    }

    // Direct Pizza Details Page
    public function pizzaDetails($pizzaId)
    {
        $pizza = Product::where("id", $pizzaId)->first();
        $pizzaList = Product::get();
        return view("user.main.details", compact("pizza", "pizzaList"));
    }

    //Direct Cart List Page
    public function cartList()
    {
        $cartList = Cart::select("carts.*", "products.name as pizza_name", "products.price as pizza_price", "products.image as image")
            ->leftJoin("products", "products.id", "carts.product_id")
            ->where("carts.user_id", Auth::user()->id)
            ->get();
        $totalPrice = 0;
        foreach ($cartList as $c) {
            $totalPrice += $c->pizza_price * $c->qty;
        }
        return view("user.cart.cart", compact("cartList", "totalPrice"));
    }

    //Direct History Page
    public function history()
    {
        $order = Order::orderBy("created_at", "desc")->where("user_id", Auth::user()->id)->paginate(6);
        return view("user.main.history", compact("order"));
    }


    //request user data
    private function getUserData($request)
    {
        return [
            "name" => $request->name,
            "email" => $request->email,
            "gender" => $request->gender,
            "phone" => $request->phone,
            "address" => $request->address,
            "updated_at" => Carbon::now(),
        ];
    }

    //Account Validation Check
    private function accountValidationcheck($request)
    {
        Validator::make($request->all(), [
            "name" => 'required',
            "email" => "required",
            "gender" => "required",
            "phone" => "required",
            "address" => "required",
            "image" => "mimes:png,jpg,jpeg,webp|file"
        ])->validate();
    }

    //Password Validation Check
    private function passwordValidationcheck($request)
    {
        Validator::make($request->all(), [
            "oldPassword" => "required|min:6",
            "newPassword" => "required|min:6",
            "confirmPassword" => "required|min:6|same:newPassword",
        ])->validate();
    }
}