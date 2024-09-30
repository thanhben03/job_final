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
                            <h2 class="wt-title">Company Profile</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="index.html">Home</a></li>
                            <li>Company Profile</li>
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

                    <!-- Right SideBar Company -->
                    <x-right-sidebar-2 :company="$company" />

                    <div class="col-xl-9 col-lg-8 col-md-12 m-b30">
                        <!--Filter Short By-->
                        <div class="twm-right-section-panel site-bg-gray">
                            <form method="POST" action="{{route('company.profile.update')}}">
                                @csrf
                                @method('PUT')
                                <!--Basic Information-->
                                <div class="panel panel-default">
                                    <div class="panel-heading wt-panel-heading p-a20">
                                        <h4 class="panel-tittle m-a0">Company Profile</h4>
                                        @foreach ($errors->all() as $error)
                                            <p class="alert alert-danger">{{ $error }}</p>
                                        @endforeach
                                        @if(Session::has('msg'))
                                            <p class="alert alert-success">{{ Session::get('msg') }}</p>
                                        @endif
                                    </div>
                                    <div class="panel-body wt-panel-body p-a20 m-b30 ">

                                        <div class="row">

                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Company Name</label>
                                                    <div class="ls-inputicon-box">
                                                        <input class="form-control" name="company_name" type="text"  value="{{old('company_name', $company->company_name)}}" placeholder="Devid Smith">
                                                        <i class="fs-input-icon fa fa-building"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <div class="ls-inputicon-box">
                                                        <input class="form-control"  value="{{old('company_phone', $company->company_phone)}}" name="company_phone" type="text" placeholder="(251) 1234-456-7890">
                                                        <i class="fs-input-icon fa fa-phone-alt"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Email Address</label>
                                                    <div class="ls-inputicon-box">
                                                        <input class="form-control"  value="{{old('company_email', $company->company_email)}}" name="company_email" type="email" placeholder="Devid@example.com">
                                                        <i class="fs-input-icon fas fa-at"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Website</label>
                                                    <div class="ls-inputicon-box">
                                                        <input class="form-control"  value="{{old('website', $company->website)}}" name="website" type="text" placeholder="https://devsmith.net">
                                                        <i class="fs-input-icon fa fa-globe-americas"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12">
                                                <div class="form-group city-outer-bx has-feedback">
                                                    <label>Full Address</label>
                                                    <div class="ls-inputicon-box">
                                                        <input class="form-control"  value="{{old('company_address', $company->company_address)}}" name="company_address" type="text" placeholder="1363-1385 Sunset Blvd Angeles, CA 90026 ,USA">
                                                        <i class="fs-input-icon fas fa-map-marker-alt"></i>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea class="form-control" rows="3">{{$company->introduce}}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!--Social Network-->
                                <div class="panel panel-default">
                                    <div class="panel-heading wt-panel-heading p-a20">
                                        <h4 class="panel-tittle m-a0">Social Network</h4>
                                    </div>
                                    <div class="panel-body wt-panel-body p-a20">

                                        <div class="row">

                                            <div class="col-xl-4 col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Facebook</label>
                                                    <div class="ls-inputicon-box">
                                                        <input
                                                            class="form-control wt-form-control"
                                                            name="facebook_link"
                                                             value="{{old('facebook_link', $company->facebook_link)}}"
                                                            type="text"
                                                            placeholder="https://www.facebook.com/">
                                                        <i class="fs-input-icon fab fa-facebook-f"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Twitter</label>
                                                    <div class="ls-inputicon-box">
                                                        <input
                                                            class="form-control wt-form-control"
                                                            name="twitter_link"
                                                             value="{{old('twitter_link', $company->twitter_link)}}"
                                                            type="text"
                                                            placeholder="https://twitter.com/">
                                                        <i class="fs-input-icon fab fa-twitter"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Instagram</label>
                                                    <div class="ls-inputicon-box">
                                                        <input
                                                            class="form-control wt-form-control"
                                                            name="instagram_link"
                                                             value="{{old('instagram_link', $company->instagram_link)}}"
                                                            type="text"
                                                            placeholder="https://www.instagram.com/">
                                                        <i class="fs-input-icon fab fa-instagram"></i>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 mt-3">
                                    <div class="text-left">
                                        <button type="submit" class="site-button">Save Changes</button>
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
