@extends('layouts.app')
@section('content')
    <!-- Modal -->
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
                        <button type="submit" class="btn btn-primary">Upload</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Công việc phù hợp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Chúng tôi gợi ý cho bạn một số công việc phù hợp với hồ sơ của bạn</p>
                    <ul class="list-group" id="suggest-job">

                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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
                            <h2 class="wt-title">Candidate CV Manager</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="index.html">Home</a></li>
                            <li>Candidate CV Manager</li>
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
                                <span class="woocommerce-result-count-left">CV Manager</span>

                                <form class="woocommerce-ordering twm-filter-select" method="get">
                                    <span class="woocommerce-result-count">Short By</span>
                                    <select class="wt-select-bar-2 selectpicker"  data-live-search="true" data-bv-field="size">
                                        <option>Last 2 Months</option>
                                        <option>Last 1 Months</option>
                                        <option>15 days ago</option>
                                        <option>Weekly</option>
                                        <option>Yesterday</option>
                                        <option>Today</option>
                                    </select>
                                </form>

                            </div>

                            <div class="twm-cv-manager-list-wrap">
                                <!-- Section: Create CV -->
                                <div class="row upload-section p-4 bg-light border rounded">
                                    <div class="col-md-9 d-flex align-items-center">
                                        <div>
                                            <img src="https://static.topcv.vn/v4/image/cv-manager/no-cv.png" alt="Icon">
                                            <p>Bạn chưa tạo CV nào</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">+ Tạo mới</button>
                                    </div>
                                </div>

                                <!-- Section: Uploaded CVs -->
                                <div class="uploaded-section">
                                    <h4 class="my-2">CV đã tải lên TopCV</h4>
                                    <div class="row" style="flex-wrap: nowrap; overflow-x: auto">
                                        <!-- CV Card 1 -->
                                        @foreach($resumes as $resume)
                                            <div class="card mx-1 my-1 card-cv" >
                                                <img src="{{asset('storage/uploads/'. $resume->thumbnail)}}" class="card-img-top card-cv-img" alt="Profile">

                                                <div class="card-body">
                                                    <h5 class="card-title">{{$resume->path}}</h5>
                                                    <p class="card-text">Cập nhật lần cuối {{$resume->updated_at}}</p>
                                                    <div class="d-flex justify-content-around">
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
                                    <h4 class="my-2">CV đã tạo trên hệ thống</h4>
                                    <div class="row" style="flex-wrap: nowrap; overflow-x: auto">
                                        <!-- CV Card 1 -->
                                        @foreach($resumeOnSys as $resume)
                                            <div class="card mx-1 my-1 card-cv" >
                                                <img src="{{asset('storage/uploads/'. $resume->cv->thumbnail)}}" class="card-img-top card-cv-img" alt="Profile">

                                                <div class="card-body">
                                                    <h5 class="card-title">{{$resume->cv->path}}</h5>
                                                    <p class="card-text">Cập nhật lần cuối {{$resume->cv->updated_at}}</p>
                                                    <div class="d-flex justify-content-around">
                                                        <button class="btn btn-outline-secondary">
                                                            <a
                                                                download
                                                                href="{{asset('storage/uploads/'. $resume->cv->path)}}">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                        </button>
                                                        <button class="btn btn-outline-info">
                                                            <a href="{{route('candidate.create-cv', $resume->id)}}">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        </button>
                                                        <button onclick="deleteCV({{$resume->cv->id}})" class="btn btn-outline-danger">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                        <button title="Tìm kiếm công việc tự động" class="btn btn-outline-warning" onclick="matchWithJob({{$resume->cv->id}})">
                                                            <i class="fas fa-magic"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                            <div class="pagination-outer">
                                <div class="pagination-style1">
                                    <ul class="clearfix">
                                        <li class="prev"><a href="javascript:;"><span> <i class="fa fa-angle-left"></i> </span></a></li>
                                        <li><a href="javascript:;">1</a></li>
                                        <li class="active"><a href="javascript:;">2</a></li>
                                        <li><a href="javascript:;">3</a></li>
                                        <li><a class="javascript:;" href="javascript:;"><i class="fa fa-ellipsis-h"></i></a></li>
                                        <li><a href="javascript:;">5</a></li>
                                        <li class="next"><a href="javascript:;"><span> <i class="fa fa-angle-right"></i> </span></a></li>
                                    </ul>
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

                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('api.file.upload') }}",  // Đường dẫn API
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
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
                        $('#uploadResult').html('<div class="alert alert-danger">Upload failed. Please try again.</div>');
                    }
                });
            });

        });

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
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">${ele.title}</h5>
                                    <p class="mb-0"><strong>Company:</strong> ${ele.company.company_name}</p>
                                    <p class="mb-0"><strong>Location:</strong> ${ele.address}</p>
                                </div>
                                <div>
                                    <a href="/jobs/${ele.slug}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
{{--                            <p class="mb-1 mt-2"><strong>Description:</strong> {{ Str::limit(${ele.detail.desc}, 100) }}</p>--}}
                            <div>
                            <small class="text-muted">Posted on: ${ele.created_at}</small>
                            <small class="">Max salary: <strong style="color: green">${ele.max_salary.convert}</strong></small>
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
                        $("#suggest-job").html(html)
                        $("#modal-math-job").modal('toggle')
                    }, 1000)


                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.msg, 'Notification !')
                }
            })
        }
    </script>
@endpush
