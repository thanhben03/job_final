@php use Illuminate\Support\Facades\Session; @endphp
    <!DOCTYPE html>

<html lang="en">

<head>

    <!-- META -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content=""/>
    <meta name="author" content=""/>
    <meta name="robots" content=""/>
    <meta name="description" content=""/>

    <!-- FAVICONS ICON -->
    <link rel="icon" href="images/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png"/>

    <!-- PAGE TITLE HERE -->
    <title>jobzilla Template | dashboard</title>

    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-head/>

    @vite('resources/js/bootstrap.js')


</head>

<body>

<!-- LOADING AREA START ===== -->
<div class="loading-area">
    <div class="loading-box"></div>
    <div class="loading-pic">
        <div class="wrapper">
            <div class="cssload-loader"></div>
        </div>
    </div>
</div>
<!-- LOADING AREA  END ====== -->

<div class="page-wraper">

    <x-company.header/>
    <!-- Sidebar Holder -->
    <nav id="sidebar-admin-wraper">
        <div class="page-logo">
            <a href="{{route('company.dashboard')}}"><img src="/images/logo-dark.png" alt=""></a>
        </div>

        <div class="admin-nav scrollbar-macosx">
            <ul>
                <li class="@if(str_contains(request()->url(), 'dashboard')) active @endif">
                    <a href="{{route('company.dashboard')}}"><i class="fa fa-home"></i><span class="admin-nav-text">Dashboard</span></a>
                </li>

                <li class="@if(str_contains(request()->url(), 'profile')) active @endif">
                    <a href="{{route('company.profile')}}"><i class="fa fa-user-tie"></i><span class="admin-nav-text">Company Profile</span></a>
                </li>

                <li
                    class="@if(
                                str_contains(request()->url(), 'post-job') ||
                                str_contains(request()->url(), 'manage-job') ||
                                str_contains(request()->url(), 'detail-job') ||
                                str_contains(request()->url(), 'candidate-applied')
                                )
                                active
                           @endif">
                    <a href="javascript:;"><i class="fa fa-suitcase"></i><span class="admin-nav-text">Jobs</span></a>
                    <ul class="sub-menu">
                        <li><a href="{{route('company.show.post-job')}}"><span
                                    class="admin-nav-text">Post a New Jobs</span></a></li>
                        <li><a href="{{route('company.manage-job')}}"><span
                                    class="admin-nav-text">Manage Jobs</span></a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('candidate.list')}}"><i class="fa fa-user-friends"></i><span class="admin-nav-text">Candidates</span></a>
                </li>
                <li>
                    <a href="{{route('company.show.invite')}}"><i class="fa fa-money-bill-alt"></i><span class="admin-nav-text">Invites</span></a>
                </li>
                <li>
                    <a href="dash-bookmark.html"><i class="fa fa-bookmark"></i><span class="admin-nav-text">Bookmark Resumes</span></a>
                </li>



                <li>
                    <a href="javascript:;"><i class="fa fa-envelope"></i><span class="admin-nav-text">Messages <sup
                                class="twm-msg-noti">5</sup></span></a>
                    <ul class="sub-menu">
                        <li><a href="dash-messages.html"><span class="admin-nav-text">MSG Style-1</span></a></li>
                        <li><a href="dash-messages_2.html"><span class="admin-nav-text">MSG Style-2</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="dash-resume-alert.html"><i class="fa fa-bell"></i><span class="admin-nav-text">Resume Alerts</span></a>
                </li>

                <li>
                    <a href="dash-my-profile.html"><i class="fa fa-user"></i><span
                            class="admin-nav-text">My Profile1</span></a>
                </li>

                <li>
                    <a href="dash-change-password.html"><i class="fa fa-fingerprint"></i><span class="admin-nav-text">Change Password</span></a>
                </li>

                <li>
                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#delete-dash-profile"><i
                            class="fa fa-trash-alt"></i><span class="admin-nav-text">Delete Profile</span></a>
                </li>

                <li>
                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#logout-dash-profile"><i
                            class="fa fa-share-square"></i><span class="admin-nav-text">Logout</span></a>
                </li>

            </ul>
        </div>
    </nav>

    @yield('content')

    <!--Delete Profile Popup-->
    <div class="modal fade twm-model-popup" id="delete-dash-profile" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 class="modal-title">Do you want to delete your profile?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="site-button" data-bs-dismiss="modal">No</button>
                    <button type="button" class="site-button outline-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>


    <!--Logout Profile Popup-->
    <div class="modal fade twm-model-popup" id="logout-dash-profile" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 class="modal-title">Do you want to Logout your profile?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="site-button" data-bs-dismiss="modal">No</button>
                    <button type="button" class="site-button outline-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>


</div>


<audio id="notification-sound" src="{{asset('/sound/ding.mp3')}}"></audio>



<!-- JAVASCRIPT  FILES ========================================= -->
<x-script-js/>

@stack('js')

<script>
    function playNotificationSound() {
        const audio = document.getElementById('notification-sound');
            /* the audio is now playable; play it if permissions allow */
        var resp = audio.play();

        if (resp!== undefined) {
            resp.then(_ => {
                audio.play()
            }).catch(error => {
                //show error
            });
        }
        console.log('play sound')

    }
    // Function to update the browser tab title
    function updateTabTitle(message) {
        const originalTitle = document.title;
        document.title = `(1) Bạn có một thông báo mới !`;

        // Restore the original title after a few seconds (optional)
        setTimeout(() => {
            document.title = originalTitle;
        }, 2000);
    }
    document.addEventListener('DOMContentLoaded', function () {
        window.Echo.private('appointment.company.' + '{{auth()->guard('company')->user()->id}}')
            .listen('AppointmentAcceptEvent', (e) => {
                toastr.success('Bạn có một thông báo mới !', 'Notification!');
                updateTabTitle();
                playNotificationSound()
                let notiRead = $("#notification-read-count");
                notiRead.text(parseInt(notiRead.text()) + 1)
                let notiUnread = $("#notification-unread-count");
                notiUnread.text(parseInt(notiUnread.text()) + 1)
                $("#wrap-notification").append(`
                    <li>
                        <a href="#">
                            <span class="noti-icon"><i
                                    class="far fa-bell"></i></span>
                            <span
                                class="noti-texting">${e.message}</span>
                        </a>
                    </li>
                `)
            });

        window.Echo.private('notification.' + '{{auth()->guard('company')->user()->id}}')
            .listen('NotificationEvent', (e) => {
                createNoti(e)
            })

        function createNoti(e) {
            toastr.success(e.message, 'Notification !')
            updateTabTitle()
            playNotificationSound()
            let notiRead = $("#notification-read-count");
            notiRead.text(parseInt(notiRead.text()) + 1)

            let notiUnread = $("#notification-unread-count");
            notiUnread.text(parseInt(notiUnread.text()) + 1)
            $("#wrap-notification").prepend(`
                    <li>
                        <a href="#">
                            <span class="noti-icon"><i
                                    class="far fa-bell"></i></span>
                            <span
                                class="noti-texting">${e.message}</span>
                        </a>
                    </li>
                `)
        }
    });
</script>

</body>

</html>
