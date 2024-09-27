@extends('layouts.app')

@section('content')
    <!-- INNER PAGE BANNER -->
    <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url(images/banner/1.jpg);">
        <div class="overlay-main site-bg-white opacity-01"></div>
        <div class="container">
            <div class="wt-bnr-inr-entry">
                <div class="banner-title-outer">
                    <div class="banner-title-name">
                        <h2 class="wt-title">The Most Exciting Jobs</h2>
                    </div>
                </div>
                <!-- BREADCRUMB ROW -->

                <div>
                    <ul class="wt-breadcrumb breadcrumb-style-2">
                        <li><a href="index.html">Home</a></li>
                        <li>Jobs List</li>
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

                <div class="col-lg-4 col-md-12 rightSidebar">

                    <div class="side-bar">

                        <div class="sidebar-elements search-bx">

                            <form id="formFilter">

                                <div class="form-group mb-4">
                                    <h4 class="section-head-small mb-4">Skill</h4>
                                    <select multiple name="skills[]" id="select-skill" class="wt-select-bar-large selectpicker"  data-live-search="true" data-bv-field="size">
                                        @foreach($skills as $skill)
                                            <option
                                                @if(str_contains(session()->get('skills'), $skill->name))
                                                    selected
                                                @endif
                                                value="{{$skill->name}}"
                                            >
                                                {{$skill->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-4">
                                    <h4 class="section-head-small mb-4">Keyword</h4>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Job Title or Keyword">
                                        <button class="btn" type="button"><i class="feather-search"></i></button>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <h4 class="section-head-small mb-4">Location</h4>
                                    <div class="input-group">
                                        <select name="provinces[]" multiple class="wt-select-bar-large selectpicker" id="select-province"  data-live-search="true" data-bv-field="size">
                                            @foreach($provinces as $province)
                                                <option
                                                    @if(str_contains(session()->get('locations'), $province->name))
                                                        selected
                                                    @endif
                                                    value="{{$province->name}}"
                                                >
                                                    {{$province->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="twm-sidebar-ele-filter">

                                    <h4 class="section-head-small mb-4">Job Type</h4>
                                    <ul>
                                        <li>
                                            <div class=" form-check">
                                                <input type="checkbox"
                                                       @if(str_contains(session()->get('job-type'), "Full Time"))
                                                           checked
                                                       @endif
                                                       value="Full Time"
                                                       class="form-check-input job-type"
                                                       name="job-type[]"
                                                       id="exampleCheck2">
                                                <label class="form-check-label" for="exampleCheck2">Full Time</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class=" form-check">
                                                <input type="checkbox"
                                                       @if(str_contains(session()->get('job-type'), "Part Time"))
                                                           checked
                                                       @endif
                                                       value="Part Time"
                                                       class="form-check-input job-type"
                                                       name="job-type[]"
                                                       id="exampleCheck4">
                                                <label class="form-check-label" for="exampleCheck4">Part Time</label>
                                            </div>

                                        </li>

                                        <li>
                                            <button type="button" id="submit-filter" class="btn btn-success">Filter</button>
                                            <button type="button" id="btn-reset" class="btn btn-danger">Reset</button>

                                        </li>
                                    </ul>
                                </div>

                                <div class="twm-sidebar-ele-filter">
{{--                                    <h4 class="section-head-small mb-4">Date Posts</h4>--}}
{{--                                    <ul>--}}
{{--                                        <li>--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input type="radio" class="form-check-input" id="exampleradio1">--}}
{{--                                                <label class="form-check-label" for="exampleradio1">Last hour</label>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input type="radio" class="form-check-input" id="exampleradio2">--}}
{{--                                                <label class="form-check-label" for="exampleradio2">Last 24 hours</label>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}

{{--                                        <li>--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input type="radio" class="form-check-input" id="exampleradio3">--}}
{{--                                                <label class="form-check-label" for="exampleradio3">Last 7 days</label>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}

{{--                                        <li>--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input type="radio" class="form-check-input" id="exampleradio4">--}}
{{--                                                <label class="form-check-label" for="exampleradio4">Last 14 days</label>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}

{{--                                        <li>--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input type="radio" class="form-check-input" id="exampleradio5">--}}
{{--                                                <label class="form-check-label" for="exampleradio5">Last 30 days</label>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}

{{--                                        <li>--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input type="radio" class="form-check-input" id="exampleradio6">--}}
{{--                                                <label class="form-check-label" for="exampleradio6">All</label>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}

{{--                                    </ul>--}}
                                </div>

                                <div class="twm-sidebar-ele-filter">
{{--                                    <h4 class="section-head-small mb-4">Type of employment</h4>--}}
{{--                                    <ul>--}}
{{--                                        <li>--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input type="radio" class="form-check-input" id="Freelance1">--}}
{{--                                                <label class="form-check-label" for="Freelance1">Freelance</label>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input type="radio" class="form-check-input" id="FullTime1">--}}
{{--                                                <label class="form-check-label" for="FullTime1">Full Time</label>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}

{{--                                        <li>--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input type="radio" class="form-check-input" id="Intership1">--}}
{{--                                                <label class="form-check-label" for="Intership1">Intership</label>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}

{{--                                        <li>--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input type="radio" class="form-check-input" id="Part-Time1">--}}
{{--                                                <label class="form-check-label" for="Part-Time1">Part Time</label>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}

{{--                                    </ul>--}}
                                </div>

                            </form>
                        </div>

                    </div>



                </div>
                <div class="col-lg-8 col-md-12">
                    <!--Filter Short By-->
                    <div class="product-filter-wrap d-flex justify-content-between align-items-center m-b30">
                        <span class="woocommerce-result-count-left">Showing {{$careers->perPage()}} / {{$careers->total()}} jobs</span>

                        <form id="formSort" class="woocommerce-ordering twm-filter-select" method="get">
                            <span class="woocommerce-result-count">Short By</span>
                            <select id="select-sort" class="wt-select-bar-2 selectpicker" name="sort" data-live-search="true" data-bv-field="size">
                                <option
                                    @if(str_contains(session()->get('sort'), "latest"))
                                        selected
                                    @endif
                                    value="latest"
                                >Latest
                                </option>
                                <option
                                    @if(str_contains(session()->get('sort'), "oldest"))
                                        selected
                                    @endif
                                    value="oldest"
                                >
                                    Oldest
                                </option>

                            </select>
{{--                            <select class="wt-select-bar-2 selectpicker"  data-live-search="true" data-bv-field="size">--}}
{{--                                <option>Show 10</option>--}}
{{--                                <option>Show 20</option>--}}
{{--                                <option>Show 30</option>--}}
{{--                                <option>Show 40</option>--}}
{{--                                <option>Show 50</option>--}}
{{--                                <option>Show 60</option>--}}
{{--                            </select>--}}
                        </form>

                    </div>

                    <div class="twm-jobs-list-wrap">
                        <ul>
                            @foreach($data as $career)
                                <li>
                                    <div class="twm-jobs-list-style1 mb-5">
                                        <div class="twm-media">
                                            <img src="{{$career['company']->company_avatar}}" alt="#">
                                        </div>
                                        <div class="twm-mid-content">
                                            <a href="{{route('jobs.show', $career['slug'])}}" class="twm-job-title">
                                                <h4>{{$career['title']}}<span class="twm-job-post-duration">/ {{$career['updated_at']}}</span></h4>
                                            </a>
                                            <p class="twm-job-address">{{$career['address']}}</p>
                                            <a href="{{$career['company']->website}}" class="twm-job-websites site-text-primary">
                                                {{$career['company']->website}}
                                            </a>
                                        </div>
                                        <div class="twm-right-content">
                                            <div class="twm-jobs-category green">
                                                <span class="twm-bg-green">New</span>
                                                @if(in_array($career['id'], $careerIdSaved))
                                                    <i
                                                        id="icon-save-{{$career['id']}}"
                                                        onclick="savedJob({{$career['id']}})"
                                                        class="fas fa-heart saved-job icon-save-job btn-save-job">

                                                    </i>
                                                @else
                                                    <i
                                                        id="icon-save-{{$career['id']}}"
                                                        onclick="savedJob({{$career['id']}})"
                                                        class="far fa-heart icon-save-job btn-save-job">

                                                    </i>
                                                @endif
                                            </div>
                                            <div class="twm-jobs-amount">{{$career['max_salary']}} <span>/ Month</span></div>
                                            <a href="job-detail.html" class="twm-jobs-browse site-text-primary">{{$career['province']}}</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                            {{$careers->links()}}
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- OUR BLOG END -->
@endsection
@push('js')
    <script>
        $(document).ready(function() {

            const submitFilter = $("#submit-filter");
            const btnReset = $("#btn-reset");
            const selectSort = $("#select-sort")
            const btnSaveJob = $(".btn-save-job");

            const formSort = $("#formSort");

            let originUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
            let url;
            let filterJobTypeStr = '';
            let filterSkillStr = '';
            let filterProvinceStr = '';

            savedJob = function (careerId) {
                let iconSave = document.querySelector('#icon-save-'+ careerId)
                iconSave.classList.toggle('far')
                iconSave.classList.toggle('fas')
                iconSave.classList.toggle('saved-job')

                $.ajax({
                    type: 'POST',
                    url: '{{route('candidate.process.saved-job')}}',
                    data: {
                        '_token': '{{csrf_token()}}',
                        'career_id': careerId
                    },
                    success: function(res){
                        toastr.success(res.msg, 'Notification !')
                    }
                });
            }


            submitFilter.click(function () {
                resetFilter()
                filterSkill()
                filterJobType()
                filterLocation()
                console.log(url)

                window.location.href = url;
            })

            btnReset.click(function (e) {
                e.preventDefault();
                window.location.href = originUrl
            })

            selectSort.change((ele) => {
                formSort.submit();
            })

            function filterJobType() {
                let selectedValues = [];
                $('input.job-type:checked').each(function() {
                    selectedValues.push($(this).val());
                });
                for (let i = 0; i < selectedValues.length; i++) {
                    if (i === 0) {
                        filterJobTypeStr += url.includes("?") ? `&job-type=${selectedValues[i]}` : `?job-type=${selectedValues[i]}`
                    } else {
                        filterJobTypeStr += `,${selectedValues[i]}`
                    }
                }
                url += filterJobTypeStr;
            }

            function filterSkill() {
                let skills = $("#select-skill").val()

                for (let i = 0; i < skills.length; i++) {
                    if (i === 0) {
                        filterSkillStr += url.includes("?") ? `&skills=${skills[i]}` : `?skills=${skills[i]}`
                    } else {
                        filterSkillStr += `,${skills[i]}`
                    }
                }
                url += filterSkillStr;
            }

            function filterLocation() {
                let provinces = $("#select-province").val()

                for (let i = 0; i < provinces.length; i++) {
                    if (i === 0) {
                        filterProvinceStr += url.includes("?") ? `&locations=${provinces[i]}` : `?locations=${provinces[i]}`
                    } else {
                        filterProvinceStr += `,${provinces[i]}`
                    }
                }
                url += filterProvinceStr;
            }

            function resetFilter() {
                url = originUrl;
                filterJobTypeStr = '';
                filterSkillStr = '';
                filterProvinceStr = '';
            }




        });

    </script>
@endpush
