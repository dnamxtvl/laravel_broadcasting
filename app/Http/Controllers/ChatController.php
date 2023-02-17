<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\GroupChat;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct(Chat $chat, GroupChat $groupChat)
    {
        $this->chat = $chat;
        $this->groupChat = $groupChat;
    }

    public function index(Request $request)
    {
        return view('chat.index');
    }

    public function addGroupCChat(Request $request)
    {
        dd($request->all());
    }

    public function sendMessage(Request $request)
    {
        try {
            $this->chat->create([
                'send_user_id' => Auth::id(),
                'to_user_id' => $request->to_user_id,
                'message' => $request->message
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }
}
