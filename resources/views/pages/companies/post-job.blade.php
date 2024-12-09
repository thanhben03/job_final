@extends('layouts.company')

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="jobPreviewModal" tabindex="-1" aria-labelledby="jobPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobPreviewModalLabel">Preview Job Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="jobPreviewContent">
                        <!-- Nội dung sẽ được hiển thị ở đây -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content Holder -->
    <div id="content">

        <div class="content-admin-main">

            <div class="wt-admin-right-page-header clearfix">
                <h2>{{ trans('lang.Post a New Jobs') }}</h2>
                <div class="breadcrumbs"><a href="#">{{ trans('lang.header.home') }}</a><a
                        href="#">{{ trans('lang.user.dashboard') }}</a><span>{{ trans('lang.Job Submission Form') }}</span>
                </div>
            </div>


            <!--Basic Information-->
            <div class="panel panel-default">
                <div class="panel-heading wt-panel-heading p-a20">
                    <h4 class="panel-tittle m-a0">
                        <i class="fa fa-suitcase"></i>
                        {{ trans('lang.Job Information') }}
                    </h4>
                    <div id="draft">

                    </div>
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                    @if (Session::has('msg'))
                        <p class="alert alert-success">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="panel-body wt-panel-body p-a20 m-b30 ">
                    <form id="form-post-job" action="{{ route('job.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!--Job title-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Job Title</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control" value="{{ old('title', 'Ahihihihi 123') }}"
                                            name="title" type="text" placeholder="Devid Smith">
                                        <i class="fs-input-icon fa fa-address-card"></i>
                                    </div>
                                </div>
                            </div>

                            <!--Job Skill-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group city-outer-bx has-feedback">
                                    <label>Job Skill</label>
                                    <div class="ls-inputicon-box">
                                        <select name="skill_ids[]" multiple class="wt-select-box selectpicker"
                                            data-live-search="true" title="" id="j-category" data-bv-field="size">
                                            @foreach ($skills as $skill)
                                                <option value="{{ $skill->id }}">{{ $skill->name }}</option>
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
                                        <select name="working_time" class="wt-select-box selectpicker"
                                            data-live-search="true" title="" id="s-category" data-bv-field="size">
                                            @foreach ($workType as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
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
                                                <input type="number" name="min_salary"
                                                    value="{{ old('min_salary', '1000000') }}" class="form-control">
                                                <i class="fs-input-icon fa fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Max Salary</label>
                                            <div class="ls-inputicon-box">
                                                <input type="number" name="max_salary"
                                                    value="{{ old('max_salary', '2000000') }}" class="form-control">
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
                                        <select name="experience" class="wt-select-box selectpicker" data-live-search="true"
                                            title="" id="salary" data-bv-field="size">
                                            @foreach ($exps as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
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
                                        <select name="qualification" class="wt-select-box selectpicker"
                                            data-live-search="true" title="" data-bv-field="size">
                                            @foreach ($qualifications as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
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
                                        <select class="wt-select-box selectpicker" data-live-search="true" name="gender"
                                            id="gender" data-bv-field="size">
                                            @foreach ($genders as $keyd => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
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
                                        <select onchange="selectProvince(this)" class="wt-select-box selectpicker"
                                            data-live-search="true" title="" name="province_id"
                                            data-bv-field="size">
                                            @foreach ($provinces as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
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
                                        <select class="form-control" id="district" name="district_id">

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
                                        <select class="wt-select-box selectpicker" data-live-search="true" title=""
                                            name="level" data-bv-field="size">
                                            @foreach ($levels as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
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
                                        <input class="form-control" value="{{ old('phone', '0772854932') }}"
                                            name="phone" type="text" placeholder="0772859431">
                                        <i class="fs-input-icon fa fa-map-pin"></i>
                                    </div>
                                </div>
                            </div>

                            <!--Employee-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Employee Number</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control" value="{{ old('employee', 10) }}" name="employee"
                                            type="number" placeholder="10">
                                        <i class="fs-input-icon fas fa-at"></i>
                                    </div>
                                </div>
                            </div>

                            <!--From Time-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>From Time</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control" value="{{ old('from_time', '16:34') }}"
                                            name="from_time" type="time">
                                        <i class="fs-input-icon fa fa-globe-americas"></i>
                                    </div>
                                </div>
                            </div>

                            <!--To Time-->
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>To Time</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control" value="{{ old('to_time', '16:40') }}" name="to_time"
                                            type="time">
                                        <i class="fs-input-icon fa fa-clock"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Expiration Day -->

                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Expiration Day</label>
                                    <div class="ls-inputicon-box">
                                        <input type="date" value="{{ old('expiration_day', '2024-10-04') }}"
                                            name="expiration_day" class="form-control">
                                        <i class="fs-input-icon fa fa-map-marker-alt"></i>
                                    </div>
                                </div>
                            </div>

                            <!--Complete Address-->
                            <div class="col">
                                <div class="form-group">
                                    <label>Complete Address</label>
                                    <div class="ls-inputicon-box">
                                        <input class="form-control"
                                            value="{{ old('address', 'AN BINH, AN THANH TRUNG') }}" name="address"
                                            type="text" placeholder="1363-1385 Sunset Blvd Los Angeles, CA 90026, USA">
                                        <i class="fs-input-icon fa fa-home"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Category</label>
                                    <div class="ls-inputicon-box">
                                        <select onchange="changeCategory(this)" class="wt-select-box selectpicker"
                                            data-live-search="true" title="" name="category_id"
                                            data-bv-field="size">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <i class="fs-input-icon fa fa-home"></i>
                                    </div>
                                </div>
                            </div>

                            <!--Description-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea id="desc" name="description" class="form-control" rows="3">
                                        {{ old('description', 'DESC DEFAULT') }}
                                    </textarea>
                                </div>
                            </div>

                            <!--Require-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Require</label>
                                    <textarea id="requirements" name="requirement" class="form-control" rows="3">
                                        {{ old('requirement', 'REQUIRE DEFAULT') }}
                                    </textarea>
                                </div>
                            </div>

                            <!--Benefit-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Benefit</label>
                                    <textarea id="benefit" name="benefit" class="form-control" rows="3">
                                        {{ old('benefit', 'BENEFIT DEFAULT') }}
                                    </textarea>
                                </div>
                            </div>

                            <!--Key Responsibility-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Key Responsibility</label>
                                    <textarea name="key_responsibilities" id="key_responsibility" class="form-control" rows="3">
                                        {{ old('key_responsibilities', 'RESPONSIBILITY DEFAULT') }}
                                    </textarea>
                                </div>
                            </div>


                            <div class="col-lg-12 col-md-12">
                                <div class="text-left">
                                    <button type="submit" class="site-button m-r5">{{ trans('lang.save') }}</button>
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
    <script src="https://cdn.tiny.cloud/1/j7s71fyc3kax1nrnlchfbs12d0rgzpsuwjdnkn43xugf4xgv/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#key_responsibility,#benefit,#desc,#requirements',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
    <script>
        function selectProvince(e) {
            $.ajax({
                type: 'GET',
                url: '/api/v1/get-district/' + e.value,
                success: function(res) {
                    let html = ''
                    let districtEle = document.querySelector('#district');
                    res.districts.forEach(e => {
                        html +=
                            `<option value="${e.code}">${e.name}</option>`
                    })
                    while (districtEle.hasChildNodes()) {
                        districtEle.removeChild(districtEle.firstChild);
                    }
                    districtEle.innerHTML = html;
                }
            });
        }

        function changeCategory(e) {
            // if (e.value != 7) {
            //     console.log(1)
            //     console.log($("#select-skills"))
            //     $("#select-skills").classList.add('d-none');
            // } else {
            //     $("#select-skills").classList.remove('d-none');
            // }
        }

        function previousPost() {
            // Khi nhấn nút Preview

            // Lấy dữ liệu từ form
            let jobData = JSON.parse(localStorage.getItem('jobs'));
            console.log(jobData);



            // Điền lại dữ liệu vào form
            $('input[name="title"]').val(jobData.title || '');
            $('select[name="skill_ids[]"]').val(jobData.skill_ids.map(Number) || [])
                .change(); // Trigger change event nếu cần
            $('select[name="working_time"]').val(jobData.working_time || '').change();
            $('input[name="min_salary"]').val(jobData.min_salary || '');
            $('input[name="max_salary"]').val(jobData.max_salary || '');
            $('select[name="experience"]').val(jobData.experience || '').change();
            $('select[name="qualification"]').val(jobData.qualification || '').change();
            $('select[name="gender"]').val(jobData.gender || '').change();
            // $('select[name="province_id"]').val(jobData.province_id || '').change();
            // $('select[name="district_id"]').val(jobData.district_id || '').change();
            $('select[name="level"]').val(jobData.level || '').change();
            $('input[name="phone"]').val(jobData.phone || '');
            $('input[name="employee"]').val(jobData.employee || '');
            $('input[name="from_time"]').val(jobData.from_time || '');
            $('input[name="to_time"]').val(jobData.to_time || '');
            $('input[name="expiration_day"]').val(jobData.expiration_day || '');
            $('input[name="address"]').val(jobData.address || '');
            $('select[name="category_id"]').val(jobData.category_id || '').change();
            $('textarea[name="description"]').val(jobData.description || '');
            $('textarea[name="requirement"]').val(jobData.requirement || '');
            $('textarea[name="benefit"]').val(jobData.benefit || '');
            $('textarea[name="key_responsibilities"]').val(jobData.key_responsibilities || '');

            $.ajax({
                type: 'GET',
                url: '/api/v1/get-district/' + jobData.province_id,
                success: function(res) {
                    let html = ''
                    let districtEle = document.querySelector('#district');
                    res.districts.forEach(e => {
                        html +=
                            `<option value="${e.code}">${e.name}</option>`
                    })
                    while (districtEle.hasChildNodes()) {
                        districtEle.removeChild(districtEle.firstChild);
                    }
                    districtEle.innerHTML = html;
                    $('select[name="district_id"]').val(jobData.district_id)
                    localStorage.removeItem('jobs')
                }
            });

            $('select[name="province_id"]').selectpicker('val', jobData.province_id)

            $('#j-category').val(jobData.skill_ids.map(Number))
            $('#j-category').selectpicker('render')
        }

        function sendJobToServer(data) {
            if (!data) {
                data = JSON.parse(localStorage.getItem('jobs'))[0];
            }
            data['_token'] = '{{ csrf_token() }}';
            $.ajax({
                type: 'POST',
                url: '{{ route('job.store') }}',
                data: data,
                success: function(res) {

                }
            })
        }
        $(document).ready(function() {
            const form = $('#form-post-job');

            // Lưu công việc vào LocalStorage
            function saveJobOffline(data) {

                localStorage.setItem('jobs', JSON.stringify(data));
            }

            // Xử lý sự kiện submit form
            // form.on('submit', async function(event) {
            //     event.preventDefault();

            //     const job = {
            //         title: $('input[name="title"]').val(),
            //         skill_ids: $('select[name="skill_ids[]"]').val(),
            //         working_time: $('select[name="working_time"]').val(),
            //         min_salary: $('input[name="min_salary"]').val(),
            //         max_salary: $('input[name="max_salary"]').val(),
            //         experience: $('select[name="experience"]').val(),
            //         qualification: $('select[name="qualification"]').val(),
            //         gender: $('select[name="gender"]').val(),
            //         province_id: $('select[name="province_id"]').val(),
            //         district_id: $('select[name="district_id"]').val(),
            //         level: $('select[name="level"]').val(),
            //         phone: $('input[name="phone"]').val(),
            //         employee: $('input[name="employee"]').val(),
            //         from_time: $('input[name="from_time"]').val(),
            //         to_time: $('input[name="to_time"]').val(),
            //         expiration_day: $('input[name="expiration_day"]').val(),
            //         address: $('input[name="address"]').val(),
            //         category_id: $('select[name="category_id"]').val(),
            //         description: $('textarea[name="description"]').val(),
            //         requirement: $('textarea[name="requirement"]').val(),
            //         benefit: $('textarea[name="benefit"]').val(),
            //         key_responsibilities: $('textarea[name="key_responsibilities"]').val(),
            //     };


            //     if (navigator.onLine) {
            //         const success = await sendJobToServer(job);
            //         if (success) {
            //             toastr.success("Success !")

            //         } else {
            //             saveJobOffline(job);
            //         }
            //     } else {
            //         // Không có mạng, lưu tạm
            //         console.log('offline');

            //         saveJobOffline(job);
            //     }

            //     form[0].reset(); // Reset form sau khi submit
            // });



            if (localStorage.getItem('jobs')) {

                $("#draft").html(
                    `
                    <p>Bạn có một bản nháp tự động lưu do sự cố mạng !</p>
                    <p onclick="previousPost()" >Tải lại</p>
                    `
                )
            }
            window.addEventListener('offline', () => {
                console.log("Bạn đã mất kết nối mạng.");
                const job = {
                    title: $('input[name="title"]').val(),
                    skill_ids: $('select[name="skill_ids[]"]').val(),
                    working_time: $('select[name="working_time"]').val(),
                    min_salary: $('input[name="min_salary"]').val(),
                    max_salary: $('input[name="max_salary"]').val(),
                    experience: $('select[name="experience"]').val(),
                    qualification: $('select[name="qualification"]').val(),
                    gender: $('select[name="gender"]').val(),
                    province_id: $('select[name="province_id"]').val(),
                    district_id: $('select[name="district_id"]').val(),
                    level: $('select[name="level"]').val(),
                    phone: $('input[name="phone"]').val(),
                    employee: $('input[name="employee"]').val(),
                    from_time: $('input[name="from_time"]').val(),
                    to_time: $('input[name="to_time"]').val(),
                    expiration_day: $('input[name="expiration_day"]').val(),
                    address: $('input[name="address"]').val(),
                    category_id: $('select[name="category_id"]').val(),
                    description: $('textarea[name="description"]').val(),
                    requirement: $('textarea[name="requirement"]').val(),
                    benefit: $('textarea[name="benefit"]').val(),
                    key_responsibilities: $('textarea[name="key_responsibilities"]').val(),
                };
                saveJobOffline(job);

            });

            window.addEventListener('online', () => {
                const job = JSON.parse(localStorage.getItem('jobs'));
                if (job) {
                    $("#draft").html(
                        `
                    <p>Bạn có một bản nháp tự động lưu do sự cố mạng !</p>
                    <p class="btn btn-success" onclick="previousPost()" >Tải lại</p>
                    `
                    )
                }

            });
        })
    </script>
@endpush
