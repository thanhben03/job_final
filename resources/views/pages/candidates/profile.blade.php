@php use App\Enums\GenderEnum;use App\Enums\WorkTypeEnum;use App\Models\Province;use App\Models\Skill; @endphp
@extends('layouts.app')
@section('content')
    <!-- Modal Add Skill -->
    <div class="modal fade" id="modal-add-skill" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select name="" id="select-skill" class="form-select">
                        @foreach(Skill::all() as $skill)
                            <option value="{{$skill->name}}">{{$skill->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button onclick="addSkill()" type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Experience -->
    <div class="modal fade" id="modal-add-experience" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>From Date</label>
                        <select name="" id="from-date" class="form-select">
                            @for($i = 1980; $i <= 2024; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label>To Date</label>
                        <select name="" id="to-date" class="form-select">
                            @for($i = 1980; $i <= 2024; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Title</label>
                        <input id="title" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Position</label>
                        <input id="position" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <input id="description" type="text" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button onclick="addExperienceProfile()" type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url(images/banner/1.jpg);">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">Candidate Profile</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="index.html">Home</a></li>
                            <li>Candidate Profile</li>
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
                    <x-right-sidebar/>

                    <div class="col-xl-9 col-lg-8 col-md-12 m-b30">
                        <!--Filter Short By-->
                        <div class="twm-right-section-panel site-bg-gray">
                            <form action="{{route('profile.update')}}" method="POST">
                                @csrf
                                @method('PATCH')

                                <!--Basic Information-->
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                    aria-expanded="false" aria-controls="flush-collapseOne">
                                                Basic Information
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                                             aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">

                                                <div class="panel panel-default">
                                                    <div class="panel-heading wt-panel-heading p-a20">
                                                        {{--                                                        <h4 class="panel-tittle m-a0">Basic Informations</h4>--}}
                                                        @foreach ($errors->all() as $error)
                                                            <p>{{ $error }}</p>
                                                        @endforeach
                                                        @if(Session::has('msg'))
                                                            <p class="alert alert-success">{{ Session::get('msg') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="panel-body wt-panel-body p-a20 m-b30 ">

                                                        <div class="row">

                                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Your Name</label>
                                                                    <div class="ls-inputicon-box">
                                                                        <input class="form-control" name="fullname"
                                                                               type="text"
                                                                               value="{{auth()->user()->fullname}}">
                                                                        <i class="fs-input-icon fa fa-user "></i>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Phone</label>
                                                                    <div class="ls-inputicon-box">
                                                                        <input class="form-control" name="phone"
                                                                               type="text"
                                                                               value="{{auth()->user()->phone}}">
                                                                        <i class="fs-input-icon fa fa-phone-alt"></i>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Email Address</label>
                                                                    <div class="ls-inputicon-box">
                                                                        <input class="form-control" name="email"
                                                                               type="email"
                                                                               value="{{auth()->user()->email}}"
                                                                               placeholder="Devid@example.com">
                                                                        <i class="fs-input-icon fas fa-at"></i>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Price Per Hours</label>
                                                                    <div class="ls-inputicon-box">
                                                                        <input class="form-control"
                                                                               name="price_per_hours"
                                                                               value="{{auth()->user()->price_per_hours}}"
                                                                               type="number"
                                                                               placeholder="200.000">
                                                                        <i class="fs-input-icon fa fa-globe-americas"></i>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Type Work</label>

                                                                    <div class="position-relative">
                                                                        <i class="fs-input-icon fa fa-user-graduate icon-select-custom"></i>

                                                                        <select name="type_work"
                                                                                class="form-select custom-select">
                                                                            @foreach(WorkTypeEnum::asSelectArray() as $item)
                                                                                <option
                                                                                    {{WorkTypeEnum::getValue($item) == auth()->user()->type_work ? 'selected' : ''}}
                                                                                    value="{{WorkTypeEnum::getValue($item)}}">{{$item}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Gender</label>

                                                                    <div class="position-relative">
                                                                        <i class="fs-input-icon fa fa-user-graduate icon-select-custom"></i>

                                                                        <select name="gender"
                                                                                class="form-select custom-select">
                                                                            @foreach(GenderEnum::asSelectArray() as $key => $value)
                                                                                <option
                                                                                    @if(auth()->user()->gender == $key) selected
                                                                                    @endif value="{{$key}}">{{$value}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Birthday</label>
                                                                    <div class="ls-inputicon-box">
                                                                        <input class="form-control" name="birthday"
                                                                               type="date"
                                                                               value="{{auth()->user()->birthday}}"
                                                                               placeholder="Devid@example.com">
                                                                        <i class="fs-input-icon fas fa-at"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Province</label>
                                                                    <div class="ls-inputicon-box">
                                                                        <select class="form-control" name="province_id"
                                                                                id="">
                                                                            @foreach(Province::all() as $province)
                                                                                <option
                                                                                    @if(auth()->user()->province_id == $province->code) selected
                                                                                    @endif value="{{$province->code}}">{{$province->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <i class="fs-input-icon fas fa-at"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Address</label>
                                                                    <div class="ls-inputicon-box">
                                                                        <input value="{{auth()->user()->address}}" name="address" class="form-control" type="text" >
                                                                        <i class="fs-input-icon fas fa-at"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Introduce</label>
                                                                    <textarea name="introduce" class="form-control"
                                                                              rows="3">{{auth()->user()->introduce}}</textarea>
                                                                </div>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingTwo">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                                    aria-expanded="false" aria-controls="flush-collapseTwo">
                                                Professional skills
                                            </button>
                                        </h2>
                                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                             aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body d-flex justify-content-between">
                                                <div class="tw-sidebar-tags-wrap">
                                                    <div class="tagcloud">
                                                        @foreach(auth()->user()?->skills as $skill)
                                                            <input name="skill_ids[]" value="{{$skill->name}}" />
                                                        @endforeach
                                                    </div>

                                                    <button type="button" onclick="showModalAddSkillProfile()"
                                                            style="background: #006aff;
                                                                    border: navajowhite;
                                                                    color: white;
                                                                    border-radius: 5px;" href="">+ New Skill
                                                    </button>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingThree">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                                    aria-expanded="false" aria-controls="flush-collapseThree">
                                                Work Experience
                                            </button>
                                        </h2>
                                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                                             aria-labelledby="flush-headingThree"
                                             data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="twm-timing-list-wrap wrap-experience">

                                                    @foreach(auth()->user()->experiences as $exp)
                                                        <div class="twm-timing-list">
                                                            <div class="twm-time-list-date">{{$exp->from_date}} to {{$exp->to_date}}</div>
                                                            <input value="{{$exp->from_date}}" name="from_date[]" hidden />
                                                            <input value="{{$exp->to_date}}" name="to_date[]" hidden />
                                                            <div class="twm-time-list-title">{{$exp->title}}</div>
                                                            <input value="{{$exp->title}}" name="title[]" hidden />
                                                            <div class="twm-time-list-position">{{$exp->position}}</div>
                                                            <input value="{{$exp->position}}" name="position[]" hidden />
                                                            <div class="twm-time-list-discription">
                                                                <p>{{$exp->description}}</p>
                                                            </div>
                                                            <input value="{{$exp->description}}" name="description[]" hidden />

                                                        </div>
                                                    @endforeach


                                                </div>
                                                <button type="button" onclick="showModalAddExpProfile()"
                                                        style="
                                                        background: #006aff;
                                                        border: navajowhite;
                                                        color: white;
                                                        border-radius: 5px;" href="">+ New Experience
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 mt-3">
                                    <div class="text-left">
                                        <button type="submit" class="site-button">Save All
                                        </button>
                                    </div>
                                </div>
                            </form>
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
    <script>
        function showModalAddSkillProfile() {
            $("#modal-add-skill").modal('toggle')
        }

        function addSkill() {
            let selectedSkill = $("#select-skill").val()

            $(".tagcloud").append(`<input name="skill_ids[]" value="${selectedSkill}" />`)
            $("#modal-add-skill").modal('toggle')
        }

        function addExperienceProfile() {
            let fromDate = $("#from-date");
            let toDate = $("#to-date");
            let title = $("#title");
            let position = $("#position");
            let description = $("#description");

            $(".wrap-experience").append(`
                <div class="twm-timing-list">
                    <div class="twm-time-list-date">${fromDate.val()} to ${toDate.val()}</div>
                    <input value="${fromDate.val()}" name="from_date[]" hidden />
                    <input value="${toDate.val()}" name="to_date[]" hidden />
                    <div class="twm-time-list-title">${title.val()}</div>
                    <input value="${title.val()}" name="title[]" hidden />
                    <div class="twm-time-list-position">${position.val()}</div>
                    <input value="${position.val()}" name="position[]" hidden />
                    <div class="twm-time-list-discription">
                        <p>${description.val()}</p>
                    </div>
                    <input value="${description.val()}" name="description[]" hidden />

                </div>
            `)
            fromDate.val('1980')
            toDate.val('1980')
            title.val('')
            position.val('')
            description.val('')
            $("#modal-add-experience").modal('toggle')
        }

        function showModalAddExpProfile() {
            $("#modal-add-experience").modal('toggle')
        }
    </script>
@endpush
