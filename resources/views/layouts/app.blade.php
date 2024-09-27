<!DOCTYPE html>
<html lang="en">

<head>

    <!-- META -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="description" content="" />

    <!-- FAVICONS ICON -->
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />

    <!-- PAGE TITLE HERE -->
    <title>Dream Job For You</title>

    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="{{{asset('/css/bootstrap.min.css')}}}"><!-- BOOTSTRAP STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{{asset('/css/font-awesome.min.css')}}}"><!-- FONTAWESOME STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{{asset('/css/feather.css')}}}"><!-- FEATHER ICON SHEET -->
    <link rel="stylesheet" type="text/css" href="{{{asset('/css/owl.carousel.min.css')}}}"><!-- OWL CAROUSEL STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{{asset('/css/magnific-popup.min.css')}}}"><!-- MAGNIFIC POPUP STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{{asset('/css/lc_lightbox.css')}}}"><!-- Lc light box popup -->
    <link rel="stylesheet" type="text/css" href="{{{asset('/css/bootstrap-select.min.css')}}}"><!-- BOOTSTRAP SLECT BOX STYLE SHEET  -->
    <link rel="stylesheet" type="text/css" href="{{{asset('/css/dataTables.bootstrap5.min.css')}}}"><!-- DATA table STYLE SHEET  -->
    <link rel="stylesheet" type="text/css" href="{{{asset('/css/select.bootstrap5.min.css')}}}"><!-- DASHBOARD select bootstrap  STYLE SHEET  -->
    <link rel="stylesheet" type="text/css" href="{{{asset('/css/dropzone.css')}}}"><!-- DROPZONE STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{{asset('/css/scrollbar.css')}}}"><!-- CUSTOM SCROLL BAR STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{{asset('/css/datepicker.css')}}}"><!-- DATEPICKER STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{{asset('/css/flaticon.css')}}}"> <!-- Flaticon -->
    <link rel="stylesheet" type="text/css" href="{{{asset('/css/swiper-bundle.min.css')}}}"><!-- Swiper Slider -->
    <link rel="stylesheet" type="text/css" href="{{{asset('/css/style.css')}}}"><!-- MAIN STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{{asset('/css/toastr.min.css')}}}"><!-- MAIN STYLE SHEET -->

    <!-- THEME COLOR CHANGE STYLE SHEET -->
    <link rel="stylesheet" class="skin" type="text/css" href="{{{asset('/css/skins-type/skin-6.css')}}}">

    <style>
        /* Show dropdown on hover */
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        /* Style the dropdown items */
        .dropdown-item {
            padding: 12px 20px;
            transition: background-color 0.3s ease;
        }

        /* Hover effect for items */
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        /* Style the profile section */
        .profile-container {
            padding: 10px;
            border-radius: 12px;
            transition: background-color 0.3s ease;
        }

        /* Hover effect for the profile container */
        .profile-container:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>

<!-- LOADING AREA START ===== -->
<div class="loading-area">
    <div class="loading-box"></div>
    <div class="loading-pic">
        <div class="wrapper">
            <div class="cssload-loader"></div>
        </div>
    </div>
</div>
<!-- LOADING AREA  END ====== -->

<div class="page-wraper">




    <!-- HEADER START -->
    <x-header />
    <!-- HEADER END -->

    <!-- CONTENT START -->
    <div class="page-content">

        @yield('content')


    </div>
    <!-- CONTENT END -->

    <!-- FOOTER START -->
    <footer class="footer-dark" style="background-image: url(/images/f-bg.jpg);">
        <div class="container">

            <!-- NEWS LETTER SECTION START -->
            <div class="ftr-nw-content">
                <div class="row">
                    <div class="col-md-5">
                        <div class="ftr-nw-title">
                            Join our email subscription now to get updates
                            on new jobs and notifications.
                        </div>
                    </div>
                    <div class="col-md-7">
                        <form>
                            <div class="ftr-nw-form">
                                <input name="news-letter" class="form-control" placeholder="Enter Your Email" type="text">
                                <button class="ftr-nw-subcribe-btn">Subscribe Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- NEWS LETTER SECTION END -->
            <!-- FOOTER BLOCKES START -->
            <div class="footer-top">
                <div class="row">

                    <div class="col-lg-3 col-md-12">

                        <div class="widget widget_about">
                            <div class="logo-footer clearfix">
                                <a href="index.html"><img src="images/logo-light.png" alt=""></a>
                            </div>
                            <p>Many desktop publishing packages and web page editors now.</p>
                            <ul class="ftr-list">
                                <li><p><span>Address :</span>65 Sunset CA 90026, USA </p></li>
                                <li><p><span>Email :</span>example@max.com</p></li>
                                <li><p><span>Call :</span>555-555-1234</p></li>
                            </ul>
                        </div>

                    </div>

                    <div class="col-lg-9 col-md-12">
                        <div class="row">

                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="widget widget_services ftr-list-center">
                                    <h3 class="widget-title">For Candidate</h3>
                                    <ul>
                                        <li><a href="dashboard.html">User Dashboard</a></li>
                                        <li><a href="dash-resume-alert.html">Alert resume</a></li>
                                        <li><a href="candidate-grid.html">Candidates</a></li>
                                        <li><a href="blog-list.html">Blog List</a></li>
                                        <li><a href="blog-single.html">Blog single</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="widget widget_services ftr-list-center">
                                    <h3 class="widget-title">For Employers</h3>
                                    <ul>
                                        <li><a href="dash-post-job.html">Post Jobs</a></li>
                                        <li><a href="blog-grid.html">Blog Grid</a></li>
                                        <li><a href="contact.html">Contact</a></li>
                                        <li><a href="job-list.html">Jobs Listing</a></li>
                                        <li><a href="job-detail.html">Jobs details</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="widget widget_services ftr-list-center">
                                    <h3 class="widget-title">Helpful Resources</h3>
                                    <ul>
                                        <li><a href="faq.html">FAQs</a></li>
                                        <li><a href="employer-detail.html">Employer detail</a></li>
                                        <li><a href="dash-my-profile.html">Profile</a></li>
                                        <li><a href="error-404.html">404 Page</a></li>
                                        <li><a href="pricing.html">Pricing</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="widget widget_services ftr-list-center">
                                    <h3 class="widget-title">Quick Links</h3>
                                    <ul>
                                        <li><a href="index.html">Home</a></li>
                                        <li><a href="about-1.html">About us</a></li>
                                        <li><a href="dash-bookmark.html">Bookmark</a></li>
                                        <li><a href="job-grid.html">Jobs</a></li>
                                        <li><a href="employer-list.html">Employer</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
            <!-- FOOTER COPYRIGHT -->
            <div class="footer-bottom">

                <div class="footer-bottom-info">

                    <div class="footer-copy-right">
                        <span class="copyrights-text">Copyright © 2023 by thewebmax All Rights Reserved.</span>
                    </div>
                    <ul class="social-icons">
                        <li><a href="javascript:void(0);" class="fab fa-facebook-f"></a></li>
                        <li><a href="javascript:void(0);" class="fab fa-twitter"></a></li>
                        <li><a href="javascript:void(0);" class="fab fa-instagram"></a></li>
                        <li><a href="javascript:void(0);" class="fab fa-youtube"></a></li>
                    </ul>

                </div>

            </div>

        </div>

    </footer>
    <!-- FOOTER END -->

    <!-- BUTTON TOP START -->
    <button class="scroltop"><span class="fa fa-angle-up  relative" id="btn-vibrate"></span></button>

    <!--Model Popup Section Start-->
    <!--Signup popup -->
    <div class="modal fade twm-sign-up" id="sign_up_popup" aria-hidden="true" aria-labelledby="sign_up_popupLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="#">
                    <div class="modal-header">
                        @if(Session::has('msg'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                        @endif
                        <h2 class="modal-title" id="sign_up_popupLabel">Sign Up</h2>
                        <p>Sign Up and get access to all the features of Jobzilla</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="twm-tabs-style-2">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">

                                <!--Signup Candidate-->
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#sign-candidate" type="button"><i class="fas fa-user-tie"></i>Candidate</button>
                                </li>
                                <!--Signup Employer-->
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#sign-Employer" type="button"><i class="fas fa-building"></i>Employer</button>
                                </li>

                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <!--Signup Candidate Content-->
                                <div class="tab-pane fade show active" id="sign-candidate">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <input id="fullname" name="fullname" type="text" required="" class="form-control" placeholder="Full Name">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <input id="email" name="email" type="text" class="form-control" required="" placeholder="Email">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <input id="password" name="password" type="text" class="form-control" required="" placeholder="Password">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <input id="phone" name="phone" type="text" class="form-control" required="" placeholder="Phone">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <div class=" form-check">
                                                    <input type="checkbox" class="form-check-input" id="agree1">
                                                    <label class="form-check-label" for="agree1">I agree to the <a href="javascript:;">Terms and conditions</a></label>
                                                    <p>Already registered?
                                                        <button class="twm-backto-login" data-bs-target="#sign_up_popup2" data-bs-toggle="modal" data-bs-dismiss="modal">Log in here</button>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="button" onclick="signup()" class="site-button">Sign Up</button>
                                        </div>

                                    </div>
                                </div>
                                <!--Signup Employer Content-->
                                <div class="tab-pane fade" id="sign-Employer">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <input name="fullname" type="text" required="" class="form-control" placeholder="Usearname*">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <input name="email" type="text" class="form-control" required="" placeholder="Password*">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <input name="phone" type="text" class="form-control" required="" placeholder="Email*">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <input name="phone" type="text" class="form-control" required="" placeholder="Phone*">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <div class=" form-check">
                                                    <input type="checkbox" class="form-check-input" id="agree2">
                                                    <label class="form-check-label" for="agree2">I agree to the <a href="javascript:;">Terms and conditions</a></label>
                                                    <p>Already registered?
                                                        <button class="twm-backto-login" data-bs-target="#sign_up_popup2" data-bs-toggle="modal" data-bs-dismiss="modal">Log in here</button>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="site-button">Sign Up</button>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <span class="modal-f-title">Login or Sign up with</span>
                        <ul class="twm-modal-social">
                            <li><a href="javascript" class="facebook-clr"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="javascript" class="twitter-clr"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="javascript" class="linkedin-clr"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="javascript" class="google-clr"><i class="fab fa-google"></i></a></li>
                        </ul>
                    </div>

                </form>
            </div>
        </div>

    </div>
    <!--Login popup -->
    <div class="modal fade twm-sign-up" id="sign_up_popup2" aria-hidden="true" aria-labelledby="sign_up_popupLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form>
                    <div class="modal-header">
                        <h2 class="modal-title" id="sign_up_popupLabel2">Login</h2>
                        <p>Login and get access to all the features of Jobzilla</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="twm-tabs-style-2">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">

                                <!--Login Candidate-->
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#login-candidate" type="button"><i class="fas fa-user-tie"></i>Candidate</button>
                                </li>
                                <!--Login Employer-->
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#login-Employer" type="button"><i class="fas fa-building"></i>Employer</button>
                                </li>

                            </ul>

                            <div class="tab-content" id="myTab2Content">
                                <!--Login Candidate Content-->
                                <div class="tab-pane fade show active" id="login-candidate">
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
                                            <div class="form-group mb-3">
                                                <div class=" form-check">
                                                    <input type="checkbox" class="form-check-input" id="Password3">
                                                    <label class="form-check-label rem-forgot" for="Password3">Remember me <a href="javascript:;">Forgot Password</a></label>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="site-button">Log in</button>
                                            <div class="mt-3 mb-3">Don't have an account ?
                                                <button class="twm-backto-login" data-bs-target="#sign_up_popup" data-bs-toggle="modal" data-bs-dismiss="modal">Sign Up</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!--Login Employer Content-->
                                <div class="tab-pane fade" id="login-Employer">
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
                                            <div class="form-group mb-3">
                                                <div class=" form-check">
                                                    <input type="checkbox" class="form-check-input" id="Password4">
                                                    <label class="form-check-label rem-forgot" for="Password4">Remember me <a href="javascript:;">Forgot Password</a></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <button type="submit" class="site-button">Log in</button>
                                            <div class="mt-3 mb-3">Don't have an account ?
                                                <button class="twm-backto-login" data-bs-target="#sign_up_popup" data-bs-toggle="modal" data-bs-dismiss="modal">Sign Up</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="modal-f-title">Login or Sign up with</span>
                        <ul class="twm-modal-social">
                            <li><a href="javascript" class="facebook-clr"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="javascript" class="twitter-clr"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="javascript" class="linkedin-clr"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="javascript" class="google-clr"><i class="fab fa-google"></i></a></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Model Popup Section End-->


</div>



<!-- JAVASCRIPT  FILES ========================================= -->
<script  src="{{asset('/js/jquery-3.6.0.min.js')}}"></script>
<script  src="{{asset('/js/popper.min.js')}}"></script>
<script  src="{{asset('/js/bootstrap.min.js')}}"></script><!-- BOOTSTRAP.MIN JS -->
<script  src="{{asset('/js/magnific-popup.min.js')}}"></script><!-- MAGNIFIC-POPUP JS -->
<script  src="{{asset('/js/waypoints.min.js')}}"></script><!-- WAYPOINTS JS -->
<script  src="{{asset('/js/counterup.min.js')}}"></script><!-- COUNTERUP JS -->
<script  src="{{asset('/js/waypoints-sticky.min.js')}}"></script><!-- STICKY HEADER -->
<script  src="{{asset('/js/isotope.pkgd.min.js')}}"></script><!-- MASONRY  -->
<script  src="{{asset('/js/imagesloaded.pkgd.min.js')}}"></script><!-- MASONRY  -->
<script  src="{{asset('/js/owl.carousel.min.js')}}"></script><!-- OWL  SLIDER  -->
<script  src="{{asset('/js/theia-sticky-sidebar.js')}}"></script><!-- STICKY SIDEBAR  -->
<script  src="{{asset('/js/lc_lightbox.lite.js')}}" ></script><!-- IMAGE POPUP -->
<script  src="{{asset('/js/bootstrap-select.min.js')}}"></script><!-- Form js -->
<script  src="{{asset('/js/dropzone.js')}}"></script><!-- IMAGE UPLOAD  -->
<script  src="{{asset('/js/jquery.scrollbar.js')}}"></script><!-- scroller -->
<script  src="{{asset('/js/bootstrap-datepicker.js')}}"></script><!-- scroller -->
<script  src="{{asset('/js/jquery.dataTables.min.js')}}"></script><!-- Datatable -->
<script  src="{{asset('/js/dataTables.bootstrap5.min.js')}}"></script><!-- Datatable -->
<script  src="{{asset('/js/chart.js')}}"></script><!-- Chart -->
<script  src="{{asset('/js/bootstrap-slider.min.js')}}"></script><!-- Price range slider -->
<script  src="{{asset('/js/swiper-bundle.min.js')}}"></script><!-- Swiper JS -->
<script  src="{{asset('/js/custom.js')}}"></script><!-- CUSTOM FUCTIONS  -->
<script  src="{{asset('/js/toastr.min.js')}}"></script><!-- CUSTOM FUCTIONS  -->


@stack('js')



</body>

</html>
