<x-app-layout>

    <x-slot name="pageTitle">
        Role List
    </x-slot>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css">
    <style>
        /*.send-message {*/
        /*    display: none;*/
        /*}*/

        .detail-scroll-message {
            height: 80%;
        }

        .list-toast-send-message {
            position: absolute;
            right: 20px;
            bottom: 40px;
            z-index: 9999;
        }

        .toast-entity {
            margin-top: 10px;
        }

        .add-selected-user {
            background-color: cornflowerblue;
        }

        .select2-container--default {
            width: 463px !important;
        }

        #toast-created {
            margin-left: 50px !important;
        }

        .select2-selection--multiple {
            height: 40px !important;
        }

        .d-none {
            display: none;
        }

        .emoji-icon {
            position: absolute;
            right: 10px;
            margin-top: -450px;
        }

        .img-thumbs {
            background: #eee;
            border: 1px solid #ccc;
            border-radius: 0.25rem;
            margin: 1.5rem 0;
            padding: 0.75rem;
        }

        .wrapper-thumb {
            position: relative;
            display:inline-block;
            margin: 1rem 0;
            justify-content: space-around;
        }

        .img-preview-thumb {
            background: #fff;
            border: 1px solid none;
            border-radius: 0.25rem;
            box-shadow: 0.125rem 0.125rem 0.0625rem rgba(0, 0, 0, 0.12);
            margin-right: 1rem;
            max-width: 140px;
            padding: 0.25rem;
        }

        .remove-btn{
            position:absolute;
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:.7rem;
            top:-5px;
            right:10px;
            width:20px;
            height:20px;
            background:white;
            border-radius:10px;
            font-weight:bold;
            cursor:pointer;
        }

        .remove-btn:hover{
            box-shadow: 0px 0px 3px grey;
            transition:all .3s ease-in-out;
        }
    </style>
    @vite('resources/css/loading.css')
    @vite('resources/css/toast.css')
    <!-- This is an example component -->
    <!-- toast -->
    <div class="list-toast-send-message">
        <!-- content -->
    </div>

    <!-- end toast -->
    <div class="flex h-screen antialiased text-gray-800">
        <!-- loading -->
        <div class="loading">Loading&#8230;</div>
        <!-- end loading -->
        <div class="flex flex-row h-full w-full overflow-x-hidden">
            <div class="flex flex-col py-8 pl-3 pr-3 w-64 bg-white flex-shrink-0">
                <div class="flex flex-row items-center justify-center h-12 w-full">
                    <div class="flex items-center justify-center rounded-2xl text-indigo-700 bg-indigo-100 h-10 w-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                    <div class="ml-2 font-bold text-2xl">QuickChat</div>
                </div>
                <div class="flex flex-col items-center bg-indigo-100 border border-gray-200 mt-4 w-full py-6 px-4 rounded-lg">
                    <div class="h-20 w-20 rounded-full border overflow-hidden">
                        <img src="https://avatars3.githubusercontent.com/u/2763884?s=128" alt="Avatar" class="h-full w-full" />
                    </div>
                    <div class="text-sm font-semibold mt-2">Namdv</div>
                    <div class="text-xs text-gray-500">Lead UI/UX Designer</div>
                    <div class="flex flex-row items-center mt-3">
                        <div class="flex flex-col justify-center h-4 w-8 bg-indigo-500 rounded-full">
                            <div class="h-3 w-3 bg-white rounded-full self-end mr-1"></div>
                        </div>
                        <div class="leading-none ml-1 text-xs">Active</div>
                    </div>
                </div>
                <div class="flex flex-col mt-8">
                    <div class="flex flex-row items-center justify-end text-xs">
{{--                        <form>--}}
{{--                            <div class="grid">--}}
{{--                                <div>--}}
{{--                                    <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Email or name" required>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Search</button>--}}
{{--                        </form>--}}
                        <span class="flex items-center justify-center ml-2 bg-gray-300 h-4 w-4 rounded-full cursor-pointer icon-create-group" onclick="toggleModalCreateGroup()">
                            <svg class="h-8 w-8 text-blue-700-800"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />  <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />  <line x1="16" y1="5" x2="19" y2="8" /></svg>
                        </span>
                    </div>
                    @if (\Session::has('success'))
                        <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                {!! \Session::get('success') !!}.
                            </div>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                {{$errors->first()}}
                            </div>
                        </div>
                    @endif
                    <div class="flex flex-col space-y-1 mt-4 -mx-2 overflow-y-auto">
                        <input type="hidden" value="" id="current-send-user-id" />
                        <input type="hidden" value="" id="current-type-conversation" />
                        <input type="hidden" value="0" id="current-length-message-detail" />
                        <input type="hidden" value="" id="current-length-load-more-message-detail" />
                        @if ($listConversations->count())
                        @foreach ($listConversations as $item)
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
                            <div class="ml-2 text-sm font-semibold">{{ Auth::id() == $item['id'] ? 'My account' : $item['name'] }}</div>
                            <div class="flex items-center justify-center ml-auto text-xs text-white bg-red-500 h-4 w-4 rounded leading-none <?php echo "count-message-unread" . $item['id']; ?>">
                                {{ $item['count_unread'] }}
                            </div>
                        </button>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex flex-col flex-auto h-full p-6">
                <div class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-gray-100 h-full p-4">
                    <div class="flex flex-col h-full overflow-x-auto mb-4 detail-scroll-message">
                        <div class="flex flex-col h-full" id="list-content-message">
                            <div class="grid grid-cols-12 gap-y-2" id="content-message-detail">
                                <!-- list message -->
                                <!-- end list message -->
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row items-center h-16 rounded-xl bg-white w-full px-4">
                        <div>
                            <form id="form-upload-image"><input type="file" class="form-control d-none" name="images" id="upload-img" accept="image/png, image/gif, image/jpeg" /></form>
                        <div class="img-thumbs d-none" id="img-preview" d-none></div>
                            <button class="flex items-center justify-center text-gray-400 hover:text-gray-600" id="button-select-image">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex-grow ml-4">
                            <div class="relative w-full">
                                <input type="text" class="input-message flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 pl-4 h-10" />
                                <button id="emojiButton" class="absolute flex items-center justify-center h-full w-12 right-0 top-0 text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                                <emoji-picker class="emoji-icon d-none"></emoji-picker>
                            </div>
                        </div>
                        <div class="ml-4">
                            <button class="send-message flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white px-4 py-1 flex-shrink-0">
                                <span>Send</span>
                                <span class="ml-2">
                                    <svg class="w-4 h-4 transform rotate-45 -mt-px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                    <!-- Modal create group -->
                    <div class="fixed z-10 overflow-y-auto top-0 w-full left-0 hidden" id="modal-create-group">
                        <div class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 transition-opacity">
                                <div class="absolute inset-0 bg-gray-900 opacity-75" />
                            </div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                            <div class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                <form method="post" action="{{ route('chats.createNewConversation') }}">
                                    @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Group Name</label>
                                    <input type="text" name="name" class="w-full outline-none rounded bg-gray-100 p-2 mt-2 mb-3" required minlength="6" maxlength="255" />
                                    <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Users</label>
                                    <div>
                                        <select class="select-user-multiple" name="users[]" multiple="multiple" required>
                                            @foreach($listUsers as $user)
                                                @if ($user->id != auth()->id())
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="submit" class="inline-flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 sm:ml-3 sm:w-auto" >Submit</button>
                                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" onclick="toggleModalCreateGroup()">Cancel</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end modal create group -->
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/bootstrap.js')
    @vite('resources/js/toast.js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
    <script>
        const typeReadyConversation = 1;
        const typeNewConversation = 2;
        let showEmoji = false;
        let imagesFiles = '';

        $('#emojiButton').click(function () {
            showEmoji = !showEmoji;
            openCloseEmoji();
            let currentType = $('.button-select-user-id[data-id="' + $('#current-send-user-id').val() + '"]').attr('data-type');
            $('#current-type-conversation').val(currentType);
        });

        let imgUpload = document.getElementById('upload-img')
            , imgPreview = document.getElementById('img-preview')
            , imgUploadForm = document.getElementById('form-upload')
            , totalFiles
            , previewTitle
            , previewTitleText
            , img;

        imgUpload.addEventListener('change', previewImgs, true);

        function previewImgs(event) {
            totalFiles = imgUpload.files.length;
            imagesFiles = event.target.files[0];
            if (!!totalFiles) {
                imgPreview.classList.remove('d-none');
            }

            for (var i = 0; i < totalFiles; i++) {
                wrapper = document.createElement('div');
                wrapper.classList.add('wrapper-thumb');
                removeBtn = document.createElement("span");
                nodeRemove = document.createTextNode('x');
                removeBtn.classList.add('remove-btn');
                removeBtn.appendChild(nodeRemove);
                img = document.createElement('img');
                img.src = URL.createObjectURL(event.target.files[i]);
                img.classList.add('img-preview-thumb');
                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                imgPreview.appendChild(wrapper);

                $('.remove-btn').click(function () {
                    $(this).parent('.wrapper-thumb').remove();
                    $('#img-preview').addClass('d-none');
                    imagesFiles = '';
                    $('#upload-img').val('');
                });
            }
        }

        document.querySelector('emoji-picker')
            .addEventListener('emoji-click', function (event) {
                $('.input-message').val($('.input-message').val() + event.detail.unicode);
            });

        function openCloseEmoji() {
            if (showEmoji) {
                $('.emoji-icon').removeClass('d-none');
            } else {
                $('.emoji-icon').addClass('d-none');
            }
        }

        function toggleModalCreateGroup() {
            document.getElementById('modal-create-group').classList.toggle('hidden')
        }

        $(document).ready(function() {
            let page = 1;
            $('.loading').css('display', 'none');
            $('.select-user-multiple').select2();
            $('.input-message').on('change', function() {
                if (this.value) {
                    $('.send-message').addClass('display-button');
                } else {
                    $('.send-message').removeClass('display-button');
                    $.toast({
                        heading: 'Error',
                        text: 'Message reply is empty!',
                        showHideTransition: 'fade',
                        icon: 'error'
                    })
                }
            });

            $('#button-select-image').click(function () {
                $('#upload-img').trigger('click');
            });

            $('.button-select-user-id').click(function() {
                page = 1;
                $('.button-select-user-id').removeClass('add-selected-user');
                $(this).addClass('add-selected-user');
                $('#current-send-user-id').val($(this).attr('data-id'));
                $('#current-type-conversation').val($(this).attr('data-type'));
                $('#current-length-message-detail').val(0);
                readMessageSingleCurrentUser($(this).attr('data-id'));
                getMessageSingle($(this).attr('data-id'), page, true);
                $('.content-message-popup-parent[data-id="' + $(this).attr('data-id') + '"]').remove();
            });

            $('.input-message').click(function() {
                showEmoji = false;
                openCloseEmoji();
                readMessageSingleCurrentUser($('#current-send-user-id').val());
                let currentType = $('.button-select-user-id[data-id="' + $('#current-send-user-id').val() + '"]').attr('data-type');
                $('#current-type-conversation').val(currentType);
            });

            $('.detail-scroll-message').scroll(function() {
                if ($(this).scrollTop() == 0 && parseInt($('#current-length-load-more-message-detail').val())) {
                    page = page + 1;
                    getMessageSingle($('#current-send-user-id').val(), page, false);
                    scrollToTopScreen();
                }

                if (Math.round($(this).scrollTop() + $(this).innerHeight(), 10) >= Math.round($(this)[0].scrollHeight, 10)) {
                    scrollToEndScreen();
                }
            });

            $('.send-message').click(function() {
                showEmoji = false;
                openCloseEmoji();
                let message = $('.input-message').val();
                if (!message) {
                    $.toast({
                        heading: 'Error',
                        text: 'Message reply is empty!',
                        showHideTransition: 'fade',
                        icon: 'error'
                    })
                } else {
                    let htmlContent = getSendNewMessageContent(message);
                    restartContentDivMessageDetailFirstSendMessage();
                    $("#content-message-detail").append(htmlContent);
                    $('.input-message').val('');
                    scrollToEndMessageDetail();
                    let sendMessageUrl = window.location.protocol + '//' + window.location.host + '/chat/send-message'
                    sendMessageByAjax($('#current-send-user-id').val(), sendMessageUrl, message);
                }
            });
        });

        function getMessageSingle(conversationId, page, scrollToEndScreenMode) {
            $('#current-send-user-id').val(conversationId);
            let getDetailMessageSingle = window.location.protocol + '//' + window.location.host + "/chat/get-message-of-conversation/" + conversationId
            $('.loading').css('display', 'block');
            $.ajax({
                url: getDetailMessageSingle,
                type: 'get',
                data: {
                    "type": $('#current-type-conversation').val(),
                    "page": page
                },
                success: function(data) {
                    $('#current-length-load-more-message-detail').val(data.data.length);
                    if (!data.data.length) {
                        if (scrollToEndScreenMode) {
                            $('#content-message-detail').remove();
                            $('#list-content-message').append('<div class="grid no-message-text grid-cols-12 gap-y-2" id="content-message-detail"><h3 class="no-message">There are no messages yet!</h3></div>')
                            $('html, body').animate({
                                scrollTop: 0
                            }, 1000);
                        }
                    } else {
                        if (scrollToEndScreenMode) {
                            $('#content-message-detail').remove();
                            $('#list-content-message').append('<div class="grid grid-cols-12 gap-y-2" id="content-message-detail"></div>');
                            let htmlContent = getMessageFromDataMessage(data);

                            $("#content-message-detail").append(htmlContent);

                            scrollToEndScreen();
                            scrollToEndMessageDetail();
                        } else {
                            scrollToEndMessageDetail(true);
                            let oldContentHtmlMessageSingle = $("#content-message-detail").html();
                            let htmlContentLoadMore = getMessageFromDataMessage(data);

                            htmlContentLoadMore = htmlContentLoadMore + oldContentHtmlMessageSingle;
                            $('#content-message-detail').remove();
                            $('#list-content-message').append('<div class="grid grid-cols-12 gap-y-2" id="content-message-detail"></div>');
                            $("#content-message-detail").append(htmlContentLoadMore);
                        }

                    }
                    $('.loading').css('display', 'none');
                },
                error: function() {
                    $('.loading').css('display', 'none');
                    alert('Đã xảy ra lỗi');
                }
            });
        }

        function getMessageFromDataMessage(dataMessage) {
            let htmlContent = "";
            for (let i = 0; i < dataMessage.data.length; i++) {
                $('#current-length-message-detail').val(parseInt($('#current-length-message-detail').val()) + 1);
                let authId = "{{ Auth::id() }}";
                let htmlContentAvatarMessage = !dataMessage.data[i].user_send.avatar_url ?
                    '<div class = "flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0" >' + dataMessage.data[i].user_send.name[0] + '</div>'
                    : '<img src="' + dataMessage.data[i].user_send.avatar_url + '" class = "flex items-center justify-center h-9 w-9 rounded-full bg-indigo-500 flex-shrink-0" >';
                if (authId != dataMessage.data[i].sender_id) {
                    htmlContent = htmlContent +
                        '<div class="col-start-1 col-end-8 p-3 rounded-lg">' +
                        '<div class = "flex flex-row items-center">' + htmlContentAvatarMessage +
                        '<div class = "relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">' +
                        '<div>' + dataMessage.data[i].content + '</div></div><span class="ml-2 mr-2">' + moment(dataMessage.data[i].created_at).format('HH:mm') + '</span></div></div>'
                } else {
                    htmlContent = htmlContent +
                        '<div class="col-start-6 col-end-13 p-3 rounded-lg">' +
                        '<div class = "flex items-center justify-start flex-row-reverse">' + htmlContentAvatarMessage +
                        '<div class = "relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">' +
                        '<div>' + dataMessage.data[i].content + '</div></div><span class="ml-2 mr-2">' + moment(dataMessage.data[i].created_at).format('HH:mm') + '</span></div></div>'
                }
            }

            return htmlContent;
        }

        function scrollToEndScreen() {
            $('html, body').animate({
                scrollTop: $(document).height()
            }, 1000);
        }

        function scrollToTopScreen() {
            $('html, body').animate({
                scrollTop: 0
            }, 1000);
        }

        function scrollToEndMessageDetail(scrollAfterLoadMore = false) {
            const offset = 20;
            $(".detail-scroll-message").animate({
                scrollTop: !scrollAfterLoadMore ? $('.detail-scroll-message').prop("scrollHeight") : offset
            }, 1000);
        }

        function restartContentDivMessageDetailFirstSendMessage() {
            const lengthOldMessageDetails = $('#current-length-message-detail').val();
            if (!parseInt(lengthOldMessageDetails) || !lengthOldMessageDetails) {
                $('#content-message-detail').remove();
                $('#list-content-message').append('<div class="grid grid-cols-12 gap-y-2" id="content-message-detail"></div>');
            }
        }

        function getNewLengthDetailMessage() {
            let lengthNewMessageDetails = parseInt($('#current-length-message-detail').val()) + 1;
            $('#current-length-message-detail').val(lengthNewMessageDetails);
        }

        function receiveNewMessageContent(message, avatar = null, name) {
            let htmlContent = "";
            let htmlContentAvatarMessage = !avatar ?
                '<div class = "flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0" >' + name[0] + '</div>'
                : '<img src="' + avatar + '" class = "flex items-center justify-center h-9 w-9 rounded-full bg-indigo-500 flex-shrink-0" >';
            htmlContent = htmlContent +
                '<div class="col-start-1 col-end-8 p-3 rounded-lg">' +
                '<div class = "flex flex-row items-center">' + htmlContentAvatarMessage +
                '<div class = "relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">' +
                '<div>' + message + '</div></div> <span class="ml-2 mr-2">' + moment().format('HH:mm') + '</span></div></div>';

            return htmlContent;
        }

        function getSendNewMessageContent(message) {
            let htmlContent = "";
            let name = "{{ Auth::user()->name }}";
            let avatar = "{{ Auth::user()->avatar_url }}";
            let htmlContentAvatarMessage = !avatar ?
                '<div class = "flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0" >' + name[0] + '</div>'
                : '<img src="' + avatar + '" class = "flex items-center justify-center h-9 w-9 rounded-full bg-indigo-500 flex-shrink-0" >';
            htmlContent = htmlContent +
                '<div class="col-start-6 col-end-13 p-3 rounded-lg">' +
                '<div class = "flex items-center justify-start flex-row-reverse">' + htmlContentAvatarMessage +
                '<div class = "relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">' +
                '<div>' + message + '</div></div><span class="ml-2 mr-2">' + moment().format('HH:mm') + '</span></div></div>';

            return htmlContent;
        }

        function getActiveBackgroundSelectedLatestMessage(latestToConversationId) {
            $('.button-select-user-id').each(function() {
                let dataId = $(this).data('id');
                if (dataId == latestToConversationId) {
                    $(this).addClass('add-selected-user');
                }
            });
        }

        function readMessageSingleCurrentUser(currentSendUserId) {
            let classNameCountUnreadUser = '.count-message-unread' + currentSendUserId;
            $(classNameCountUnreadUser).text(0);
        }

        function getNewCountUnReadMessageUserSingle(currentConversationId, userId) {
            let classNameCountUnreadUser = '.count-message-unread' + userId;
            let classNameCountUnreadConversation = '.count-message-unread' + currentConversationId;
            let newCountUnreadConversation = parseInt($(classNameCountUnreadConversation).text()) + 1;
            let newCountUnReadMessageUserSingle = parseInt($(classNameCountUnreadUser).text()) + 1;
            $(classNameCountUnreadUser).text(newCountUnReadMessageUserSingle);
            $(classNameCountUnreadConversation).text(newCountUnreadConversation);
        }

        function addPopupNewMessageReceiveSingle(userSendMessage, message, conversationId = false, seederId = false) {
            let messageSlice = message.length > 50 ? message.slice(0, 50) + '...' : message;
            let now = moment().format('HH:mm');
            let conversationIdString = conversationId ? conversationId : userSendMessage.id;
            let htmlContent = '<div class="att-toast toast-entity" id="popup-message-alert1">' +
                '<div class="bg-gray-200 rounded-lg shadow-lg content-message-popup-parent" data-sender-id="' + userSendMessage.id + '" data-id=' + conversationIdString + '>' +
                '<div class="flex items-center justify-between px-4 py-2">' +
                '<div class="flex items-center">' +
                '<img src="https://banner2.kisspng.com/20180730/kug/kisspng-at-t-u-verse-mobile-phones-directv-internet-globe-flat-icon-5b5ecf850759b5.0794762015329401650301.jpg" alt="logo" class="w-5 h-5 rounded mr-2">' +
                '<strong class="text-sm font-medium text-gray-900" id="toast-author">' + userSendMessage.name + '</strong>' +
                '<small class="text-xs text-gray-500" id="toast-created">' + now + '</small>' +
                '</div>' +
                '<div class="flex items-center">' +
                '<button type="button" class="ml-2 mb-1 mr-2 text-sm font-medium text-gray-600 hover:text-gray-800 focus:outline-none focus:text-gray-800 toast-maximize hidden"><span aria-hidden="true">+</span></button>' +
                '<button type="button" class="ml-2 mb-1 mr-2 text-sm font-medium text-gray-600 hover:text-gray-800 focus:outline-none focus:text-gray-800 toast-minimize"><span aria-hidden="true">-</span></button>' +
                '<button type="button" class="ml-2 mb-1 mr-2 text-sm font-medium text-gray-600 hover:text-gray-800 focus:outline-none focus:text-gray-800 redirect-detail-message"><span aria-hidden="true">^</span></button>' +
                '<button type="button" class="ml-2 mb-1 text-sm font-medium text-gray-600 hover:text-gray-800 focus:outline-none focus:text-gray-800 toast-close"><span aria-hidden="true">&times;</span></button>' +
                '</div>' +
                '</div>' +
                '<div class="px-4 py-2 content-popup-message">' +
                '<div class="pl-3 pr-3 pb-2 text-sm text-gray-600" id="toast-secondary">' + messageSlice + '</div>' +
                '<div class="flex items-center justify-between pl-2 pr-2 pb-2 mb-2">' +
                '<input type="text" class="form-input w-full rounded-md border-gray-300 shadow-sm sm:text-sm sm:leading-5" id="toast-feedback" placeholder="Send Feedback">' +
                '<div class="ml-2" data-id=' + conversationIdString + '>' +
                '<button class="px-3 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray active:bg-gray-900 reply-message-on-toast" type="button">&crarr;</button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';

            $('.list-toast-send-message').append(htmlContent);
        }

        function sendMessageByAjax(sendToConversationId, sendMessageUrl, message, sendMessageByToast = false) {
            $.ajax({
                url: sendMessageUrl,
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "message": message,
                    "type": $('#current-type-conversation').val(),
                    "conversation_id": sendToConversationId
                },
                success: function(data) {
                    if (!sendMessageByToast) {
                        getNewLengthDetailMessage();
                    } else {
                        $.toast({
                            heading: 'Success',
                            text: 'Reply message has been sent!',
                            showHideTransition: 'slide',
                            icon: 'success'
                        })
                        $('.content-message-popup-parent[data-id="' + sendToConversationId + '"]').remove();
                    }
                },
                error: function() {
                    alert('Đã xảy ra lỗi!Message chưa đc gửi!');
                }
            });
        }

        window.onload = function() {
            const authId = "{{Auth::id()}}"
            const latestToConversationId = "{{$listConversations->first()['id']}}";
            getActiveBackgroundSelectedLatestMessage(latestToConversationId);
            getMessageSingle(latestToConversationId, 1, true);
            Echo.private('chat-single.' + authId)
                .listen('SendMessageEvent', (e) => {
                    getNewCountUnReadMessageUserSingle(e.conversationId, e.sender.id);
                    if (e.sender.id == $('#current-send-user-id').val() || e.conversationId == $('#current-send-user-id').val()) {
                        restartContentDivMessageDetailFirstSendMessage();
                        getNewLengthDetailMessage();
                        let htmlContent = receiveNewMessageContent(e.message, e.sender.avatar_url, e.sender.name);
                        $("#content-message-detail").append(htmlContent);
                        scrollToEndMessageDetail();
                        scrollToEndScreen();
                    } else {
                        addPopupNewMessageReceiveSingle(e.sender, e.message, e.conversationId, e.sender.id);
                    }
                });
        }
    </script>
</x-app-layout>
