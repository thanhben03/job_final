@php
    use Illuminate\Support\Facades\Session; $company = auth()->guard('company')->user();
    use App\Models\Notification;

    $notifications = Notification::where('company_id', $company->id)->orderBy('created_at', 'desc')->get();

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
                                        <a onclick="deleteAllMessage()" href="javascript:;">Delete All</a>

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
                                    <a href="javascript:;" class="dropdown-toggle" id="ID-ACCOUNT_dropdown">
                                        <div class="user-name text-black">
                                                    <span>
                                                        <img src="{{asset('/images/avatar/'. $company->company_avatar)}}" alt="">
                                                    </span>{{$company->company_name}}
                                        </div>
                                    </a>
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

        function logout() {
            $("#formLogout").submit()
        }

        function deleteAllMessage() {
            if (confirm('Are you sure ?')) {
                $.ajax({
                    type: "GET",
                    url: "{{route('delete.all', ':type')}}".replace(':type', 'company'),
                    success: function (res) {
                        console.log(res)

                        window.location.reload();
                    }
                })
            }
        }
    </script>
@endpush
