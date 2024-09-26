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
                            <h2 class="wt-title">Candidate Profile</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="index.html">Home</a></li>
                            <li>Candidate Profile</li>
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
                        <!--Filter Short By-->
                        <div class="twm-right-section-panel site-bg-gray">
                            <form action="{{route('profile.update')}}" method="POST">
                                @csrf
                                @method('PATCH')

                                <!--Basic Information-->
                                <div class="panel panel-default">
                                    <div class="panel-heading wt-panel-heading p-a20">
                                        <h4 class="panel-tittle m-a0">Basic Informations</h4>
                                        @foreach ($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                        @endforeach
                                        @if(Session::has('msg'))
                                            <p class="alert alert-success">{{ Session::get('msg') }}</p>
                                        @endif
                                    </div>
                                    <div class="panel-body wt-panel-body p-a20 m-b30 ">

                                        <div class="row">

                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Your Name</label>
                                                    <div class="ls-inputicon-box">
                                                        <input class="form-control" name="fullname" type="text" value="{{auth()->user()->fullname}}">
                                                        <i class="fs-input-icon fa fa-user "></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <div class="ls-inputicon-box">
                                                        <input class="form-control" name="phone" type="text" value="{{auth()->user()->phone}}">
                                                        <i class="fs-input-icon fa fa-phone-alt"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Email Address</label>
                                                    <div class="ls-inputicon-box">
                                                        <input class="form-control" name="email" type="email" value="{{auth()->user()->email}}" placeholder="Devid@example.com">
                                                        <i class="fs-input-icon fas fa-at"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Price Per Hours</label>
                                                    <div class="ls-inputicon-box">
                                                        <input class="form-control" name="price_per_hours" value="{{auth()->user()->price_per_hours}}" type="number" placeholder="200.000">
                                                        <i class="fs-input-icon fa fa-globe-americas"></i>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-xl-6 col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label>Type Work</label>

                                                        <div class="position-relative">
                                                            <i class="fs-input-icon fa fa-user-graduate icon-select-custom"></i>

                                                            <select name="type_work" class="form-select custom-select">
                                                                @foreach(\App\Enums\WorkTypeEnum::asSelectArray() as $item)
                                                                    <option value="{{\App\Enums\WorkTypeEnum::getValue($item)}}">{{$item}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                </div>
                                            </div>



                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Introduce</label>
                                                    <textarea name="introduce" class="form-control" rows="3">{{auth()->user()->introduce}}</textarea>
                                                </div>
                                            </div>


                                            <div class="col-lg-12 col-md-12">
                                                <div class="text-left">
                                                    <button type="submit" class="site-button">Save Changes</button>
                                                </div>
                                            </div>


                                        </div>

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
