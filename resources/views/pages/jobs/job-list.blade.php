@extends('layouts.app')

@section('content')
    <!-- Modal Report Career-->
    <div class="modal fade" id="modal-report-career" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Báo cáo vi phạm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">Nếu bạn cho rằng đây là tin giả, vi phạm tiêu chuẩn hãy cho chúng tôi biết</div>
                    <input hidden id="career-id" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="reportCareer()" id="btn-send-report" class="btn btn-primary">Report</button>
                </div>
            </div>
        </div>
    </div>

    <!-- INNER PAGE BANNER -->
    <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url(/images/banner/1.jpg);">
        <div class="overlay-main site-bg-white opacity-01"></div>
        <div class="container">
            <div class="wt-bnr-inr-entry">
                <div class="banner-title-outer">
                    <div class="banner-title-name">
                        <h2 class="wt-title">{{__('job-list.The Most Exciting Jobs')}}</h2>
                    </div>
                </div>
                <!-- BREADCRUMB ROW -->

                <div>
                    <ul class="wt-breadcrumb breadcrumb-style-2">
                        <li><a href="index.html">{{__('lang.header.home')}}</a></li>
{{--                        <li>{{__('category.name.'.$category->trans_key)}}</li>--}}
                        <li>{{__('job-list.Jobs List')}}</li>
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
                                    <h4 class="section-head-small mb-4">{{__('lang.category')}}</h4>
                                    <select name="category" id="select-category" class="wt-select-bar-large selectpicker"  data-live-search="true" data-bv-field="size">
                                        <option value="">Select Category</option>
                                        @foreach(\App\Models\Category::query()->where('status', 1)->get() as $category)
                                            <option
                                                @if(str_contains(session()->get('category'), $category->slug))
                                                    selected
                                                @endif
                                                value="{{$category->slug}}"
                                            >
                                                {{trans('category.name.'.$category->trans_key)}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

{{--                                <div class="form-group mb-4">--}}
{{--                                    <h4 class="section-head-small mb-4">{{__('lang.skill')}}</h4>--}}
{{--                                    <select multiple name="skills[]" id="select-skill" class="wt-select-bar-large selectpicker"  data-live-search="true" data-bv-field="size">--}}
{{--                                        @foreach($skills as $skill)--}}
{{--                                            <option--}}
{{--                                                @if(str_contains(session()->get('skills'), $skill->name))--}}
{{--                                                    selected--}}
{{--                                                @endif--}}
{{--                                                value="{{$skill->name}}"--}}
{{--                                            >--}}
{{--                                                {{$skill->name}}--}}
{{--                                            </option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}

                                <div class="form-group mb-4">
                                    <h4 class="section-head-small mb-4">{{__('lang.keyword')}}</h4>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            id="keyword"
                                            value="{{session()->has('keyword') ? session()->get('keyword') : ''}}"
                                            class="form-control"
                                            placeholder="Job Title or Keyword">
                                        <button class="btn" type="button"><i class="feather-search"></i></button>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <h4 class="section-head-small mb-4">{{__('lang.location')}}</h4>
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

                                <div class="twm-sidebar-ele-filter">

                                    <h4 class="section-head-small mb-4">{{__('job-list.Job Type')}}</h4>
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


                            </form>
                        </div>

                    </div>



                </div>
                <div class="col-lg-8 col-md-12">
                    <!--Filter Short By-->
                    <div class="product-filter-wrap d-flex justify-content-between align-items-center m-b30">
                        <span class="woocommerce-result-count-left">{{__('lang.showing')}} {{$careers->perPage()}} / {{$careers->total()}} {{__('lang.jobs')}}</span>

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
                        </form>

                    </div>

                    <div class="twm-jobs-list-wrap">
                        <ul>
                            @foreach($data as $career)
                                <li>
                                    <div class="twm-jobs-list-style1 mb-5">
                                        <div class="twm-media">
                                            <img src="{{
                                            str_contains($career['company']->company_avatar, 'company/')
                                            ? asset('/images/avatar/'.$career['company']->company_avatar)
                                            : $career['company']->company_avatar}}" alt="#">
                                        </div>
                                        <div class="twm-mid-content">
                                            <a href="{{route('jobs.show', ['job' => $career['slug']])}}" class="twm-job-title">
                                                <h4>{{$career['title']}}<span class="twm-job-post-duration">/ {{$career['updated_at']}}</span></h4>
                                            </a>
                                            <p class="twm-job-address">{{$career['address']}}</p>
                                            <a href="{{$career['company']->website}}" class="twm-job-websites site-text-primary">
                                                {{$career['company']->website}}
                                            </a>
                                            <div class="">
                                                <span onclick="showModalReportCareer({{$career['id']}})" class="btn-report">Report</span>
                                            </div>
                                        </div>
                                        <div class="twm-right-content">
                                            <div class="twm-jobs-category green">
                                                @if($career['expiration_day'] < \Carbon\Carbon::now())
                                                    <span style="background: #929292">Expired</span>
                                                @else
                                                    <span class="twm-bg-green">New</span>

                                                @endif
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
                                            <div class="twm-jobs-amount">{{$career['max_salary']['convert']}} <span>/ Month</span></div>
                                            <a href="job-detail.html" class="twm-jobs-browse site-text-primary">{{$career['province']->name}}</a>
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
            let filterCategoryStr = '';
            // let filterSkillStr = '';
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
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON.msg)
                        iconSave.classList.toggle('far')
                        iconSave.classList.toggle('fas')
                        iconSave.classList.toggle('saved-job')
                    }
                });
            }


            submitFilter.click(function () {
                resetFilter()
                // filterSkill()
                filterCategory()
                filterJobType()
                filterLocation()
                getKeyword()

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

            function filterCategory() {
                let selectedValues = $('#select-category').val()
                if (selectedValues == '')
                    return;
                console.log('123')
                filterCategoryStr += url.includes("?") ? `&category=${selectedValues}` : `?category=${selectedValues}`
                url += filterCategoryStr;
            }

            // function filterSkill() {
            //     let skills = $("#select-skill").val()
            //
            //     for (let i = 0; i < skills.length; i++) {
            //         if (i === 0) {
            //             filterSkillStr += url.includes("?") ? `&skills=${skills[i]}` : `?skills=${skills[i]}`
            //         } else {
            //             filterSkillStr += `,${skills[i]}`
            //         }
            //     }
            //     url += filterSkillStr;
            // }

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

            function getKeyword() {
                let keyword = $("#keyword").val()
                if (keyword == '')
                    return;
                url += url.includes("?") ? `&search=${keyword}` : `?search=${keyword}`;
            }

            function resetFilter() {
                url = originUrl;
                filterJobTypeStr = '';
                filterSkillStr = '';
                filterProvinceStr = '';
            }




        });
        function showModalReportCareer (careerId) {
            $("#modal-report-career").modal('toggle')
            $("#btn-send-report").prop("disabled", false)
            $("#career-id").val(careerId)
        }

        function reportCareer() {
            $.ajax({
                type: 'POST',
                url: '{{route('job.report')}}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'career_id': $("#career-id").val()
                },
                success: function (res) {
                    toastr.success('Reported Successfully !', 'Notification !')
                    $("#btn-send-report").prop('disabled', true)

                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.msg, 'Notification !')
                    $("#btn-send-report").prop('disabled', true)
                }

            })
        }

    </script>
@endpush
