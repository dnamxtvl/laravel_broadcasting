<x-app-layout>

    <x-slot name="pageTitle">
        Role List
    </x-slot>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css">
    <style>
        .send-message {
            display: none;
        }

        .display-button {
            display: block;
        }

        .add-selected-user {
            background-color: blueviolet;
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

        #toast-created {
            margin-left: 50px !important;
        }

        .created-at-chat-message {
            margin-left: 10px !important;
            font-size: x-small;
            font-weight: revert;
            margin-right: 10px !important;
        }

        .count-user {
            margin-left: 10px;
            margin-top: 3px;
        }

        .button-search-user {
            margin-left: 10px;
        }
    </style>
    @vite('resources/css/loading.css')
    @vite('resources/css/toast.css')
    @if (session('success'))
    <div class="max-w-4xl mx-auto mt-8 bg-green-700 text-white p-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif
    @if(Session::has('error'))
    <p class="alert alert-danger">{{ Session::get('error') }}</p>
    @endif
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
            <div class="flex flex-col py-8 pl-6 pr-2 w-64 bg-white flex-shrink-0">
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
                    <div class="text-sm font-semibold mt-2">Aminos Co.</div>
                    <div class="text-xs text-gray-500">Lead UI/UX Designer</div>
                    <div class="flex flex-row items-center mt-3">
                        <div class="flex flex-col justify-center h-4 w-8 bg-indigo-500 rounded-full">
                            <div class="h-3 w-3 bg-white rounded-full self-end mr-1"></div>
                        </div>
                        <div class="leading-none ml-1 text-xs">Active</div>
                    </div>
                </div>
                <div class="flex flex-col mt-8">
                    <div class="flex flex-row items-center justify-between text-xs">
                        <form>
                            <div class="flex">
                                <div>
                                    <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Email or name" required>
                                </div>
                                <button type="button" class="button-search-user text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="flex">
                        <span class="font-bold">Chat Users</span>
                        <span class="flex items-center justify-center count-user bg-gray-300 h-4 w-4 rounded-full">4</span>
                    </div>
                    <div class="flex flex-col space-y-1 mt-4 -mx-2 h-48 overflow-y-auto">
                        <input type="hidden" value="" id="current-send-user-id" />
                        <input type="hidden" value="0" id="curent-length-message-detail" />
                        <input type="hidden" value="" id="curent-length-load-more-message-detail" />
                        @if ($listUsers->count())
                        @foreach ($listUsers as $user)
                        <button class="button-select-user-id flex flex-row items-center hover:bg-gray-100 rounded-xl p-2" data-id="{{ $user->id }}">
                            <div class="flex items-center justify-center h-8 w-8 bg-gray-200 rounded-full">
                                {{ strtoupper($user->name[0]) }}
                            </div>
                            <div class="ml-2 text-sm font-semibold">{{ Auth::id() == $user->id ? 'My account' : $user->name }}</div>
                            <div class="flex items-center justify-center ml-auto text-xs text-white bg-red-500 h-4 w-4 rounded leading-none <?php echo "count-message-unread" . $user->id; ?>">
                                {{ $user->unread_message }}
                            </div>
                        </button>
                        @endforeach
                        @endif
                    </div>
                    <div class="flex flex-row items-center justify-between text-xs mt-6">
                        <span class="font-bold">Archivied</span>
                        <span class="flex items-center justify-center bg-gray-300 h-4 w-4 rounded-full">7</span>
                    </div>
                    <div class="flex flex-col space-y-1 mt-4 -mx-2">
                        <button class="flex flex-row items-center hover:bg-gray-100 rounded-xl p-2">
                            <div class="flex items-center justify-center h-8 w-8 bg-indigo-200 rounded-full">
                                H
                            </div>
                            <div class="ml-2 text-sm font-semibold">Henry Boyd</div>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex flex-col flex-auto h-full p-6">
                <div class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-gray-100 h-full p-4">
                    <div class="flex flex-col h-full overflow-x-auto mb-4 detail-scroll-message">
                        <div class="flex flex-col h-full" id="list-content-message">
                            <div class="grid grid-cols-12 gap-y-2" id="content-message-detail">
                                <!-- list message -->
                                <!-- <div class="col-start-1 col-end-8 p-3 rounded-lg">
                                    <div class="flex flex-row items-center">
                                        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                            A
                                        </div>
                                        <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                                            <div>Hey How are you today?</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-start-1 col-end-8 p-3 rounded-lg">
                                    <div class="flex flex-row items-center">
                                        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                            A
                                        </div>
                                        <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                                            <div>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing
                                                elit. Vel ipsa commodi illum saepe numquam maxime
                                                asperiores voluptate sit, minima perspiciatis.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-start-6 col-end-13 p-3 rounded-lg">
                                    <div class="flex items-center justify-start flex-row-reverse">
                                        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                            A
                                        </div>
                                        <div class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
                                            <div>I'm ok what about you?</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-start-6 col-end-13 p-3 rounded-lg">
                                    <div class="flex items-center justify-start flex-row-reverse">
                                        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                            A
                                        </div>
                                        <div class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
                                            <div>
                                                Lorem ipsum dolor sit, amet consectetur adipisicing. ?
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-start-1 col-end-8 p-3 rounded-lg">
                                    <div class="flex flex-row items-center">
                                        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                            A
                                        </div>
                                        <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                                            <div>Lorem ipsum dolor sit amet !</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-start-6 col-end-13 p-3 rounded-lg">
                                    <div class="flex items-center justify-start flex-row-reverse">
                                        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                            A
                                        </div>
                                        <div class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
                                            <div>
                                                Lorem ipsum dolor sit, amet consectetur adipisicing. ?
                                            </div>
                                            <div class="absolute text-xs bottom-0 right-0 -mb-5 mr-2 text-gray-500">
                                                Seen
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-start-1 col-end-8 p-3 rounded-lg">
                                    <div class="flex flex-row items-center">
                                        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                            A
                                        </div>
                                        <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                                            <div>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                Perspiciatis, in.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-start-1 col-end-8 p-3 rounded-lg">
                                    <div class="flex flex-row items-center">
                                        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                            A
                                        </div>
                                        <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                                            <div class="flex flex-row items-center">
                                                <button class="flex items-center justify-center bg-indigo-600 hover:bg-indigo-800 rounded-full h-8 w-10">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </button>
                                                <div class="flex flex-row items-center space-x-px ml-4">
                                                    <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-4 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-8 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-8 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-10 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-10 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-12 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-10 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-6 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-5 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-4 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-3 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-10 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-10 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-8 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-8 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-1 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-1 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-8 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-8 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                    <div class="h-4 w-1 bg-gray-500 rounded-lg"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- end list message -->
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row items-center h-16 rounded-xl bg-white w-full px-4">
                        <div>
                            <button class="flex items-center justify-center text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex-grow ml-4">
                            <div class="relative w-full">
                                <input type="text" class="input-message flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 pl-4 h-10" />
                                <button class="absolute flex items-center justify-center h-full w-12 right-0 top-0 text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
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
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/bootstrap.js')
    @vite('resources/js/toast.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
    <script>
        $(document).ready(function() {
            var page = 1;
            $('.loading').css('display', 'none');
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

            $('.button-select-user-id').click(function() {
                page = 1;
                $('.button-select-user-id').removeClass('add-selected-user');
                $(this).addClass('add-selected-user');
                $('#current-send-user-id').val($(this).attr('data-id'));
                $('#curent-length-message-detail').val(0);
                readMessageSingleCurrentUser($(this).attr('data-id'));
                getMessageSingle($(this).attr('data-id'), page, true);
                $('.content-message-popup-parent[data-id="' + $(this).attr('data-id') + '"]').remove();
            });

            $('.input-message').click(function() {
                readMessageSingleCurrentUser($('#current-send-user-id').val());
            });

            $('.detail-scroll-message').scroll(function() {
                if ($(this).scrollTop() == 0 && parseInt($('#curent-length-load-more-message-detail').val())) {
                    page = page + 1;
                    getMessageSingle($('#current-send-user-id').val(), page, false);
                    scrollToTopScreen();
                }

                if (Math.round($(this).scrollTop() + $(this).innerHeight(), 10) >= Math.round($(this)[0].scrollHeight, 10)) {
                    scrollToEndScreen();
                }
            });

            $('.send-message').click(function() {
                var message = $('.input-message').val();
                if (!message) {
                    $.toast({
                        heading: 'Error',
                        text: 'Message reply is empty!',
                        showHideTransition: 'fade',
                        icon: 'error'
                    })
                } else {
                    var htmlContent = getSendNewMessageContent(message);
                    restartContentDivMessageDetailFirstSendMessage();
                    $("#content-message-detail").append(htmlContent);
                    $('.input-message').val('');
                    scrollToEndMessageDetail();
                    let sendMessageUrl = window.location.protocol + '//' + window.location.host + '/admin/chats/send-message-to-user'
                    sendMessageByAjax($('#current-send-user-id').val(), sendMessageUrl, message);
                }
            });
        });

        function getMessageSingle(userId, page, scrollToEndSceenMode) {
            $('#current-send-user-id').val(userId);
            let getDetailMessageSingle = window.location.protocol + '//' + window.location.host + "/admin/chats/detail-message-single/" + userId
            $('.loading').css('display', 'block');
            $.ajax({
                url: getDetailMessageSingle,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "page": page
                },
                success: function(data) {
                    $('#curent-length-load-more-message-detail').val(data.data.length);
                    console.log($('#curent-length-load-more-message-detail').val());
                    if (!data.data.length) {
                        if (scrollToEndSceenMode) {
                            $('#content-message-detail').remove();
                            $('#list-content-message').append('<div class="grid no-message-text grid-cols-12 gap-y-2" id="content-message-detail"><h3 class="no-message">There are no messages yet!</h3></div>')
                            $('html, body').animate({
                                scrollTop: 0
                            }, 1000);
                        }
                    } else {
                        if (scrollToEndSceenMode) {
                            $('#content-message-detail').remove();
                            $('#list-content-message').append('<div class="grid grid-cols-12 gap-y-2" id="content-message-detail"></div>');
                            var htmlContent = getMessageFromDataMessage(data);

                            $("#content-message-detail").append(htmlContent);

                            scrollToEndScreen();
                            scrollToEndMessageDetail();
                        } else {
                            scrollToEndMessageDetail(true);
                            var oldContentHtmlMessageSingle = $("#content-message-detail").html();
                            var htmlContentLoadMore = getMessageFromDataMessage(data);

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
            var htmlContent = "";
            for (var i = 0; i < dataMessage.data.length; i++) {
                $('#curent-length-message-detail').val(parseInt($('#curent-length-message-detail').val()) + 1);
                var authId = "{{ Auth::id() }}";
                if (authId != dataMessage.data[i].send_user_id) {
                    htmlContent = htmlContent +
                        '<div class="col-start-1 col-end-8 p-3 rounded-lg">' +
                        '<div class = "flex flex-row items-center">' +
                        '<div class = "flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0" >' + dataMessage.data[i].user_send_message.name[0] +
                        '</div> <div class = "relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">' +
                        '<div>' + dataMessage.data[i].message + '</div></div><div class="created-at-chat-message">' + moment(dataMessage.data[i].created_at).format('YYYY-MM-DD HH:mm') + '</div></div></div>'
                } else {
                    htmlContent = htmlContent +
                        '<div class="col-start-6 col-end-13 p-3 rounded-lg">' +
                        '<div class = "flex items-center justify-start flex-row-reverse">' +
                        '<div class = "flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0" >' + dataMessage.data[i].user_send_message.name[0] +
                        '</div>' +
                        '<div class = "relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">' +
                        '<div>' + dataMessage.data[i].message + '</div></div><div class="created-at-chat-message">' + moment(dataMessage.data[i].created_at).format('YYYY-MM-DD HH:mm') + '</div></div></div>'
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
            const lengthOldMessageDetails = $('#curent-length-message-detail').val();
            if (!parseInt(lengthOldMessageDetails) || !lengthOldMessageDetails) {
                $('#content-message-detail').remove();
                $('#list-content-message').append('<div class="grid grid-cols-12 gap-y-2" id="content-message-detail"></div>');
            }
        }

        function getNewLengthDetailMessage() {
            let lengthNewMessageDetails = parseInt($('#curent-length-message-detail').val()) + 1;
            $('#curent-length-message-detail').val(lengthNewMessageDetails);
        }

        function reviceNewMessageContent(message) {
            var htmlContent = "";
            htmlContent = htmlContent +
                '<div class="col-start-1 col-end-8 p-3 rounded-lg">' +
                '<div class = "flex flex-row items-center">' +
                '<div class = "flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0" >A' +
                '</div> <div class = "relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">' +
                '<div>' + message + '</div></div><div class="created-at-chat-message">' + moment().format('YYYY-MM-DD HH:mm') + '</div></div></div>'

            return htmlContent;
        }

        function getSendNewMessageContent(message) {
            var htmlContent = "";
            htmlContent = htmlContent +
                '<div class="col-start-6 col-end-13 p-3 rounded-lg">' +
                '<div class = "flex items-center justify-start flex-row-reverse">' +
                '<div class = "flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0" >A </div>' +
                '<div class = "relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">' +
                '<div>' + message + '</div></div><div class="created-at-chat-message">' + moment().format('YYYY-MM-DD HH:mm') + '</div></div></div>'

            return htmlContent;
        }

        function getActiveBackgroundSelectedLastestMessage(lastestToUserId) {
            $('.button-select-user-id').each(function() {
                var dataId = $(this).data('id'); // Lấy giá trị data-id của thẻ div hiện tại
                if (dataId == lastestToUserId) { // Kiểm tra nếu giá trị data-id là 1 thì thêm class 'add-selected-user'
                    $(this).addClass('add-selected-user');
                }
            });
        }

        function readMessageSingleCurrentUser(currentSendUserId) {
            var classNameCountUnreadUser = '.count-message-unread' + currentSendUserId;
            $(classNameCountUnreadUser).text(0);
        }

        function getNewCountUnReadMessageUserSingle(currentSendUserId) {
            var classNameCountUnreadUser = '.count-message-unread' + currentSendUserId;
            var newCountUnReadMessageUserSingle = parseInt($(classNameCountUnreadUser).text()) + 1;
            $(classNameCountUnreadUser).text(newCountUnReadMessageUserSingle);
        }

        function addPopupNewMessageReviceSingle(userSendMessage, message) {
            var messageSlice = message.length > 50 ? message.slice(0, 50) + '...' : message;
            var now = moment().format('HH:mm');
            var htmlContent = '<div class="att-toast toast-entity" id="popup-message-alert1">' +
                '<div class="bg-gray-200 rounded-lg shadow-lg content-message-popup-parent" data-id=' + userSendMessage.id + '>' +
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
                '<div class="ml-2" data-id=' + userSendMessage.id + '>' +
                '<button class="px-3 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray active:bg-gray-900 reply-message-on-toast" type="button">&crarr;</button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';

            $('.list-toast-send-message').append(htmlContent);
        }

        function sendMessageByAjax(sendToUserId, sendMessageUrl, message, sendMessageByToast = false) {
            $.ajax({
                url: sendMessageUrl,
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "message": message,
                    "to_user_id": sendToUserId
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
                        $('.content-message-popup-parent[data-id="' + sendToUserId + '"]').remove();
                    }
                },
                error: function() {
                    alert('Đã xảy ra lỗi!Message chưa đc gửi!');
                }
            });
        }

        window.onload = function() {
            const authId = "{{Auth::id()}}"
            const lastestToUserId = "{{$lastestToUserId}}";
            getActiveBackgroundSelectedLastestMessage(lastestToUserId);
            getMessageSingle(lastestToUserId, 1, true);
            Echo.private('chat-single.' + authId)
                .listen('SendMessageEvent', (e) => {
                    getNewCountUnReadMessageUserSingle(e.user.id);
                    if (e.user.id == parseInt($('#current-send-user-id').val())) {
                        restartContentDivMessageDetailFirstSendMessage();
                        getNewLengthDetailMessage();
                        var htmlContent = reviceNewMessageContent(e.message);
                        $("#content-message-detail").append(htmlContent);
                        scrollToEndMessageDetail();
                        scrollToEndScreen();
                    } else {
                        addPopupNewMessageReviceSingle(e.user, e.message);
                    }
                });
        }
    </script>
</x-app-layout>