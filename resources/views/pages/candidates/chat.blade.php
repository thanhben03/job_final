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
                                        <input class="form-control" placeholder="Search Messages" type="text">
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
                                <div id="msg-list-wrap" class="wt-dashboard-msg-search-list scrollbar-macosx">

                                    <div class="wt-dashboard-msg-search-list-wrap">
                                        <a href="javascript:;" class="msg-user-info clearfix">
                                            <div class="msg-user-timing">Thu</div>
                                            <div class="msg-user-info-pic"><img src="images/user-avtar/pic4.jpg" alt=""></div>
                                            <div class="msg-user-info-text">
                                                <div class="msg-user-name">Randall Henderson</div>
                                                <div class="msg-user-discription">All created by our Global</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <!-- user msg list End-->

                            </div>

                            <!--Right Msg section-->
                            <div class="wt-dashboard-msg-box">
                                <div class="single-msg-user-name-box">
                                    <div class="single-msg-short-discription">
                                        <h4 class="single-msg-user-name">Randall Henderson </h4>
                                        IT Contractor
                                    </div>
                                    <a href="#" class="message-action"><i class="far fa-trash-alt"></i> Delete Conversation</a>
                                </div>
                                <div id="msg-chat-wrap" class="single-user-msg-conversation scrollbar-macosx">

                                    <div class="single-user-comment-wrap">
                                        <div class="row">
                                            <div class="col-xl-9 col-lg-12">
                                                <div class="single-user-comment-block clearfix">
                                                    <div class="single-user-com-pic"><img src="images/user-avtar/pic4.jpg" alt=""></div>
                                                    <div class="single-user-com-text">Breaking the endless cycle of meaningless text message conversations starts with only talking to someone who offers interesting topics opinions.</div>
                                                    <div class="single-user-msg-time">12:13 PM</div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="single-user-comment-wrap sigle-user-reply">
                                        <div class="row justify-content-end">
                                            <div class="col-xl-9 col-lg-12">
                                                <div class="single-user-comment-block clearfix">
                                                    <div class="single-user-com-pic"><img src="images/user-avtar/pic1.jpg" alt=""></div>
                                                    <div class="single-user-com-text">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</div>
                                                    <div class="single-user-msg-time">12:37 PM</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="single-msg-reply-comment">
                                    <div class="input-group">
                                        <textarea class="form-control" placeholder="Type a message here"></textarea>
                                        <button class="btn" type="button"><i class="fa fa-paper-plane"></i></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- OUR BLOG END -->
@endsection
