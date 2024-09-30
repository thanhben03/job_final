
<div class="col-xl-3 col-lg-4 col-md-12 rightSidebar m-b30">

    <div class="side-bar-st-1">

        <div class="twm-candidate-profile-pic">

            <img src="{{asset('/images/avatar/'.$company->company_avatar)}}" alt="">
            <div class="upload-btn-wrapper">

                <div id="upload-image-grid"></div>
                <button class="site-button button-sm">Upload Photo</button>
                <input onchange="uploadAvatar(this)" type="file" name="fileAvatar" id="file-uploader" accept=".jpg, .jpeg, .png">
            </div>

        </div>

        <div class="twm-mid-content text-center">
            <a href="candidate-detail.html" class="twm-job-title">
                <h4>{{$company->company_name}}</h4>
            </a>
            <p>IT Contractor</p>
        </div>

        <div class="twm-nav-list-1">
            <ul>
                <li class="@if(str_contains(request()->url(), 'dashboard')) active @endif">
                    <a href="employer-profile.html">
                        <i class="fa fa-user"></i>
                        Company Profile
                    </a></li>
                <li class="@if(str_contains(request()->url(), 'resume')) active @endif"><a href="employer-resume.html"><i class="fa fa-receipt"></i> Resume</a></li>
                <li class="@if(str_contains(request()->url(), 'manage-jobs')) active @endif"><a href="employer-manage-jobs.html"><i class="fa fa-suitcase"></i> Manage Jobs</a></li>
                <li><a href="employer-post-job.html"><i class="fa fa-book-reader"></i> Post A Jobs</a></li>
                <li><a href="employer-transaction.html"><i class="fa fa-credit-card"></i>Transaction</a></li>
                <li><a href="candidate-grid.html"><i class="fa fa-user-check"></i> Browse Candidates</a></li>
                <li><a href="employer-change-password.html"><i class="fa fa-fingerprint"></i> Change Passeord</a></li>
                <li><a href="index.html"><i class="fa fa-share-square"></i> Logout</a></li>
                <li><a href="employer-account-fresher.html"><i class="fa fa-pencil-alt"></i>Register Fresher</a></li>
                <li><a href="employer-account-professional.html"><i class="fa fa-pencil-alt"></i>Register Professionals</a></li>
            </ul>
        </div>

    </div>

</div>
@push('js')
    <script>
        function uploadAvatar(input) {
            // Kiểm tra nếu có file được chọn
            if (input.files && input.files[0]) {
                // Tạo đối tượng FormData
                let formData = new FormData();
                formData.append('avatar', input.files[0]); // Thêm file vào FormData
                formData.append('_token', '{{ csrf_token() }}');
                console.log(input.files[0])
                // Gửi yêu cầu AJAX
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    url: '{{ route("api.file.upload.avatar.company") }}', // Route Laravel xử lý upload
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        toastr.success(response.msg, 'Notification !')
                    },
                    error: function(xhr) {
                        console.log(xhr)
                        toastr.error(xhr.responseJSON.msg, 'Notification !')
                    }
                });
            }
        }
    </script>
@endpush
