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
                                        <input id="search-message" class="form-control" placeholder="Search Messages" type="text">
                                        <button onclick="searchMessage()" class="btn" type="button"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <!-- Search Section End-->

                                <!-- Search Section End-->
                                <div class="msg-find-list d-none">
                                    <select class="wt-select-box bs-select-hidden">
                                        <option>Recent Chats</option>
                                        <option>Short by Time</option>
                                        <option>Short by Unread</option>
                                    </select>
                                </div>
                                <!-- Search Section End-->

                                <!-- user msg list start-->
                                <div class="msg-current-list">
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
                                </div>
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


                    let html = `
                    <div class="single-user-comment-wrap">
                        <div class="row">
                            <div class="col-xl-9 col-lg-12">
                                <div class="single-user-comment-block clearfix" style="float: left">
                                    <div class="single-user-com-pic custom-avatar-chat">
                                        <img src="${e.message.company.company_avatar.includes('http') ? e.message.company.company_avatar : `/images/avatar/${e.message.company.company_avatar}`}" alt="">
                                    </div>
                                    <div style="width: max-content" class="single-user-com-text">${e.message.message}</div>
                                    <div class="single-user-msg-time">${e.message.created_at}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `
                    if($("#current-receiver-id").val() == e.message.company.id) {
                        $("#msg-chat-wrap").append(html)
                    }
                    scrollToBottom()


                })


            // Handle Send Chat

            document.getElementById('btn-send-message').addEventListener('click',function sendMessage() {
                let message = $("#message");
                let receiver_id = $("#current-receiver-id").val();

                if (receiver_id === '') {
                    message.val('')
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: '{{route('send.chat.to.company')}}',
                    data: {
                        'company_id': receiver_id,
                        'message': message.val(),
                        '_token' : '{{csrf_token()}}'
                    },
                    success: function (res) {
                        console.log(res)
                        let html = `

                            <div class="single-user-comment-wrap sigle-user-reply">
                                <div class="row justify-content-end">
                                    <div class="col-xl-9 col-lg-12">
                                        <div style="float: right" class="single-user-comment-block clearfix">

                                            <div style="width: max-content" class="single-user-com-text">${res.message}</div>
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
            // luu company id dang nhan hien tai
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
                                            <div class="single-user-comment-block clearfix" style="float: left">
                                                <div class="single-user-com-pic custom-avatar-chat">
                                                    <img src="${ele.company.company_avatar.includes('http') ? ele.company.company_avatar : `/images/avatar/${ele.company.company_avatar}`}" alt="">
                                                </div>
                                                <div style="width: max-content" class="single-user-com-text">${ele.message}</div>
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
                                        <div class="single-user-comment-block clearfix" style="float: right">
                                            <div style="width: max-content" class="single-user-com-text">${ele.message}</div>
                                            <div class="single-user-msg-time">${ele.created_at}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `
                        }
                    })

                    // Chuyển tin nhắn sang đã xem đồng thời in đậm dòng tin nhắn ở bên trái
                    $(`.msg-user-info.active`).removeClass('active')
                    let wrapItemList = $("#wrap-item-list-"+companyId)
                    wrapItemList.toggleClass('active')
                    let descriptionElement = wrapItemList.find('.msg-user-discription');
                    descriptionElement.removeClass('active')

                    // Hiển thị ten nguoười dùng đang nhắn
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

        function searchMessage() {
            let textToFind = $("#search-message").val(); // Văn bản bạn muốn tìm
            let cloneListMsg = $(".wt-dashboard-msg-search-list-wrap").clone(); // Lưu trữ các phần tử ban đầu


            // let matchingElement = $(".msg-user-name").filter(function() {
            //     return $(this).text().trim() === textToFind;
            // });

            if (textToFind === '') {
                $(".msg-find-list").toggleClass('d-none')
                $(".msg-current-list").toggleClass('d-none')
                return;
            }

            $(".msg-user-name").each(function() {
                // Nếu nội dung của phần tử này khác với nội dung bạn tìm thấy, thì xóa nó
                if ($(this).text().trim().includes(textToFind)) {
                    let ele = $(this).parent().parent().parent().clone();

                    $(".msg-find-list").html(ele);

                    $(".msg-current-list").toggleClass('d-none')
                    $(".msg-find-list").toggleClass('d-none')

                }
            });


        }

    </script>
@endpush
