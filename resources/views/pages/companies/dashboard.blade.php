@extends('layouts.company')


@section('content')
    <!-- Page Content Holder -->
    <div id="content">

        <div class="content-admin-main">

            <div class="wt-admin-right-page-header clearfix">
                <h2>{{ trans('lang.hello') }}, {{ Auth::guard('company')->user()->company_name }}</h2>
                <div class="breadcrumbs"><a href="#">{{ trans('lang.header.home') }}</a><span>{{ trans('lang.user.dashboard') }}</span></div>
            </div>

            <div class="twm-dash-b-blocks mb-5">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-12 mb-3">
                        <div class="panel panel-default">
                            <div class="panel-body wt-panel-body gradi-1 dashboard-card ">
                                <div class="wt-card-wrap">
                                    <div class="wt-card-icon"><i class="far fa-address-book"></i></div>
                                    <div class="wt-card-right wt-total-active-listing counter ">{{$postedJobCount}}</div>
                                    <div class="wt-card-bottom ">
                                        <h4 class="m-b0">{{ trans('lang.Posted Jobs') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 mb-3">
                        <div class="panel panel-default">
                            <div class="panel-body wt-panel-body gradi-2 dashboard-card ">
                                <div class="wt-card-wrap">
                                    <div class="wt-card-icon"><i class="far fa-file-alt"></i></div>
                                    <div class="wt-card-right  wt-total-listing-view counter ">{{$appliedCount}}</div>
                                    <div class="wt-card-bottom">
                                        <h4 class="m-b0">{{ trans('lang.Total Applications') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 mb-3">
                        <div class="panel panel-default">
                            <div class="panel-body wt-panel-body gradi-3 dashboard-card ">
                                <div class="wt-card-wrap">
                                    <div class="wt-card-icon"><i class="far fa-envelope"></i></div>
                                    <div class="wt-card-right wt-total-listing-review counter ">{{$messageCount}}</div>
                                    <div class="wt-card-bottom">
                                        <h4 class="m-b0">{{ trans('lang.user.message') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 mb-3">
                        <div class="panel panel-default">
                            <div class="panel-body wt-panel-body gradi-4 dashboard-card ">
                                <div class="wt-card-wrap">
                                    <div class="wt-card-icon"><i class="far fa-bell"></i></div>
                                    <div class="wt-card-right wt-total-listing-bookmarked counter ">{{$notificationCount}}</div>
                                    <div class="wt-card-bottom">
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
@endsection
