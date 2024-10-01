@php use App\Enums\StatusCV; @endphp
@extends('layouts.company')

@section('content')
    <!-- Page Content Holder -->
    <div id="content">

        <div class="content-admin-main">

            <div class="wt-admin-right-page-header clearfix">
                <h2>Candidates</h2>
                <div class="breadcrumbs"><a href="#">Home</a><a href="#">Dasboard</a><span>Candidates</span></div>
            </div>

            <div class="twm-pro-view-chart-wrap">

                <div class="col-lg-12 col-md-12 mb-4">
                    <div class="panel panel-default site-bg-white m-t30">
                        <div class="panel-heading wt-panel-heading p-a20">
                            <h4 class="panel-tittle m-a0"><i class="far fa-list-alt"></i>All Candidates</h4>
                        </div>
                        <div class="panel-body wt-panel-body">
                            <div class="twm-D_table p-a20 table-responsive">
                                <table id="candidate_data_table" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" onclick="checkAll(this)"></th>
                                        <th>Name</th>
                                        <th>Applied for</th>
                                        <th>CV</th>
                                        <th>Date</th>
                                        <th>Status</th>
{{--                                        <th></th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!--1-->
                                    @foreach($career['candidates'] as $candidate)
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>
                                                <div class="twm-DT-candidates-list">
                                                    <div class="twm-media">
                                                        <div class="twm-media-pic">
                                                            <img
                                                                src="{{asset('/images/avatar/'. $candidate['info']->avatar)}}"
                                                                alt="#">
                                                        </div>
                                                    </div>
                                                    <div class="twm-mid-content">
                                                        <a href="#" class="twm-job-title">
                                                            <h4>{{$candidate['info']->fullname}}</h4>
                                                            <p class="twm-candidate-address">
                                                                <i class="feather-map-pin"></i>{{$candidate['info']->email}}
                                                            </p>
                                                        </a>

                                                    </div>

                                                </div>
                                            </td>
                                            <td>{{$career['title']}}</td>
                                            <td>
                                                <a style="color: blue" download href="{{asset('/storage/uploads/'. $candidate['cv'])}}">{{$candidate['cv']}}</a>
                                            </td>
                                            <td>{{$candidate['applied_day']}}</td>
                                            <td>
                                                <div class="twm-jobs-category">
                                                    <select onchange="updateUserCareer({{$candidate['user_career_id']}}, this)" name="status" class="form-select" id="status">
                                                        @foreach($statusCV as $key => $value)
                                                            <option {{$key == StatusCV::getKeyFromDesc($candidate['status']) ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
{{--                                            <td>--}}
{{--                                                <div class="twm-table-controls">--}}
{{--                                                    <ul class="twm-DT-controls-icon list-unstyled">--}}
{{--                                                        <li>--}}
{{--                                                            <button title="View profile" data-bs-toggle="tooltip"--}}
{{--                                                                    data-bs-placement="top">--}}
{{--                                                                <span class="fa fa-eye"></span>--}}
{{--                                                            </button>--}}
{{--                                                        </li>--}}
{{--                                                        <li>--}}
{{--                                                            <button title="Send message" data-bs-toggle="tooltip"--}}
{{--                                                                    data-bs-placement="top">--}}
{{--                                                                <span class="far fa-envelope-open"></span>--}}
{{--                                                            </button>--}}
{{--                                                        </li>--}}
{{--                                                        <li>--}}
{{--                                                            <button title="Delete" data-bs-toggle="tooltip"--}}
{{--                                                                    data-bs-placement="top">--}}
{{--                                                                <span class="far fa-trash-alt"></span>--}}
{{--                                                            </button>--}}
{{--                                                        </li>--}}
{{--                                                    </ul>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
                                        </tr>
                                    @endforeach


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Applied for</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>

    </div>
@endsection

@push('js')
    <script>
        function updateUserCareer(id, ele) {
            $.ajax({
                type: 'POST',
                url: '{{route('job.update.user.career')}}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id': id,
                    'status': ele.value
                },
                success: function (res) {
                    toastr.success(res.msg, 'Notification !')
                },
                error: function(xhr) {
                    console.log(xhr)
                    toastr.error(xhr.responseJSON.msg, 'Notification !')
                }
            })
        }
    </script>
@endpush
