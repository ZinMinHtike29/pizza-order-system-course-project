<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //Direct CAtegory List PAge
    public function list()
    {
        $categories = Category::when(request("key"), function ($query) {
            $searchKey = request("key");
            $query->where("name", "like", "%$searchKey%");
        })
            ->orderBy("id", "desc")
            ->paginate(5);
        return view("admin.category.list", compact("categories"));
    }

    //Direct Create Page
    public function createPage()
    {
        return view("admin.category.create");
    }

    //Create Category
    public function create(Request $request)
    {
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::create($data);
        return redirect()->route("category#list");
    }

    //Delete Category
    public function delete($id)
    {
        Category::where("id", $id)->delete();
        return back()->with(["deleteSuccess" => "Category Deleted..."]);
    }

    //Direct edit Page
    public function edit($id)
    {
        $category = Category::where("id", $id)->first();
        return view("admin.category.edit", compact("category"));
    }

    //Update Category
    public function update(Request $request)
    {
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::where("id", $request->categoryId)->update($data);
        return redirect()->route("category#list");
    }

    //Category Validation Check
    private function categoryValidationCheck($request)
    {
        Validator::make($request->all(), [
            "categoryName" => "required|min:4|unique:categories,name,$request->categoryId"
        ])->validate();
    }

    //request Category Data
    private function requestCategoryData($request)
    {
        return [
            "name" => $request->categoryName
        ];
    }
}