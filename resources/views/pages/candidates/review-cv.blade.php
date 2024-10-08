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
                                <div class="">
                                    <div>Choose CV: </div>
                                    <select name="" id="">
                                        <option value="1">1728379351_CV-Nguyen-Ho-Thanh-Ben-PHP-Laravel-Dev.pdf.pdf</option>
                                        <option value="2">1728379351_CV-Nguyen-Ho-Thanh-Ben-PHP-Laravel-Dev.pdf.pdf</option>
                                        <option value="3">1728379351_CV-Nguyen-Ho-Thanh-Ben-PHP-Laravel-Dev.pdf.pdf</option>
                                    </select>
                                </div>
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
                                            <tbody>
                                            <tr class="personal_info">
                                                <td><span class="text-highlight bg-primary bg-danger">5</span></td>
                                                <td><b>Thông tin:</b> <span>Thiếu thông tin quan trọng như ngày sinh và địa chỉ.</span>
                                                    <p><span class="p"><i class="fa fa-flag-o"></i> <u>Gợi ý:</u> Cập nhật đầy đủ thông tin cá nhân như ngày sinh và địa chỉ để tăng độ tin cậy.</span></p></td>
                                            </tr>
                                            <tr class="work_experience">
                                                <td><span class="text-highlight bg-primary bg-danger">2</span></td>
                                                <td><b>Kinh nghiệm:</b> <span>Không có kinh nghiệm làm việc nào được liệt kê.</span>
                                                    <p><span class="p"><i class="fa fa-flag-o"></i> <u>Gợi ý:</u> Nếu chưa có kinh nghiệm làm việc chính thức, hãy thêm các dự án cá nhân hoặc thực tập để thể hiện kỹ năng và kinh nghiệm thực tế.</span><span class="ex"> <b>Ví dụ:</b> <i>"Responsible for managing projects."</i> <span class="br"></span><i class="fa fa-hand-o-right mr-5 ml-5" aria-hidden="true"></i> <i class="wavy-text">Successfully managed 5 projects from inception to completion, resulting in a 20% increase in client satisfaction.</i></span></p></td>
                                            </tr>
                                            <tr class="skills">
                                                <td><span class="text-highlight bg-primary bg-danger">6</span></td>
                                                <td><b>Kĩ năng:</b> <span>Có nhiều kỹ năng tốt nhưng thiếu phần mô tả cho các kỹ năng mềm.</span>
                                                    <p><span class="p"><i class="fa fa-flag-o"></i> <u>Gợi ý:</u> Cân nhắc thêm các kỹ năng mềm như làm việc nhóm, giao tiếp, hoặc quản lý thời gian.</span></p></td>
                                            </tr>
                                            <tr class="education">
                                                <td><span class="text-highlight bg-primary">8</span></td>
                                                <td><b>Học vấn:</b> <span>Thông tin giáo dục được cung cấp đầy đủ nhưng thiếu chi tiết về thành tích học tập.</span>
                                                    <p><span class="p"><i class="fa fa-flag-o"></i> <u>Gợi ý:</u> Thêm thông tin về GPA hoặc các khóa học nổi bật liên quan đến vị trí bạn đang ứng tuyển.</span></p></td>
                                            </tr>
                                            <tr class="career_goal">
                                                <td><span class="text-highlight bg-primary bg-orange-600">7</span></td>
                                                <td><b>Mục tiêu nghề nghiệp:</b> <span>Mục tiêu nghề nghiệp khá rõ ràng nhưng còn thiếu sự cụ thể về cách bạn muốn đóng góp.</span>
                                                    <p><span class="p"><i class="fa fa-flag-o"></i> <u>Gợi ý:</u> Cải thiện bằng cách nêu rõ loại dự án hoặc lĩnh vực mà bạn muốn làm việc.</span><span class="ex"> <b>Ví dụ:</b> <i>"Là một lập trình viên Back-end có động lực cao và chú ý đến chi tiết, mục tiêu của tôi là tận dụng kỹ năng và chuyên môn của mình để đóng góp cho sự thành công của một tổ chức năng động và đổi mới."</i> <span class="br"></span><i class="fa fa-hand-o-right mr-5 ml-5" aria-hidden="true"></i> <i class="wavy-text">Là một lập trình viên Back-end có động lực cao, tôi hướng tới việc phát triển các ứng dụng web hiệu suất cao cho các dự án thương mại điện tử, nhằm tối ưu hóa trải nghiệm người dùng và tăng trưởng kinh doanh cho một tổ chức đổi mới.</i></span></p></td>
                                            </tr>
                                            <tr class="achievements">
                                                <td><span class="text-highlight bg-primary bg-danger">3</span></td>
                                                <td><b>Thành tích:</b> <span>Thiếu thông tin về thành tích hoặc giải thưởng.</span>
                                                    <p><span class="p"><i class="fa fa-flag-o"></i> <u>Gợi ý:</u> Nếu có bất kỳ giải thưởng hoặc dự án nào đáng chú ý, hãy thêm chúng vào để làm nổi bật bản thân.</span></p></td>
                                            </tr>
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
    </script>
@endpush
