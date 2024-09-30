@extends('layouts.company')

@section('content')
    <!-- Page Content Holder -->
    <div id="content">

        <div class="content-admin-main">

            <div class="wt-admin-right-page-header clearfix">
                <h2>Company Profile!</h2>
                <div class="breadcrumbs"><a href="#">Home</a><a href="#">Dasboard</a><span>Company Profile!</span></div>
            </div>

            <!--Logo and Cover image-->
            <div class="panel panel-default">
                <div class="panel-heading wt-panel-heading p-a20">
                    <h4 class="panel-tittle m-a0">Logo and Cover image</h4>
                </div>
                <div class="panel-body wt-panel-body p-a20 p-b0 m-b30 ">

                    <div class="row">

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">

                                <div class="dashboard-profile-pic">
                                    <div class="dashboard-profile-photo">
                                        <img src="{{asset('/images/avatar/'.$company->company_avatar)}}" alt="">
                                        <div class="upload-btn-wrapper">
                                            <div id="upload-image-grid"></div>
                                            <button class="site-button button-sm">Upload Photo</button>
                                            <input onchange="uploadAvatar(this)" type="file" name="myfile" id="file-uploader" accept=".jpg, .jpeg, .png">
                                        </div>
                                    </div>
                                    <p><b>Company Logo :- </b> Max file size is 1MB, Minimum dimension: 136 x 136 And Suitable files are .jpg & .png</p>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="dashboard-cover-pic">
                                <form action="upload.php" class="dropzone"></form>
                                <p><b>Background Banner Image :- </b> Max file size is 1MB, Minimum dimension: 770 x 310 And Suitable files are .jpg & .png</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!--Basic Information-->
            <div class="panel panel-default">
                <div class="panel-body wt-panel-body p-a20 m-b30 ">

                    <form method="POST" >
                        @csrf
                        @method('PUT')
                        <!--Basic Information-->
                        <div class="panel panel-default">
                            <div class="panel-heading wt-panel-heading p-a20">
                                <h4 class="panel-tittle m-a0">Company Profile</h4>
                                @foreach ($errors->all() as $error)
                                    <p class="alert alert-danger">{{ $error }}</p>
                                @endforeach
                                @if(Session::has('msg'))
                                    <p class="alert alert-success">{{ Session::get('msg') }}</p>
                                @endif
                            </div>
                            <div class="panel-body wt-panel-body p-a20 m-b30 ">

                                <div class="row">

                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <div class="ls-inputicon-box">
                                                <input class="form-control" name="company_name" type="text"  value="{{old('company_name', $company->company_name)}}" placeholder="Devid Smith">
                                                <i class="fs-input-icon fa fa-building"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <div class="ls-inputicon-box">
                                                <input class="form-control"  value="{{old('company_phone', $company->company_phone)}}" name="company_phone" type="text" placeholder="(251) 1234-456-7890">
                                                <i class="fs-input-icon fa fa-phone-alt"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <div class="ls-inputicon-box">
                                                <input class="form-control"  value="{{old('company_email', $company->company_email)}}" name="company_email" type="email" placeholder="Devid@example.com">
                                                <i class="fs-input-icon fas fa-at"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Website</label>
                                            <div class="ls-inputicon-box">
                                                <input class="form-control"  value="{{old('website', $company->website)}}" name="website" type="text" placeholder="https://devsmith.net">
                                                <i class="fs-input-icon fa fa-globe-americas"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="form-group city-outer-bx has-feedback">
                                            <label>Full Address</label>
                                            <div class="ls-inputicon-box">
                                                <input class="form-control"  value="{{old('company_address', $company->company_address)}}" name="company_address" type="text" placeholder="1363-1385 Sunset Blvd Angeles, CA 90026 ,USA">
                                                <i class="fs-input-icon fas fa-map-marker-alt"></i>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" rows="3">{{$company->introduce}}</textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!--Social Network-->
                        <div class="panel panel-default">
                            <div class="panel-heading wt-panel-heading p-a20">
                                <h4 class="panel-tittle m-a0">Social Network</h4>
                            </div>
                            <div class="panel-body wt-panel-body p-a20">

                                <div class="row">

                                    <div class="col-xl-4 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Facebook</label>
                                            <div class="ls-inputicon-box">
                                                <input
                                                    class="form-control wt-form-control"
                                                    name="facebook_link"
                                                    value="{{old('facebook_link', $company->facebook_link)}}"
                                                    type="text"
                                                    placeholder="https://www.facebook.com/">
                                                <i class="fs-input-icon fab fa-facebook-f"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Twitter</label>
                                            <div class="ls-inputicon-box">
                                                <input
                                                    class="form-control wt-form-control"
                                                    name="twitter_link"
                                                    value="{{old('twitter_link', $company->twitter_link)}}"
                                                    type="text"
                                                    placeholder="https://twitter.com/">
                                                <i class="fs-input-icon fab fa-twitter"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Instagram</label>
                                            <div class="ls-inputicon-box">
                                                <input
                                                    class="form-control wt-form-control"
                                                    name="instagram_link"
                                                    value="{{old('instagram_link', $company->instagram_link)}}"
                                                    type="text"
                                                    placeholder="https://www.instagram.com/">
                                                <i class="fs-input-icon fab fa-instagram"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 mt-3">
                            <div class="text-left">
                                <button type="submit" class="site-button">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>


@endsection
@push('js')
    <script>
        const uploadAvatar = function (input) {
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
