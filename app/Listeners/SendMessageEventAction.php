<?php

namespace App\Listeners;

use App\Events\SendMessageEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SendMessageEventAction
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendMessageEvent  $event
     * @return void
     */
    public function handle(SendMessageEvent $event)
    {
        try {
            Chat::create([
                'send_user_id' => $event->user->id,
                'to_user_id' => $event->toUserId,
                'message' => $event->message,
                'status' => Chat::STATUS_UNREAD,
            ]);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
        }
    }
}
