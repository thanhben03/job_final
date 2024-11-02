@extends('layouts.company')


@section('content')
    <!-- Page Content Holder -->
    <div id="content">

        <div class="content-admin-main">

            <div class="wt-admin-right-page-header clearfix">
                <h2>{{ trans('lang.Appointment Manager') }}</h2>
                <div class="breadcrumbs"><a href="#">{{ trans('lang.header.home') }}</a><a href="#">{{ trans('lang.user.dashboard') }}</a><span>{{ trans('lang.Appointment Manager') }}</span></div>
            </div>

            <div class="twm-pro-view-chart-wrap">

                <div class="col-lg-12 col-md-12 mb-4">
                    <div class="panel panel-default site-bg-white m-t30">
                        <div class="panel-heading wt-panel-heading p-a20">
                            <h4 class="panel-tittle m-a0"><i class="far fa-bookmark"></i>{{ trans('lang.Appointment Manager') }}</h4>
                        </div>
                        <div class="panel-body wt-panel-body">
                            <div class="twm-D_table p-a20 table-responsive">
                                <table id="jobs_bookmark_table" class="table table-bordered twm-bookmark-list-wrap">
                                    <thead>
                                    <tr>
                                        <th>Candidate</th>
                                        <th>Invite Date</th>
                                        <th>Accepted Date</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!--1-->
                                        @foreach($invites as $invite)
                                            <tr>
                                                <td>
                                                    <div class="twm-bookmark-list">
                                                        <div class="twm-media">
                                                            <div class="twm-media-pic">
                                                                <img
                                                                    src="
                                                       {{
                                                        str_contains($invite['user']->avatar, 'http')
                                                        ? $invite['user']->avatar
                                                        : asset('/images/avatar/'.$invite['user']->avatar)
                                                        }}"
                                                                    alt="#">
                                                            </div>
                                                        </div>
                                                        <div class="twm-mid-content">
                                                            <a href="{{route('candidate.detail', $invite['user']->id)}}" class="twm-job-title">
                                                                <h4>{{$invite['user']->fullname}}</h4>
                                                            </a>
                                                            <p class="twm-bookmark-address">
                                                                <i class="feather-map-pin"></i>
                                                                {{$invite['user']->address}}
                                                            </p>
                                                            <a href="#" class="twm-job-websites site-text-primary">https://thewebmax.com</a>

                                                        </div>

                                                    </div>
                                                </td>
                                                <td>{{$invite['created_at']}}</td>
                                                <td>{{$invite['accepted_at']}}</td>
                                                <td>
                                                    @if($invite['status'])
                                                        <span class="text-clr-green2">
                                                            Accept
                                                        </span>
                                                    @else
                                                        <span class="text-clr-red">
                                                            Reject
                                                        </span>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Candidate</th>
                                        <th>Invite Date</th>
                                        <th>Accepted Date</th>
                                        <th>Status</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
