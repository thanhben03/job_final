@extends('layouts.app')
@section('content')
    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url(images/banner/1.jpg);">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">Candidate Jobs Applied</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="index.html">Home</a></li>
                            <li>Candidate Jobs Applied</li>
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
                    <x-right-sidebar />

                    <div class="col-xl-9 col-lg-8 col-md-12 m-b30">
                        <div class="twm-right-section-panel candidate-save-job site-bg-gray">
                            <!--Filter Short By-->
                            <div class="product-filter-wrap d-flex justify-content-between align-items-center">
                                <span class="woocommerce-result-count-left">Applied {{count($data)}} jobs</span>

{{--                                <form class="woocommerce-ordering twm-filter-select" method="get">--}}
{{--                                    <select class="wt-select-bar-2 selectpicker"  data-live-search="true" data-bv-field="size">--}}
{{--                                        <option>Show 10</option>--}}
{{--                                        <option>Show 20</option>--}}
{{--                                        <option>Show 30</option>--}}
{{--                                        <option>Show 40</option>--}}
{{--                                        <option>Show 50</option>--}}
{{--                                        <option>Show 60</option>--}}
{{--                                    </select>--}}
{{--                                </form>--}}

                            </div>

                            <div class="twm-jobs-list-wrap">
                                <ul>

                                    @foreach($data as $career)
                                        <li>
                                            <div class="twm-jobs-list-style1 mb-5">
                                                <div class="twm-media">
                                                    <img
                                                        src="
                                                        {{
                                                        str_contains($career['company']->company_avatar, 'http')
                                                        ? $career['company']->company_avatar
                                                        : asset('/images/avatar/'.$career['company']->company_avatar)
                                                        }}"
                                                        alt="#">
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
                                                    <div class="twm-jobs-category green"><span class="twm-bg-green">New</span></div>
                                                    <div class="twm-jobs-amount">{{$career['max_salary']['convert']}} <span>/ Month</span></div>
                                                    <a href="job-detail.html" class="twm-jobs-browse site-text-primary">Browse Job</a>
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



    </div>
    <!-- CONTENT END -->
@endsection
