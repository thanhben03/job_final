<div id="chat-bot" class="container py-5 d-none">

    <div class="row d-flex justify-content-center"
        style="position: fixed;
                bottom: 122px;
                z-index: 999999;
                right: 60px;
                width: 423px;">
        <div class="">

            <div class="card" id="chat1" style="border-radius: 15px;">
                <div class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0"
                    style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <i style="visibility: hidden" class="fas fa-angle-left"></i>
                    <p class="mb-0 fw-bold">Chat Bot</p>
                    <i onclick="toggleOpenChat()" id="close-popup-chat" class="fas fa-times"></i>
                </div>
                <div class="card-body"
                    style="
                        height: 70vh;
                        overflow-y: scroll;
                        display: flex;
                        flex-direction: column;
                        justify-content: space-between;">

                    <div class="wrap-message">
                        <div class="d-flex flex-row justify-content-start mb-4">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                alt="avatar 1" style="width: 45px; height: 100%;">
                            <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                <p class="small mb-0">{{ trans('lang.Hello, how can i help you ?') }}</p>
                            </div>
                        </div>
                        <div class="d-flex flex-row justify-content-start mb-4">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                alt="avatar 1" style="width: 45px; height: 100%;">
                            <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                <p class="small mb-0">
                                    {{ trans('lang.Some suggestions') }}:
                                </p>
                            </div>
                        </div>
                        <div class="d-flex flex-row justify-content-start mb-4">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                alt="avatar 1" style="width: 45px; height: 100%;">
                            <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                <p class="small mb-0">
                                    {{ trans('lang.I need to find a job majoring in finance/marketing') }}
                            
                                </p>
                            </div>
                        </div>
                        <div class="d-flex flex-row justify-content-start mb-4">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                alt="avatar 1" style="width: 45px; height: 100%;">
                            <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                <p class="small mb-0">
                                    {{ trans('lang.I need to find a php job') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div data-mdb-input-init class="form-outline">
                        <textarea autofocus class="form-control bg-body-tertiary" id="message-to-bot" rows="4"></textarea>
                        <label class="form-label" for="textAreaExample">Type your message</label>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>


<button class="toggle-chat">
    <svg class="close-chat" width="20px" height="20px" viewBox="0 0 20 20" version="1.1"
        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g id="chat_option_01" transform="translate(-266.000000, -579.000000)" fill="#274666" fill-rule="nonzero">
                <g id="button_chat-close_static" transform="translate(246.000000, 559.000000)">
                    <g id="Group-4" transform="translate(20.000000, 20.000000)">
                        <path
                            d="M6.18869049,10 L0.789348044,4.60065755 C-0.263116015,3.54819349 -0.263116015,1.8418121 0.789348044,0.789348044 C1.8418121,-0.263116015 3.54819349,-0.263116015 4.60065755,0.789348044 L10,6.18869049 L15.3993425,0.789348044 C16.4518065,-0.263116015 18.1581879,-0.263116015 19.210652,0.789348044 C20.263116,1.8418121 20.263116,3.54819349 19.210652,4.60065755 L13.8113095,10 L19.210652,15.3993425 C20.263116,16.4518065 20.263116,18.1581879 19.210652,19.210652 C18.1581879,20.263116 16.4518065,20.263116 15.3993425,19.210652 L10,13.8113095 L4.60065755,19.210652 C3.54819349,20.263116 1.8418121,20.263116 0.789348044,19.210652 C-0.263116015,18.1581879 -0.263116015,16.4518065 0.789348044,15.3993425 L6.18869049,10 Z"
                            id="Combined-Shape"></path>
                    </g>
                </g>
            </g>
        </g>
    </svg>

    <span class="open-chat">
        <svg width="33px" height="37px" viewBox="0 0 33 37" version="1.1" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink">
            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="chat_option_01" transform="translate(-59.000000, -572.000000)">
                    <g id="button_chat_static" transform="translate(46.000000, 559.000000)">
                        <g id="icon_chat" transform="translate(13.000000, 13.000000)">
                            <path
                                d="M11.3908465,32.1937452 C12.3733449,33.8267185 14.076396,35.4288034 16.5,37 C5.95869323,35.1320625 0.468256843,28.6257901 0.0286908382,17.481183 C0.00965275619,17.1565548 0,16.8294047 0,16.5 C0,16.4339782 0.000387763357,16.3680469 0.00116113687,16.3022084 C0.000387045622,16.2018277 -1.24344979e-14,16.1010916 -1.24344979e-14,16 L0.00728022691,16.0050958 C0.268977109,7.12133202 7.55285045,0 16.5,0 C25.6126984,0 33,7.38730163 33,16.5 C33,25.6126984 25.6126984,33 16.5,33 C14.7167319,33 12.9995375,32.7171051 11.3908465,32.1937452 Z"
                                id="Combined-Shape-Copy" fill="#274666"></path>
                            <g id="Group" transform="translate(7.000000, 15.000000)" fill="#FFFFFF">
                                <circle id="Oval" cx="2" cy="2" r="2"></circle>
                                <circle id="Oval" cx="9" cy="2" r="2"></circle>
                                <circle id="Oval" cx="16" cy="2" r="2"></circle>
                            </g>
                        </g>
                    </g>
                </g>
            </g>
        </svg>
        Chat Bot
    </span>
</button>

@push('js')
    <script>
        let input = $('#message-to-bot');

        input.on('keydown', function(e) {
            if (e.which == 13) {
                const inputValue = input.val(); // Lấy giá trị của ô input
                $(".wrap-message").append(`
                    <div class="d-flex flex-row justify-content-end mb-4">
                        <div class="p-3 me-3 border bg-body-tertiary" style="border-radius: 15px;">
                            <p class="small mb-0">${inputValue}</p>
                        </div>
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava2-bg.webp"
                            alt="avatar 1" style="width: 45px; height: 100%;">
                    </div>
                `);
                $(".wrap-message").append(
                            `
                            <div id="loading-message" class="d-flex flex-row justify-content-start mb-4">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                    alt="avatar 1" style="width: 45px; height: 100%;">
                                <div style="background: cornsilk;" class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                    <p class="small mb-0">
                                        Hệ thống đang phản hồi...
                                    </p>
                                </div>
                            </div>
                        `);
                        
                $.ajax({
                    type: "POST",
                    url: "{{ route('chat.bot') }}",
                    data: {
                        "prompt": inputValue,
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        // Có thể thêm mã để hiển thị loader tại đây nếu cần
                        input.val(""); // Đặt giá trị ô input thành rỗng
                        
                    },
                    success: function(res) {
                        $(".wrap-message").append(res.content);
                        $("#loading-message").remove();
                        scrollToBottom();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON);
                        $("#loading-message").remove();

                    }
                });

                // Reset ô tin nhắn sau khi gửi
            }
        });

        input.on('keyup', function(e) {
            if (e.which == 13) {
                input.val(""); // Đặt giá trị ô input thành rỗng
            }
        })
    </script>
@endpush
