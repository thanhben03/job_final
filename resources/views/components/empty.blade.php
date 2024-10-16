@props(['text'])

<div class="empty text-center">
    <img style="display: inline-block;
    height: 200px;
    margin-bottom: 16px;
    width: 200px;" class="img-responsive" src="{{asset('/images/empty.png')}}" alt="">
    <span style="    color: #bcc1c5;
    display: block;
    font-size: 12px;
    font-weight: 500;
    line-height: 16px;">{{$text}}</span>
</div>
