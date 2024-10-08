@extends('layouts.app')
@section('content')
    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url(images/banner/1.jpg);">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">Candidate Saved Jobs</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="index.html">Home</a></li>
                            <li>Candidate Saved Jobs</li>
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
                        <div class="twm-right-section-panel candidate-save-job site-bg-gray">
                            <div class="twm-D_table table-responsive">
                                <table id="jobs_bookmark_table" class="table table-bordered twm-candidate-save-job-list-wrap">
                                    <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Company</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $career)
                                        <tr>
                                            <td>
                                                <div class="twm-candidate-save-job-list">
                                                    <div class="twm-media">
                                                        <div class="twm-media-pic">
                                                            <img src="{{$career['company']->company_avatar}}" alt="#">
                                                        </div>
                                                    </div>
                                                    <div class="twm-mid-content">
                                                        <a href="{{route('jobs.show', $career['slug'])}}" class="twm-job-title">
                                                            <h4>{{$career['title']}}</h4>
                                                        </a>

                                                    </div>

                                                </div>
                                            </td>
                                            <td><a href="javascript:;">{{$career['company']->company_name}}</a></td>
                                            <td>
                                                <div>28/06/2023</div>
                                            </td>

                                            <td>
                                                <div class="twm-table-controls">
                                                    <ul class="twm-DT-controls-icon list-unstyled">
                                                        <li>
                                                            <a data-bs-toggle="modal" href="{{route('jobs.show', $career['slug'])}}" role="button" class="custom-toltip">
                                                                <span class="fa fa-eye"></span>
                                                                <span class="custom-toltip-block">Veiw</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button onclick="removeJob({{$career['id']}})" title="Delete" data-bs-toggle="tooltip" data-bs-placement="top">
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
                                        <th>Company</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
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
@push('js')
    <script>
        function removeJob(careerId) {
            $.ajax({
                type: 'POST',
                url: '{{route('candidate.process.saved-job')}}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'career_id': careerId
                },
                success: function(res){
                    toastr.success(res.msg, 'Notification !')
                    window.location.reload()
                }
            });
        }
    </script>
@endpush
