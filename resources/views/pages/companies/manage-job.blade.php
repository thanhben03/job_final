@extends('layouts.company')

@section('content')
    <!-- Page Content Holder -->
    <div id="content">

        <div class="content-admin-main">

            <div class="wt-admin-right-page-header clearfix">
                <h2>Manage Jobs</h2>
                <div class="breadcrumbs"><a href="#">Home</a><a href="#">Dasboard</a><span>My Job Listing</span></div>
            </div>

            <!--Basic Information-->
            <div class="panel panel-default">
                <div class="panel-heading wt-panel-heading p-a20">
                    <h4 class="panel-tittle m-a0"><i class="fa fa-suitcase"></i> Job Details</h4>
                </div>
                <div class="panel-body wt-panel-body p-a20 m-b30 ">
                    <div class="twm-D_table p-a20 table-responsive">
                        <table id="jobs_bookmark_table" class="table table-bordered twm-bookmark-list-wrap">
                            <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Category</th>
                                <th>Job Types</th>
                                <th>Applications</th>
                                <th>Created & Expired</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--1-->
                            @foreach($careers as $career)
                                <tr>
                                    <td>
                                        <div class="twm-bookmark-list">
                                            <div class="twm-media">
                                                <div class="twm-media-pic">
                                                    <img src="{{asset('/images/avatar/'.auth()->user()->company->company_avatar)}}" alt="#">
                                                </div>
                                            </div>
                                            <div class="twm-mid-content">
                                                <a href="#" class="twm-job-title">
                                                    <a href="{{route('company.show.detail-job', $career['slug'])}}">
                                                        <h4>{{$career['title']}}</h4>
                                                    </a>
                                                    <p class="twm-bookmark-address">
                                                        <i class="feather-map-pin"></i>{{$career['address']}}
                                                    </p>
                                                </a>

                                            </div>

                                        </div>
                                    </td>
                                    <td>{{$career['level']}}</td>
                                    <td><div class="twm-jobs-category"><span class="twm-bg-green">Part Time</span></div></td>
                                    <td><a href="javascript:;" class="site-text-primary">{{$career['cv_applied'] == null ? 0 : count(array($career['cv_applied']))}} Applied</a></td>
                                    <td>
                                        <div>{{$career['created_at']}} &</div>
                                        <div>{{$career['expiration_day']}}</div>
                                    </td>

                                    <td>
                                        <div class="twm-table-controls">
                                            <ul class="twm-DT-controls-icon list-unstyled">
                                                <li>
                                                    <button title="View profile" data-bs-toggle="tooltip" data-bs-placement="top">
                                                        <span class="fa fa-eye"></span>
                                                    </button>
                                                </li>
                                                <li>
                                                    <a href="{{route('company.show.detail-job', $career['slug'])}}">
                                                        <button title="Edit" data-bs-toggle="tooltip" data-bs-placement="top">
                                                            <span class="far fa-edit"></span>
                                                        </button>
                                                    </a>
                                                </li>
                                                <li>
                                                    <button title="Delete" data-bs-toggle="tooltip" data-bs-placement="top">
                                                        <span class="far fa-trash-alt"></span>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Job Title</th>
                                <th>Category</th>
                                <th>Job Types</th>
                                <th>Applications</th>
                                <th>Created & Expired</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
