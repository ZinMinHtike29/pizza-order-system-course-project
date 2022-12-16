<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    //Direct USerLIst PAge
    public function userList()
    {
        $users = User::where("role", "user")
            ->when(request("key"), function ($query) {
                $query->where("name", "like", "%" . request("key") . "%");
                // ->orWhere("email", "like", "%" . request("key") . "%")
                // ->orWhere("gender", "like", "%" . request("key") . "%")
                // ->orWhere("phone", "like", "%" . request("key") . "%")
                // ->orWhere("address", "like", "%" . request("key") . "%");
            })
            ->paginate(3);
        return view("admin.user.list", compact("users"));
    }

    //User Role Change With Ajax
    public function userChangeRole(Request $request)
    {
        User::where("id", $request->userId)->update(["role" => $request->role]);
    }

    //Delete User With Ajax
    public function deleteUser(Request $request)
    {
        User::where("id", $request->userId)->delete();
        return response()->json(["status" => true], 200);
    }
}