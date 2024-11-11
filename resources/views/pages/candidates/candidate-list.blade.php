@php use App\Enums\WorkTypeEnum;use App\Models\Province; @endphp
@extends('layouts.app')

@section('content')
    <!-- INNER PAGE BANNER -->
    <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url(/images/banner/1.jpg);">
        <div class="overlay-main site-bg-white opacity-01"></div>
        <div class="container">
            <div class="wt-bnr-inr-entry">
                <div class="banner-title-outer">
                    <div class="banner-title-name">
                        <h2 class="wt-title">{{trans('lang.candidate')}}</h2>
                    </div>
                </div>
                <!-- BREADCRUMB ROW -->

                <div>
                    <ul class="wt-breadcrumb breadcrumb-style-2">
                        <li><a href="index.html">{{trans('lang.header.home')}}</a></li>
                        <li>{{trans('lang.candidate')}}</li>
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

                            <form>

                                <div class="form-group mb-4">
                                    <h4 class="section-head-small mb-4">Work Type</h4>
                                    <select class="wt-select-bar-large selectpicker job-type" id="work-type" data-live-search="true"
                                            data-bv-field="size">
                                        <option value="all" selected>All</option>
                                        @foreach(WorkTypeEnum::asSelectArray() as $key => $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-4">
                                    <h4 class="section-head-small mb-4">Keyword</h4>
                                    <div class="input-group">
                                        <input type="text" id="keyword" class="form-control"
                                               placeholder="Name of candidate">
                                        <button class="btn" type="button"><i class="feather-search"></i></button>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <h4 class="section-head-small mb-4">Location</h4>
                                    <div class="input-group">
                                        <select name="provinces[]" multiple class="wt-select-bar-large selectpicker" id="select-province"  data-live-search="true" data-bv-field="size">
                                            @foreach(Province::all() as $province)
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



                            </form>

                        </div>

                        <div class="btn-filter">
                            <button type="button" id="submit-filter" class="btn btn-success">Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-danger">Reset</button>
                        </div>

                    </div>


                </div>

                <div class="col-lg-8 col-md-12">
                    <!--Filter Short By-->
{{--                    <div class="product-filter-wrap d-flex justify-content-between align-items-center m-b30">--}}

{{--                        <form class="woocommerce-ordering twm-filter-select" method="get">--}}
{{--                            <span class="woocommerce-result-count">Short By</span>--}}
{{--                            <select class="wt-select-bar-2 selectpicker" data-live-search="true" data-bv-field="size">--}}
{{--                                <option>Most Recent</option>--}}
{{--                                <option>Freelance</option>--}}
{{--                                <option>Full Time</option>--}}
{{--                                <option>Internship</option>--}}
{{--                                <option>Part Time</option>--}}
{{--                                <option>Temporary</option>--}}
{{--                            </select>--}}
{{--                            <select class="wt-select-bar-2 selectpicker" data-live-search="true" data-bv-field="size">--}}
{{--                                <option>Show 10</option>--}}
{{--                                <option>Show 20</option>--}}
{{--                                <option>Show 30</option>--}}
{{--                                <option>Show 40</option>--}}
{{--                                <option>Show 50</option>--}}
{{--                                <option>Show 60</option>--}}
{{--                            </select>--}}
{{--                        </form>--}}

{{--                    </div>--}}

                    <div class="twm-candidates-grid-wrap">
                        <div class="row">
                            @foreach($data as $candidate)
                                <div class="col-lg-6 col-md-6">
                                    <div class="twm-candidates-grid-style1 mb-5">
                                        <div class="twm-media">
                                            <div class="twm-media-pic">
                                                <img
                                                    src="
                                                       {{
                                                        str_contains($candidate['avatar'], 'http')
                                                        ? $candidate['avatar']
                                                        : asset('/images/avatar/'.$candidate['avatar'])
                                                        }}"
                                                    alt="#">
                                            </div>
                                            <div class="twm-candidates-tag"><span>{{$candidate['type_work']}}</span>
                                            </div>
                                        </div>
                                        <div class="twm-mid-content">
                                            <a href="{{route('candidate.detail', $candidate['id'])}}" class="twm-job-title">
                                                <h4>{{$candidate['fullname']}}</h4>
                                            </a>
                                            <p>{{$candidate['email']}}</p>
                                            <a href="candidate-detail.html" class="twm-view-prifile site-text-primary">View
                                                Profile</a>

                                            <div class="twm-fot-content">
                                                <div class="twm-left-info">
                                                    <p class="twm-candidate-address"><i
                                                            class="feather-map-pin"></i>{{$candidate['province']->name ?? ''}}
                                                    </p>
                                                    <div class="twm-jobs-vacancies">{{$candidate['gender']}}</div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    {{$candidates->links()}}

                </div>

            </div>
        </div>
    </div>
    <!-- OUR BLOG END -->

@endsection


@push('js')
    <script>
        $(document).ready(function () {
            let originUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
            let url;
            let filterJobTypeStr = '';
            let filterKeywordStr = '';
            let filterProvinceStr = '';

            const submitFilter = $("#submit-filter");
            const btnReset = $("#btn-reset");

            submitFilter.click(function () {
                resetFilter()
                filterJobType()
                filterLocation()
                getKeyword()

                window.location.href = url;
            })

            btnReset.click(function (e) {
                e.preventDefault();
                window.location.href = originUrl
            })

            function filterJobType() {
                let jobType = $("#work-type").val();

                let selectedValues = [];
                selectedValues.push(jobType);

                for (let i = 0; i < selectedValues.length; i++) {
                    if (i === 0) {
                        filterJobTypeStr += url.includes("?") ? `&job-type=${selectedValues[i]}` : `?job-type=${selectedValues[i]}`
                    } else {
                        filterJobTypeStr += `,${selectedValues[i]}`
                    }
                }
                url += filterJobTypeStr;
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

            function getKeyword() {
                let keyword = $("#keyword").val()
                if (keyword == '')
                    return;
                url += url.includes("?") ? `&search=${keyword}` : `?search=${keyword}`;
            }


            function resetFilter() {
                url = originUrl;
                filterJobTypeStr = '';
                filterKeywordStr = '';
                filterProvinceStr = '';
            }

        })
    </script>
@endpush
