@extends('layouts.company')

@section('content')
    <!-- Page Content Holder -->
    <div id="content">

        <div class="content-admin-main">

            <div class="wt-admin-right-page-header clearfix">
                <h2>Post a Job</h2>
                <div class="breadcrumbs"><a href="#">Home</a><a href="#">Dasboard</a><span>Job Detail Form</span></div>
            </div>

            <!--Logo and Cover image-->
            <!-- <div class="panel panel-default">
                <div class="panel-heading wt-panel-heading p-a20">
                    <h4 class="panel-tittle m-a0">Logo and Cover image</h4>
                </div>
                <div class="panel-body wt-panel-body p-a20 p-b0 m-b30 ">

                    <div class="row">

                        <div class="col-lg-12 col-md-6">
                            <div class="form-group">

                                <div class="dashboard-profile-pic">
                                    <div class="dashboard-profile-photo">
                                        <img src="images/jobs-company/pic1.jpg" alt="">
                                        <div class="upload-btn-wrapper">
                                            <button class="site-button button-sm">Upload Photo</button>
                                            <input type="file" name="myfile">
                                        </div>
                                    </div>
                                    <p><b>Company Logo :- </b> Max file size is 1MB, Minimum dimension: 136 x 136 And Suitable files are .jpg & .png</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-6">
                            <div class="dashboard-cover-pic">
                                <form action="upload.php" class="dropzone"></form>
                                <p><b>Background Banner Image :- </b> Max file size is 1MB, Minimum dimension: 770 x 310 And Suitable files are .jpg & .png</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>  -->

            <!--Basic Information-->
            <div class="panel panel-default">
                <div class="panel-heading wt-panel-heading p-a20">
                    <h4 class="panel-tittle m-a0"><i class="fa fa-suitcase"></i>Job Details</h4>
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                    @if(Session::has('msg'))
                        <p class="alert alert-success">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="panel-body wt-panel-body p-a20 m-b30 ">
                    <form action="{{route('jobs.update', $career['id'])}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!--Job title-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Job Title</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control" value="{{old('title', $career['title'])}}" name="title" type="text" placeholder="Devid Smith">
                                        <i class="fs-input-icon fa fa-address-card"></i>
                                    </div>
                                </div>
                            </div>

                            <!--Job Skill-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group city-outer-bx has-feedback">
                                    <label>Job Skill</label>
                                    <div class="ls-inputicon-box">
                                        <select
                                            name="skill_ids[]"
                                            multiple
                                            class="wt-select-box selectpicker"
                                            data-live-search="true" title="" id="j-category" data-bv-field="size">
                                            @foreach($skills as $skill)
                                                <option {{in_array($skill->id, $career['skills']->pluck('id')->toArray()) ? 'selected' : ''}} value="{{$skill->id}}">{{$skill->name}}</option>
                                            @endforeach
                                        </select>
                                        <i class="fs-input-icon fa fa-border-all"></i>
                                    </div>

                                </div>
                            </div>

                            <!--Job Type-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Job Type</label>
                                    <div class="ls-inputicon-box">
                                        <select
                                            name="working_time"
                                            class="wt-select-box selectpicker"
                                            data-live-search="true" title="" id="s-category" data-bv-field="size">
                                            @foreach($workType as $key => $value)
                                                <option {{$value == $career['work_type'] ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <i class="fs-input-icon fa fa-file-alt"></i>
                                    </div>
                                </div>
                            </div>


                            <!--Offered Salary-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Min Salary</label>
                                            <div class="ls-inputicon-box">
                                                <input type="number" name="min_salary" value="{{old('min_salary', $career['min_salary']['origin'])}}" class="form-control">
                                                <i class="fs-input-icon fa fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Max Salary</label>
                                            <div class="ls-inputicon-box">
                                                <input type="number" name="max_salary" value="{{old('max_salary', $career['max_salary']['origin'])}}" class="form-control">
                                                <i class="fs-input-icon fa fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Experience-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Experience</label>
                                    <div class="ls-inputicon-box">
                                        <select name="experience" class="wt-select-box selectpicker"  data-live-search="true" title="" id="salary" data-bv-field="size">
                                            @foreach($exps as $key => $value)
                                                <option {{$value == $career['experience'] ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                            @endforeach

                                        </select>
                                        <i class="fs-input-icon fa fa-graduation-cap"></i>

                                    </div>
                                </div>
                            </div>

                            <!--Qualification-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Qualification</label>
                                    <div class="ls-inputicon-box">
                                        <select name="qualification" class="wt-select-box selectpicker"  data-live-search="true" title="" data-bv-field="size">
                                            @foreach($qualifications as $key => $value)
                                                <option {{$value == $career['qualification'] ? 'selected' : ''}}  value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <i class="fs-input-icon fa fa-user-graduate"></i>
                                    </div>
                                </div>
                            </div>

                            <!--Gender-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <div class="ls-inputicon-box">
                                        <select class="wt-select-box selectpicker"  data-live-search="true" name="gender" id="gender" data-bv-field="size">
                                            @foreach($genders as $keyd => $value)
                                                <option {{$value == $career['gender']}} value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <i class="fs-input-icon fa fa-venus-mars"></i>
                                    </div>
                                </div>
                            </div>

                            <!--Province-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Province</label>
                                    <div class="ls-inputicon-box">
                                        <select onchange="selectProvince(this)"
                                                class="wt-select-box selectpicker"
                                                data-live-search="true" title=""
                                                name="province_id" data-bv-field="size">
                                            @foreach($provinces as $key => $value)
                                                <option {{$value == $career['province']->name ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <i class="fs-input-icon fa fa-globe-americas"></i>
                                    </div>
                                </div>
                            </div>


                            <!--District-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>District</label>
                                    <div class="ls-inputicon-box">
                                        <select
                                                class="wt-select-box selectpicker"
                                                id="district"
                                                data-live-search="true" title=""
                                                name="district_id" data-bv-field="size">
                                                @foreach($districts as $district)
                                                <option {{$career['district']->code == $district->code ? 'selected' : ''}} value="{{$district->code}}">{{$district->name}}</option>
                                                @endforeach
                                        </select>
                                        <i class="fs-input-icon fa fa-map-marker-alt"></i>
                                    </div>
                                </div>
                            </div>



                            <!--Level-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Level</label>
                                    <div class="ls-inputicon-box">
                                        <select class="wt-select-box selectpicker"  data-live-search="true" title="" name="level" data-bv-field="size">
                                            @foreach($levels as $key => $value)
                                                <option {{$value == $career['level']}} value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <i class="fs-input-icon fa fa-globe-americas"></i>
                                    </div>
                                </div>
                            </div>

                            <!--Phone-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control" value="{{old('phone', $career['phone'])}}" name="phone" type="text" placeholder="0772859431">
                                        <i class="fs-input-icon fa fa-map-pin"></i>
                                    </div>
                                </div>
                            </div>

                            <!--Employee-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Employee Number</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control" value="{{old('employee', $career['employee'])}}" name="employee" type="number" placeholder="10">
                                        <i class="fs-input-icon fas fa-at"></i>
                                    </div>
                                </div>
                            </div>

                            <!--From Time-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>From Time</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control" value="{{old('from_time', $career['from_time'])}}" name="from_time" type="time" >
                                        <i class="fs-input-icon fa fa-globe-americas"></i>
                                    </div>
                                </div>
                            </div>

                            <!--To Time-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>To Time</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control" value="{{old('to_time', $career['to_time'])}}" name="to_time" type="time" >
                                        <i class="fs-input-icon fa fa-clock"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Expiration Day -->

                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Expiration Day</label>
                                    <div class="ls-inputicon-box">
                                        <input type="date" value="{{old('expiration_day', $career['expiration_day'])}}" name="expiration_day" class="form-control">
                                        <i class="fs-input-icon fa fa-map-marker-alt"></i>
                                    </div>
                                </div>
                            </div>

                            <!--Complete Address-->
                            <div class="col-xl-12 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Complete Address</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control" value="{{old('address', $career['address'])}}" name="address" type="text" placeholder="1363-1385 Sunset Blvd Los Angeles, CA 90026, USA">
                                        <i class="fs-input-icon fa fa-home"></i>
                                    </div>
                                </div>
                            </div>

                            <!--Description-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea id="desc"
                                              name="desc" class="form-control" rows="3"
                                    >
                                        {{old('address', $career['detail']?->desc)}}
                                    </textarea>
                                </div>
                            </div>

                            <!--Require-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Require</label>
                                    <textarea
                                        id="require"
                                        name="require"
                                        class="form-control"
                                        rows="3"
                                        >
                                        {{old('require', $career['detail']?->require)}}
                                    </textarea>
                                </div>
                            </div>

                            <!--Benefit-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Benefit</label>
                                    <textarea
                                        id="benefit"
                                        name="benefit"
                                        class="form-control" rows="3"
                                    >
                                        {{old('benefit', $career['detail']?->benefit)}}
                                    </textarea>
                                </div>
                            </div>

                            <!--Key Responsibility-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Key Responsibility</label>
                                    <textarea
                                        name="key_responsibilities"
                                        id="key_responsibility"
                                        class="form-control" rows="3"
                                    >
                                        {{old('key_responsibility', $career['detail']?->key_responsibilities)}}
                                    </textarea>
                                </div>
                            </div>


                            <div class="col-lg-12 col-md-12">
                                <div class="text-left">
                                    <button type="submit" class="site-button m-r5">Publish Job</button>
                                    <button type="submit" class="site-button outline-primary">Save Draft</button>
                                </div>
                            </div>




                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('js')
    <!-- Place the first <script> tag in your HTML's <head> -->
    <script src="https://cdn.tiny.cloud/1/j7s71fyc3kax1nrnlchfbs12d0rgzpsuwjdnkn43xugf4xgv/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
    <script>
        tinymce.init({
            selector: '#key_responsibility,#benefit,#desc,#require',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
    <script>
        function selectProvince(e) {
            $.ajax({
                type: 'GET',
                url: '/api/v1/get-district/' + e.value,
                success: function(res){
                    let html = ''
                    let districtEle = document.querySelector('#district');
                    res.districts.forEach(e => {
                        html +=
                            `<option value="${e.code}">${e.name}</option>`
                    })

                    districtEle.innerHTML = html;
                    $("#district").selectpicker('refresh')
                }
            });
        }
    </script>
@endpush
