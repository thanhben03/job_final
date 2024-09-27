
<header  class="site-header header-style-3 mobile-sider-drawer-menu">

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
                <button id="mobile-side-drawer" data-target=".header-nav" data-toggle="collapse" type="button" class="navbar-toggler collapsed">
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
{{--                            <ul class="sub-menu">--}}
{{--                                <li><a href="job-grid.html">Jobs Grid</a></li>--}}
{{--                                <li><a href="job-grid-with-map.html">Jobs Grid with Map</a></li>--}}
{{--                                <li><a href="job-list.html">Jobs List</a></li>--}}
{{--                                <li class="has-child"><a href="javascript:;">Job Detail</a>--}}
{{--                                    <ul class="sub-menu">--}}
{{--                                        <li><a href="job-detail.html">Detail 1</a>--}}
{{--                                        <li><a href="job-detail-v2.html">Detail 2 </a>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                                <li><a href="apply-job.html">Apply Jobs</a></li>--}}
{{--                            </ul>--}}
                        </li>
                        <li class=""><a href="javascript:;">Employers</a>
{{--                            <ul class="sub-menu">--}}
{{--                                <li><a href="employer-grid.html">Employers Grid</a></li>--}}
{{--                                <li><a href="employer-list.html">Employers List</a></li>--}}
{{--                                <li class="has-child"><a href="javascript:;">Employers Detail</a>--}}
{{--                                    <ul class="sub-menu">--}}
{{--                                        <li><a href="employer-detail.html">Detail 1</a>--}}
{{--                                        <li><a href="employer-detail-v2.html">Detail 2</a>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                                <li><a href="employer-profile.html">Profile</a></li>--}}
{{--                                <li><a href="employer-resume.html">Resume</a></li>--}}
{{--                                <li><a href="employer-manage-jobs.html">Manage Jobs</a></li>--}}
{{--                                <li><a href="employer-post-job.html">Post A Jobs</a></li>--}}
{{--                                <li><a href="employer-transaction.html">Transaction</a></li>--}}
{{--                                <li><a href="candidate-grid.html">Browse Candidates</a></li>--}}
{{--                                <li><a href="employer-change-password.html">Change Password</a></li>--}}
{{--                                <li><a href="employer-account-fresher.html">Register Fresher</a></li>--}}
{{--                                <li><a href="employer-account-professional.html">Register Professionals</a></li>--}}
{{--                            </ul>--}}
                        </li>
                        <li class=""><a href="javascript:;">Company</a>
                            <ul class="sub-menu">
                                <li><a href="candidate-grid.html">Candidates Grid</a></li>
                                <li><a href="candidate-list.html">Candidates List</a></li>
                                <li class="has-child"><a href="javascript:;">Candidate Detail</a>
                                    <ul class="sub-menu">
                                        <li><a href="candidate-detail.html">Detail 1</a>
                                        <li><a href="candidate-detail-v2.html">Detail 2</a>
                                    </ul>
                                </li>
                                <li><a href="candidate-dashboard.html">Dashboard</a></li>
                                <li><a href="candidate-profile.html">My Pfofile</a></li>
                                <li><a href="candidate-jobs-applied.html">Applied Jobs</a></li>
                                <li><a href="candidate-my-resume.html">My Resume</a></li>
                                <li><a href="candidate-saved-jobs.html">Saved Jobs</a></li>
                                <li><a href="candidate-cv-manager.html">CV Manager</a></li>
                                <li><a href="candidate-job-alert.html">Job Alerts</a></li>
                                <li><a href="candidate-change-password.html">Change Passeord</a></li>
                                <li><a href="candidate-chat.html">Chat</a></li>
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
                                <div class="dropdown" style="margin-right: 12px">
                                    <!-- Profile Section -->
                                    <div class="d-flex align-items-center" data-bs-toggle="dropdown">
                                        <!-- Profile Picture -->
                                        <img src="{{asset('/images/avatar/'.auth()->user()->avatar)}}" class="rounded-circle me-3" alt="Profile Picture" width="50" height="50">
                                        <!-- Name and Status -->
                                        <div>
                                            <h5 class="mb-0">{{auth()->user()->fullname}}</h5>
                                            <small class="text-success">Đang tìm việc</small>
                                        </div>
                                    </div>
                                    <!-- Dropdown Menu -->
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{route('candidate.dashboard')}}">Dashboard</a></li>
                                        <li><a class="dropdown-item" href="#">Logout</a></li>
                                    </ul>
                                </div>
                            @else
                                <div class="twm-nav-btn-left">
                                    <a class="twm-nav-sign-up" href="{{route('login')}}"     >
                                        <i class="feather-log-in"></i> Sign In
                                    </a>
                                </div>
                            @endif

                            <div class="twm-nav-btn-right">
                                <a href="dash-post-job.html" class="twm-nav-post-a-job">
                                    <i class="feather-briefcase"></i> Post a job
                                </a>
                            </div>
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
