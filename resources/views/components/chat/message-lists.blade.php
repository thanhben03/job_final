<div id="msg-list-wrap" class="wt-dashboard-msg-search-list scrollbar-macosx">
    @foreach($latestMessages as $message)

        <div id="position-chat-{{$message['company']['id']}}" onclick="viewChat({{$message['company']['id']}}, '{{$message['company']['company_name']}}')" class="wt-dashboard-msg-search-list-wrap mb-1">
            <a href="javascript:;" id="wrap-item-list-{{$message['company']['id']}}" class="msg-user-info clearfix">
                <div class="msg-user-timing">{{$message['created_at']}}</div>
                <div class="msg-user-info-pic">
                    <img src="{{str_contains($message['company']['company_avatar'], 'http') ? $message['company']['company_avatar'] : asset('/images/avatar/'.$message['company']['company_avatar'])}}" alt="">
                </div>
                <div class="msg-user-info-text">
                    <div class="msg-user-name">{{$message['company']['company_name']}}</div>
                    <div class="msg-user-discription {{$message['read'] == 0 && $message['sender'] == 'company' ? 'active' : ''}}">{{$message['message']}}</div>
                </div>
            </a>
        </div>
    @endforeach

</div>
