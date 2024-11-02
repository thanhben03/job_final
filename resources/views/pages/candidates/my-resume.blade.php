@extends('layouts.app')
@section('content')
    <!-- Modal Upload CV -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload File</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="uploadResult" class="mt-3">
                </div>
                <div class="modal-body">
                    <!-- Form Upload -->
                    <form id="uploadForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Choose file</label>
                            <input class="form-control" type="file" id="formFile" name="file">
                        </div>
                        <button type="submit" id="btn-upload" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Match JOB -->
    <div class="modal fade" id="modal-math-job" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.Suitable Job') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div
                    class="modal-body"
                    style="
                        height: 465px;
                        overflow: auto;"
                >
                    <p>{{ trans('lang.We suggest you some jobs that match your profile') }}</p>
                    <div class="alert alert-primary">{{ trans('lang.The Best For You') }} !</div>
                    <ul class="list-group" id="suggest-job">

                    </ul>
                    <div class="alert alert-success mt-3">{{ trans('lang.There are similarities') }}</div>
                    <ul class="list-group see-more-match-job" id="suggest-job">
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('lang.close') }}</button>
                    <button type="button" class="btn btn-primary">{{ trans('lang.save') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal QuickView Company-->
    <div class="modal fade" id="modal-view-company" tabindex="-1" aria-labelledby="companyInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="companyInfoModalLabel">{{ trans('lang.Company Information') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="company-content">
                </div>
                <div class="modal-footer">
                    <a type="button" onclick="directViewCompany()" class="btn btn-primary">{{ trans('lang.View Detail') }}</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('lang.close') }}</button>
                </div>
            </div>
        </div>
    </div>


    <x-modal.modal-progress />

    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url(/images/banner/1.jpg);">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">{{ trans('lang.Candidate CV Manager') }}</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="index.html">{{ trans('lang.home') }}</a></li>
                            <li>{{ trans('lang.Candidate CV Manager') }}</li>
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
                        <div class="twm-right-section-panel candidate-save-job site-bg-gray">
                            <!--Filter Short By-->
                            <div class="product-filter-wrap d-flex justify-content-between align-items-center">
                                <span class="woocommerce-result-count-left">{{ trans('lang.CV Manager') }}</span>

                            </div>

                            <div class="twm-cv-manager-list-wrap">
                                <!-- Section: Create CV -->
                                <div class="row upload-section p-4 bg-light border rounded">
                                    <div class="col-md-9 d-flex align-items-center">
                                        <div>
                                            <img src="https://static.topcv.vn/v4/image/cv-manager/no-cv.png" alt="Icon">
                                            <p>{{ trans('lang.You havent created any CV yet') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">+ Tạo mới</button>
                                    </div>
                                </div>

                                <!-- Section: Uploaded CVs -->
                                <div class="uploaded-section">
                                    <h4 class="my-2">{{ trans('lang.CV Uploaded') }}</h4>
                                    <div class="row" style="flex-wrap: nowrap; overflow-x: auto">
                                        <!-- CV Card 1 -->
                                        @foreach($resumes as $resume)
                                            <div class="card mx-1 my-1 card-cv" >
                                                <img src="{{asset('storage/uploads/'. $resume->thumbnail)}}" class="card-img-top card-cv-img" alt="Profile">

                                                <div class="card-body">
                                                    <h5 class="card-title">{{$resume->path}}</h5>
                                                    <p class="card-text">{{ trans('lang.Last Updated') }} {{$resume->updated_at}}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-outline-secondary">
                                                            <a
                                                                download
                                                                href="{{asset('storage/uploads/'. $resume->path)}}">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                        </button>

                                                        <button onclick="deleteCV({{$resume->id}})" class="btn btn-outline-danger">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                <div class="uploaded-section">
                                    <h4 class="my-2">{{ trans('lang.CV created on the system') }}</h4>
                                    <div class="row" style="flex-wrap: nowrap; overflow-x: auto">
                                        <!-- CV Card 1 -->
                                        @foreach($resumeOnSys as $resume)
                                        <div class="card mx-1 my-1 card-cv">
                                            <img src="{{ asset('storage/uploads/' . $resume->cv->thumbnail) }}" class="card-img-top card-cv-img" alt="Profile">
                                        
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $resume->cv->path }}</h5>
                                                <p class="card-text">{{ trans('lang.Last Updated') }} {{ $resume->cv->updated_at }}</p>
                                        
                                                <!-- Three-dot menu for actions -->
                                                <div class="dropdown float-end">
                                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Menu
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li>
                                                            <button class="dropdown-item" onclick="setMainCV({{ $resume->cv->id }})">
                                                                <i class="fas fa-wrench"></i> {{ trans('lang.Set Main CV') }}
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" download href="{{ asset('storage/uploads/' . $resume->cv->path) }}">
                                                                <i class="fas fa-download"></i> {{ trans('lang.download') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('candidate.create-cv', $resume->id) }}">
                                                                <i class="fas fa-edit"></i> {{ trans('lang.edit') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item text-danger" onclick="deleteCV({{ $resume->cv->id }})">
                                                                <i class="fas fa-trash-alt"></i> {{ trans('lang.delete') }}
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item text-warning" onclick="matchWithJob({{ $resume->cv->id }})">
                                                                <i class="fas fa-magic"></i> {{ trans('lang.Match with Job') }}
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            @if(auth()->user()->main_cv == $resume->cv->id)
                                                
                                                <div class="main-cv">Main CV</div>
                                            @endif

                                        </div>
                                        
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
    <!-- CONTENT END -->
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function (e) {
            $('#uploadForm').on('submit', function (e) {
                e.preventDefault();
                const btnUpload = $("#btn-upload");

                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('api.file.upload') }}",  // Đường dẫn API
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        btnUpload.text('Process...')
                        btnUpload.prop('disabled', true)
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#uploadResult').html('<div class="alert alert-success">' + response.msg + '</div>');
                            $('#formFile').val('');
                        } else {
                            $('#uploadResult').html('<div class="alert alert-danger">' + response.msg + '</div>');
                        }

                        setTimeout(function () {
                            $("#uploadModal").modal('toggle')
                            window.location.reload()
                        }, 1500)
                    },
                    error: function (response) {
                        $('#uploadResult').html(`<div class="alert alert-danger">${response.responseJSON.message}</div>`);
                    },
                    complete: function () {
                        btnUpload.text('Upload')
                        btnUpload.prop('disabled', false)
                    }
                });
            });




        });


        function setMainCV(cvID) {  
            $.ajax({
                type: 'GET',
                url: "{{ route('set.main.cv', ':cvID') }}".replace(':cvID', cvID),
                success: function (res) {
                    toastr.success(res.msg, 'Notification !')
                    setTimeout(function () {
                        window.location.reload()
                    }, 1500)
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.msg, 'Notification !')
                }
            })
        }

        function deleteCV(cvID) {
            let check = confirm('Are you sure ?')
            if (!check)
                return
            $.ajax({
                type: 'GET',
                url: '{{ route('candidate.delete-cv', ':cvID') }}'.replace(':cvID', cvID),
                success: function (res) {
                    toastr.success(res.msg, 'Notification !')
                    setTimeout(function () {
                        window.location.reload()
                    }, 1500)
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.msg, 'Notification !')

                }
            })
        }

        function applyNow(jobId, cvId) {
            $.ajax({
                type: 'POST',
                // make sure you respect the same origin policy with this url:
                // http://en.wikipedia.org/wiki/Same_origin_policy
                url: '{{route('api.v1.applyJob')}}',
                data: {
                    "job_id" : jobId,
                    "cv_id": cvId,
                    "_token": '{{csrf_token()}}'
                },
                success: function(msg){
                    $("#apply_job_popup").modal('toggle');
                    toastr.success('Apply Success !', 'Notification')
                    $(".apply-now-text").css('cursor', 'not-allowed')

                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.msg, 'Notification !')
                }
            });

        }

        function matchWithJob(cvID) {
            $("#modal-progress").modal('toggle')
            let $bar = $(".bar");
            var progress = setInterval(function() {

                // perform processing logic (ajax) here
                $bar.width($bar.width()+100);

                $bar.text($bar.width()/5 + "%");
            }, 700);
            $.ajax({
                type: 'GET',
                url: '{{ route('match.with.job', ':cvID') }}'.replace(':cvID', cvID),
                success: function (res) {
                    let html = ''
                    res.careers.forEach(ele => {
                        html += `
                        <li class="list-group-item item-quickview-company">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">${ele.title}</h5>
                                    <p class="mb-0 d-flex">
                                        <strong>Company:</strong>
                                        <span style="color: blue" onclick="viewCompany(${ele.company.id})" class="link-quickview-company">
                                            ${ele.company.company_name}
                                        </span>
                                    </p>
                                    <p class="mb-0"><strong>{{trans('lang.location')}}:</strong> ${ele.address}</p>
                                </div>
                                <div>
                                    <a href="/jobs/${ele.slug}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
                            <div>
                                <small class="text-muted">{{trans('lang.Posted On')}}: ${ele.created_at}</small>
                                <br>
                                <small class="text-muted">{{trans('lang.expiration')}}: ${ele.expiration_day}</small>
                                <div class="d-flex justify-content-between">
                                    <small class="">{{trans('lang.Max salary')}}: <strong style="color: green">${ele.max_salary.convert}</strong></small>
                                    <small ${ele.cv_applied.length > 0 ? '' : `onclick="applyNow(${ele.id}, ${cvID})"`} class="apply-now-text">${ele.cv_applied.length > 0 ? 'Applied' : 'Apply now'}</small>
                                </div>
                            </div>
                        </li>
                        `
                    })

                    let html2 = '';

                    res.bestCareers.forEach(ele => {
                        html2 += `
                        <li class="list-group-item item-quickview-company">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">${ele.title}</h5>
                                    <p class="mb-0 d-flex">
                                        <strong>Company:</strong>
                                        <span style="color: blue" onclick="viewCompany(${ele.company.id})" class="link-quickview-company">
                                            ${ele.company.company_name}
                                        </span>
                                    </p>
                                    <p class="mb-0"><strong>{{trans('lang.location')}}:</strong> ${ele.address}</p>
                                </div>
                                <div>
                                    <a href="/jobs/${ele.slug}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
                        <div>
                            <small class="text-muted">{{trans('lang.Posted On')}}: ${ele.created_at}</small>
                                <br>
                                <small class="text-muted">{{trans('lang.Expiration')}}: ${ele.expiration_day}</small>
                                <div class="d-flex justify-content-between">
                                    <small class="">{{trans('lang.Max salary')}}: <strong style="color: green">${ele.max_salary.convert}</strong></small>
                                    <small ${ele.cv_applied.length > 0 ? '' : `onclick="applyNow(${ele.id}, ${cvID})"`} class="apply-now-text">${ele.cv_applied.length > 0 ? 'Applied' : 'Apply now'}</small>
                                </div>
                            </div>
                        </li>
                        `
                    })


                    clearInterval(progress);
                    $('.progress').removeClass('active');
                    $bar.width(500);
                    $bar.text('100%');
                    $(".progress-bar").css('background-color', '#00b314')

                    setTimeout(function () {
                        $("#modal-progress").modal('toggle')
                        $("#suggest-job").html(html2)
                        $(".see-more-match-job").html(html)
                        $("#modal-math-job").modal('toggle')
                    }, 1000)


                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.msg, 'Notification !')
                }
            })
        }
        let mathJobModal = new bootstrap.Modal(document.getElementById('modal-math-job'));
        let companyInfoModal = new bootstrap.Modal(document.getElementById('modal-view-company'));

        document.getElementById('modal-view-company').addEventListener('show.bs.modal', function () {
            mathJobModal.hide();
        });

        // Khi đóng modal thông tin công ty, mở lại modal hiện tại
        document.getElementById('modal-view-company').addEventListener('hidden.bs.modal', function () {
            mathJobModal.show();
        });

        function viewCompany(companyId) {
            $.ajax({
                type: "GET",
                url: '{{route('company.detail', ':companyId')}}'.replace(':companyId', companyId),
                dataType: "json",
                success: function (res) {


                    let html = `
                    <input hidden id="current-choose-company" value="${companyId}" />
                    <h6><strong>Tên công ty:</strong> <span id="companyName">${res.company_name}</span></h6>
                    <p><strong>Địa chỉ:</strong> ${res.company_address}</p>
                    <p><strong>Mô tả:</strong> ${res.introduce}</p>
                    <p><strong>Liên hệ:</strong> ${res.email} | SĐT: ${res.company_phone}</p>`;

                    $("#company-content").html(html)
                    $("#modal-view-company").modal('toggle')
                },
                error: function (xhr) {

                }
            })
        }

        function directViewCompany() {
            window.location.href = '{{route('company.detail', ':companyId')}}'.replace(':companyId', $("#current-choose-company").val())
        }
    </script>
@endpush
