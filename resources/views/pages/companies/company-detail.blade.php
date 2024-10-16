@extends('layouts.app')


@section('content')
    <!-- INNER PAGE BANNER -->
    <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url(/images/banner/1.jpg);">
        <div class="overlay-main site-bg-white opacity-01"></div>
        <div class="container">
            <div class="wt-bnr-inr-entry">
                <div class="banner-title-outer">
                    <div class="banner-title-name">
                        <h2 class="wt-title">Employer Detail</h2>
                    </div>
                </div>
                <!-- BREADCRUMB ROW -->

                <div>
                    <ul class="wt-breadcrumb breadcrumb-style-2">
                        <li><a href="index.html">Home</a></li>
                        <li>Employer Detail</li>
                    </ul>
                </div>

                <!-- BREADCRUMB ROW END -->
            </div>
        </div>
    </div>
    <!-- INNER PAGE BANNER END -->

    <!-- Employer Detail START -->
    <div class="section-full  p-t120 p-b90 bg-white">
        <div class="container">


            <div class="section-content">
                <div class="row d-flex justify-content-center">

                    <div class="col-lg-8 col-md-12">
                        <!-- Candidate detail START -->
                        <div class="cabdidate-de-info">
                            <div class="twm-employer-self-wrap">
                                <div class="twm-employer-self-info">
                                    <div class="twm-employer-self-top">
                                        <div class="twm-media-bg">
                                            <img
                                                src="
                                                        {{
                                                        str_contains($company['banner'], 'http')
                                                        ? $company['banner']
                                                        : asset('/images/avatar/'.$company['banner'])
                                                        }}"
                                                alt="#">
                                        </div>


                                        <div class="twm-mid-content">

                                            <div class="twm-media">
                                                <img
                                                    src="
                                                        {{
                                                        str_contains($company['company_avatar'], 'http')
                                                        ? $company['company_avatar']
                                                        : asset('/images/avatar/'.$company['company_avatar'])
                                                        }}"
                                                    alt="#">
                                            </div>

                                            <h4 class="twm-job-title">{{$company['company_name']}}</h4>
                                            <p class="twm-employer-address"><i class="feather-map-pin"></i>{{$company['company_address']}}</p>
                                            <a href="{{$company['website']}}" class="twm-employer-websites site-text-primary">{{$company['website']}}</a>
                                            <div class="twm-employer-self-bottom">
                                                <a href="javascript:;" class="site-button outline-primary">Add Review</a>
                                                <a href="javascript:;" class="site-button">Follow Us</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <h4 class="twm-s-title">About Company</h4>
                            <!-- Introduce -->
                            {!! $company['introduce'] !!}

                            {{--Available Job--}}
                            <h4 class="twm-s-title">Available Jobs</h4>
                            <div class="twm-jobs-list-wrap">
                                <ul>
                                    @foreach($company['careers'] as $career)
                                        <li>
                                            <div class="twm-jobs-list-style1 mb-5">
                                                <div class="twm-media">
                                                    <img
                                                        src="
                                                        {{
                                                        str_contains($company['company_avatar'], 'http')
                                                        ? $company['company_avatar']
                                                        : asset('/images/avatar/'.$company['company_avatar'])
                                                        }}"
                                                        alt="#">
                                                </div>
                                                <div class="twm-mid-content">
                                                    <a href="{{route('jobs.show', $career->slug)}}" class="twm-job-title">
                                                        <h4>{{$career->title}}<span class="twm-job-post-duration">/ {{$career->created_at->diffForHumans()}}</span></h4>
                                                    </a>
                                                    <p class="twm-job-address">{{$career->address}}</p>
                                                    <a href="https://themeforest.net/user/thewebmax/portfolio" class="twm-job-websites site-text-primary">https://thewebmax.com</a>
                                                </div>
                                                <div class="twm-right-content">
                                                    <div class="twm-jobs-category green"><span class="twm-bg-green">New</span></div>
                                                    <div class="twm-jobs-amount">$1000 <span>/ Month</span></div>
                                                    <a href="job-detail.html" class="twm-jobs-browse site-text-primary">Browse Job</a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 rightSidebar">

                        <div class="side-bar-2">

                            <div class="twm-s-info-wrap mb-5">
                                <h4 class="section-head-small mb-4">Profile Info</h4>
                                <div class="twm-s-info">
                                    <ul>
                                        <li>
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-clock"></i>
                                                <span class="twm-title">Website</span>
                                                <div class="twm-s-info-discription">{{$company['website']}}</div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-venus-mars"></i>
                                                <span class="twm-title">Employee</span>
                                                <div class="twm-s-info-discription">{{$company['employee']}}</div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-mobile-alt"></i>
                                                <span class="twm-title">Phone</span>
                                                <div class="twm-s-info-discription">{{$company['company_phone']}}</div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-at"></i>
                                                <span class="twm-title">Email</span>
                                                <div class="twm-s-info-discription">{{$company['email']}}</div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twm-s-info-inner">

                                                <i class="fas fa-map-marker-alt"></i>
                                                <span class="twm-title">Address</span>
                                                <div class="twm-s-info-discription">{{$company['company_address']}}</div>
                                            </div>
                                        </li>

                                    </ul>

                                </div>
                            </div>

                            <div class="twm-s-contact-wrap mb-5">
                                <h4 class="section-head-small mb-4">Contact us</h4>
                                <div class="twm-s-contact">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <input name="username" type="text" required class="form-control" placeholder="Name">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <input name="email" type="text" class="form-control" required placeholder="Email">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <input name="phone" type="text" class="form-control" required placeholder="Phone">
                                            </div>
                                        </div>


                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <textarea name="message" class="form-control" rows="3" placeholder="Message"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <button type="submit" class="site-button">Submit Now</button>
                                        </div>

                                    </div>

                                </div>
                            </div>


                        </div>


                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- Employer Detail END -->
@endsection
