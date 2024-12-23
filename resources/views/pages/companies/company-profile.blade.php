@extends('layouts.company')

@section('content')
    <!-- Page Content Holder -->
    <div id="content">

        <div class="content-admin-main">

            <div class="wt-admin-right-page-header clearfix">
                <h2>{{ trans('lang.Company Profile') }}</h2>
                <div class="breadcrumbs"><a href="#">Home</a><a
                        href="#">{{ trans('lang.user.dashboard') }}</a><span>{{ trans('lang.Company Profile') }}</span>
                </div>
            </div>

            <!--Logo and Cover image-->
            <div class="panel panel-default">
                <div class="panel-heading wt-panel-heading p-a20">
                    <h4 class="panel-tittle m-a0">{{ trans('lang.avatar') }}</h4>
                </div>
                <div class="panel-body wt-panel-body p-a20 p-b0 m-b30 ">

                    <div class="row">

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">

                                <div class="dashboard-profile-pic">
                                    <div class="dashboard-profile-photo">
                                        <img src="{{ asset('/images/avatar/' . $company->company_avatar) }}" alt="">
                                        <div class="upload-btn-wrapper">
                                            <div id="upload-image-grid"></div>
                                            <button class="site-button button-sm">{{ trans('lang.Company Logo') }}</button>
                                            <input onchange="uploadAvatar(this)" type="file" name="myfile"
                                                id="file-uploader" accept=".jpg, .jpeg, .png">
                                        </div>
                                    </div>
                                    <p><b>{{ trans('lang.Company Logo') }} : </b>{{ trans('lang.Require Image') }}</p>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <h4>{{ trans('lang.Upload Banner') }}</h4>
                            <form id="formUploadBanner" method="POST" action="/upload-banner"
                                enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="banner"
                                        class="form-label">{{ trans('lang.Choose a banner to upload') }}:</label>
                                    <input class="form-control" type="file" id="banner" name="banner"
                                        accept="image/*" onchange="previewImage(event)">
                                </div>
                                <div class="mb-3">
                                    <img id="bannerPreview"
                                        src="{{ str_contains($company->banner, 'http') ? $company->banner : asset('/images/avatar/' . $company->banner) }}"
                                        alt="Banner Preview" class="img-fluid"
                                        style="max-height: 300px; @if (!$company->banner) display: none; @endif">
                                </div>
                                <button type="submit" class="btn btn-primary">{{ trans('lang.upload') }}</button>
                            </form>

                        </div>

                    </div>

                </div>
            </div>

            <!--Basic Information-->
            <div class="panel panel-default">
                <div class="panel-body wt-panel-body p-a20 m-b30 ">

                    <form method="POST" action="{{ route('company.profile.update', $company->id) }}">
                        @csrf
                        @method('PUT')
                        <!--Basic Information-->
                        <div class="panel panel-default">
                            <div class="panel-heading wt-panel-heading p-a20">
                                <h4 class="panel-tittle m-a0">{{ trans('lang.Company Profile') }}</h4>
                                @foreach ($errors->all() as $error)
                                    <p class="alert alert-danger">{{ $error }}</p>
                                @endforeach
                                @if (Session::has('msg'))
                                    <p class="alert alert-success">{{ Session::get('msg') }}</p>
                                @endif
                            </div>
                            <div class="panel-body wt-panel-body p-a20 m-b30 ">

                                <div class="row">

                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('lang.Company Name') }}</label>
                                            <div class="ls-inputicon-box">
                                                <input class="form-control" name="company_name" type="text"
                                                    value="{{ old('company_name', $company->company_name) }}"
                                                    placeholder="Devid Smith">
                                                <i class="fs-input-icon fa fa-building"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('lang.phone') }}</label>
                                            <div class="ls-inputicon-box">
                                                <input class="form-control"
                                                    value="{{ old('company_phone', $company->company_phone) }}"
                                                    name="company_phone" type="text" placeholder="(251) 1234-456-7890">
                                                <i class="fs-input-icon fa fa-phone-alt"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('lang.Email Address') }}</label>
                                            <div class="ls-inputicon-box">
                                                <input class="form-control" value="{{ old('email', $company->email) }}"
                                                    name="email" type="email" placeholder="Devid@example.com">
                                                <i class="fs-input-icon fas fa-at"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Website</label>
                                            <div class="ls-inputicon-box">
                                                <input class="form-control" value="{{ old('website', $company->website) }}"
                                                    name="website" type="text" placeholder="https://devsmith.net">
                                                <i class="fs-input-icon fa fa-globe-americas"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group city-outer-bx has-feedback">
                                            <label>{{ trans('lang.address') }}</label>
                                            <div class="ls-inputicon-box">
                                                <input class="form-control"
                                                    value="{{ old('company_address', $company->company_address) }}"
                                                    name="company_address" type="text"
                                                    placeholder="1363-1385 Sunset Blvd Angeles, CA 90026 ,USA">
                                                <i class="fs-input-icon fas fa-map-marker-alt"></i>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group city-outer-bx has-feedback">
                                            <label>{{ trans('lang.Province') }}</label>
                                            <div class="ls-inputicon-box">
                                                <select class="form-control" name="province_id" id="">
                                                    @foreach ($provinces as $item)
                                                        <option
                                                        @selected($item->code == $company->province_id)
                                                        value="{{ $item->code }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>

                                                <i class="fs-input-icon fas fa-map-marker-alt"></i>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('lang.description') }}</label>
                                            <textarea name="introduce" class="form-control" rows="3">{{ $company->introduce }}</textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!--Social Network-->
                        <div class="panel panel-default">
                            <div class="panel-heading wt-panel-heading p-a20">
                                <h4 class="panel-tittle m-a0">{{ trans('lang.Social Network') }}</h4>
                            </div>
                            <div class="panel-body wt-panel-body p-a20">

                                <div class="row">

                                    <div class="col-xl-4 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Facebook</label>
                                            <div class="ls-inputicon-box">
                                                <input class="form-control wt-form-control" name="facebook_link"
                                                    value="{{ old('facebook_link', $company->facebook_link) }}"
                                                    type="text" placeholder="https://www.facebook.com/">
                                                <i class="fs-input-icon fab fa-facebook-f"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Twitter</label>
                                            <div class="ls-inputicon-box">
                                                <input class="form-control wt-form-control" name="twitter_link"
                                                    value="{{ old('twitter_link', $company->twitter_link) }}"
                                                    type="text" placeholder="https://twitter.com/">
                                                <i class="fs-input-icon fab fa-twitter"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Instagram</label>
                                            <div class="ls-inputicon-box">
                                                <input class="form-control wt-form-control" name="instagram_link"
                                                    value="{{ old('instagram_link', $company->instagram_link) }}"
                                                    type="text" placeholder="https://www.instagram.com/">
                                                <i class="fs-input-icon fab fa-instagram"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 mt-3">
                            <div class="text-left">
                                <button type="submit" class="site-button">{{ trans('lang.save') }}</button>
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
        const uploadAvatar = function(input) {
            // Kiểm tra nếu có file được chọn
            if (input.files && input.files[0]) {
                // Tạo đối tượng FormData
                let formData = new FormData();
                formData.append('avatar', input.files[0]); // Thêm file vào FormData
                formData.append('_token', '{{ csrf_token() }}');

                // Gửi yêu cầu AJAX
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    url: '{{ route('api.file.upload.avatar.company') }}', // Route Laravel xử lý upload
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

        $("#formUploadBanner").submit(function(e) {
            e.preventDefault();
            let formData = new FormData();
            let input = document.querySelector("#banner");

            formData.append('avatar', input.files[0]); // Thêm file vào FormData
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('type', 'banner');

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: '{{ route('api.file.upload.avatar.company') }}', // Route Laravel xử lý upload
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

        })

        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function() {
                var imgElement = document.getElementById('bannerPreview');
                imgElement.src = reader.result;
                imgElement.style.display = 'block'; // Hiển thị hình ảnh
            };

            reader.readAsDataURL(input.files[0]); // Đọc dữ liệu ảnh
        }
    </script>
@endpush
