<div class="flex flex-col space-y-1 mt-4 -mx-2 overflow-y-auto">
    @if ($listConversations->count())
        @foreach ($listConversations as $key => $item)
            <button class="button-select-user-id flex flex-row items-center hover:bg-gray-100 rounded-xl p-2" data-id="{{ $item['id'] }}"  data-type="{{ $item['type'] }}">
                @if (is_null($item['avatar_url']))
                    <div class="flex items-center justify-center h-8 w-8 bg-gray-200 rounded-full">
                        {{ strtoupper($item['name'][0]) }}
                    </div>
                @else
                    <div class="h-9 w-9 rounded-full border overflow-hidden">
                        <input type="image" src="{{ $item['avatar_url'] }}" class="w-9 h-9" />
                    </div>
                @endif
                <div>
                    <div class="ml-2 text-base text-left font-semibold">{{ Auth::id() == $item['id'] ? 'My account' : $item['name'] }}</div>
                    @if ($item['latest_message'])
                        <div class="ml-2 text-xs text-left <?php
                            if ($item['count_unread']) {
                                echo 'font-semibold';
                            }
                        ?>">{{ $item['latest_message']['userName'] . ":" . $item['latest_message']['content'] }}</div>
                    @endif
                </div>
                <div class="flex items-center justify-center ml-auto text-xs text-white bg-red-500 h-4 w-4 rounded leading-none <?php echo "count-message-unread" . $item['id']; ?>">
                    {{ $item['count_unread'] }}
                </div>
            </button>
        @endforeach
            <button wire:click="render" id="reload-conversation" class="d-none"></button>
    @endif
</div>
@push('scripts')
<script>
    window.addEventListener('name-updated', event => {
        alert('Name updated to: ' + event.detail.newName);
    })
</script>
@endpush
