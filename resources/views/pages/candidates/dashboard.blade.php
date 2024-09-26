@extends('layouts.app')
@section('content')
    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url(/images/banner/1.jpg);">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">Candidate Dashboard</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="index.html">Home</a></li>
                            <li>Candidate Chat</li>
                        </ul>
                    </div>

                    <!-- BREADCRUMB ROW END -->
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->


        <!-- OUR BLOG START -->
        <div class="section-full p-t120  p-b90 site-bg-white">


            <div class="container">
                <div class="row">

                    <!-- Right Sidebar -->
                    <x-right-sidebar />
                    <div class="col-xl-9 col-lg-8 col-md-12 m-b30">
                        <!--Filter Short By-->
                        <div class="twm-right-section-panel site-bg-gray">
                            <div class="wt-admin-right-page-header">
                                <h2>{{auth()->user()->fullname}}</h2>
                                <p>IT Contractor</p>
                            </div>

                            <div class="twm-dash-b-blocks mb-5">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body wt-panel-body dashboard-card-2 block-gradient">
                                                <div class="wt-card-wrap-2">
                                                    <div class="wt-card-icon-2"><i class="flaticon-job"></i></div>
                                                    <div class="wt-card-right wt-total-active-listing counter ">25</div>
                                                    <div class="wt-card-bottom-2 ">
                                                        <h4 class="m-b0">Posted Jobs</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body wt-panel-body dashboard-card-2 block-gradient-2">
                                                <div class="wt-card-wrap-2">
                                                    <div class="wt-card-icon-2"><i class="flaticon-resume"></i></div>
                                                    <div class="wt-card-right  wt-total-listing-view counter ">435</div>
                                                    <div class="wt-card-bottom-2">
                                                        <h4 class="m-b0">Total Applications</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body wt-panel-body dashboard-card-2 block-gradient-3">
                                                <div class="wt-card-wrap-2">
                                                    <div class="wt-card-icon-2"><i class="flaticon-envelope"></i></div>
                                                    <div class="wt-card-right wt-total-listing-review counter ">28</div>
                                                    <div class="wt-card-bottom-2">
                                                        <h4 class="m-b0">Messages</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body wt-panel-body dashboard-card-2 block-gradient-4">
                                                <div class="wt-card-wrap-2">
                                                    <div class="wt-card-icon-2"><i class="flaticon-bell"></i></div>
                                                    <div class="wt-card-right wt-total-listing-bookmarked counter ">18</div>
                                                    <div class="wt-card-bottom-2">
                                                        <h4 class="m-b0">Notifications</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="twm-pro-view-chart-wrap">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 mb-4">

                                        <div class="panel panel-default site-bg-white">
                                            <div class="panel-heading wt-panel-heading p-a20">
                                                <h4 class="panel-tittle m-a0"><i class="far fa-chart-bar"></i>Your Profile Views</h4>
                                            </div>
                                            <div class="panel-body wt-panel-body twm-pro-view-chart">
                                                <canvas id="profileViewChart"></canvas>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-12 mb-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading wt-panel-heading p-a20">
                                                <h4 class="panel-tittle m-a0">Inbox</h4>
                                            </div>
                                            <div class="panel-body wt-panel-body bg-white">
                                                <div class="dashboard-messages-box-scroll scrollbar-macosx">

                                                    <div class="dashboard-messages-box">
                                                        <div class="dashboard-message-avtar"><img src="images/user-avtar/pic1.jpg" alt=""></div>
                                                        <div class="dashboard-message-area">
                                                            <h5>Lucy Smith<span>18 June 2023</span></h5>
                                                            <p>Bring to the table win-win survival strategies to ensure proactive domination. at the end of the day, going forward, a new normal that has evolved from generation.</p>
                                                        </div>
                                                    </div>

                                                    <div class="dashboard-messages-box">
                                                        <div class="dashboard-message-avtar"><img src="images/user-avtar/pic3.jpg" alt=""></div>
                                                        <div class="dashboard-message-area">
                                                            <h5>Richred paul<span>19 June 2023</span></h5>
                                                            <p>Bring to the table win-win survival strategies to ensure proactive domination. at the end of the day, going forward, a new normal that has evolved from generation.</p>
                                                        </div>
                                                    </div>

                                                    <div class="dashboard-messages-box">
                                                        <div class="dashboard-message-avtar"><img src="images/user-avtar/pic4.jpg" alt=""></div>
                                                        <div class="dashboard-message-area">
                                                            <h5>Jon Doe<span>20 June 2023</span></h5>
                                                            <p>Bring to the table win-win survival strategies to ensure proactive domination. at the end of the day, going forward, a new normal that has evolved from generation.</p>
                                                        </div>
                                                    </div>

                                                    <div class="dashboard-messages-box">
                                                        <div class="dashboard-message-avtar"><img src="images/user-avtar/pic1.jpg" alt=""></div>
                                                        <div class="dashboard-message-area">
                                                            <h5>Thomas Smith<span>22 June 2023</span></h5>
                                                            <p>Bring to the table win-win survival strategies to ensure proactive domination. at the end of the day, going forward, a new normal that has evolved from generation. </p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 mb-4">
                                        <div class="panel panel-default site-bg-white m-t30">
                                            <div class="panel-heading wt-panel-heading p-a20">
                                                <h4 class="panel-tittle m-a0"><i class="far fa-list-alt"></i>Recent Activities</h4>
                                            </div>
                                            <div class="panel-body wt-panel-body">

                                                <div class="dashboard-list-box list-box-with-icon">
                                                    <ul>
                                                        <li>
                                                            <i class="fa fa-envelope text-success list-box-icon"></i>Nikol Tesla has sent you <a href="#" class="text-success">private message!</a>
                                                            <a href="#" class="close-list-item color-lebel clr-red">
                                                                <i class="far fa-trash-alt"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-suitcase text-primary list-box-icon"></i>Your job for
                                                            <a href="#" class="text-primary">Web Designer</a>
                                                            has been approved!
                                                            <a href="#" class="close-list-item color-lebel clr-red">
                                                                <i class="far fa-trash-alt"></i>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <i class="fa fa-bookmark text-warning list-box-icon"></i>
                                                            Someone bookmarked your
                                                            <a href="#" class="text-warning">SEO Expert</a>
                                                            Job listing!
                                                            <a href="#" class="close-list-item color-lebel clr-red">
                                                                <i class="far fa-trash-alt"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-tasks text-info list-box-icon"></i>
                                                            Your job listing Core
                                                            <a href="#" class="text-info">PHP Developer</a> for Site Maintenance is expiring!
                                                            <a href="#" class="close-list-item color-lebel clr-red">
                                                                <i class="far fa-trash-alt"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-paperclip text-success list-box-icon"></i>
                                                            You have new application for
                                                            <a href="#" class="text-success"> UI/UX Developer & Designer! </a>
                                                            <a href="#" class="close-list-item color-lebel clr-red">
                                                                <i class="far fa-trash-alt"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-suitcase text-danger list-box-icon"></i>
                                                            Your Magento Developer job expire
                                                            <a href="#" class="text-danger">Renew</a>  now it.
                                                            <a href="#" class="close-list-item color-lebel clr-red">
                                                                <i class="far fa-trash-alt"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-star site-text-orange list-box-icon"></i>
                                                            David cope left a
                                                            <a href="#" class="site-text-orange"> review 4.5</a> for Real Estate Logo
                                                            <a href="#" class="close-list-item color-lebel clr-red">
                                                                <i class="far fa-trash-alt"></i>
                                                            </a>
                                                        </li>
                                                    </ul>

                                                </div>

                                            </div>
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



    </div>
    <!-- CONTENT END -->
@endsection
