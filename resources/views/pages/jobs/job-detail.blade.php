@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="/richtexteditor/rte_theme_default.css" />
    <style>
        .richtexteditor.rte-skin-default.rte-modern {
            width: unset !important;
            min-width: unset !important;
        }
        /* Định nghĩa overlay */
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Màu nền mờ */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Hiển thị trên tất cả các thành phần khác */
            visibility: hidden; /* Ẩn overlay mặc định */
        }

        /* Định nghĩa icon loading */
        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        /* Hiệu ứng xoay */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Hiển thị overlay khi cần */
        #overlay.active {
            visibility: visible;
        }

    </style>
@endpush
@section('content')
    <div id="overlay">
        <div class="spinner"></div>
    </div>
    <!-- Modal Report Career-->
    <div class="modal fade" id="modal-report-career" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.Report Violations') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">{{ trans('lang.Content Report') }}</div>
                    <input hidden id="career-id" value="" />
                    <textarea id="report-content" placeholder="{{ trans('lang.Content') }}" class="form-control" cols="30"
                        rows="20"></textarea>
                    <label for="fileInput" class="form-label">Upload Image:</label>
                    <input class="form-control" type="file" id="fileInput" multiple>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ trans('lang.close') }}</button>
                    <button type="button" onclick="reportCareer()" id="btn-send-report"
                        class="btn btn-primary">{{ trans('lang.report') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url({{ asset('/images/banner/1.jpg') }});">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">{{ $career['title'] }}</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="index.html">{{ __('lang.header.home') }}</a></li>
                            <li>{{ $career['category']->name }}</li>
                            <li>{{ $career['title'] }}</li>
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
                                                <img width="100%"
                                                    src="{{ asset('/images/avatar/' . $career['company']->banner) }}"
                                                    alt="#">
                                                <div class="twm-jobs-category green">
                                                    @if ($career['expiration_day'] < \Carbon\Carbon::now())
                                                        <span style="background: #929292">Expired</span>
                                                    @else
                                                        <span class="twm-bg-green">New</span>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="twm-mid-content">

                                                <div class="twm-media">
                                                    <img src="{{ str_contains($career['company']->company_avatar, 'company/')
                                                        ? asset('/images/avatar/' . $career['company']->company_avatar)
                                                        : $career['company']->company_avatar }}"
                                                        alt="#">
                                                </div>

                                                <h4 class="twm-job-title d-flex">
                                                    {{ $career['title'] }}
                                                    <span class="twm-job-post-duration">/
                                                        {{ $career['updated_at'] }}</span>
                                                    <div class="">
                                                        <span onclick="showModalReportCareer({{ $career['id'] }})"
                                                            class="btn-report">{{ trans('lang.report') }}</span>
                                                    </div>
                                                </h4>
                                                <p class="twm-job-address">
                                                    <i class="feather-map-pin"></i>
                                                    {{ $career['address'] }}
                                                </p>
                                                <p>
                                                    <strong>
                                                        {{trans('lang.company')}}:
                                                        {{$career['company']->company_name}}
                                                    </strong>
                                                </p>
                                                <div class="twm-job-self-mid">
                                                    <div class="twm-job-self-mid-left">
                                                        <a href="https://themeforest.net/user/thewebmax/portfolio"
                                                            class="twm-job-websites site-text-primary">{{ $career['company']->website }}</a>
                                                        <div class="twm-jobs-amount">{{ $career['min_salary']['convert'] }}
                                                            - {{ $career['max_salary']['convert'] }} <span>/ Month</span>
                                                        </div>
                                                    </div>
                                                    {{--                                                    <div class="twm-job-apllication-area">Application ends: --}}
                                                    {{--                                                        <span class="twm-job-apllication-date">October 1, 2025</span> --}}
                                                    {{--                                                    </div> --}}
                                                </div>

                                                @if (!$isApplied)
                                                    <div class="twm-job-self-bottom">
                                                        <a class="site-button" data-bs-toggle="modal"
                                                            href="#apply_job_popup" role="button">
                                                            {{ trans('lang.apply') }}
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

                                <h4 class="twm-s-title">{{ trans('lang.Job Description') }}:</h4>
                                @if (!empty($career['detail']->description))
                                    {!! $career['detail']->description !!}
                                @else
                                    <x-empty text="{{ trans('lang.No Data') }}" />
                                @endif

                                <h4 class="twm-s-title">{{ trans('lang.requirements') }}:</h4>
                                @if (!empty($career['detail']->requirement))
                                    {!! $career['detail']->requirement !!}
                                @else
                                    <x-empty text="{{ trans('lang.No Data') }}" />
                                @endif

                                <h4 class="twm-s-title">{{ trans('lang.responsabilities') }}:</h4>
                                @if (!empty($career['detail']->key_responsibilities))
                                    {!! $career['detail']->key_responsibilities !!}
                                @else
                                    <x-empty text="{{ trans('lang.No Data') }}" />
                                @endif


                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12 rightSidebar">

                            <div class="side-bar mb-4">
                                <div class="twm-s-info2-wrap mb-5">
                                    <div class="twm-s-info2">
                                        <h4 class="section-head-small mb-4">{{ trans('lang.Job Information') }}</h4>
                                        <ul class="twm-job-hilites2">

                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <span class="twm-title">{{ trans('lang.Posted On') }}</span>
                                                    <div class="twm-s-info-discription">{{ $career['created_at'] }}</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <span class="twm-title">{{ trans('lang.expiration') }}</span>
                                                    <div class="twm-s-info-discription">{{ $career['expiration_day'] }}
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span class="twm-title">{{ trans('lang.location') }}</span>
                                                    <div class="twm-s-info-discription">{{ $career['province']->name }}
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-user-tie"></i>
                                                    <span class="twm-title">{{ trans('lang.level') }}</span>
                                                    <div class="twm-s-info-discription">{{ $career['level'] }}</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-clock"></i>
                                                    <span class="twm-title">{{ trans('lang.experience') }}</span>
                                                    <div class="twm-s-info-discription">{{ $career['experience'] }}</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-suitcase"></i>
                                                    <span class="twm-title">{{ trans('lang.qualifications') }}</span>
                                                    <div class="twm-s-info-discription">{{ $career['qualification'] }}
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">
                                                    <i class="fas fa-venus-mars"></i>
                                                    <span class="twm-title">{{ trans('lang.gender') }}</span>
                                                    <div class="twm-s-info-discription">{{ $career['gender'] }}</div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="twm-s-info-inner">

                                                    <i class="fas fa-money-bill-wave"></i>
                                                    <span class="twm-title">{{ trans('lang.salary') }}</span>
                                                    <div class="twm-s-info-discription">
                                                        {{ $career['min_salary']['convert'] }}-{{ $career['max_salary']['convert'] }}
                                                        / Month</div>
                                                </div>
                                            </li>

                                        </ul>

                                    </div>
                                </div>

                                <div class="widget tw-sidebar-tags-wrap">
                                    <h4 class="section-head-small mb-4">{{ trans('lang.Job Skills') }}</h4>

                                    <div class="tagcloud">

                                        @foreach ($career['skills'] as $skill)
                                            <a href="javascript:void(0)">{{ $skill->name }}</a>
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
                    <h4 class="modal-title" id="sign_up_popupLabel">{{ trans('lang.apply') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="apl-job-inpopup">
                        <!--Basic Information-->
                        <div class="panel panel-default">

                            <div class="panel-body wt-panel-body p-a20 ">

                                <div class="twm-tabs-style-1">

                                    <div class="row">
{{--                                        <div class="col-xl-12 col-lg-12 col-md-12">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>{{ trans('lang.Your Name') }}</label>--}}
{{--                                                <div class="ls-inputicon-box">--}}
{{--                                                    <input class="form-control" readonly name="company_name"--}}
{{--                                                        type="text" value="{{ auth()->user()->fullname }}">--}}
{{--                                                    <i class="fs-input-icon fa fa-user "></i>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-xl-12 col-lg-12 col-md-12">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>{{ trans('lang.Email Address') }}</label>--}}
{{--                                                <div class="ls-inputicon-box">--}}
{{--                                                    <input class="form-control" name="company_Email" readonly--}}
{{--                                                        type="email" value="{{ auth()->user()->email }}">--}}
{{--                                                    <i class="fs-input-icon fas fa-at"></i>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <input type="text" hidden id="current_cv_id">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <input checked value="upload_cv" name="type_cv" type="radio">
                                                <label>{{trans('lang.Upload Resume')}}</label>
                                                <form id="uploadForm" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <input class="form-control" type="file" id="formFile"
                                                            name="file">
                                                    </div>
                                                    <button type="submit" id="btn-upload"
                                                        class="btn btn-primary">{{trans('lang.upload')}}</button>
                                                </form>
                                            </div>


                                        </div>

                                        <div class="col-lg-12 col-md-12">
                                            <input value="available_cv" name="type_cv" type="radio">
                                            <label>{{trans('lang.CV Available')}}</label>

                                            <select id="cv_id" class="form-select mb-3"
                                                aria-label="Default select example">
                                                <option selected>{{ trans('lang.Select your CV') }}</option>
                                                @foreach ($resumes as $resume)
                                                    <option value="{{ $resume->id }}">{{ $resume->path }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="col-lg-12 col-md-12 mb-2">
                                            <div class="container1">
                                                <div class="card">
                                                    <div class="card-header">
                                                        {{trans('lang.Letter Introduction')}}
                                                        <button id="btnGetLetter" onclick="handleIntroduction()" style="font-size: 13px; color: white" class="btn btn-info">
                                                            {{trans('lang.Create auto')}}
                                                            <img class="d-none" id="loading" src="/images/loading.svg" width="18" alt="">
                                                        </button>

                                                    </div>
                                                    <div class="card-body">
                                                        <form>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="introduction" id="no-introduction" value="option1" checked>
                                                                <label class="form-check-label" for="no-introduction">
                                                                    {{trans('lang.Not Use')}}
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="introduction" id="custom-introduction" value="option2">
                                                                <label class="form-check-label" for="custom-introduction">
                                                                    {{trans('lang.Write Content')}}
                                                                </label>
                                                            </div>
                                                            <div id="custom-introduction-content" style="display: none;">
                                                                <textarea class="form-control" id="custom-introduction-text" rows="5" placeholder="{{trans('lang.Enter self-introduction content')}}"></textarea>
                                                            </div>
                                                            <div id="no-use-introduction">
                                                                <p>{{trans('lang.The system will send a notification email to the employer')}}</p>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="text-left">
                                                <button type="button" id="btn-send-application"
                                                    class="site-button">{{ trans('lang.Send Application') }}</button>

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
    <script type="text/javascript" src="/richtexteditor/rte.js"></script>
    <script type="text/javascript" src='/richtexteditor/plugins/all_plugins.js'></script>
    <script>
        let selectedCvId = null;
        let editor1 = new RichTextEditor("#custom-introduction-text");

        $(document).ready(function() {

            const introductionRadio = document.getElementsByName('introduction');
            const customIntroductionContent = document.getElementById('custom-introduction-content');
            const noUseIntroductionContent = document.getElementById('no-use-introduction');

            introductionRadio.forEach(radio => {
                radio.addEventListener('change', () => {
                    if (radio.value === 'option2') {
                        customIntroductionContent.style.display = 'block';
                        noUseIntroductionContent.style.display = 'none';
                    } else {
                        customIntroductionContent.style.display = 'none';
                        noUseIntroductionContent.style.display = 'block';
                    }
                });
            });

            let typeChooseCV = 'upload_cv'
            $('#uploadForm').on('submit', function(e) {
                e.preventDefault();
                const btnUpload = $("#btn-upload");

                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('api.file.upload') }}", // Đường dẫn API
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        btnUpload.text('Process...')
                        btnUpload.prop('disabled', true)
                    },
                    success: function(response) {
                        $("#current_cv_id").val(response.cv.id)
                        alert('Upload success !')
                        console.log(response)
                    },
                    error: function(response) {
                        alert(response.responseJSON.message)
                    },
                    complete: function() {
                        btnUpload.text('Upload')
                        btnUpload.prop('disabled', false)
                    }
                });
            });


            const btnSend = $("#btn-send-application");

            // chooseTypeCV.change(function (e) {
            //     if (e.target.value === 'upload_cv') {
            //         $("#current_cv_id").val()
            //     }
            // })

            btnSend.click(function() {
                if ({{ $career['flag'] }}) {
                    return confirm('This job is being flagged. Are you sure you want to continue?')
                }
                let chooseTypeCV = $('input[name="type_cv"]:checked')
                let letter = $('input[name="introduction"]:checked').val() === 'option1' ? '' : $("#custom-introduction-text").val();

                $.ajax({
                    type: 'POST',
                    // make sure you respect the same origin policy with this url:
                    // http://en.wikipedia.org/wiki/Same_origin_policy
                    url: '{{ route('api.v1.applyJob') }}',
                    data: {
                        "job_id": {{ $career['id'] }},
                        'cv_id': chooseTypeCV.val() === 'upload_cv' ? $("#current_cv_id").val() : $(
                            "#cv_id").val(),
                        'letter': letter,
                        "_token": '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        document.getElementById('overlay').classList.add('active');
                    },
                    success: function(msg) {
                        $("#apply_job_popup").modal('toggle');
                        toastr.success('Apply Success !', 'Notification')
                        document.getElementById('overlay').classList.remove('active');
                        setTimeout(() => {
                            window.location.reload()
                        }, 1200)
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message, 'Error !')
                        document.getElementById('overlay').classList.remove('active');

                    }
                });
            })

        })


        function handleIntroduction() {
            let contentIntro = $("#custom-introduction-text").val();
            console.log(contentIntro.length)

            if (contentIntro.length < 18) {
                let uploadCVType = $('input[name="type_cv"]:checked').val() === 'upload_cv';
                console.log($("#current_cv_id").val())
                console.log(uploadCVType)
                // type upload cv
                cv_id = uploadCVType ? $("#current_cv_id").val() : $("#cv_id").val();

                if (cv_id == 'Select your CV' || cv_id == '') {
                    alert('{{trans('lang.Please select at least 1 CV')}}')
                    return;
                }
                $.ajax({
                    type: "POST",
                    url: "/test",
                    data: {
                        'cv_id': cv_id
                    },
                    beforeSend: function () {
                        $("#btn-send-application").prop('disabled', true);
                        $("#loading").toggleClass('d-none');
                    },
                    success: function (res) {
                        editor1.insertHTML(res)
                        editor1.collapse(false)
                        $("#btn-send-application").prop('disabled', false);

                        $("#loading").toggleClass('d-none');
                        toastr.success('Success !');
                    },
                    error: function (xhr) {
                        $("#loading").toggleClass('d-none');
                        toastr.error('Error !');
                        $("#btn-send-application").prop('disabled', false);


                    }

                })
            } else {
                alert('{{trans('lang.Delete old content before starting to write new content')}}')
            }


        }

        function reportCareer() {
            var formData = new FormData();

            // Thêm các file vào FormData
            let filesArr = $('#fileInput')[0].files;
            for (let i = 0; i < filesArr.length; i++) {
                formData.append('files[]', filesArr[i]);
            }

            // Thêm các trường khác vào FormData
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('career_id', $("#career-id").val());
            formData.append('report_content', $("#report-content").val());

            // Gửi request AJAX
            $.ajax({
                type: 'POST',
                url: '{{ route('job.report') }}',
                data: formData,
                processData: false, // Không xử lý dữ liệu FormData
                contentType: false, // Không thiết lập Content-Type mặc định
                beforeSend: function () {
                    document.getElementById('overlay').classList.add('active');

                },
                success: function (res) {
                    toastr.success('Reported Successfully!', 'Notification!');
                    $("#btn-send-report").prop('disabled', true);
                    $("#modal-report-career").modal('toggle');
                    document.getElementById('overlay').classList.remove('active');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);

                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.message, 'Notification!');
                    document.getElementById('overlay').classList.remove('active');

                }
            });
        }


        function showModalReportCareer(careerId) {

            $("#modal-report-career").modal('toggle')
            $("#btn-send-report").prop("disabled", false)
            $("#career-id").val(careerId)
        }

    </script>
@endpush
