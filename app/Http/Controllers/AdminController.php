<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //direct changePasswordPage
    public function changePasswordPage()
    {
        return view("admin.account.changePassword");
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

    //Direct admin Details Page
    public function details()
    {
        return view("admin.account.details");
    }

    //direct admin profile edit page
    public function edit()
    {
        return view("admin.account.edit");
    }

    //Update acc Profile
    public function update(Request $request, $id)
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
        return redirect()->route("admin#details")->with(["updateSuccess" => "Admin Account Updated.."]);
    }

    //Direct Admin List Page
    public function list()
    {
        $admin = User::where("role", "admin")
            ->when(request("key"), function ($query) {
                $query->where("name", "like", "%" . request("key") . "%");
                // ->orWhere("email", "like", "%" . request("key") . "%")
                // ->orWhere("gender", "like", "%" . request("key") . "%")
                // ->orWhere("phone", "like", "%" . request("key") . "%")
                // ->orWhere("address", "like", "%" . request("key") . "%");
            })
            ->paginate(3);
        $admin->appends(request()->all());
        return view("admin.account.list", compact("admin"));
    }

    //Delete Admin acc
    public function delete($id)
    {
        User::where("id", $id)->delete();
        return back()->with(["deleteSuccess" => "Admin Delete Success.."]);
    }

    //Admin Acc Changerole page
    public function changeRole($id)
    {
        $account = User::where("id", $id)->first();
        return view("admin.account.changeRole", compact("account"));
    }

    //Change Role
    public function change($id, Request $request)
    {
        $data = $this->requestUserData($request);
        User::where("id", $id)->update($data);
        return redirect()->route("admin#list");
    }

    //Ajax Change Role
    public function ajaxChangeRole(Request $request)
    {
        User::where("id", $request->userId)->update(["role" => $request->role]);
        return response()->json(["status" => "success"], 200);
    }

    //Request User Data For Role Change
    private function requestUserData($request)
    {
        return [
            "role" => $request->role
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
            "image" => "mimes:png,jpg,jpeg|file"
        ])->validate();
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

    //Password Validation Check
    private function passwordValidationcheck($request)
    {
        Validator::make($request->all(), [
            "oldPassword" => "required|min:6|max:10",
            "newPassword" => "required|min:6|max:10",
            "confirmPassword" => "required|min:6|max:10|same:newPassword",
        ])->validate();
    }
}