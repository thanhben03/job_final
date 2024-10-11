
@props(['receiver_id', 'message', 'created_at', 'receiver_avatar', 'receiver_name','isRead', 'sender'])


<div id="position-chat-{{$receiver_id}}" onclick="viewChat({{$receiver_id}}, '{{$receiver_name}}')" class="wt-dashboard-msg-search-list-wrap mb-1">
    <a href="javascript:;" id="wrap-item-list-{{$receiver_id}}" class="msg-user-info clearfix">
        <div class="msg-user-timing">{{$created_at}}</div>
        <div class="msg-user-info-pic">
            <img src="{{str_contains($receiver_avatar, 'http') ? $receiver_avatar : asset('/images/avatar/'.$receiver_avatar)}}" alt="">
        </div>
        <div class="msg-user-info-text">
            <div class="msg-user-name">{{$receiver_name}}</div>
            <div class="msg-user-discription {{$isRead == 0 && $sender == 'company' ? 'active' : ''}}">{{$message}}</div>
        </div>
    </a>
</div>
