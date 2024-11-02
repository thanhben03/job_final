@extends('layouts.app')

@section('content')
    <!-- INNER PAGE BANNER -->
    <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url(/images/banner/1.jpg);">
        <div class="overlay-main site-bg-white opacity-01"></div>
        <div class="container">
            <div class="wt-bnr-inr-entry">
                <div class="banner-title-outer">
                    <div class="banner-title-name">
                        <h2 class="wt-title">{{__('company.The Most Exciting Company')}}</h2>
                    </div>
                </div>
                <!-- BREADCRUMB ROW -->

                <div>
                    <ul class="wt-breadcrumb breadcrumb-style-2">
                        <li><a href="index.html">{{__('lang.header.home')}}</a></li>
                        <li>{{__('company.Companies List')}}</li>
                    </ul>
                </div>

                <!-- BREADCRUMB ROW END -->
            </div>
        </div>
    </div>
    <!-- INNER PAGE BANNER END -->

    <!-- Employer List START -->
    <div class="section-full p-t120  p-b90 site-bg-white">


        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-12 rightSidebar">

                    <div class="side-bar">

                        <div class="sidebar-elements search-bx">

                            <form>

                                <div class="form-group mb-4">
                                    <h4 class="section-head-small mb-4">{{__('lang.location')}}</h4>
                                    <select class="wt-select-bar-large selectpicker" id="select-province" multiple  data-live-search="true" data-bv-field="size">
                                        @foreach(\App\Models\Province::query()->get() as $province)
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

                                <div class="form-group mb-4">
                                    <h4 class="section-head-small mb-4">{{__('company.Company Size')}}</h4>
                                    <select class="wt-select-bar-large selectpicker" id="company-size" data-live-search="true" data-bv-field="size">
                                        <option value="0" selected>All Category</option>
                                        @foreach(\App\Enums\CompanySizeEnum::asSelectArray() as $key => $value)
                                            <option
                                                @if(session()->get('company-size') == $key)
                                                    selected
                                                @endif
                                                value="{{$key}}">
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-4">
                                    <h4 class="section-head-small mb-4">{{__('lang.keyword')}}</h4>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            id="keyword"
                                            class="form-control"
                                            placeholder="Company Name"
                                            value="{{session()->has('keyword') ? session()->get('keyword') : ''}}"
                                        >
                                        <button class="btn" type="button"><i class="feather-search"></i></button>
                                    </div>
                                </div>

                            </form>

                        </div>

                        <div>
                            <button type="button" id="submit-filter" class="btn btn-success">Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-danger">Reset</button>

                        </div>
                    </div>

                </div>

                <div class="col-lg-8 col-md-12">
                    <!--Filter Short By-->
                    <div class="product-filter-wrap d-flex justify-content-between align-items-center m-b30">
                        <span class="woocommerce-result-count-left">
                            {{__('lang.showing')}}
                                @if($companies->total() < $companies->perPage())
                                    {{$companies->total()}}
                                @else
                                    {{$companies->perPage()}}
                               @endif
                            / {{$companies->total()}}
                            {{__('lang.company')}}
                        </span>

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

                    <div class="twm-employer-list-wrap">
                        <ul>
                            @foreach($companyResources as $company)
                                <li>
                                    <div class="twm-employer-list-style1 mb-5">
                                        <div class="twm-media">
                                            <img src="{{str_contains($company['company_avatar'], 'http') ? $company['company_avatar'] : asset('/images/avatar/'.$company['company_avatar'])}}" alt="">
                                        </div>
                                        <div class="twm-mid-content">
                                            <a href="{{route('company.detail', $company['id'])}}" class="twm-job-title">
                                                <h4>{{$company['company_name']}}</h4>
                                            </a>
                                            <p class="twm-job-address">{{$company['company_address']}}</p>
{{--                                            <a href="employer-detail.html" class="twm-job-websites site-text-primary">Accountancy</a>--}}
                                        </div>
                                        <div class="twm-right-content">
                                            <div class="twm-jobs-vacancies"><span>{{count($company['careers'])}}</span>Vacancies</div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>

                    {{$companies->links()}}

                </div>

            </div>
        </div>
    </div>
    <!-- Employer List END -->

@endsection


@push('js')
    <script>
        $(document).ready(function () {
            const submitFilter = $("#submit-filter");
            const btnReset = $("#btn-reset");
            const selectSort = $("#select-sort")
            const formSort = $("#formSort");


            let originUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
            let url;
            let filterJobTypeStr = '';
            let filterSkillStr = '';
            let filterProvinceStr = '';

            selectSort.change((ele) => {
                formSort.submit();
            })

            submitFilter.click(function () {
                resetFilter()
                filterLocation()
                getKeyword()
                filterCompanySize()
                window.location.href = url;
            })

            btnReset.click(function (e) {
                e.preventDefault();
                window.location.href = originUrl
            })

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
            function filterCompanySize() {
                let companySize = $("#company-size").val()
                if (companySize == '' || companySize == '0')
                    return
                url += url.includes("?") ? `&company-size=${companySize}` : `?company-size=${companySize}`;
            }


            function getKeyword() {
                let keyword = $("#keyword").val()
                if (keyword == '')
                    return
                url += url.includes("?") ? `&search=${keyword}` : `?search=${keyword}`;
            }

            function resetFilter() {
                url = originUrl;
                filterJobTypeStr = '';
                filterSkillStr = '';
                filterProvinceStr = '';
            }

        })
    </script>
@endpush
