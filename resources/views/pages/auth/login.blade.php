@extends('layouts.app')
@section('content')
    <!-- CONTENT START -->
    <div class="page-content">




        <!-- Login Section Start -->
        <div class="section-full site-bg-white">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-8 col-lg-6 col-md-5 twm-log-reg-media-wrap">
                        <div class="twm-log-reg-media">
                            <div class="twm-l-media">
                                <img src="images/login-bg.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-7">
                        <div class="twm-log-reg-form-wrap">
                            <div class="twm-log-reg-logo-head">
                                <a href="index.html">
                                    <img src="images/logo-dark.png" alt="" class="logo">
                                </a>
                            </div>

                            <div class="twm-log-reg-inner">
                                <div class="twm-log-reg-head">
                                    <div class="twm-log-reg-logo">
                                        <span class="log-reg-form-title">Log In</span>
                                    </div>
                                </div>
                                <div class="twm-tabs-style-2">

                                    <ul class="nav nav-tabs" id="myTab2" role="tablist">

                                        <!--Login Candidate-->
                                        <li class="nav-item">
                                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#twm-login-candidate" type="button"><i class="fas fa-user-tie"></i>Candidate</button>
                                        </li>
                                        <!--Login Employer-->
                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#twm-login-Employer" type="button"><i class="fas fa-building"></i>Employer</button>
                                        </li>

                                    </ul>

                                    <div class="tab-content" id="myTab2Content">
                                        <!--Login Candidate Content-->
                                        <div class="tab-pane fade show active" id="twm-login-candidate">
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <div class="form-group mb-3">
                                                        <input name="username" type="text" required="" class="form-control" placeholder="Usearname*">
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group mb-3">
                                                        <input name="email" type="text" class="form-control" required="" placeholder="Password*">
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="twm-forgot-wrap">
                                                        <div class="form-group mb-3">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="Password4">
                                                                <label class="form-check-label rem-forgot" for="Password4">Remember me <a href="javascript:;" class="site-text-primary">Forgot Password</a></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="site-button">Log in</button>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <span class="center-text-or">Or</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="log_with_facebook">
                                                            <i class="fab fa-facebook"></i>
                                                            Continue with Facebook
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="log_with_google">
                                                            <img src="images/google-icon.png" alt="">
                                                            Continue with Google
                                                        </button>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <!--Login Employer Content-->
                                        <div class="tab-pane fade" id="twm-login-Employer">
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <div class="form-group mb-3">
                                                        <input name="username" type="text" required="" class="form-control" placeholder="Usearname*">
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group mb-3">
                                                        <input name="email" type="text" class="form-control" required="" placeholder="Password*">
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="twm-forgot-wrap">
                                                        <div class="form-group mb-3">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="Password4">
                                                                <label class="form-check-label rem-forgot" for="Password4">Remember me <a href="javascript:;" class="site-text-primary">Forgot Password</a></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="site-button">Log in</button>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <span class="center-text-or">Or</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="log_with_facebook">
                                                            <i class="fab fa-facebook"></i>
                                                            Continue with Facebook
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="log_with_google">
                                                            <img src="images/google-icon.png" alt="">
                                                            Continue with Google
                                                        </button>
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
            </div>
        </div>
        <!-- Login Section End -->



    </div>
    <!-- CONTENT END -->
@endsection
