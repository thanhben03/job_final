<div class="wt-dashboard-msg-box">
    <div class="single-msg-user-name-box">
        <div class="single-msg-short-discription">
            <h4 class="single-msg-user-name">{{$receiver->company_name ?? trans('lang.No contact !') }}</h4>

        </div>
    </div>
    <div id="msg-chat-wrap" class="single-user-msg-conversation scrollbar-macosx">

    </div>
    <div class="single-msg-reply-comment">
        <div class="input-group">
            <input type="text" id="current-receiver-id" hidden value="">
            <textarea id="message" class="form-control" placeholder="Type a message here"></textarea>
            <button class="btn" id="btn-send-message" type="button"><i class="fa fa-paper-plane"></i></button>
        </div>
    </div>
</div>
