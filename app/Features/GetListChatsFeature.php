<?php

namespace App\Features;

use App\Domains\Chat\Jobs\GetLatestUserIdSendMessageJob;
use App\Domains\Chat\Jobs\GetListChatJob;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Lucid\Units\Feature;

class GetListChatsFeature extends Feature
{
    public function __construct(
    ) {
    }

    public function handle(): View
    {
        $listUsers = $this->run(new GetListChatJob(userId: Auth::id()));
        $latestToUserId = $this->run(new GetLatestUserIdSendMessageJob(userId: Auth::id()));

        return view('chat.index', compact('listUsers', 'latestToUserId'));
    }
}
