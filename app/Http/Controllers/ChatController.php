<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\GroupChat;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Events\SendMessageEvent;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChatController extends Controller
{
    public function __construct(Chat $chat, GroupChat $groupChat, User $user)
    {
        $this->chat = $chat;
        $this->groupChat = $groupChat;
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $listUser = $this->user->all();
        return view('chat.index');
    }

    public function addGroupCChat(Request $request)
    {
        dd($request->all());
    }

    public function sendUserMessage(Request $request)
    {
        try {
            // SendMessageEvent::dispatch(Auth::user(), $request->to_user_id, $request->message);
            broadcast(new SendMessageEvent(Auth::user(), $request->to_user_id, $request->message))->toOthers();
            return response()->json([
                'status' => 200,
                'message' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function listDetailMessageSingle($toUserId)
    {
        $listMessage = $this->chat->whereNull('group_id')
            ->with([
                'userSendMessage:id,name,avatar',
                'userReceiveMessage:id,name,avatar'
            ])
            ->where(function ($query) use ($toUserId) {
                $query->where('send_user_id', Auth::id())
                ->where('to_user_id', $toUserId);
            })->orWhere(function ($query1) use ($toUserId) {
                $query1->where('to_user_id', Auth::id())
                ->where('send_user_id', $toUserId);
            })
            ->orderBy('created_at')
            ->get();

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $listMessage
        ], 200);
    }
}
