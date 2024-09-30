@extends('layouts.app')
@section('content')
    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url(/images/banner/1.jpg);">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">Company Resume</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="index.html">Home</a></li>
                            <li>Company Resume</li>
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

                    <x-right-sidebar-2 :company="$company" />

                    <div class="col-xl-9 col-lg-8 col-md-12 m-b30">
                        <div class="twm-right-section-panel candidate-save-job site-bg-gray">
                            <!--Filter Short By-->
                            <div class="product-filter-wrap d-flex justify-content-between align-items-center m-b30">
                                <span class="woocommerce-result-count-left">Showing 2,150 Candidates</span>

                                <form class="woocommerce-ordering twm-filter-select" method="get">
                                    <span class="woocommerce-result-count">Short By</span>
                                    <select class="wt-select-bar-2 selectpicker"  data-live-search="true" data-bv-field="size">
                                        <option>Most Recent</option>
                                        <option>Freelance</option>
                                        <option>Full Time</option>
                                        <option>Internship</option>
                                        <option>Part Time</option>
                                        <option>Temporary</option>
                                    </select>
                                    <select class="wt-select-bar-2 selectpicker"  data-live-search="true" data-bv-field="size">
                                        <option>Show 10</option>
                                        <option>Show 20</option>
                                        <option>Show 30</option>
                                        <option>Show 40</option>
                                        <option>Show 50</option>
                                        <option>Show 60</option>
                                    </select>
                                </form>

                            </div>

                            <div class="twm-candidates-grid-wrap">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="twm-candidates-grid-style1 mb-5">
                                            <div class="twm-media">
                                                <div class="twm-media-pic">
                                                    <img src="/images/candidates/pic1.jpg" alt="#">
                                                </div>
                                            </div>
                                            <div class="twm-mid-content">
                                                <a href="candidate-detail.html" class="twm-job-title">
                                                    <h4>Wanda Montgomery </h4>
                                                </a>
                                                <p>Charted Accountant</p>
                                                <a href="files/pdf-sample.pdf" target="blank" title="Download Resume" class="twm-view-prifile site-text-primary">
                                                    <i class="fa fa-download"></i>
                                                </a>

                                                <div class="twm-fot-content">
                                                    <div class="twm-left-info">
                                                        <p class="twm-candidate-address"><i class="feather-map-pin"></i>New York</p>
                                                        <div class="twm-jobs-vacancies">$20<span>/ Day</span></div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="twm-candidates-grid-style1 mb-5">
                                            <div class="twm-media">
                                                <div class="twm-media-pic">
                                                    <img src="/images/candidates/pic2.jpg" alt="#">
                                                </div>

                                            </div>
                                            <div class="twm-mid-content">
                                                <a href="candidate-detail.html" class="twm-job-title">
                                                    <h4>Peter Hawkins</h4>
                                                </a>
                                                <p>Medical Professed</p>
                                                <a href="files/pdf-sample.pdf" target="blank" title="Download Resume" class="twm-view-prifile site-text-primary">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <div class="twm-fot-content">
                                                    <div class="twm-left-info">
                                                        <p class="twm-candidate-address"><i class="feather-map-pin"></i>New York</p>
                                                        <div class="twm-jobs-vacancies">$7<span>/ Hour</span></div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="twm-candidates-grid-style1 mb-5">
                                            <div class="twm-media">
                                                <div class="twm-media-pic">
                                                    <img src="/images/candidates/pic3.jpg" alt="#">
                                                </div>

                                            </div>
                                            <div class="twm-mid-content">
                                                <a href="candidate-detail.html" class="twm-job-title">
                                                    <h4>Ralph Johnson  </h4>
                                                </a>
                                                <p>Bank Manger</p>
                                                <a href="files/pdf-sample.pdf" target="blank" title="Download Resume" class="twm-view-prifile site-text-primary">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <div class="twm-fot-content">
                                                    <div class="twm-left-info">
                                                        <p class="twm-candidate-address"><i class="feather-map-pin"></i>New York</p>
                                                        <div class="twm-jobs-vacancies">$180<span>/ Day</span></div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="twm-candidates-grid-style1 mb-5">
                                            <div class="twm-media">
                                                <div class="twm-media-pic">
                                                    <img src="/images/candidates/pic4.jpg" alt="#">
                                                </div>

                                            </div>
                                            <div class="twm-mid-content">
                                                <a href="candidate-detail.html" class="twm-job-title">
                                                    <h4>Randall Henderson </h4>
                                                </a>
                                                <p>IT Contractor</p>
                                                <a href="files/pdf-sample.pdf" target="blank" title="Download Resume" class="twm-view-prifile site-text-primary">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <div class="twm-fot-content">
                                                    <div class="twm-left-info">
                                                        <p class="twm-candidate-address"><i class="feather-map-pin"></i>New York</p>
                                                        <div class="twm-jobs-vacancies">$90<span>/ Week</span></div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="twm-candidates-grid-style1 mb-5">
                                            <div class="twm-media">
                                                <div class="twm-media-pic">
                                                    <img src="/images/candidates/pic5.jpg" alt="#">
                                                </div>

                                            </div>
                                            <div class="twm-mid-content">
                                                <a href="candidate-detail.html" class="twm-job-title">
                                                    <h4>Randall Warren</h4>
                                                </a>
                                                <p>Digital & Creative</p>
                                                <a href="files/pdf-sample.pdf" target="blank" title="Download Resume" class="twm-view-prifile site-text-primary">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <div class="twm-fot-content">
                                                    <div class="twm-left-info">
                                                        <p class="twm-candidate-address"><i class="feather-map-pin"></i>New York</p>
                                                        <div class="twm-jobs-vacancies">$95<span>/ Day</span></div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="twm-candidates-grid-style1 mb-5">
                                            <div class="twm-media">
                                                <div class="twm-media-pic">
                                                    <img src="/images/candidates/pic6.jpg" alt="#">
                                                </div>

                                            </div>
                                            <div class="twm-mid-content">
                                                <a href="candidate-detail.html" class="twm-job-title">
                                                    <h4>Christina Fischer </h4>
                                                </a>
                                                <p>Charity & Voluntary</p>
                                                <a href="files/pdf-sample.pdf" target="blank" title="Download Resume" class="twm-view-prifile site-text-primary">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <div class="twm-fot-content">
                                                    <div class="twm-left-info">
                                                        <p class="twm-candidate-address"><i class="feather-map-pin"></i>New York</p>
                                                        <div class="twm-jobs-vacancies">$19<span>/ Hour</span></div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="twm-candidates-grid-style1 mb-5">
                                            <div class="twm-media">
                                                <div class="twm-media-pic">
                                                    <img src="/images/candidates/pic7.jpg" alt="#">
                                                </div>

                                            </div>
                                            <div class="twm-mid-content">
                                                <a href="candidate-detail.html" class="twm-job-title">
                                                    <h4>Wanda Willis </h4>
                                                </a>
                                                <p>Marketing & PR</p>
                                                <a href="files/pdf-sample.pdf" target="blank" title="Download Resume" class="twm-view-prifile site-text-primary">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <div class="twm-fot-content">
                                                    <div class="twm-left-info">
                                                        <p class="twm-candidate-address"><i class="feather-map-pin"></i>New York</p>
                                                        <div class="twm-jobs-vacancies">$12<span>/ Day</span></div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="twm-candidates-grid-style1 mb-5">
                                            <div class="twm-media">
                                                <div class="twm-media-pic">
                                                    <img src="/images/candidates/pic8.jpg" alt="#">
                                                </div>

                                            </div>
                                            <div class="twm-mid-content">
                                                <a href="candidate-detail.html" class="twm-job-title">
                                                    <h4>Peter Hawkins</h4>
                                                </a>
                                                <p>Public Sector</p>
                                                <a href="files/pdf-sample.pdf" target="blank" title="Download Resume" class="twm-view-prifile site-text-primary">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <div class="twm-fot-content">
                                                    <div class="twm-left-info">
                                                        <p class="twm-candidate-address"><i class="feather-map-pin"></i>New York</p>
                                                        <div class="twm-jobs-vacancies">$7<span>/ Hour</span></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="twm-candidates-grid-style1 mb-5">
                                            <div class="twm-media">
                                                <div class="twm-media-pic">
                                                    <img src="/images/candidates/pic9.jpg" alt="#">
                                                </div>

                                            </div>
                                            <div class="twm-mid-content">
                                                <a href="candidate-detail.html" class="twm-job-title">
                                                    <h4>Kathleen Moreno </h4>
                                                </a>
                                                <p>Sales & Marketing</p>
                                                <a href="files/pdf-sample.pdf" target="blank" title="Download Resume" class="twm-view-prifile site-text-primary">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <div class="twm-fot-content">
                                                    <div class="twm-left-info">
                                                        <p class="twm-candidate-address"><i class="feather-map-pin"></i>New York</p>
                                                        <div class="twm-jobs-vacancies">$125<span>/ Week</span></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="twm-candidates-grid-style1 mb-5">
                                            <div class="twm-media">
                                                <div class="twm-media-pic">
                                                    <img src="/images/candidates/pic10.jpg" alt="#">
                                                </div>

                                            </div>
                                            <div class="twm-mid-content">
                                                <a href="candidate-detail.html" class="twm-job-title">
                                                    <h4>Kathleen Moreno </h4>
                                                </a>
                                                <p>Sales & Marketing</p>
                                                <a href="files/pdf-sample.pdf" target="blank" title="Download Resume" class="twm-view-prifile site-text-primary">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <div class="twm-fot-content">
                                                    <div class="twm-left-info">
                                                        <p class="twm-candidate-address"><i class="feather-map-pin"></i>New York</p>
                                                        <div class="twm-jobs-vacancies">$125<span>/ Week</span></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="pagination-outer">
                                <div class="pagination-style1">
                                    <ul class="clearfix">
                                        <li class="prev"><a href="javascript:;"><span> <i class="fa fa-angle-left"></i> </span></a></li>
                                        <li><a href="javascript:;">1</a></li>
                                        <li class="active"><a href="javascript:;">2</a></li>
                                        <li><a href="javascript:;">3</a></li>
                                        <li><a class="javascript:;" href="javascript:;"><i class="fa fa-ellipsis-h"></i></a></li>
                                        <li><a href="javascript:;">5</a></li>
                                        <li class="next"><a href="javascript:;"><span> <i class="fa fa-angle-right"></i> </span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- OUR BLOG END -->



    </div>
    <!-- CONTENT END -->
@endsection
