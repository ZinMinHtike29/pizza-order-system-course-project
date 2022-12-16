<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\user\AjaxController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\UserManagementController;
use Symfony\Component\HttpKernel\DataCollector\AjaxDataCollector;
use Symfony\Component\Routing\Annotation\Route as AnnotationRoute;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware("admin_auth")->group(function () {
    //login,register
    Route::redirect("/", "loginPage");
    Route::get("loginPage", [AuthController::class, "loginPage"])->name("auth#loginPage");
    Route::get("registerPage", [AuthController::class, "registerPage"])->name("auth#registerPage");
});

Route::middleware(['auth'])->group(function () {

    // dashboard
    Route::get("dashboard", [AuthController::class, "dashboard"])->name("dashboard");
    //admin
    Route::middleware("admin_auth")->group(function () {
        //category
        Route::prefix("category")->group(function () {
            Route::get("list", [CategoryController::class, "list"])->name("category#list");
            Route::get("createPage", [CategoryController::class, "createPage"])->name("category#createPage");
            Route::post("create", [CategoryController::class, "create"])->name("category#create");
            Route::get("delete/{id}", [CategoryController::class, "delete"])->name("category#delete");
            Route::get("edit/{id}", [CategoryController::class, "edit"])->name("category#edit");
            Route::post("updatePage", [CategoryController::class, "update"])->name("category#update");
        });

        // admin account
        Route::prefix("admin")->group(function () {
            //password
            Route::get("password/changePage", [AdminController::class, "changePasswordPage"])->name("admin#changePasswordPage");
            Route::post("change/password", [AdminController::class, "changePassword"])->name("admin#changepassword");

            //account profile
            Route::get("details", [AdminController::class, "details"])->name("admin#details");
            Route::get("edit", [AdminController::class, "edit"])->name("admin#edit");
            Route::post("update/{id}", [AdminController::class, "update"])->name("admin#update");

            //Admin List
            Route::get("list", [AdminController::class, "list"])->name("admin#list");
            Route::get("delete/{id}", [AdminController::class, "delete"])->name("admin#delete");
            Route::get("changeRole/{id}", [AdminController::class, "changeRole"])->name("admin#changeRole");
            Route::post("change/role/{id}", [AdminController::class, "change"])->name("admin#change");
            Route::get("ajax/change/role", [AdminController::class, "ajaxChangeRole"])->name("admin#ajaxChangeRole");
        });

        //products
        Route::prefix("products")->group(function () {
            Route::get("list", [ProductController::class, "list"])->name("product#list");
            Route::get("createPage", [ProductController::class, "createPage"])->name("product#createPage");
            Route::post("create", [ProductController::class, "create"])->name("product#create");
            Route::get("delete/{id}", [ProductController::class, "delete"])->name("product#delete");
            Route::get("edit/{id}", [ProductController::class, "edit"])->name("product#edit");
            Route::get("updatePage/{id}", [ProductController::class, "updatePage"])->name("product#updatePage");
            Route::post("update", [ProductController::class, "update"])->name("product#update");
        });

        //Order
        Route::prefix("order")->group(function () {
            Route::get("list", [OrderController::class, "orderList"])->name("admin#orderList");
            Route::get("change/status", [OrderController::class, "changeStatus"])->name("admin#changeStatus");
            Route::get("ajax/change/status", [OrderController::class, "ajaxChangeStatus"])->name("admin#ajaxChangeStatus");
            Route::get("listInfo/{orderCode}", [OrderController::class, "listInfo"])->name("admin#listInfo");
        });

        //User Management
        Route::prefix("user")->group(function () {
            Route::get("list", [UserManagementController::class, "userList"])->name("admin#userList");
            Route::get("ajax/change/role", [UserManagementController::class, "userChangeRole"])->name("admin#userChangeRole");
            Route::get("ajax/delete/user", [UserManagementController::class, "deleteUser"])->name("admin#deleteUser");
        });

        //Contact
        Route::prefix("contact")->group(function () {
            Route::get("message/list", [ContactController::class, "messageList"])->name('admin#messageList');
            Route::get("filter/message", [ContactController::class, "filterMessage"])->name("admin#filterMessage");
            Route::get("message/details/{messageId}", [ContactController::class, "detailsMessage"])->name("admin#messageDetails");
            Route::get("message/reply/{messageId}", [ContactController::class, "replyMessagePage"])->name("admin#replyMessagePage");
            Route::post("reply/message", [ContactController::class, "replyMessage"])->name("admin#replyMessage");
        });
    });

    //User
    Route::group(["prefix" => "user", "middleware" => "user_auth"], function () {
        Route::get("homePage", [UserController::class, "home"])->name("user#home");
        Route::get("/filter/{id}", [UserController::class, "filter"])->name("user#filter");
        Route::get("/history", [UserController::class, "history"])->name("user#history");

        // Pizza
        Route::prefix("pizza")->group(function () {
            Route::get("details/{id}", [UserController::class, "pizzaDetails"])->name("user#pizzaDetails");
        });

        //Cart
        Route::prefix("cart")->group(function () {
            Route::get("cartList", [UserController::class, "cartList"])->name("user#cartList");
        });

        //Account
        Route::prefix("password")->group(function () {
            Route::get("change", [UserController::class, "changePasswordPage"])->name("user#changePasswordPage");
            Route::post("change", [UserController::class, "changePassword"])->name("user#changePassword");
        });

        //Profile
        Route::prefix("account")->group(function () {
            Route::get("change", [UserController::class, "accChangePage"])->name("user#accChangePage");
            Route::post("change/{id}", [UserController::class, "accChange"])->name("user#accChange");
        });

        //Ajax
        Route::prefix("ajax")->group(function () {
            Route::get("pizzaList", [AjaxController::class, "pizzaList"])->name("ajax#pizzalist");
            Route::get("addToCart", [AjaxController::class, "addToCart"])->name("ajax#addToCart");
            Route::get("order", [AjaxController::class, "order"])->name("ajax#order");
            Route::get("clear/cart", [AjaxController::class, 'clearCart'])->name("ajax#clearCart");
            Route::get("clear/current/product", [AjaxController::class, "clearCurrentProduct"])->name("ajax#clearCurrentProduct");
            Route::get("increase/viewCount", [AjaxController::class, "increaseViewCount"])->name("ajax#increaseViewCount");
        });

        //Contact
        Route::prefix("contact")->group(function () {
            Route::get("page", [ContactController::class, "contactPage"])->name("user#contactPage");
            Route::post("message", [ContactController::class, "sendMessage"])->name("user#sendMessage");
            Route::get("viewReply/{messageID}", [ContactController::class, "viewReply"])->name("user#viewReply");
            Route::get("ajax/delete/Message", [ContactController::class, "ajaxDeleteMessage"])->name("user#ajaxDeleteMessage");
        });
    });
});