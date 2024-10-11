@extends('layouts.company')

@section('content')
    <!-- Page Content Holder -->
    <div id="content">

        <div class="content-admin-main">


            <div class="wt-admin-right-page-header clearfix">
                <h2>Messages</h2>
                <div class="breadcrumbs"><a href="#">Home</a><a href="#">Dasboard</a><span>Messages</span></div>
            </div>

            <div class="wt-admin-dashboard-msg-2">
                <!--Left Msg section-->
                <div class="wt-dashboard-msg-user-list">
                    <div class="user-msg-list-btn-outer">
                        <button class="user-msg-list-btn-close">Close</button>
                        <button class="user-msg-list-btn-open">User Message</button>
                    </div>
                    <!-- Search Section Start-->
                    <x-chat.search-chat />
                    <!-- Search Section End-->

                    <!-- Search Section End-->
                    <div class="msg-find-list">
                        <select class="wt-select-box bs-select-hidden">
                            <option>Recent Chats</option>
                            <option>Short by Time</option>
                            <option>Short by Unread</option>
                        </select>
                    </div>
                    <!-- Search Section End-->

                    <!-- user msg list start-->
                    <div id="msg-list-wrap" class="wt-dashboard-msg-search-list scrollbar-macosx">
                        @foreach($latestMessages as $message)
                            <x-chat.message-item
                                :receiver_id="$message['user']['id']"
                                :message="$message['message']"
                                :created_at="$message['created_at']"
                                :receiver_avatar="$message['user']['avatar']"
                                :receiver_name="$message['user']['fullname']"
                                :isRead="$message['read']"
                                :sender="$message['sender']"

                            />
                        @endforeach

                    </div>

                    <!-- user msg list End-->

                </div>

                <!--Right Msg section-->
                <x-chat.right-msg-section />

            </div>


        </div>

    </div>
@endsection

@push('js')
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            window.Echo.private('message.company.' + '{{\Illuminate\Support\Facades\Session::get('company')->id}}')
                .listen('MessageSentEvent', (e) => {
                    console.log(e)
                    let positionChat = $("#position-chat-" + e.message.user.id)
                    let descriptionElement = positionChat.find('.msg-user-discription');
                    descriptionElement.text(e.message.message) // add new message
                    positionChat.prependTo('#msg-list-wrap') // push to top

                    $(`#wrap-item-list-${e.message.user.id}`).addClass('active') // add class active to new message

                    $("#msg-chat-wrap").append(`
                        <div class="single-user-comment-wrap">
                            <div class="row">
                                <div class="col-xl-9 col-lg-12">
                                    <div class="single-user-comment-block clearfix">
                                        <div class="single-user-com-pic">
                                            <img src="${e.message.user.avatar.includes('http') ? e.message.user.avatar : `/images/avatar/${e.message.user.avatar}`}" alt="">
                                        </div>
                                        <div class="single-user-com-text">${e.message.message}</div>
                                        <div class="single-user-msg-time">${e.message.created_at}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `)

                    scrollToBottom()

                })


                document.getElementById('btn-send-message').addEventListener('click',function sendMessage() {
                    let message = $("#message");
                    let receiver_id = $("#current-receiver-id").val();

                    $.ajax({
                        type: 'POST',
                        url: '{{route('send.chat.to.user')}}',
                        data: {
                            'company_id': receiver_id,
                            'message': message.val()
                        },
                        success: function (res) {
                            console.log(res)
                            let html = `

                            <div class="single-user-comment-wrap sigle-user-reply">
                                <div class="row justify-content-end">
                                    <div class="col-xl-9 col-lg-12">
                                        <div class="single-user-comment-block clearfix">
                                            <div class="single-user-com-pic">
                                                <img src="${res.company.company_avatar.includes('http') ? res.company.company_avatar : `/images/avatar/${res.company.company_avatar}`}" alt="">
                                            </div>
                                            <div class="single-user-com-text">${res.message}</div>
                                            <div class="single-user-msg-time">12:37 PM</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `
                            $("#msg-chat-wrap").append(html)
                            scrollToBottom()

                            message.val('')

                        },
                        error: function () {

                        }
                    })
            })
        })


        function scrollToBottom() {
            let chatContainer = document.getElementById('msg-chat-wrap');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }


        function viewChat(userId, fullname) {

            $("#current-receiver-id").val(userId)
            $.ajax({
                type: "GET",
                url: "{{route('chat.getChat.company', ':userId')}}".replace(':userId', userId),
                success: function (res) {
                    let html = '';
                    res.forEach(ele => {
                        if (ele.sender == 'user') {
                            html += `
                                <div class="single-user-comment-wrap">
                                    <div class="row">
                                        <div class="col-xl-9 col-lg-12">
                                            <div class="single-user-comment-block clearfix">
                                                <div class="single-user-com-pic">
                                                    <img src="${ele.user.avatar.includes('http') ? ele.user.avatar : `/images/avatar/${ele.user.avatar}`}" alt="">
                                                </div>
                                                <div class="single-user-com-text">${ele.message}</div>
                                                <div class="single-user-msg-time">${ele.message.created_at}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;


                        } else {
                            html += `

                            <div class="single-user-comment-wrap sigle-user-reply">
                                <div class="row justify-content-end">
                                    <div class="col-xl-9 col-lg-12">
                                        <div class="single-user-comment-block clearfix">
                                            <div class="single-user-com-pic">
                                                <img src="${ele.company.company_avatar.includes('http') ? ele.company.company_avatar : `/images/avatar/${ele.company.company_avatar}`}" alt="">
                                            </div>
                                            <div class="single-user-com-text">${ele.message}</div>
                                            <div class="single-user-msg-time">${ele.message.created_at}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `
                        }
                    })
                    $(`.msg-user-info.active`).removeClass('active') // reset active class
                    let wrapItemList = $("#wrap-item-list-"+userId) // active message current
                    wrapItemList.toggleClass('active')

                    let descriptionElement = wrapItemList.find('.msg-user-discription'); // delete color when i seen
                    descriptionElement.removeClass('active')

                    $(".single-msg-user-name").text(fullname) // show fullname current in chat
                    $("#msg-chat-wrap").html(html)
                    scrollToBottom()

                }
            })
        }
    </script>
@endpush
