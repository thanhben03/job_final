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
                            <h2 class="wt-title">Candidate CV Manager</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="index.html">Home</a></li>
                            <li>Candidate CV Manager</li>
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
                                <span class="woocommerce-result-count-left">CV Manager</span>

                                <form class="woocommerce-ordering twm-filter-select" method="get">
                                    <span class="woocommerce-result-count">Short By</span>
                                    <select class="wt-select-bar-2 selectpicker"  data-live-search="true" data-bv-field="size">
                                        <option>Last 2 Months</option>
                                        <option>Last 1 Months</option>
                                        <option>15 days ago</option>
                                        <option>Weekly</option>
                                        <option>Yesterday</option>
                                        <option>Today</option>
                                    </select>
                                </form>

                            </div>

                            <div class="twm-cv-manager-list-wrap">
                                <!-- Section: Create CV -->
                                <div class="row upload-section p-4 bg-light border rounded">
                                    <div class="col-md-9 d-flex align-items-center">
                                        <div>
                                            <img src="https://static.topcv.vn/v4/image/cv-manager/no-cv.png" alt="Icon">
                                            <p>Bạn chưa tạo CV nào</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <button class="btn btn-success">+ Tạo mới</button>
                                    </div>
                                </div>

                                <!-- Section: Uploaded CVs -->
                                <div class="uploaded-section">
                                    <h4 class="my-2">CV đã tải lên TopCV</h4>
                                    <div class="row">
                                        <!-- CV Card 1 -->
                                        <div class="col-md-4">
                                            <div class="card card-wrapper">
                                                <img src="https://cellphones.com.vn/sforum/wp-content/uploads/2024/02/anh-avatar-cute-58.jpg" class="card-img-top mx-auto d-block" alt="Profile">
                                                <div class="main-cv-badge bg-warning text-white p-1 rounded">CV chính</div>
                                                <div class="card-body">
                                                    <h5 class="card-title">CV-Nguyen-Ho-Thanh-Ben-PHP-Laravel</h5>
                                                    <p class="card-text">Cập nhật lần cuối 17-03-2024 16:55 PM</p>
                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-outline-primary">Chia sẻ</button>
                                                        <button class="btn btn-outline-secondary">Tải xuống</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- CV Card 2 -->
                                        <div class="col-md-4">
                                            <div class="card card-wrapper">
                                                <img src="https://cellphones.com.vn/sforum/wp-content/uploads/2024/02/anh-avatar-cute-58.jpg" class="card-img-top mx-auto d-block" alt="Profile">
                                                <div class="main-cv-badge bg-warning text-white p-1 rounded">CV chính</div>
                                                <div class="card-body">
                                                    <h5 class="card-title">CV-Nguyen-Ho-Thanh-Ben-PHP-Laravel</h5>
                                                    <p class="card-text">Cập nhật lần cuối 20-03-2024 20:00 PM</p>
                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-outline-primary">Chia sẻ</button>
                                                        <button class="btn btn-outline-secondary">Tải xuống</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- CV Card 3 -->
                                        <div class="col-md-4">
                                            <div class="card card-wrapper">
                                                <img src="https://cellphones.com.vn/sforum/wp-content/uploads/2024/02/anh-avatar-cute-58.jpg" class="card-img-top mx-auto d-block" alt="Profile">
                                                <div class="main-cv-badge bg-warning text-white p-1 rounded">CV chính</div>
                                                <div class="card-body">
                                                    <h5 class="card-title">CV-Nguyen-Ho-Thanh-Ben.pdf</h5>
                                                    <p class="card-text">Cập nhật lần cuối 07-08-2024 22:35 PM</p>
                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-outline-primary">Chia sẻ</button>
                                                        <button class="btn btn-outline-secondary">Tải xuống</button>
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
