@extends('layouts.app')

@section('content')
    <!-- Modal Report Career-->
    <div class="modal fade" id="modal-report-career" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Báo cáo vi phạm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">Nếu bạn cho rằng đây là tin giả, vi phạm tiêu chuẩn hãy cho chúng tôi biết</div>
                    <input hidden id="career-id" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="reportCareer()" id="btn-send-report" class="btn btn-primary">Report</button>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url({{asset('/images/banner/1.jpg')}});">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">IT Department Manager</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="index.html">Home</a></li>
                            <li>Job Detail</li>
                        </ul>
                    </div>

                    <!-- BREADCRUMB ROW END -->
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->



        <!-- OUR BLOG START -->
        <div class="section-full  p-t120 p-b90 bg-white">
            <div class="container">

                <!-- BLOG SECTION START -->
                <div class="section-content">
                    <div class="row d-flex justify-content-center">

                        <div class="col-lg-8 col-md-12">
                            <!-- Candidate detail START -->
                            <div class="cabdidate-de-info">
                                <div class="twm-job-self-wrap">
                                    <div class="twm-job-self-info">
                                        <div class="twm-job-self-top">
                                            <div class="twm-media-bg">
                                                <img width="100%" src="{{asset('/images/banner-detail.jpg')}}" alt="#">
                                                <div class="twm-jobs-category green"><span class="twm-bg-green">New</span></div>
                                            </div>


                                            <div class="twm-mid-content">

                                                <div class="twm-media">
                                                    <img src="{{
                                            str_contains($career['company']->company_avatar, 'company/')
                                            ? asset('/images/avatar/'.$career['company']->company_avatar)
                                            : $career['company']->company_avatar}}" alt="#">
                                                </div>

                                                <h4 class="twm-job-title d-flex">
                                                    {{$career['title']}}
                                                    <span class="twm-job-post-duration">/ {{$career['updated_at']}}</span>
                                                    <div class="">
                                                        <span onclick="showModalReportCareer({{$career['id']}})" class="btn-report">Report</span>
                                                    </div>
                                                </h4>
                                                <p class="twm-job-address"><i class="feather-map-pin"></i>{{$career['address']}}</p>
                                                <div class="twm-job-self-mid">
                                                    <div class="twm-job-self-mid-left">
                                                        <a href="https://themeforest.net/user/thewebmax/portfolio" class="twm-job-websites site-text-primary">{{$career['company']->website}}</a>
                                                        <div class="twm-jobs-amount">{{$career['min_salary']['convert']}} - {{$career['max_salary']['convert']}} <span>/ Month</span></div>
                                                    </div>
{{--                                                    <div class="twm-job-apllication-area">Application ends:--}}
{{--                                                        <span class="twm-job-apllication-date">October 1, 2025</span>--}}
{{--                                                    </div>--}}
                                                </div>

                                                @if(!$isApplied)
                                                    <div class="twm-job-self-bottom">
                                                        <a class="site-button" data-bs-toggle="modal" href="#apply_job_popup" role="button">
                                                            Apply Now
                                                        </a>
                                                    </div>
                                                @else
                                                    <button class="btn btn-success applied-btn">
                                                        Applied
                                                        <i class="fas fa-check"></i>

                                                    </button>
                                                @endif

                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <h4 class="twm-s-title">Job Description:</h4>
                                @if(!empty($career['detail']->description))
                                    {!! $career['detail']->description !!}
                                @else
                                    <x-empty text="No description for this job" />
                                @endif

                                <h4 class="twm-s-title">Requirements:</h4>
                                @if(!empty($career['detail']->requirement))
                                    {!! $career['detail']->requirement !!}
                                @else
                                    <x-empty text="No requirements for this job" />
                                @endif

                                <h4 class="twm-s-title">Responsabilities:</h4>
                                @if(!empty($career['detail']->key_responsibilities))
                                    {!! $career['detail']->key_responsibilities !!}
                                @else
                                    <x-empty text="No responsibilities for this job" />
                                @endif


                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12 rightSidebar">

                            <div class="side-bar mb-4">
                                <div class="twm-s-info2-wrap mb-5">
                                    <div class="twm-s-info2">
                                        <h4 class="section-head-small mb-4">Job Information</h4>
                                        <ul class="twm-job-hilites">
                                            <li>
                                                <i class="fas fa-calendar-alt"></i>
                                                <span class="twm-title">Date Posted</span>
                                            </li>
                                            <li>
                                                <i class="fas fa-eye"></i>
                                                <span class="twm-title">8160 Views</span>
                                            </li>
                                            <li>
                                                <i class="fas fa-file-signature"></i>
                                                <span class="twm-title">6 Applicants</span>
                                            </li>
                                        </ul>
                                        <ul class="twm-job-hilites2">

                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <span class="twm-title">Date Posted</span>
                                                    <div class="twm-s-info-discription">{{$career['created_at']}}</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span class="twm-title">Location</span>
                                                    <div class="twm-s-info-discription">{{$career['province']->name}}</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-user-tie"></i>
                                                    <span class="twm-title">Level</span>
                                                    <div class="twm-s-info-discription">{{$career['level']}}</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-clock"></i>
                                                    <span class="twm-title">Experience</span>
                                                    <div class="twm-s-info-discription">{{$career['experience']}}</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-suitcase"></i>
                                                    <span class="twm-title">Qualification</span>
                                                    <div class="twm-s-info-discription">{{$career['qualification']}}</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-venus-mars"></i>
                                                    <span class="twm-title">Gender</span>
                                                    <div class="twm-s-info-discription">{{$career['gender']}}</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">

                                                    <i class="fas fa-money-bill-wave"></i>
                                                    <span class="twm-title">Offered Salary</span>
                                                    <div class="twm-s-info-discription">{{$career['min_salary']['convert']}}-{{$career['max_salary']['convert']}} / Month</div>
                                                </div>
                                            </li>

                                        </ul>

                                    </div>
                                </div>

                                <div class="widget tw-sidebar-tags-wrap">
                                    <h4 class="section-head-small mb-4">Job Skills</h4>

                                    <div class="tagcloud">

                                        @foreach($career['skills'] as $skill)
                                            <a href="javascript:void(0)">{{$skill->name}}</a>
                                        @endforeach
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
    <!--apply job popup -->
    <div class="modal fade" id="apply_job_popup" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="sign_up_popupLabel">Apply For This Job</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="apl-job-inpopup">
                        <!--Basic Information-->
                        <div class="panel panel-default">

                            <div class="panel-body wt-panel-body p-a20 ">

                                <div class="twm-tabs-style-1">

                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label>Your Name</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control" readonly name="company_name" type="text" value="{{auth()->user()->fullname}}">
                                                    <i class="fs-input-icon fa fa-user "></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label>Email Address</label>
                                                <div class="ls-inputicon-box">
                                                    <input class="form-control" name="company_Email" readonly type="email" value="{{auth()->user()->email}}">
                                                    <i class="fs-input-icon fas fa-at"></i>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-12 col-md-12">
{{--                                            <div class="form-group">--}}
{{--                                                <label>Upload Resume</label>--}}
{{--                                                <form action="upload.php" class="dropzone dz-clickable"><div class="dz-default dz-message"><span><i class="sl sl-icon-plus"></i> Click here or drop files to upload</span></div></form>--}}
{{--                                                <small>If you do not have a resume document, you may write your brief professional profile <a class="site-text-primary" href="javascript:void(0);">here</a></small>--}}
{{--                                            </div>--}}

                                            <select id="cv_id" class="form-select mb-3" aria-label="Default select example">
                                                <option selected>Select your CV</option>
                                                @foreach($resumes as $resume)
                                                    <option value="{{$resume->id}}">{{$resume->path}}</option>
                                                @endforeach
                                            </select>

                                        </div>



                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="text-left">
                                                <button type="button" id="btn-send-application" class="site-button">Send Application</button>
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
@endsection

@push('js')

    <script>
        $(document).ready(function() {
          const btnSend = $("#btn-send-application");
            // check flag job

          btnSend.click(function () {
              if ({{$career['flag']}}) {
                  return confirm('This job is being flagged. Are you sure you want to continue?')
              }
              $.ajax({
                  type: 'POST',
                  // make sure you respect the same origin policy with this url:
                  // http://en.wikipedia.org/wiki/Same_origin_policy
                  url: '{{route('api.v1.applyJob')}}',
                  data: {
                      "job_id" : {{$career['id']}},
                      'cv_id': $("#cv_id").val(),
                      "_token": '{{csrf_token()}}'
                  },
                  success: function(msg){
                      $("#apply_job_popup").modal('toggle');
                      toastr.success('Apply Success !', 'Notification')

                  },
                  error: function (xhr) {
                      toastr.error(xhr.responseJSON.msg, 'Error !')
                  }
              });
          })

        })



        function reportCareer() {
            $.ajax({
                type: 'POST',
                url: '{{route('job.report')}}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'career_id': $("#career-id").val()
                },
                success: function (res) {
                    toastr.success('Reported Successfully !', 'Notification !')
                    $("#btn-send-report").prop('disabled', true)

                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.msg, 'Notification !')
                    $("#btn-send-report").prop('disabled', true)
                }

            })
        }
        function showModalReportCareer (careerId) {

            $("#modal-report-career").modal('toggle')
            $("#btn-send-report").prop("disabled", false)
            $("#career-id").val(careerId)
        }
    </script>
@endpush
