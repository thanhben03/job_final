@extends('layouts.app')

@section('content')
    <!-- OUR BLOG START -->
    <div class="section-full p-t120  p-b90 site-bg-white">


        <div class="container">
            <div class="row">

                <x-right-sidebar />

                <div class="col-xl-9 col-lg-8 col-md-12 m-b30">
                    <!--Filter Short By-->
                    <div class="twm-right-section-panel site-bg-gray">
                        <div class="wt-admin-dashboard-msg-2  twm-dashboard-style-2">
                            <!--Left Msg section-->
                            <div class="wt-dashboard-msg-user-list">
                                <div class="user-msg-list-btn-outer">
                                    <button class="user-msg-list-btn-close">Close</button>
                                    <button class="user-msg-list-btn-open">User Message</button>
                                </div>
                                <!-- Search Section Start-->
                                <div class="wt-dashboard-msg-search">
                                    <div class="input-group">
                                        <input onchange="searchMessage()" class="form-control" placeholder="Search Messages" type="text">
                                        <button class="btn" type="button"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
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
                                @foreach($latestMessages as $message)
                                    <x-chat.message-item
                                        :receiver_id="$message['company']['id']"
                                        :message="$message['message']"
                                        :created_at="$message['created_at']"
                                        :receiver_avatar="$message['company']['company_avatar']"
                                        :receiver_name="$message['company']['company_name']"
                                        :isRead="$message['read']"
                                        :sender="$message['sender']"

                                    />
                                @endforeach
                                <!-- user msg list End-->

                            </div>

                            <!--Right Msg section-->
                            <x-chat.right-msg-section />

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- OUR BLOG END -->
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.Echo.private('message.' + '{{auth()->user()->id}}')
                .listen('MessageSentEvent', (e) => {
                    let positionChat = $("#position-chat-" + e.message.company.id)
                    let descriptionElement = positionChat.find('.msg-user-discription');
                    descriptionElement.text(e.message.message) // add new message
                    positionChat.prependTo('#msg-list-wrap') // push to top

                    $(`#wrap-item-list-${e.message.company.id}`).addClass('active') // add class active to new message
                })


            // Handle Send Chat

            document.getElementById('btn-send-message').addEventListener('click',function sendMessage() {
                let message = $("#message");
                let receiver_id = $("#current-receiver-id").val();

                $.ajax({
                    type: 'POST',
                    url: '{{route('send.chat.to.company')}}',
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
                                                <img src="${res.user.avatar.includes('http') ? res.user.avatar : `/images/avatar/${res.user.avatar}`}" alt="">
                                            </div>
                                            <div class="single-user-com-text">${res.message}</div>
                                            <div class="single-user-msg-time">${res.created_at}</div>
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

        function viewChat(companyId, companyName) {
            $("#current-receiver-id").val(companyId)

            $.ajax({
                type: "GET",
                url: "{{route('chat.getChat', ':companyId')}}".replace(':companyId', companyId),
                success: function (res) {
                    let html = '';
                    res.forEach(ele => {
                        if (ele.sender != 'user') {
                            html += `
                                <div class="single-user-comment-wrap">
                                    <div class="row">
                                        <div class="col-xl-9 col-lg-12">
                                            <div class="single-user-comment-block clearfix">
                                                <div class="single-user-com-pic">
                                                    <img src="${ele.company.company_avatar.includes('http') ? ele.company.company_avatar : `/images/avatar/${ele.company.company_avatar}`}" alt="">
                                                </div>
                                                <div class="single-user-com-text">${ele.message}</div>
                                                <div class="single-user-msg-time">${ele.created_at}</div>
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
                                            <div class="single-user-com-pic"><img src="/images/avatar/${ele.user.avatar}" alt=""></div>
                                            <div class="single-user-com-text">${ele.message}</div>
                                            <div class="single-user-msg-time">${ele.created_at}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `
                        }
                    })
                    $(`.msg-user-info.active`).removeClass('active')
                    let wrapItemList = $("#wrap-item-list-"+companyId)
                    wrapItemList.toggleClass('active')
                    let descriptionElement = wrapItemList.find('.msg-user-discription');
                    descriptionElement.removeClass('active')

                    $(".single-msg-user-name").text(companyName)
                    $("#msg-chat-wrap").html(html)
                    scrollToBottom()
                }
            })
        }


        // Handle Scroll To Latest Message
        function scrollToBottom() {
            let chatContainer = document.getElementById('msg-chat-wrap');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

    function searchMessage(e) {
        console.log('312321')
    }

    </script>
@endpush
