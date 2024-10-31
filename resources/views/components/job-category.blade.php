<!-- JOBS CATEGORIES SECTION START -->
<div class="section-full p-t120 p-b90 site-bg-white twm-job-categories-area3">
    <div class="container">

        <div class="wt-separator-two-part">
            <div class="row wt-separator-two-part-row">
                <div class="col-xl-6 col-lg-6 col-md-12 wt-separator-two-part-left">
                    <!-- TITLE START-->
                    <div class="section-head left wt-small-separator-outer">
                        <div class="wt-small-separator site-text-primary">
                            <div>Jobs by Categories</div>
                        </div>
                        <h2 class="wt-title">Choose Your Desire Category</h2>
                    </div>
                    <!-- TITLE END-->
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 wt-separator-two-part-right text-right">
                    <a href="job-list.html" class=" site-button">All Categories</a>
                </div>
            </div>
        </div>

        <div class="twm-job-categories-section-3 m-b30">

            <div class="job-categories-style3">
                <div class="row">

                    @foreach($categories as $category)
                        <!-- COLUMNS 1 -->
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 m-b30">
                            <div class="job-categories-3-wrap">
                                <div class="job-categories-3">
                                    <div class="twm-media">
                                        <div class="flaticon-dashboard"></div>
                                    </div>
                                    <div class="twm-content">
                                        <div class="twm-jobs-available">{{$category->jobs_count}} Jobs</div>
                                        <a href="{{route('jobs.index', $category->slug)}}">{{__('category.name.'.$category->trans_key)}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>

        </div>

    </div>

</div>
<!-- JOBS CATEGORIES SECTION END -->
