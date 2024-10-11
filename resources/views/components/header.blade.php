@php
    use App\Models\Notification;

    $notifications = Notification::where('user_id', auth()->id())->get();

    // Filter unread notifications
    $unreadNotifications = $notifications->where('read', 0);

    // Filter read notifications
    $readNotifications = $notifications->where('read', 1);
@endphp
<header class="site-header header-style-3 mobile-sider-drawer-menu">

    <div class="sticky-header main-bar-wraper  navbar-expand-lg">
        <div class="main-bar">

            <div class="container-fluid clearfix">

                <div class="logo-header">
                    <div class="logo-header-inner logo-header-one">
                        <a href="{{route('home')}}">
                            <img src="{{asset('/images/logo-dark.png')}}" alt="">
                        </a>
                    </div>
                </div>

                <!-- NAV Toggle Button -->
                <button id="mobile-side-drawer" data-target=".header-nav" data-toggle="collapse" type="button"
                        class="navbar-toggler collapsed">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar icon-bar-first"></span>
                    <span class="icon-bar icon-bar-two"></span>
                    <span class="icon-bar icon-bar-three"></span>
                </button>

                <!-- MAIN Vav -->
                <div class="nav-animation header-nav navbar-collapse collapse d-flex justify-content-center">

                    <ul class=" nav navbar-nav">
                        <li class="has-mega-menu"><a href="{{route('home')}}">Home</a>
                        </li>
                        <li class="has-child"><a href="{{route('jobs.index')}}">Jobs</a>
                        </li>
                        <li class=""><a href="javascript:;">Employers</a>
                        </li>
                        <li class=""><a href="javascript:;">CV / Hồ sơ</a>
                            <ul class="sub-menu">
                                <li><a href="{{route('candidate.show.review-cv')}}">Đánh giá CV</a></li>
                                <li><a href="{{route('candidate.create-cv')}}">Tạo CV</a></li>
                            </ul>
                        </li>

                    </ul>

                </div>

                <!-- Header Right Section-->
                <div class="extra-nav header-2-nav">
                    <div class="extra-cell">
                        <div class="header-search">
                            <a href="#search" class="header-search-icon"><i class="feather-search"></i></a>
                        </div>
                    </div>
                    <div class="extra-cell">
                        <div class="header-nav-btn-section">

                            @if(auth()->user())
                                <div class="header-right">
                                    <ul class="header-widget-wrap">
                                        <!--Message-->
                                        <li class="header-widget dashboard-message-dropdown">

                                            <div class="dropdown">
                                                <a href="javascript:;" class="dropdown-toggle jobzilla-admin-messange"
                                                   id="ID-MSG_dropdown"
                                                   data-bs-toggle="dropdown">
                                                    <i class="far fa-envelope"></i>
                                                    <span class="notification-animate">4</span>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="ID-MSG_dropdown">
                                                    <div class="message-list dashboard-widget-scroll">
                                                        <ul>
                                                            <li class="clearfix">
                                                    <span class="msg-avtar">
                                                        <img src="images/user-avtar/pic1.jpg" alt="">
                                                    </span>

                                                                <div class="msg-texting">
                                                                    <strong>Alexa Johnson</strong>
                                                                    <small class="msg-time">
                                                                        <span class="far fa-clock p-r-5"></span>12 mins
                                                                        ago
                                                                    </small>
                                                                    <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                                                </div>
                                                            </li>
                                                            <li class="clearfix">
                                                    <span class="msg-avtar">
                                                        <img src="images/user-avtar/pic2.jpg" alt="">
                                                    </span>

                                                                <div class="msg-texting">
                                                                    <strong>Johan Smith</strong>
                                                                    <small class="msg-time">
                                                                        <span class="far fa-clock p-r-5"></span>2 hours
                                                                        ago
                                                                    </small>
                                                                    <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                                                </div>
                                                            </li>
                                                            <li class="clearfix">
                                                    <span class="msg-avtar">
                                                        <img src="images/user-avtar/pic3.jpg" alt="">
                                                    </span>

                                                                <div class="msg-texting">
                                                                    <strong>Bobby Brown</strong>
                                                                    <small class="msg-time">
                                                                        <span class="far fa-clock p-r-5"></span>3 hours
                                                                        ago
                                                                    </small>
                                                                    <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                                                </div>
                                                            </li>
                                                            <li class="clearfix">
                                                    <span class="msg-avtar">
                                                        <img src="images/user-avtar/pic4.jpg" alt="">
                                                    </span>

                                                                <div class="msg-texting">
                                                                    <strong>David Deo</strong>
                                                                    <small class="msg-time">
                                                                        <span class="far fa-clock p-r-5"></span>4 hours
                                                                        ago
                                                                    </small>
                                                                    <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="message-view-all">
                                                            <a href="javascript:;">View All</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </li>

                                        <!--Notification-->
                                        <li class="header-widget dashboard-noti-dropdown">

                                            <div class="dropdown">
                                                <a href="javascript:;" onclick="readNoti()"
                                                   class="dropdown-toggle jobzilla-admin-notification"
                                                   id="ID-NOTI_dropdown" data-bs-toggle="dropdown">
                                                    <i class="far fa-bell"></i>
                                                    <span class="notification-animate"
                                                          id="notification-unread-count">{{count($unreadNotifications)}}</span>
                                                </a>
                                                <div class="dropdown-menu" style="left: -142px !important;"
                                                     aria-labelledby="ID-NOTI_dropdown">
                                                    <div class="dashboard-widgets-header">You
                                                        have <span id="notification-read-count">{{count($readNotifications)}}</span> notifications
                                                    </div>
                                                    <div class="noti-list dashboard-widget-scroll">
                                                        <ul id="wrap-notification">
                                                            @foreach($notifications as $noti)
                                                                <li>
                                                                    <a href="#">
                                                                        <span class="noti-icon"><i
                                                                                class="far fa-bell"></i></span>
                                                                        <span
                                                                            class="noti-texting">{{$noti->message}}</span>
                                                                    </a>
                                                                </li>
                                                            @endforeach

                                                        </ul>

                                                        <div class="noti-view-all">
                                                            <a href="javascript:;">View All</a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                        </li>

                                        <!--Account-->
                                        <li class="header-widget">
                                            <div class="dashboard-user-section">
                                                <div class="listing-user">
                                                    <div class="dropdown">
                                                        <a href="javascript:;" class="dropdown-toggle"
                                                           id="ID-ACCOUNT_dropdown"
                                                           data-bs-toggle="dropdown">
                                                            <div class="user-name text-black">
                                                    <span>
                                                        <img src="{{asset('/images/avatar/'. auth()->user()->avatar)}}"
                                                             alt="">
                                                    </span>{{auth()->user()->fullname}}
                                                            </div>
                                                        </a>
                                                        <div class="dropdown-menu"
                                                             aria-labelledby="ID-ACCOUNT_dropdown">
                                                            <ul>
                                                                <li><a href="{{route('candidate.dashboard')}}"><i
                                                                            class="fa fa-home"></i>Dashboard</a></li>
                                                                <li><a href="dash-messages.html"><i
                                                                            class="fa fa-envelope"></i> Messages</a>
                                                                </li>
                                                                <li><a href="dash-my-profile.html"><i
                                                                            class="fa fa-user"></i> Profile</a>
                                                                </li>
                                                                <li><a href="index.html"><i
                                                                            class="fa fa-share-square"></i> Logout</a>
                                                                </li>
                                                            </ul>


                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            @else
                                <div class="twm-nav-btn-left">
                                    <a class="twm-nav-sign-up" href="{{route('login')}}">
                                        <i class="feather-log-in"></i> Sign In
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>


            </div>


        </div>

        <!-- SITE Search -->
        <div id="search">
            <span class="close"></span>
            <form role="search" id="searchform" action="/search" method="get" class="radius-xl">
                <input class="form-control" value="" name="q" type="search" placeholder="Type to search"/>
                <span class="input-group-append">
                            <button type="button" class="search-btn">
                                <i class="fa fa-paper-plane"></i>
                            </button>
                        </span>
            </form>
        </div>
    </div>


</header>


@push('js')
    <script>
        function readNoti() {
            $.ajax({
                type: 'GET',
                url: '{{route('read.all.message')}}',
                success: function () {
                    $("#notification-unread-count").text('0')
                }
            })
        }
    </script>
@endpush
