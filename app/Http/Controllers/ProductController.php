<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //Direct Product List PAge
    public function list()
    {
        $pizzas = Product::select("products.*", "categories.name as category_name")
            ->when(request("key"), function ($query) {
                $query->where("products.name", "like", "%" . request("key") . "%");
            })
            ->leftJoin("categories", "products.category_id", "categories.id")
            ->orderBy("products.created_at", "desc")
            ->paginate(3);
        $pizzas->appends(request()->all());
        return view("admin.product.pizzaList", compact("pizzas"));
    }

    // Direct Pizza Create Page
    public function createPage()
    {
        $categories = Category::select("id", "name")->get();
        return view("admin.product.create", compact("categories"));
    }

    //create pizza
    public function create(Request $request)
    {
        $this->productValidationCheck($request, "create");
        $data = $this->requestProductInfo($request);

        $fileName = uniqid() . $request->file("pizzaImage")->getClientOriginalName();
        $request->file("pizzaImage")->storeAs("public", $fileName);
        $data["image"] = $fileName;

        Product::create($data);
        return redirect()->route("product#list");
    }

    //Delete Pizza
    public function delete($id)
    {
        Product::where("id", $id)->delete();
        return redirect()->route("product#list")->with(["deleteSuccess" => "Product Delete Success..."]);
    }

    //Direct Edit Page
    public function edit($id)
    {
        $pizza = Product::select("products.*", "categories.name as category_name")
            ->where("products.id", $id)
            ->leftJoin("categories", "products.category_id", "categories.id")
            ->first();
        return view("admin.product.edit", compact("pizza"));
    }

    //Direct Update Page
    public function updatePage($id)
    {
        $pizza = Product::where("id", $id)->first();
        $category = Category::get();
        return view("admin.product.update", compact("pizza", "category"));
    }

    //Update Pizza
    public function update(Request $request)
    {
        $this->productValidationCheck($request, "update");
        $data = $this->requestProductInfo($request);
        if ($request->hasFile("pizzaImage")) {
            $db_image = Product::select("image")->where("id", $request->pizzaId)->first();

            if ($db_image != null) {
                Storage::delete("public/$db_image");
            }

            $fileName = uniqid() . $request->file("pizzaImage")->getClientOriginalName();
            $request->file("pizzaImage")->storeAs("public", $fileName);
            $data["image"] = $fileName;
        }
        Product::where("id", $request->pizzaId)->update($data);
        return redirect()->route("product#list");
    }

    //Request Product Info
    private function requestProductInfo($request)
    {
        return [
            "category_id" => $request->pizzaCategory,
            "name" => $request->pizzaName,
            "description" => $request->pizzaDescription,
            "price" => $request->pizzaPrice,
            "waiting_time" => $request->pizzaWaitingTime
        ];
    }

    //Product Validation Check
    private function productValidationCheck($request, $action)
    {
        $validationRule =  [
            "pizzaName" => "required|min:5|unique:products,name," . $request->pizzaId,
            "pizzaCategory" => "required",
            "pizzaDescription" => "required|min:10",
            "pizzaPrice" => "required",
            "pizzaWaitingTime" => "required"
        ];
        $validationRule["pizzaImage"] = $action == "create" ?  "required|mimes:jpg,jpeg,png,webp|file" : "mimes:jpg,jpeg,png,webp|file";
        Validator::make($request->all(), $validationRule)->validate();
    }
}