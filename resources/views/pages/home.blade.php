@extends('layouts.app')


@section('content')
    <!--Banner Start-->
    <x-banner :categoriesCollection="$categoriesCollection" :provinces="$provinces" />
    <!--Banner End-->

    <!-- SECTION 1 -->
    <x-section-one />
    <!-- SECTION 1 END -->

    <!-- JOBS CATEGORIES SECTION START -->
    <x-job-category :categories="$categories" />
    <!-- JOBS CATEGORIES SECTION END -->


    <!-- TOP COMPANIES START -->
    <div class="section-full p-t120  site-bg-white twm-companies-wrap">

        <!-- TITLE START-->
        <div class="section-head center wt-small-separator-outer">
            <div class="wt-small-separator site-text-primary">
                <div>{{__('lang.home.Top Companies')}}</div>
            </div>
            <h2 class="wt-title">{{__('lang.home.Get hired in top companies')}}</h2>
        </div>
        <!-- TITLE END-->

        <div class="container">
            <div class="section-content">
                <div class="owl-carousel home-client-carousel2 owl-btn-vertical-center">

                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo client-logo-media">
                                <a href="/companies/list"><img src="images/client-logo/w1.png" alt=""></a></div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo client-logo-media">
                                <a href="/companies/list"><img src="images/client-logo/w2.png" alt=""></a></div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo client-logo-media">
                                <a href="/companies/list"><img src="images/client-logo/w3.png" alt=""></a></div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo client-logo-media">
                                <a href="/companies/list"><img src="images/client-logo/w4.png" alt=""></a></div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo client-logo-media">
                                <a href="/companies/list"><img src="images/client-logo/w5.png" alt=""></a></div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo client-logo-media">
                                <a href="/companies/list"><img src="images/client-logo/w6.png" alt=""></a></div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo client-logo-media">
                                <a href="/companies/list"><img src="images/client-logo/w1.png" alt=""></a></div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo client-logo-media">
                                <a href="/companies/list"><img src="images/client-logo/w2.png" alt=""></a></div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo client-logo-media">
                                <a href="/companies/list"><img src="images/client-logo/w3.png" alt=""></a></div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo client-logo-media">
                                <a href="/companies/list"><img src="images/client-logo/w5.png" alt=""></a></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="twm-company-approch-outer">
            <div class="twm-company-approch">
                <div class="row">

                    <!--block 1-->
                    <div class="col-lg-4 col-md-12">
                        <div class="counter-outer-two">
                            <div class="icon-content">
                                <div class="tw-count-number text-clr-sky">
                                    <span class="counter">5</span>M+</div>
                                <p class="icon-content-info">Million daily active users</p>
                            </div>
                        </div>
                    </div>

                    <!--block 2-->
                    <div class="col-lg-4 col-md-12">
                        <div class="counter-outer-two">
                            <div class="icon-content">
                                <div class="tw-count-number text-clr-pink">
                                    <span class="counter">9</span>K+</div>
                                <p class="icon-content-info">Open job positions</p>
                            </div>
                        </div>
                    </div>

                    <!--block 3-->
                    <div class="col-lg-4 col-md-12">
                        <div class="counter-outer-two">
                            <div class="icon-content">
                                <div class="tw-count-number text-clr-green">
                                    <span class="counter">2</span>M+</div>
                                <p class="icon-content-info">Million stories shared</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
    <!-- TOP COMPANIES END -->

    <!-- JOB POST START -->
    <div class="section-full p-t120 p-b90 site-bg-light-purple twm-bg-ring-wrap">
        <div class="twm-bg-ring-right"></div>
        <div class="twm-bg-ring-left"></div>
        <div class="container">

            <!-- TITLE START-->
            <div class="section-head center wt-small-separator-outer">
                <div class="wt-small-separator site-text-primary">
                    <div>{{__('lang.home.All Jobs Post')}}</div>
                </div>
                <h2 class="wt-title">{{__('lang.Latest Job')}}</h2>
            </div>
            <!-- TITLE END-->


            <div class="section-content">
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
{{--                                            @if(in_array($career['id'], $careerIdSaved))--}}
{{--                                                <i--}}
{{--                                                    id="icon-save-{{$career['id']}}"--}}
{{--                                                    onclick="savedJob({{$career['id']}})"--}}
{{--                                                    class="fas fa-heart saved-job icon-save-job btn-save-job">--}}

{{--                                                </i>--}}
{{--                                            @else--}}
{{--                                                <i--}}
{{--                                                    id="icon-save-{{$career['id']}}"--}}
{{--                                                    onclick="savedJob({{$career['id']}})"--}}
{{--                                                    class="far fa-heart icon-save-job btn-save-job">--}}

{{--                                                </i>--}}
{{--                                            @endif--}}
                                        </div>
                                        <div class="twm-jobs-amount">{{$career['max_salary']['convert']}} <span>/ Month</span></div>
                                        <a href="{{route('jobs.show', $career['slug'])}}" class="twm-jobs-browse site-text-primary">{{$career['province']->name}}</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
{{--                    <div class="text-center m-b30">--}}
{{--                        <a href="{{route('jobs.index', $)}}" class=" site-button">Browse All Jobs</a>--}}
{{--                    </div>--}}
                </div>
            </div>

        </div>
    </div>
    <!-- JOB POST END -->

@endsection
