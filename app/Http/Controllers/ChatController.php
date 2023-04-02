<?php

namespace App\Http\Controllers;

use App\Events\SendMessageEvent;
use App\Models\Chat;
use App\Models\GroupChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ChatController extends Controller
{
    private readonly Chat $chat;
    private readonly GroupChat $groupChat;
    private readonly User $user;

    public function __construct(Chat $chat, GroupChat $groupChat, User $user)
    {
        $this->chat = $chat;
        $this->groupChat = $groupChat;
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $listUsers = $this->user->addSelect([
            'unread_message' => $this->chat->selectRaw('count(*)')
                ->where('status', Chat::STATUS_UNREAD)
                ->whereColumn('send_user_id', 'users.id')
                ->where('to_user_id', Auth::id())
        ])->get();

        $lastestUserSendMessage = $this->chat->whereNull('group_id')
            ->where('send_user_id', Auth::id())
            ->orderByDesc('created_at')
            ->first();

        $lastestToUserId = $lastestUserSendMessage ? $lastestUserSendMessage->to_user_id : Auth::id();

        return view('chat.index', compact('listUsers', 'lastestToUserId'));
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
                'message' => 'success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function listDetailMessageSingle($toUserId, Request $request)
    {
        $limitRow = 10;
        $page = $request->page ?? 1;
        $offset = $page ? ($page - 1) * $limitRow : 0;

        $this->chat->where('to_user_id', Auth::id())
            ->where('send_user_id', $toUserId)->update([
                'status' => Chat::STATUS_READ,
            ]);

        $listMessage = $this->chat->whereNull('group_id')
            ->with([
                'userSendMessage:id,name,avatar',
                'userReceiveMessage:id,name,avatar',
            ])
            ->where(function ($query2) use ($toUserId) {
                $query2->where(function ($query) use ($toUserId) {
                    $query->where('send_user_id', Auth::id())
                        ->where('to_user_id', $toUserId);
                })->orWhere(function ($query1) use ($toUserId) {
                    $query1->where('to_user_id', Auth::id())
                        ->where('send_user_id', $toUserId);
                });
            })
            ->take($limitRow)
            ->skip($offset)
            ->orderByDesc('created_at')
            ->get()
            ->reverse()
            ->values();

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $listMessage,
        ], 200);
    }
}
