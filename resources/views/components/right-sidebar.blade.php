<div class="col-xl-3 col-lg-4 col-md-12 rightSidebar m-b30">

    <div class="side-bar-st-1">

        <div class="twm-candidate-profile-pic">

            <img src="{{asset('/images/avatar/'.auth()->user()->avatar)}}" alt="">
            <div class="upload-btn-wrapper">

                <div id="upload-image-grid"></div>
                <button class="site-button button-sm">Upload Photo</button>
                <input onchange="uploadAvatar(this)" type="file" name="fileAvatar" id="file-uploader" accept=".jpg, .jpeg, .png">

            </div>
        </div>

        <div class="twm-mid-content text-center">
            <a href="candidate-detail.html" class="twm-job-title">
                <h4>{{auth()->user()->fullname}}</h4>
            </a>
            <p>IT Contractor</p>
        </div>

        <div class="twm-nav-list-1">
            <ul>
                <li
                    class="@if(str_contains(request()->url(), 'dashboard')) active @endif">
                    <a href="{{route('candidate.dashboard')}}"><i class="fa fa-tachometer-alt"></i>
                        Dashboard</a>
                </li>
                <li class="@if(str_contains(request()->url(), 'profile')) active @endif">
                    <a href="{{route('candidate.profile')}}">
                        <i class="fa fa-user"></i>
                        My Profile
                    </a>
                </li>
                <li class="@if(str_contains(request()->url(), 'job-applied')) active @endif">
                    <a href="{{route('candidate.job-applied')}}">
                        <i class="fa fa-suitcase"></i>
                        Applied Jobs
                    </a>
                </li>
                <li class="@if(str_contains(request()->url(), 'my-resume')) active @endif">
                    <a href="{{route('candidate.my-resume')}}">
                        <i class="fa fa-receipt"></i>
                        My Resume
                    </a>
                </li>
                <li class="@if(str_contains(request()->url(), 'saved-job')) active @endif">
                    <a href="{{route('candidate.saved-job')}}">
                        <i class="fa fa-file-download"></i>
                        Saved Jobs
                    </a>
                </li>
{{--                <li><a href="candidate-job-alert.html"><i class="fa fa-bell"></i> Job Alerts</a></li>--}}
{{--                <li><a href="candidate-change-password.html"><i class="fa fa-fingerprint"></i> Change Passeord</a></li>--}}
                <li class="@if(str_contains(request()->url(), 'chat')) active @endif">
                    <a href="{{route('candidate.show.chat')}}">
                        <i class="fa fa-comments"></i>
                        Chat
                    </a>
                </li>
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
                    url: '{{ route("api.file.upload.avatar") }}', // Route Laravel xử lý upload
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
