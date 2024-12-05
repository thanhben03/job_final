<div class="twm-home1-banner-section site-bg-gray bg-cover" style="background-image:url(images/main-slider/slider1/bg1.jpg)">
    <div class="row">

        <!--Left Section-->
        <div class="col-xl-6 col-lg-6 col-md-12">
            <div class="twm-bnr-left-section">
                <div class="twm-bnr-title-large">{{__('lang.home.Find the job that fits your life')}}</div>
                <div class="twm-bnr-discription">{{__('lang.home.Type your keyword, then click search to find your perfect job.')}}</div>

                <div class="twm-bnr-search-bar">
                    <form>
                        <div class="row" style="justify-content: space-between;">
                            <!--Title-->
                            <div class="form-group col-xl-3 col-lg-6 col-md-6">
                                <label>{{__('lang.category')}}</label>
                                <select class="wt-search-bar-select selectpicker"  data-live-search="true" title="" id="select-skill" data-bv-field="size">
                                    <option disabled selected value="">Select Category</option>
                                    @foreach($categoriesCollection as $category)
                                        <option value="{{$category->slug}}">{{trans('category.name.'.$category->trans_key)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--Title-->
                            <div class="form-group col-xl-3 col-lg-6 col-md-6">
                                <label>{{__('lang.location')}}</label>
                                <select class="wt-search-bar-select selectpicker"  data-live-search="true" title="" id="select-province" data-bv-field="size">
                                    <option disabled selected value="">Select Category</option>
                                    @foreach($provinces as $province)
                                        <option value="{{$province->name}}">{{$province->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!--Find job btn-->
                            <div class="form-group col-xl-3 col-lg-6 col-md-6">
                                <button type="button" onclick="searchJob()" class="site-button">{{__('lang.home.Find Jobs')}}</button>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="twm-bnr-popular-search">
                    <span class="twm-title">{{__('lang.home.Popular Searches')}}:</span>
                    <a href="job-list.html">Developer</a> ,
                    <a href="job-list.html">Designer</a> ,
                    <a href="job-list.html">Architect</a> ,
                    <a href="job-list.html">Engineer</a> ...
                </div>
            </div>
        </div>

        <!--right Section-->
        <div class="col-xl-6 col-lg-6 col-md-12 twm-bnr-right-section">
            <div class="twm-bnr-right-content">

                <div class="twm-img-bg-circle-area">
                    <div class="twm-img-bg-circle1 rotate-center"><span></span></div>
                    <div class="twm-img-bg-circle2 rotate-center-reverse"><span></span></div>
                    <div class="twm-img-bg-circle3"><span></span></div>
                </div>

                <div class="twm-bnr-right-carousel">
                    <div class="owl-carousel twm-h1-bnr-carousal">
                        <div class="item">
                            <div class="slide-img">
                                <img src="images/main-slider/slider1/user/u-1.jpg" alt="#">
                            </div>
                        </div>
                        <div class="item">
                            <div class="slide-img">
                                <div class="slide-img">
                                    <img src="images/main-slider/slider1/user/u-2.jpg" alt="#">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="twm-bnr-blocks-position-wrap">
                        <!--icon-block-1-->
                        <div class="twm-bnr-blocks twm-bnr-blocks-position-1">
                            <div class="twm-icon">
                                <img src="images/main-slider/slider1/icon-1.png" alt="">
                            </div>
                            <div class="twm-content">
                                <div class="tw-count-number text-clr-sky">
                                    <span class="counter">12</span>K+
                                </div>
                                <p class="icon-content-info">Companies Jobs</p>
                            </div>
                        </div>

                        <!--icon-block-2-->
                        <div class="twm-bnr-blocks twm-bnr-blocks-position-2">
                            <div class="twm-icon">
                                <img src="images/main-slider/slider1/icon-2.png" alt="">
                            </div>
                            <div class="twm-content">
                                <div class="tw-count-number text-clr-pink">
                                    <span class="counter">98</span> +
                                </div>
                                <p class="icon-content-info">Job For Countries </p>
                            </div>
                        </div>

                        <!--icon-block-3-->
                        <div class="twm-bnr-blocks-3 twm-bnr-blocks-position-3">
                            <div class="twm-pics">
                                <span><img src="images/main-slider/slider1/user/u-1.jpg" alt=""></span>
                                <span><img src="images/main-slider/slider1/user/u-2.jpg" alt=""></span>
                                <span><img src="images/main-slider/slider1/user/u-3.jpg" alt=""></span>
                                <span><img src="images/main-slider/slider1/user/u-4.jpg" alt=""></span>
                                <span><img src="images/main-slider/slider1/user/u-5.jpg" alt=""></span>
                                <span><img src="images/main-slider/slider1/user/u-6.jpg" alt=""></span>
                            </div>
                            <div class="twm-content">
                                <div class="tw-count-number text-clr-green">
                                    <span class="counter">3</span>K+
                                </div>
                                <p class="icon-content-info">Jobs Done</p>
                            </div>
                        </div>
                    </div>

                </div>



                <!--Samll Ring Left-->
                <div class="twm-small-ring-l slide-top-animation"></div>
                <div class="twm-small-ring-2 slide-top-animation"></div>



            </div>
        </div>

    </div>
    <div class="twm-gradient-text">
        Jobs
    </div>
</div>

@push('js')
    <script>
        let originUrl = window.location.protocol + '//' + window.location.host + window.location.pathname + 'jobs/';

        function searchJob() {
            let skills = $("#select-skill").val()
            let provinces = $("#select-province").val()

            // Mảng để lưu các tham số truy vấn
            let queryParams = [];

            // Kiểm tra và thêm tham số 'skills' nếu có giá trị
            if (skills) {
                queryParams.push(`category=${encodeURIComponent(skills)}`);
            }

            // Kiểm tra và thêm tham số 'locations' nếu có giá trị
            if (provinces) {
                queryParams.push(`locations=${encodeURIComponent(provinces)}`);
            }

            // Nối các tham số truy vấn thành chuỗi
            let queryString = queryParams.length > 0 ? '?' + queryParams.join('&') : '';

            // Ghép URL cuối cùng
            let finalUrl = originUrl + queryString;

            window.location.href = finalUrl;
        }
    </script>
@endpush
