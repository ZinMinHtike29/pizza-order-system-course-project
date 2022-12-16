<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    //Direct Contact Page
    public function contactPage()
    {
        $messages = Contact::where("user_id", Auth::user()->id)->orderBy("created_at", "desc")->paginate(3);
        return view("user.contact.contact", compact("messages"));
    }

    //Send Message From User
    public function sendMessage(Request $request)
    {
        $this->valdationMessage($request);
        $data = [
            "user_id" => $request->userId,
            "subject" => $request->subject,
            "message" => $request->message
        ];
        Contact::create($data);
        return redirect()->route("user#contactPage")->with(["success" => "Thank You For Messaging Us ! We Will Reply Soon."]);
    }

    //Direct Message List PAge
    public function messageList()
    {
        $messages = Contact::select("contacts.*", "users.name as user_name", "users.email as user_email")
            ->leftJoin("users", "users.id", "contacts.user_id")
            ->orderBy("contacts.created_at", "desc")
            ->paginate(5);
        return view("admin.contact.messageList", compact("messages"));
    }

    //Filter Message
    public function filterMessage(Request $request)
    {
        $messages = Contact::select("contacts.*", "users.name as user_name", "users.email as user_email")
            ->leftJoin("users", "users.id", "contacts.user_id")
            ->orderBy("contacts.created_at", "desc");
        if ($request->replyStatus == null) {
            $messages = $messages->paginate(5);
        } elseif ($request->replyStatus == 0) {
            $messages = $messages->where("reply_status", $request->replyStatus)->paginate(5);
        }
        return view("admin.contact.messageList", compact("messages"));
    }

    //Direct Message Details Page
    public function detailsMessage($messageId)
    {
        $message = Contact::select("contacts.*", "users.name as user_name", "users.email as user_email")
            ->leftJoin("users", "users.id", "contacts.user_id")
            ->where("contacts.id", $messageId)
            ->first();
        return view("admin.contact.details", compact("message"));
    }

    //Reply MEssage Page
    public function replyMessagePage($messageId)
    {
        $message = Contact::select("contacts.*", "users.name as user_name", "users.email as user_email")
            ->leftJoin("users", "users.id", "contacts.user_id")
            ->where("contacts.id", $messageId)
            ->first();
        return view("admin.contact.reply", compact("message"));
    }

    //reply Message
    public function replyMessage(Request $request)
    {
        $this->replyMessageValidation($request);
        $data = [
            "message_id" => $request->messageId,
            "reply_message" => $request->adminreply
        ];
        Reply::create($data);
        Contact::where("id", $request->messageId)->update(["reply_status" => 1]);
        return redirect()->route("admin#messageList")->with(["replySuccess" => "Send Reply Success."]);
    }

    //Direct View Reply Page
    public function viewReply($messageId)
    {
        $message = Contact::where("id", $messageId)->first();
        if ($message->reply_status != 0) {
            $reply = Reply::where("message_id", $messageId)->first();
        } else {
            $reply = [];
        }
        return view("user.contact.reply", compact("message", "reply"));
    }

    //Reply Message Validation
    private function replyMessageValidation($request)
    {
        Validator::make($request->all(), [
            "adminreply" => "required||min:10"
        ])->validate();
    }

    //Delete Message With Ajax
    public function ajaxDeleteMessage(Request $request)
    {
        Contact::where("id", $request->message_id)->delete();
        Reply::where("message_id", $request->message_id)->delete();
        return response()->json(["success" => true], 200);
    }

    //Validation Contact Data
    private function valdationMessage($request)
    {
        Validator::make($request->all(), [
            "subject" => "required||min:5",
            "message" => "required||min:10"
        ])->validate();
    }
}