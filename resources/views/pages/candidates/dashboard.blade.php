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
                            <h2 class="wt-title">{{ trans('lang.user.dashboard') }}</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="index.html">{{ trans('lang.header.home') }}</a></li>
                            <li>{{ trans('lang.user.dashboard') }}</li>
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
{{--                            <div class="wt-admin-right-page-header">--}}
{{--                                <h2>{{auth()->user()->fullname}}</h2>--}}
{{--                                <p>{{auth()->user()->email}}</p>--}}
{{--                            </div>--}}

                            <div class="twm-dash-b-blocks mb-5">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body wt-panel-body dashboard-card-2 block-gradient">
                                                <div class="wt-card-wrap-2">
                                                    <div class="wt-card-icon-2"><i class="flaticon-job"></i></div>
                                                    <div class="wt-card-right wt-total-active-listing counter ">{{$savedJobCount}}</div>
                                                    <div class="wt-card-bottom-2 ">
                                                        <h4 class="m-b0">{{ trans('lang.Saved Job') }}</h4>
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
                                                    <div class="wt-card-right  wt-total-listing-view counter ">{{$appliedCount}}</div>
                                                    <div class="wt-card-bottom-2">
                                                        <h4 class="m-b0">{{ trans('lang.Total Applications') }}</h4>
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
                                                    <div class="wt-card-right wt-total-listing-review counter ">{{$messageCount}}</div>
                                                    <div class="wt-card-bottom-2">
                                                        <h4 class="m-b0">{{ trans('lang.user.message') }}</h4>
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
                                                    <div class="wt-card-right wt-total-listing-bookmarked counter ">{{$notificationCount}}</div>
                                                    <div class="wt-card-bottom-2">
                                                        <h4 class="m-b0">{{ trans('lang.notification') }}</h4>
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
        </div>
        <!-- OUR BLOG END -->



    </div>
    <!-- CONTENT END -->
@endsection
