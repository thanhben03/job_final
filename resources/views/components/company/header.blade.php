@php
    use Illuminate\Support\Facades\Session; $company = Session::get('company');
    use App\Models\Notification;

    $notifications = Notification::where('company_id', $company->id)->get();

    // Filter unread notifications
    $unreadNotifications = $notifications->where('read', 0);

    // Filter read notifications
    $readNotifications = $notifications->where('read', 1);

@endphp
<header id="header-admin-wrap" class="header-admin-fixed">

    <!-- Header Start -->
    <div id="header-admin">
        <div class="container">

            <!-- Left Side Content -->
            <div class="header-left">
                <div class="nav-btn-wrap">
                    <a class="nav-btn-admin" id="sidebarCollapse">
                        <span class="fa fa-angle-left"></span>
                    </a>
                </div>
            </div>
            <!-- Left Side Content End -->

            <!-- Right Side Content -->
            <div class="header-right">
                <ul class="header-widget-wrap">
                    <!--Message-->
                    <li class="header-widget dashboard-message-dropdown">

                        <div class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle jobzilla-admin-messange" id="ID-MSG_dropdown"
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
                                                    <span class="far fa-clock p-r-5"></span>12 mins ago
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
                                                    <span class="far fa-clock p-r-5"></span>2 hours ago
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
                                                    <span class="far fa-clock p-r-5"></span>3 hours ago
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
                                                    <span class="far fa-clock p-r-5"></span>4 hours ago
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
                                    <a href="javascript:;" class="dropdown-toggle" id="ID-ACCOUNT_dropdown"
                                       data-bs-toggle="dropdown">
                                        <div class="user-name text-black">
                                                    <span>
                                                        <img src="{{asset('/images/avatar/'. $company->company_avatar)}}" alt="">
                                                    </span>{{$company->company_name}}
                                        </div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="ID-ACCOUNT_dropdown">

                                        <ul>
                                            <li><a href="dashboard.html"><i class="fa fa-home"></i>Dashboard</a></li>
                                            <li><a href="dash-messages.html"><i class="fa fa-envelope"></i> Messages</a>
                                            </li>
                                            <li><a href="dash-my-profile.html"><i class="fa fa-user"></i> Profile</a>
                                            </li>
                                            <li><a href="index.html"><i class="fa fa-share-square"></i> Logout</a></li>
                                        </ul>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </li>

                </ul>
            </div>
            <!-- Right Side Content End -->

        </div>
    </div>
    <!-- Header End -->

</header>
@push('js')
    <script>
        function readNoti() {
            $.ajax({
                type: 'GET',
                url: '{{route('read.all.company.message')}}',
                success: function () {
                    $("#notification-unread-count").text('0')
                }
            })
        }
    </script>
@endpush
