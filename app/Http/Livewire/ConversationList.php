<?php

namespace App\Http\Livewire;

use App\Services\Interface\ChatServiceInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ConversationList extends Component
{
    public int $count = 1;

    public string $rowSelectedId = '';

    /**
     * @throws BindingResolutionException
     */
    public function render(): View
    {
        $chatService = app()->make(ChatServiceInterface::class);
        $listConversations = $chatService->getListConversations(userId: Auth::id(), page: $this->count);

        return view('livewire.conversation-list', compact('listConversations'));
    }

    public function getSelectedId(string $rowSelectedId): void
    {
        $this->rowSelectedId = $rowSelectedId;
    }
}
