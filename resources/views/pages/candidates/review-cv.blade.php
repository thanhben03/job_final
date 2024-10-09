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
                                <span class="woocommerce-result-count-left">Review CV</span>
                            </div>
                            <div class="">
                                <label class="form-label">Choose CV: </label>
                                <select class="form-select" name="" id="">
                                    <option value="1">1728379351_CV-Nguyen-Ho-Thanh-Ben-PHP-Laravel-Dev.pdf.pdf</option>
                                    <option value="2">1728379351_CV-Nguyen-Ho-Thanh-Ben-PHP-Laravel-Dev.pdf.pdf</option>
                                    <option value="3">1728379351_CV-Nguyen-Ho-Thanh-Ben-PHP-Laravel-Dev.pdf.pdf</option>
                                </select>
                                <button onclick="reviewCV()" class="mt-2 btn btn-success">Review</button>

                            </div>

                            <div class="twm-cv-manager-list-wrap">
                                <div class="col-sm-12" bis_skin_checked="1">
                                    <div class="table-responsive" bis_skin_checked="1">
                                        <table class="table table-lg">
                                            <thead>
                                                <tr>
                                                    <th>Score</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody id="wrap-reviews-body">
                                            </tbody>
                                        </table>
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

                    $("#suggest-job").html(html)
                    $("#modal-math-job").modal('toggle')

                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.msg, 'Notification !')
                }
            })
        }

        function reviewCV() {
            $.ajax({
                type: "POST",
                url: "{{route('candidate.review-cv')}}",
                data: {
                  "_token": "{{csrf_token()}}"
                },
                success: function (res) {
                    let reviews = Object.values(res);
                    console.log(reviews)
                    let html = '';
                    // console.log(reviews)
                    reviews.forEach(item => {
                        Object.keys(item).forEach(key => {
                            let value = item[key];
                            html += `

                            <tr class="personal_info">
                                <td><span class="text-highlight bg-primary bg-danger review-cv-score">${value.score}</span></td>
                                <td><b>${key}:</b> <span>${value.reason}</span>
                                <p>
                                    <span class="p"><i class="fa fa-flag-o"></i> <u>Gợi ý:</u>
                                        ${value.suggestion}
                                    </span>
                                </p></td>
                            </tr>
                            `

                        });
                    });

                    $("#wrap-reviews-body").html(html)
                },
                error: function (xhr) {
                    console.log(xhr.responseJSON)
                }
            })
        }
    </script>
@endpush
