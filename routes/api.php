<?php

use App\Http\Controllers\API\RouteController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Get
Route::get("product/list", [RouteController::class, "productList"]);
Route::get("category/list", [RouteController::class, "categoryList"]);
Route::get("order/list", [RouteController::class, "orderList"]);
Route::get("contact/list", [RouteController::class, "contactList"]);
Route::get("reply/list", [RouteController::class, "replyList"]);
Route::get("delete/category/{id}", [RouteController::class, "deleteCategoryWithGet"]);

//Post
Route::post("create/category", [RouteController::class, "categoryCreate"]);
Route::post("create/contact", [RouteController::class, "contactCreate"]);
Route::post("delete/category", [RouteController::class, "deleteCategory"]);
Route::post("category/details", [RouteController::class, "categoryDetails"]);
Route::post("category/update", [RouteController::class, "updateCategory"]);

/**
 *  Category List
 * http://127.0.0.1:8000/api/category/list (get)
 *
 * Create Category
 * http://127.0.0.1:8000/api/create/category (post)
 *
 * key =>name
 *
 * Delete Category
 * http://127.0.0.1:8000/api/delete/category (post)
 * key => id
 *
 * Update Category
 * http://127.0.0.1:8000/api/category/update (post)
 *
 * key => id , name
 *
 */