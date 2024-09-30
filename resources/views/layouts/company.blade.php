<!DOCTYPE html>

<html lang="en">

<head>

    <!-- META -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="description" content="" />

    <!-- FAVICONS ICON -->
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />

    <!-- PAGE TITLE HERE -->
    <title>jobzilla Template | dashboard</title>

    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-head />




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

    <x-company.header />
    <!-- Sidebar Holder -->
    <nav id="sidebar-admin-wraper">
        <div class="page-logo">
            <a href="index.html"><img src="/images/logo-dark.png" alt=""></a>
        </div>

        <div class="admin-nav scrollbar-macosx">
            <ul>
                <li class="active">
                    <a href="dashboard.html"><i class="fa fa-home"></i><span class="admin-nav-text">Dashboard</span></a>
                </li>

                <li>
                    <a href="dash-company-profile.html"><i class="fa fa-user-tie"></i><span class="admin-nav-text">Company Profile</span></a>
                </li>

                <li>
                    <a href="javascript:;"><i class="fa fa-suitcase"></i><span class="admin-nav-text">Jobs</span></a>
                    <ul class="sub-menu">
                        <li> <a href="dash-post-job.html"><span class="admin-nav-text">Post a New Jobs</span></a></li>
                        <li> <a href="dash-manage-jobs.html"><span class="admin-nav-text">Manage Jobs</span></a></li>
                    </ul>
                </li>
                <li>
                    <a href="dash-candidates.html"><i class="fa fa-user-friends"></i><span class="admin-nav-text">Candidates</span></a>
                </li>
                <li>
                    <a href="dash-bookmark.html"><i class="fa fa-bookmark"></i><span class="admin-nav-text">Bookmark Resumes</span></a>
                </li>

                <li>
                    <a href="dash-package.html"><i class="fa fa-money-bill-alt"></i><span class="admin-nav-text">Packages</span></a>
                </li>

                <li>
                    <a href="javascript:;"><i class="fa fa-envelope"></i><span class="admin-nav-text">Messages <sup class="twm-msg-noti">5</sup></span></a>
                    <ul class="sub-menu">
                        <li> <a href="dash-messages.html"><span class="admin-nav-text">MSG Style-1</span></a></li>
                        <li> <a href="dash-messages_2.html"><span class="admin-nav-text">MSG Style-2</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="dash-resume-alert.html"><i class="fa fa-bell"></i><span class="admin-nav-text">Resume Alerts</span></a>
                </li>

                <li>
                    <a href="dash-my-profile.html"><i class="fa fa-user"></i><span class="admin-nav-text">My Profile</span></a>
                </li>

                <li>
                    <a href="dash-change-password.html"><i class="fa fa-fingerprint"></i><span class="admin-nav-text">Change Password</span></a>
                </li>

                <li>
                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#delete-dash-profile"><i class="fa fa-trash-alt"></i><span class="admin-nav-text">Delete Profile</span></a>
                </li>

                <li>
                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#logout-dash-profile"><i class="fa fa-share-square"></i><span class="admin-nav-text">Logout</span></a>
                </li>

            </ul>
        </div>
    </nav>

    @yield('content')

    <!--Delete Profile Popup-->
    <div class="modal fade twm-model-popup" id="delete-dash-profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"  aria-hidden="true">
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
    <div class="modal fade twm-model-popup" id="logout-dash-profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
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


<!-- JAVASCRIPT  FILES ========================================= -->
<x-script-js />

@stack('js')

</body>

</html>
